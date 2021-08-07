<?php
function upPrices()
{
    $products = \App\Models\Product::all();
    foreach ($products as $key => $product) {
        //$product->prices[1] = $product->price;
        $product->prices_opt = [1=>[50 => $product->opt_50, 100 => $product->opt_100,300 => $product->opt_300]];

        $product->save();
    }
}
function country()
{
    //upPrices();
    static $country = false;
    if ($country === false) {
        preg_match("/([\w\-]+?)\.([\w\-]+?)$/",$_SERVER['HTTP_HOST'],$matches);
        if (isset($matches[0])) {
            $domain = $matches[0];
            $country = \App\Models\Country::with('corrects.correct')->where('status',1)->where('domain',$domain)->first();
        }
        $country = $country ?? \App\Models\Country::with('corrects.correct')->first();
    }
    return $country;
}
function currency()
{
    return country()->currency;
}
function currentCity()
{
    static $city = false;
    $country = country();


    if ($city === false) {
        if ($_SERVER['HTTP_HOST'] != $country->domain) {
            $sub = explode('.', $_SERVER['HTTP_HOST']);
            $sub = array_shift($sub);
            $city= \App\Models\City::where('country_id',$country->id)->where('slug',$sub)->first();
            if (!$city) {
                abort(404);
            }
        } else {
            $sCity = request()->session()->get('Scity');
            $city = null;
            if ($sCity === null) {
                $ip = $_SERVER['REMOTE_ADDR'];
                $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip . '?lang=ru'));
                if ($query && $query['status'] == 'success') {

                    $name = $query['city'];
                    $city = \App\Models\City::where('country_id',$country->id)->where('name',$name)->first();

                    if ($city) {
                        session(['Scity' => $city->id]);
                    } else {
                        session(['Scity' => 0]);
                    }
                } else {
                    session(['Scity' => 0]);
                }
            } else {
                //$sCity = session(['city'=> $sCity]);
                $city = \App\Models\City::find($sCity);
            }
        }
        if (!$city) {
            $defaultCity = \App\Models\City::where('country_id',$country->id)->where('use_default',1)->first();
            if ($defaultCity) {
                $city = $defaultCity;
            }
        }
         /*
        if (!$city && $country->id == 2) {
            $city = \App\Models\City::find(188);
        } */
    }
    return $city;
}
function cityUrl($city) {
    //dump();
    $url = "";
    if ($city->use_default)
    {
        $url = request()->getScheme().'://'.country()->domain.'/';
    }
    else
    {
        $url = request()->getScheme().'://'.$city->slug.'.'.country()->domain.'/';
    }

    if (strlen(Request::path()) > 1)
    {
        $url = $url.Request::path()."/";
    }

    return $url;
}
function setTitle($title) {
    $city = currentCity();
    if ($city) {
        $title .= ' в '.$city->name5;
    }
    return $title;
}
function rv($text, ...$replacements)
{
    return call_user_func_array("replaceVariables",func_get_args());
}

function replaceVariables($text, ...$replacements) {
    //---------------- replaces chain --------------------
    //user defined
    $text = _rv($text,\App\Services\MainService::getUserDefinedTextVariables());
    //system
    $text = _rv($text,\App\Services\MainService::getSystemTextVariables());
    //country
    $text = _rv($text,country());
    //city
    $text = _rv($text, currentCity());
    //replacements
    foreach ($replacements as $replacement)
    {
        $text = _rv($text, $replacement);
    }
    //clear empty
    $text = _rv($text,true);
    //-------------------- end chain ---------------------
    return $text;
}

/**
 * Low-level analog for ReplaceVariable() helper . Replace all var occurrences in text
 * If last parameter is Boolean true, all empty placeholders been cleared
 * @param $text
 * @param mixed ...$replacements
 *
 * @return string
 */
function _rv($text, ...$replacements)
{
    foreach ($replacements as $item)
    {
        //replace placeholders using replacement array
        if (is_array($item))
        {
            $text = str_replace(array_keys($item),array_values($item),$text);
        }
        //replace placeholders using replacements container
        if ($item instanceof \App\Interfaces\ITextVariablesContainer)
        {
            $text = str_replace(array_keys($item->variables()),array_values($item->variables()),$text);
        }
    }
    //replace empty placeholders if debug is false
    if (!env("APP_DEBUG",false) && (is_bool(end($replacements)) && end($replacements)))
    {
        $pattern = '/\%[\w]+\%/';
        $text = preg_replace($pattern,'',$text);
    }

    return $text;
}
function variablesHelp()
{
    return 'Доступны переменные: %phone%, %phone2%, %address%, %city%, %city1%, %city2%, %city3%, %city4%, %city5%, %city6% -> "в "+%city5%';
}
function nf($number) {
    return number_format($number,0,'.',' ');
}
function getConfigValue($key)
{
    static $config = false;
    if ($config === false) {
        $config = \App\Models\Config::all();
    }
    $res = false;
    $con = $config->where('country_id',country()->id)->where('key', $key)->first();
    if ($con) {
        $res = $con->value;
    }
    return $res;
}
function cv($key)
{
    return getConfigValue($key);
}
function getPhone()
{
    static $res = false;
    if ($res === false ) {
        $city = currentCity();
        if ($city) {
            $phone1 = $city->phone1 ?? getConfigValue('phone1');
        } else {
            $phone1 = getConfigValue('phone1');
        }

        $res = [
            'format' => $phone1,
            'clear' => str_replace(['(', ')', ' ', '-'], '', $phone1),
        ];
    }
    return $res;
}
function getPhone2()
{
    static $res = false;
    if ($res === false ) {
        $city = currentCity();

        if ($city) {
            $phone1 = $city->phone2 ?? getConfigValue('phone_all');
        } else {
            $phone1 = getConfigValue('phone_all');
        }
        $res = [
            'format' => $phone1,
            'clear' => str_replace(['(', ')', ' ', '-'], '', $phone1),
        ];
    }
    return $res;
}
function getEmail()
{
    static $res = false;
    if ($res === false ) {
        /* $city = currentCity();
        if ($city) {
            $res = $city->email ? $city->email : getConfigValue('email');
        } else {
            $res = getConfigValue('email');
        }   */
        $res = getConfigValue('email');
    }
    return $res;
}
function getMap()
{
    static $res = false;
    if ($res === false ) {
        $city = currentCity();
        if ($city) {
            $res = $city->map ?? getConfigValue('map');
        } else {
            $res = getConfigValue('map');
        }
    }
    return $res;
}

function getAddress()
{
    $city = currentCity();
    if ($city) {
        $address = $city->address ?? getConfigValue('address');
    } else {
        $address = getConfigValue('address');
    }
    return $address;
}
function getSchedule()
{
    $city = currentCity();
    if ($city) {
        $address = $city->schedule ? $city->schedule : getConfigValue('schedule');
    } else {
        $address = getConfigValue('schedule');
    }
    return $address;
}
function getScheduleHtml()
{
    $city = currentCity();
    if ($city) {
        $address = $city->schedule ? $city->schedule : getConfigValue('schedule');
    } else {
        $address = getConfigValue('schedule');
    }
    $lines = explode("\n",$address);
    $htmlLines = [];
    foreach ($lines as $key => $line) {
        $htmlLines[] = '<time itemprop="openingHours" datetime="'
                    .str_replace(['Пн','Пт','Сб','Вс',',',' :'],['Mo','Fr','Sa','Su','-',':'],$line)
                    .'">'.$line.'</time>';
    }
    return implode('<br>',$htmlLines);
}
function getCategories() {
    static $categories = false;
    if ($categories === false) {
        $categories = \App\Models\Category::orderBy('order')->get();
    }
    return $categories;
}
function cartCount()
{
    $cart = cartGet();
    $count = 0;
    foreach ($cart as $key => $item) {
        $count += $item;
    }
    return $count;
}
function cartSum()
{
    $cart = cartGet();
    $sum = 0;
    $pids = array_keys($cart);
    $products = \App\Models\Product::whereIn('id',$pids)->get();
    foreach ($products as $key => $item) {
        $sum += $item->getPrice() * $cart[$item->id];
    }
    return $sum;
}

function cartGet()
{
    $cart = request()->session()->get('cart', []);
    return $cart;
}
function citiesInLetter($cities,$letter)
{
    foreach ($cities as $key => $city) {
        if ($city->show_default && mb_strpos($city->name,$letter) === 0)  {
            return true;
        }
    }
    return false;
}
function fitImage($image, $width = null, $height = null,$jpg = false,$qt = 90)
{
    $i = $image;
    $fileA = explode('/',$image);
    if ($image && ($width != null || $height != null)) {
        $folder = 'images/styles/fit_'.$width.'x'.$height;
        $fileName = array_pop($fileA);

        $image = $folder.'/'.$fileName;

        $image = str_replace('.png','.jpg',$image);
        //dd($image);
        if(true || (!file_exists($image) && file_exists($i))) {

            $img = \Image::make($i);
            if ($img->width() > $width && $img->height() > $height) {
                //dd($width, $img->width(), $height, $img->height());
                $img->fit($width, $height, function ($constraint) {
                    $constraint->upsize();
                });
                @mkdir(base_path().'/public/'.$folder,0777,true);
                //dd($folder.'/'.($image));

                $img->encode('jpg');
                $img->save(base_path().'/public/'.($image),100);
            } else {
                copy($i,base_path().'/public/'.($image));
            }
            //app(\Spatie\ImageOptimizer\OptimizerChain::class)->optimize(public_path($image));

        }
    }
    return $image;
}
function resizeImage($image, $width = null, $height = null,$jpg = false,$qt = 90)
{
    $i = $image;
    $fileA = explode('/',$image);
    if ($image && ($width != null || $height != null)) {
        $folder = 'images/styles/size_'.$width.'x'.$height;
        $fileName = array_pop($fileA);

        $image = $folder.'/'.$fileName;

        if(true || (!file_exists($image) && file_exists($i))) {

            $img = \Image::make($i);
            if ($img->width() > $img->height()) {
                $img->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                },'center');
            } else {
                $img->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                },'center');
            }
            $bg = \Image::canvas($width,$height);
            $bg->insert($img,'center');
            @mkdir(base_path().'/public/'.$folder,0777,true);
            //dd($folder.'/'.($image));

            //$img->encode('jpg');
            $img->save(base_path().'/public/'.($image),100);

            //app(\Spatie\ImageOptimizer\OptimizerChain::class)->optimize(public_path($image));

        }
    }
    return $image;
}
function discountDate()
{
    static $date = false;
    if($date === false) {
        $date = getConfigValue('discount_date');
        if ($date) {
            $date = \Carbon\Carbon::parse($date);
        } else {
            $date = \Carbon\Carbon::now();
        }
        $now = \Carbon\Carbon::now();
        $dd = $now->diffInHours($date);

        if ($dd < 3) {
            $date->addHours(getConfigValue('discount_count'));

            \DB::table('configs')->where('key', 'discount_date')->update(['value'=>$date]);
        }
        $date =$now->diffInMinutes($date);
    }
    return $date;
}
function ppId($id)
{
    $url = '';
    $page = \App\Models\Page::find($id);
    if ($page) {
        $url = route('page.show',['slug'=>$page->slug]);
    }
    return $url.'/';
}
function getLat()
{
    static $res = false;
    if ($res === false ) {
        $city = currentCity();
        if ($city) {
            $res = $city->lat_map ? $city->lat_map : getConfigValue('lat');
        } else {
            $res = getConfigValue('lat');
        }
    }
    return $res;
}
function getLng()
{
    static $res = false;
    if ($res === false ) {
        $city = currentCity();
        if ($city) {
            $res = $city->lng_map ? $city->lng_map : getConfigValue('lng');
        } else {
            $res = getConfigValue('lng');
        }
    }
    return $res;
}

/**
 * Checking if user is admin and developer mode enabled
 *
 * @return bool
 */
function _dm()
{
    return access()->dev;
}

/**
 * Checking if editor mode enabled
 *
 * @return bool
 */
function _em()
{
    return access()->edit;
}

/**
 * Run ImageOptimizer chain with user params
 *
 * @param $path
 * @param mixed ...$params
 * @return mixed
 */
function _i($path, ...$params)
{
    $result = $path;
    //$start = microtime(true);
    if (env("IMG_OPTIMIZER", true))
    {
        if (env("APP_ENV") === "production")
            $result =  forward_static_call_array(['\App\Services\ImageOptimizer', "Assign"],func_get_args());
        else
            $result =  forward_static_call_array(['\App\Services\ImageOptimizer', "Optimize"],func_get_args());
    }
    //$time = microtime(true) - $start;
    return $result;
}

/**
 * UTF-8 Complatible lcfirst() function
 *
 * @param $string
 * @return string
 */
function mb_lcfirst($string)
{
    return mb_strtolower(mb_substr($string, 0, 1)) . mb_substr($string, 1);
}

/**
 * UTF-8 Complatible ucfirst() function
 *
 * @param $string
 * @return string
 */

function mb_ucfirst($string)
{
    return mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
}



/**
 * Super meta helper;
 * Returns MetaBuilder instance, if Key is defined, return MetaBuilder->using(Meta) instance with specified key
 *
 * @param null $key
 * @return \App\Services\MetaBuilder|\App\Models\Meta|null
 */

function meta($key = null)
{
    if(is_null($key))
        return \App\Services\MetaBuilder::instance();
    return \App\Services\MetaBuilder::instance()->using($key);
}

/**
 * Super breadcrumb helper;
 * Returns BreadcrumbBuilder instance
 *
 * @return \App\Services\BreadcrumbBuilder
 */

function breadcrumbs()
{
    return \App\Services\BreadcrumbBuilder::instance();
}

/**
 * Captcha helper, returns CaptchaService instance
 *
 * @return \App\Services\CaptchaService
 */
function captcha()
{
    return \App\Services\CaptchaService::instance();
}

/**
 * Render editor widget for IEditable models
 *
 * @param $model
 * @return array|string|null
 * @throws Throwable
 */
function edit($model)
{
    if (_em() && $model instanceof App\Interfaces\IEditable)
    {
        return  view("admin.front.edit-widget",["model"=>$model])->render();
    }
    return null;
}

/**
 *  Return user access manager helper service
 *
 * @return \App\Services\AccessService
 */
function access()
{
    return \App\Services\AccessService::instance();
}

/**
 * Decode UTF8 characters
 * Super code from Stackowerflow
 *
 * @param $str
 * @return string|string[]|null
 */
function escape_sequence_decode($str)
{

    // [U+D800 - U+DBFF][U+DC00 - U+DFFF]|[U+0000 - U+FFFF]
    $regex = '/\\\u([dD][89abAB][\da-fA-F]{2})\\\u([dD][c-fC-F][\da-fA-F]{2})
              |\\\u([\da-fA-F]{4})/sx';

    return preg_replace_callback($regex, function ($matches) {

        if (isset($matches[3])) {
            $cp = hexdec($matches[3]);
        } else {
            $lead = hexdec($matches[1]);
            $trail = hexdec($matches[2]);

            // http://unicode.org/faq/utf_bom.html#utf16-4
            $cp = ($lead << 10) + $trail + 0x10000 - (0xD800 << 10) - 0xDC00;
        }

        // https://tools.ietf.org/html/rfc3629#section-3
        // Characters between U+D800 and U+DFFF are not allowed in UTF-8
        if ($cp > 0xD7FF && 0xE000 > $cp) {
            $cp = 0xFFFD;
        }

        // https://github.com/php/php-src/blob/php-5.6.4/ext/standard/html.c#L471
        // php_utf32_utf8(unsigned char *buf, unsigned k)

        if ($cp < 0x80) {
            return chr($cp);
        } else if ($cp < 0xA0) {
            return chr(0xC0 | $cp >> 6) . chr(0x80 | $cp & 0x3F);
        }

        return html_entity_decode('&#' . $cp . ';');
    }, $str);
}

/**
 * Retturn AdminMessagesService;
 *
 * @return \App\Services\AdminMessagesService
 */
function messages()
{
    return \App\Services\AdminMessagesService::instance();
}

/**
 * Return \App\Services\ProductFilteringService;
 *
 * @return \App\Services\ProductFilteringService
 */
function filters($filters = null)
{
    return \App\Services\ProductFilteringService::instance($filters);
}

/**
 * Return \App\Services\\App\Services\CatalogResolverService;
 *
 * @return \App\Services\CatalogResolverService
 */
function resolver()
{
    return \App\Services\CatalogResolverService::instance();
}

function promocode()
{
    return \App\Services\PromocodeService::instance();
}

function cart()
{
    return \App\Services\CartService::instance();
}