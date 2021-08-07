<?php

namespace App\Http\Controllers;

use App\Models\{
    Page,
    Meta
};
use Illuminate\Http\Request;
use Sitemap;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{

    public function test()
    {

        //return 'end';
        $callback = \App\Models\Question::find(12);
        //Mail::to('leonidsor@gmail.com')->send(new \App\Mail\OrderShipped($callback));
        return new \App\Mail\Answer($callback);

        return 'dddd';
    }


    /**
     * Display the specified resource.
     *
     * @param  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $city = null)
    {

        //return view('pages.'.$slug);
        currentCity();
        //dd(country());
        $page = Page::where('slug',$slug)->where('country_id',country()->id)->first();
        if ($page && $page->status) {
            /* META */
            meta($page);

            breadcrumbs()
                ->root()
                ->to($page->title);

            return view('pages.'.$page->view,[
                'page'=>$page,
                'title'=> $page->title,
                'view' => str_replace('.','-',$page->view),
                ]);
        } else {
            abort(404);
        }
    }
    public function reviews()
    {
        $page = \App\Models\Page::where('type','sys')->where('view','reviews')->where('country_id',country()->id)->first();
        if ($page  && $page->status) {
            /* META */
            meta($page);

            breadcrumbs()
                ->root()
                ->to($page->title);

            $reviews = \App\Models\Review::where('status',1)->get();
            $view = 'reviews_show';
            $title = $page->title;
            return view('pages.reviews',compact('reviews','page','view','title'));
        } else {
            abort(404);
        }
    }

    public function contacts()
    {
        $page = \App\Models\Page::where('type','page')->where('view','page.contact')->where('country_id',country()->id)->first();
        if ($page && $page->status) {
            /* META */
            meta($page);

            breadcrumbs()
                ->root()
                ->to($page->title);

            $view = 'contacts_show';
            $title = $page->title;
            $lines = collect(explode("\n",$page->body))->split(2);
            return view('pages.page.contact',compact('page','lines','view','title'));
        } else {
            abort(404);
        }
    }
    public function showFront() {
        meta()
            ->using(currentCity())
            ->using("front");

        $blocks = \App\Models\Block::where('status',1)
                                    ->where('type', 'front')
                                    ->where('country_id',country()->id)
                                    ->orderBy('order')
                                    ->get();

        return view('pages.front',['blocks'=>$blocks]);
    }
    public function video() {

        $meta = [
            'title' => getConfigValue('video_title'),
            'description' => getConfigValue('video_description'),
            'keywords' => getConfigValue('video_keywords'),
        ];
        $videos = \App\Models\Video::where('status',1)->orderBy('order','asc')->get();
        $title = 'Видеообзоры';
        $fix_bg = [
            [
                'image' => '../images/line_bg.png',
                'element' => '.video__wrapper',
            ]
        ];
        return view('pages.video',[
            'videos'    =>  $videos,
            'title'     =>  $title,
            'fluid'     =>  true,
            'fix_bg'    =>  $fix_bg,
            'meta'      =>  $meta,
        ]);
    }
    public function wholesale() {
        $meta = [
            'title' => getConfigValue('wholesale_title'),
            'description' => getConfigValue('wholesale_description'),
            'keywords' => getConfigValue('wholesale_keywords'),
        ];
        $pids = \App\Models\ProductPrice::where('country_id',country()->id)->where('qty','>',1)->get()->pluck('product_id')->toArray();
        $items = \App\Models\Product::whereIn('id',$pids)->get();
        return view('pages.wholesale',[
            'items'     => $items,
            'fluid'     => true,
            'meta'      =>  $meta,
        ]);
    }
    public function robots()
    {
        $city = currentCity();
        if($city && $city->robots) {
            $robots = $city->robots;

        } else {
            $robots = getConfigValue('robots');

        }
        if ($_SERVER['HTTP_HOST'] != country()->domain) {
            $host = 'https://'.($city ? $city->slug.'.'.country()->domain : country()->domain);
        } else {
            $host = 'https://'.country()->domain;
            $robots = getConfigValue('robots_domain');
        }

        //$robots.= "\nHost: ".$host;
        $robots.= "\n\nSitemap: $host/sitemap.xml";
        return response($robots, 200)
            ->header('Content-Type', 'text/plain');
    }

    public function contactCity($slug)
    {
        $city = \App\Models\City::where('slug',$slug)->where('country_id',country()->id)->first();
        if ($city) {
            $meta = [
                'title' => setTitle('Контакты'),
            ];
            $breadcrumbs = [
                ['href' => '/', 'name' => 'Главная'],
                ['href' => '/contact/', 'name' => setTitle('Контакты')],
            ];
            $title = setTitle('Контакты');
            return view('pages.contact_city',[
                'city'=>$city,
                'breadcrumbs' => $breadcrumbs,
                'title' => $title,
                'meta'=>$meta
                ]);
        } else {
            abort(404);
        }
    }
    public function pageSitemap()
    {
        meta("sitemap");

        breadcrumbs()
            ->root()
            ->to("Карта сайта");

        // ------------------------- СТРАНИЦЫ ------------------------------
        $list = [
            ['title' => 'Главная','href' => route('front').'/']
        ];
        $catalog = ['title' => 'Каталог','href' => route('catalog.show').'/','sub'=>[]];
        foreach (resolver()->map() as $item) {
            $catalog['sub'][] = [
                'title' => "Осциллографы ".$item->name,
                'href' => $item->href."/",
            ];
        }
        $list[] = $catalog;
        $list[] = ['title' => 'Статьи','href' => route('blog.index').'/'];
        $list[] = ['title' => 'Акции','href' => route('promo.index').'/'];
        $list[] = ['title' => 'Новости','href' => route('news.index').'/'];
        foreach (\App\Models\Page::where('status',1)->get() as $key => $page) {
            $list[] = ['title' => $page->title,'href' => ppId($page->id)];
        }
        $view = 'articles';
        return view('pages.page.sitemap',compact('list','view'));
    }
    public function sitemap()
    {
        /* $page = Page::where('lang', 'ru')->orderBy('updated_at', 'DESC')->first();
        Sitemap::addTag(config('app.url') . '/', $page->updated_at, 'monthly', '1');
        Sitemap::addTag(config('app.url') . '/services/', $page->updated_at, 'monthly', '1');
        Sitemap::addTag(config('app.url') . '/cooperation/', '', 'monthly', '1'); */
        $city = currentCity();
        if ($city && $city->sitemap) {
            $links = explode("\n", $city->sitemap);
            foreach ($links as $link) {
                if (strpos($link,'http')!==0) {
                    $link = url($link);
                }
                Sitemap::addTag($link, false , 'daily', '1');
            }
        } else {
            $paths = [
                route('front')."/",
                //route('catalog.show')
            ];
            $remove = [];
            if($city && $city->sitemap_remove) {
                $links = explode("\n", $city->sitemap_remove);
                foreach($links as $link) {
                    $remove[] = url($link);
                }
            }


            /* $categories = \App\Models\Category::all();
            foreach ($categories as $category) {
                 $url = route('catalog.category', ['slug'=>$category->slug ]);
                $paths[$url] = $url;
            } */
            foreach (resolver()->map() as $item) {
                $url = request()->getScheme()."://".request()->getHttpHost().$item->href."/"/*.$item->postfix*/;
                $paths[$url] = $url;
            }
            $products = \App\Models\Product::where('status',1)->get();
            foreach ($products as $product) {
                $url = $product->getUrl();
                $paths[$url] = $url;
            }
            $pages = Page::where('status',1)->get();
            foreach ($pages as $item) {
                $url = route('page.show', ['slug' => $item->slug]).'/';
                if (!in_array($url, $remove)) {
                    Sitemap::addTag($url, $item->updated_at, 'daily', '1');
                }
            }
            array_sort($paths);
            foreach ($paths as $url) {
                if (!in_array($url, $remove)) {
                    Sitemap::addTag($url, false, 'daily', '1');
                }
            }

            /*
            if ($city && $city->sitemap_add) {
                $add =explode("\n", $city->sitemap_add);
                foreach($add as $link) {
                    $url = url($link);
                    if (!in_array($url, $remove)) {
                        Sitemap::addTag($url, false, 'daily', '1');
                    }
                }
            } */


        }


        /* $page = Page::where('lang', 'en')->orderBy('updated_at', 'DESC')->first();
        Sitemap::addTag(config('app.url') . '/en/', $page ? $page->updated_at : '', 'monthly', '1');
        Sitemap::addTag(config('app.url') . '/en/services/', $page ? $page->updated_at : '', 'monthly', '1');
        Sitemap::addTag(config('app.url') . '/en/cooperation/', '', 'monthly', '1');
        $pages = Page::where('lang', 'en')->where('type', 'story')->orderBy('updated_at', 'DESC')->get();
        foreach ($pages as $page) {
            Sitemap::addTag(config('app.url') . '/en/' . $page->alias . '.html', $page->updated_at, 'daily', '1');
        } */

        return Sitemap::render();
    }
}
