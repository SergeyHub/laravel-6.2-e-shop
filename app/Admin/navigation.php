<?php

use SleepingOwl\Admin\Navigation\Page;

$items = [

    [
        'title' => 'Обратная связь',
        'icon' => 'fa fa-list',
        'priority' => 0,
        'pages' => [
            (new Page(\App\Models\Order::class))
                ->addBadge(function (){return \App\Models\Order::where('status','new')->count();})
                ->setPriority(1),
            (new Page(\App\Models\Callback::class))
                ->addBadge(function (){return \App\Models\Callback::where('status',0)->count();})
                ->setPriority(1),
            (new Page(\App\Models\Question::class))
                ->addBadge(function (){return \App\Models\Question::where('status',0)->count();}, ['class' => 'label-danger'])
                ->setPriority(1),
            (new Page(\App\Models\Review::class))
                ->addBadge(function (){return \App\Models\Review::where('status',0)->count();}, ['class' => 'label-danger'])
                ->setPriority(1),
            (new Page(\App\Models\Comment::class))
                ->addBadge(function (){return \App\Models\Comment::where('status',0)->count();}, ['class' => 'label-danger'])
                ->setPriority(1),
        ]
    ],
    AdminSection::addMenuPage(\App\Models\Product::class)->setPriority(1),
    AdminSection::addMenuPage(\App\Models\Filter::class)->setPriority(1),
    AdminSection::addMenuPage(\App\Models\FilterGroup::class)->setPriority(1),
    AdminSection::addMenuPage(\App\Models\Set::class)->setPriority(1),
    //AdminSection::addMenuPage(\App\Models\Brand::class)->setPriority(1),
    [
        'title' => 'Справочники',
        'icon' => 'fa fa-list',
        'priority' => 10,
        'pages' => [
            new Page(\App\Models\Country::class),
            new Page(\App\Models\City::class),
            new Page(\App\Models\Member::class),
        ]
    ],
    [
        'title' => 'Страницы',
        'icon' => 'fa fa-book',
        'priority' => 10,
        'pages' => [
            (new Page(\App\Models\Block::class))
                ->setIcon('fa fa-home')
                ->setPriority(1),
            (new Page(\App\Models\Page::class))
                ->setIcon('fa fa-list')
                ->setPriority(1),

        ]
    ],
    [
        'title' => 'Полезная информация',
        'icon' => 'fa fa-newspaper-o',
        'priority' => 10,
        'pages' => [
            (new Page(\App\Models\News::class))
                ->setPriority(1),
            (new Page(\App\Models\Promo::class))
                ->setPriority(1),
            (new Page(\App\Models\Blog::class))
                ->setPriority(1),
        ]
    ],
    [
        'title' => 'Конфигурация',
        'icon' => 'fa fa-cogs',
        'priority' => 10,
        'pages' => [
            (new Page(\App\Models\Correct::class))
                ->setPriority(1),
            (new Page(\App\Models\Meta::class))
                ->setPriority(1),
            (new Page(\App\Models\Config::class))
                ->setPriority(1),
            (new Page(\App\Models\User::class))
                ->setPriority(1),
        ]
    ],
    //-------------------- DEVELOPER MODE -----------------------------
    [
        'title' => 'Режим разработчика',
        'icon' => 'fa fa-terminal',
        'priority' => 15,
        'accessLogic' => function(){return _dm();},
        'pages' => [
            [
                'title' => 'Блоки',
                'url' => '/admin/dev/blocks',
                'icon' => 'fa fa-cogs',
                'badge' => function(){return \App\Models\Block::count();}
            ],
            [
                'title' => 'Страницы',
                'url' => '/admin/dev/pages',
                'icon' => 'fa fa-cogs',
                'badge' => function(){return \App\Models\Page::count();}
            ],
            [
                'title' => 'Мета',
                'url' => '/admin/dev/metas',
                'icon' => 'fa fa-cogs',
                'badge' => function(){return \App\Models\Meta::count();}
            ],
            [
                'title' => 'Настройки',
                'url' => '/admin/dev/configs',
                'icon' => 'fa fa-cogs',
                'badge' => function(){return \App\Models\Config::count();}
            ],
            [
                'title' => 'Страны',
                'url' => '/admin/dev/countries',
                'icon' => 'fa fa-cogs',
                'badge' => function(){return \App\Models\Country::count();}
            ],
            [
                'title' => 'Переменные среды',
                'url' => '/admin/env/editor',
                'icon' => 'fa fa-code',
            ],
        ]
    ],
];
return $items;
