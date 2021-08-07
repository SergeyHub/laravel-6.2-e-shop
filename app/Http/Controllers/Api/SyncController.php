<?php

namespace App\Http\Controllers\Api;

use App\Http\Admin\Question;
use App\Http\Controllers\Controller;
use App\Jobs\SendProducts;
use App\Jobs\UpdateCatalog;
use App\Jobs\UpdateProducts;
use App\Jobs\UpdateCities;
use App\Jobs\UpdateNames;
use App\Jobs\UpdatePrices;
use App\Models\Callback;
use App\Models\Message;
use App\Models\Order;
use App\Models\ProductSimilar;
use App\Services\API\LibraryConnector;
use App\Services\CatalogService;
use Composer\Util\RemoteFilesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Product;

class SyncController extends Controller
{
    public function postRunRemoteUpdate(Request $request, $content)
    {
        //load jobs
        switch ($content) {
            case "prices":
                //UpdatePrices::dispatch();
                break;
            case "cities":
                UpdateCities::dispatch();
                break;
            case "names":
                //UpdateNames::dispatch();
                break;
            case "products":
                $remotes = $request->get("products", []);
                CatalogService::makeProductsFromRemote($remotes, true);
                UpdateProducts::dispatch(Product::whereIn("remote_id", $remotes)->get());
                if ($request->get("ordering", false)) UpdateCatalog::dispatch();
                break;
            default:
                return response([
                    "status" => 0,
                    "message" => "Specified job not found"
                ])->setStatusCode(404);
        }
        return response([
            "status" => 1,
            "message" => "Job launched successfully"
        ]);
    }

    public function postRunRemoteAdd(Request $request, $content)
    {
        switch ($content) {
            case "products":
                CatalogService::makeProductsFromRemote($request->get("items", []));
                break;
            case "cities":
                return response([
                    "status" => 0,
                    "message" => "Not implemented"
                ])->setStatusCode(501);
                break;
            default:
                return response([
                    "status" => 0,
                    "message" => "Specified job not found"
                ])->setStatusCode(404);
        }
        return response([
            "status" => 1,
            "message" => "Job launched successfully"
        ]);
    }

    public function getSiteData()
    {
        $data = [];
        //
        $data['orders'] = Order::count();
        $data['orders_new'] = Order::where('created_at', ">", Carbon::now()->subDays(1))->count();
        //
        $data['callbacks'] = Callback::count();
        $data['callbacks_new'] = Callback::where('created_at', ">", Carbon::now()->subDays(1))->count();
        //
        $data['comments'] = class_exists(\App\Models\Comment::class) ? \App\Models\Comment::where('status', 0)->count() : 0;
        $data['reviews'] = class_exists(\App\Models\Review::class) ? \App\Models\Review::where('status', 0)->count() : 0;
        $data['questions'] = class_exists(\App\Models\Question::class) ? \App\Models\Question::where('status', 0)->count() : 0;
        //
        $data['problems'] = [];
        foreach (Message::where("type", "problem")->get() as $message) {
            $data['problems'][] = [
                'html' => view("admin.messages.short")->with('message', $message)->render(),
                'href' => '/admin/messages?type=problem',
            ];
        }
        //
        $data['bugs'] = [];
        foreach (Message::where("type", "bug")->get() as $message) {
            $data['bugs'][] = [
                'html' => view("admin.messages.short")->with('message', $message)->render(),
                'href' => '/admin/messages?type=bug',
            ];
        }
        //
        $data['products'] = Product::where("remote_id", ">", 0)->get(['remote_id'])->pluck('remote_id')->toArray();
        //
        return $data;
    }

    public function relayToShow($remote_id)
    {
        $product = Product::where("remote_id", $remote_id)->first();
        if ($product) {
            return redirect($product->getShowLink());
        }
        abort(404);
    }

    public function relayToEdit($remote_id)
    {
        $product = Product::where("remote_id", $remote_id)->first();
        if ($product) {
            return redirect($product->getEditLink());
        }
        abort(404);
    }

    public function updateProducts()
    {
        \MessagesStack::addSuccess('Данные получены');
        UpdateProducts::dispatch(Product::where("remote_id", ">", 0)->get(), true);
        return back();
    }

    public function sendProducts()
    {
        \MessagesStack::addSuccess('Данные отправлены');
        SendProducts::dispatch(Product::where("remote_id", ">", 0)->get());
        return back();
    }

    public static function fillProductData(Product &$product, $order, $item)
    {


        //================================== STATUS =================================//
        if (isset($item['status'])) {
            if (config("crm.features.order") && $order >= 0) {
                $product->order = $order;
            }
            if (config("crm.features.status")) {
                $product->status = $item['status']['status'];
            }
            if (config("crm.features.promote")) {
                $local = config("crm.fields.promote");
                $product->$local = $item['status']['promote'];
            }
            if (config("crm.features.preorder")) {
                $local = config("crm.fields.preorder");
                $product->$local = $item['status']['preorder'];
            }
        }


        //================================== CASES =================================//

        if (isset($item['cases'])) {
            if (strlen($item['cases'][0]) > 0) {
                $product->name = $item['cases'][0];
            }
            if (strlen($item['cases'][1]) > 0) {
                $product->name1 = $item['cases'][1];
            }
            if (strlen($item['cases'][2]) > 0) {
                $product->name2 = $item['cases'][2];
            }
            if (strlen($item['cases'][3]) > 0) {
                $product->name3 = $item['cases'][3];
            }
            if (strlen($item['cases'][4]) > 0) {
                $product->name4 = $item['cases'][4];
            }
            if (strlen($item['cases'][5]) > 0) {
                $product->name5 = $item['cases'][5];
            }
        }
        //================================== DESCRIPTION =================================//
        if (isset($item['description'])) {
            foreach (config("crm.fields") ?? [] as $remote => $local) {
                if (isset($item['description'][$remote])) {
                    $product->$local = $item['description'][$remote];
                }
            }
        }
        //================================== PRICES =================================//
        if (isset($item['prices'])) {
            //check built-in lock;
            if (!config("crm.features.price_diff")) {
                $product->setPrice($item['prices']['RU']);
            }
            //-------------------------------------------
            $min_price_diff = $item['directives']['minimum_additive'] ?? $product->price_diff ?? 20;
            $price_diff_enabled = $item['directives']['additive'];
            //-------------- fix price_diff -------------
            if ($price_diff_enabled) {
                $price = $item['prices']['RU'] + $min_price_diff;
                if ($price % 50 == 0) {
                    if ($price % 100 == 0) {
                        $price -= 10;
                    } else {
                        $price += 10;
                    }
                }
                $product->setPrice($price);
            }
            else
            {
                $product->setPrice($item['prices']['RU']);
            }

        }
        //================================== COMMIT =================================//
    }
}
