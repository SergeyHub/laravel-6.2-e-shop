<?php

namespace App\Http\Controllers;

use App\Models\Callback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Models\Product;
use App\Mail\CheckQTY;
class CallbackController extends Controller
{



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $res = ['status' => 'success'];
        $res['fields']['.js-client-phone'] = $request->phone;
        $res['fields']['.js-client-name'] = $request->name.',';
        //$res['src'] = captcha_src();
        //$res['popup'] = '#thankfulness-pop';
        $callback = new Callback();
        $callback->country_id = country()->id;
        $callback->phone = $request->phone;
        $callback->name = $request->name;
        $callback->message = $request->message;
        $callback->themes = $request->theme ?? '';
        $callback->email = $request->email;
        $callback->ip = $_SERVER['REMOTE_ADDR'];
        $callback->type = $request->type ?? 'Перезвоните мне';
        $callback->city = currentCity()?currentCity()->name:'';

        //$callback->message = $request->message;
        $callback->status = 0;
        if (!$request->agree) {
            $callback->save();
            $files = $request->file('upload_files');
            if ($request->hasFile('upload_files')) {
                $fls = [];
                foreach ($files as $file) {

                    $fls[] = $file->storeAs(
                        "feedbacks/".$callback->id.'/',
                        $file->getClientOriginalName());
                }
                $callback->files = $fls;
                $callback->save();
            }
            session(['callback_id' => $callback->id]);
            $res['location'] = route('callback.success').'/';
            Mail::to(getConfigValue('message_mail'))->send(new \App\Mail\Callback($callback));

            //send question mail
            if(strlen($callback->message) > 0 )
            {
                Mail::to(getConfigValue('question_mail'))->send(new \App\Mail\Comment($callback->name, "Запрос",$callback->message,$callback->getEditLink()));
            }
        }
        if ($request->ajax()) {
            return $res;
        }
        return redirect(route('callback.success').'/');
    }

    public function storeWithCaptcha(Request $request)
    {
        captcha()->validate($request, true);
        return $this->store($request);
    }

    public function success()
    {
        $callback_id = request()->session()->get('callback_id', null);
        if ($callback_id && $callback = Callback::find($callback_id)) {

            //session(['callback_id' => null]);
            $meta = [
                'title' => rv('Спасибо за заявку'),
                'description' => rv(getConfigValue('success_description')),
                'keywords' => rv(getConfigValue('success_keywords')),
            ];
            $breadcrumbs = [
                ['href'=>'/','name'=>'Главная'],
                ['href'=>'','name'=>'Спасибо за заявку']
            ];
            return view('pages.thankyou',[
                    'callback'=>$callback,
                    'title' => 'Спасибо за заявку',
                    'view' =>   'thankyou',
                    'meta' => $meta,
                    'breadcrumbs'   => $breadcrumbs,
                ]);
        } else {
            return redirect('/');
        }
    }
    public function price(Request $request)
    {
        $res = ['status' => 'success'];

        $res['fields']['.js-price-name'] = $request->name;
        $res['fields']['.js-price-email'] = $request->email;
        //$res['src'] = captcha_src();
        $res['popup'] = '.take-price';
        $callback = new Callback();
        $callback->country_id = country()->id;
        $callback->phone = $request->phone;
        $callback->email = $request->email;
        $callback->name = $request->name;
        $callback->ip = $_SERVER['REMOTE_ADDR'];
        $callback->type = 'Получить прайс';
        $callback->city = currentCity()?currentCity()->name:'';
        //$callback->message = $request->message;
        $callback->status = 0;
        if (!$request->agree) {
            $callback->save();
            Mail::to(getConfigValue('message_mail_price'))->send(new \App\Mail\Callback($callback));
        }
        return $res;// $request->all();
    }
    public function storeCall(Request $request)
    {
        $res = ['status' => 'success'];

        $res['name'] = $request->name;
        $res['phone'] = $request->phone;
        /* $data = $request->all();
        unset($data['_token']);
        unset($data['captcha']);
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['type'] = 'Обратный звонок'; */
        $callback = new Callback();
        $callback->name = $request->name;
        $callback->country_id = country()->id;
        $callback->phone = $request->phone;
        $callback->ip = $_SERVER['REMOTE_ADDR'];
        $callback->type = $request->type??'Обратный звонок';
        $callback->city = $request->city;
        $callback->message = $request->message;
        $callback->status = 0;
        if (!$request->agree) {
            $callback->save();
            Mail::to(getConfigValue('message_mail'))->send(new \App\Mail\Callback($callback));
        }
       // \DB::table('callbacks')->insert($data);
        return response()->json($res);// $request->all();
    }
    public function get_captcha(Request $request) {
        $res = ['status' => 'success', 'src' => captcha_src()];
        return response()->json($res);
    }

    /**
     * Sends Check quantity of Under Order products
     *
     * @param Request $request
     *
     * @return array
     */
    public function quantity(Request $request)
    {
        $res = ['status' => 'success'];
        $res['name'] = $request->name;
        $res['phone'] = $request->phone;

        $product = Product::findOrFail($request->product);

        $cb = new Callback();
        $cb->country_id = country()->id;
        $cb->phone = $request->phone;
        $cb->name = $request->name;
        $cb->ip = $_SERVER['REMOTE_ADDR'];
        $cb->type = 'Перезвон по наличию';
        $cb->city = currentCity() ? currentCity()->name : $request->city ?? '';
        $cb->message = $product->remote_id . " " . $product->name;
        $cb->status = 0;
        if (!$request->agree) {
            $cb->save();
            session()->put(['callback_id' => $cb->id]);
            $res['location'] = '/thankyou';
            //this
            $dest = getConfigValue('message_mail');
            Mail::to($dest)->send(new CheckQTY($product, $cb));
        }
        return $res;// $request->all();
    }
}
