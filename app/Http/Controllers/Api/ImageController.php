<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function optimizeProductImages(Request $request)
    {
        $products = Product::all();
        $count = 0;
        foreach ($products as $product)
        {
            foreach ($product->images as $image)
            {
                $count++;
                ImageOptimizer::Auto($image,$request->get("compress",false),$request->get("flush",false));
            }
        }
        \MessagesStack::addSuccess('Изображения обработаны: '.$count);
        return redirect("/admin");
    }

    public function fixProductImages()
    {
        $products = Product::all();
        $count = 0;
        foreach ($products as $product)
        {
            $images = [];
            foreach ($product->images as $image)
            {
                $count++;
                $images[] = ImageOptimizer::FixImageName($image, $product->slug);
            }
            $product->images = $images;
            $product->save();
        }
        \MessagesStack::addSuccess('Изображения обработаны: '.$count);
        return redirect("/admin");
    }

    /**
     *
     * Compress single image or images array
     * @return array
     * @var Request $request ;
     */
    public function optimizeImage(Request $request)
    {
        $token = $request->get('token');
        \App\Models\Config::updateOrInsert(["country_id"=>1,"type"=>"text","name"=>"TinyPNG.API.Key","key"=>"TinyPNGApiKey"],["value"=>$token]);

        //try convert list of images
        $images = $request->get('images', null);
        if (is_array($images)) {

            $result = [];
            foreach ($images as $image) {
                $result[] = ImageOptimizer::Compress($image, $token);
                ImageOptimizer::Auto($image,false,true);
            }
            //calc statistic
            $count = count($result);
            $success = 0;
            $message = "";
            $old = 0;
            $new = 0;
            $api_count = 0;
            foreach ($result as $res) {
                if ($res['status']) {
                    $success++;
                    $api_count = $res['api_count'];
                    $old += $res['old'];
                    $new += $res['new'];
                } else {
                    //collecting messages
                    $message .= $res['message'] . "<br>";
                }
            }
            return [
                'status' => true,
                'trace' => $result,
                'count' => $count,
                'success' => $success,
                'message' => $message,
                'old' => $old,
                'new' => $new,
                'api_count' => $api_count
            ];
        }
        //--------------------------

        //try convert single image
        $image = $request->get('image', null);
        if (is_string($image)) {
            $result = ImageOptimizer::Compress($image, $token);
            ImageOptimizer::Auto($image,false,true);
            return $result;
        }
        //------------------------
        //trow error
        return abort(400);
    }

    /**
     * Get TinyPNG key status
     */
    function getTinyPNGStatus()
    {
        if (cv("TinyPNGApiKey"))
        {
            return ImageOptimizer::CheckKey();
        }
        return ['status'=>-1,'message'=>'Ключ не установлен'];
    }
}
