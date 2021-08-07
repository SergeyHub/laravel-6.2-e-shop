<?php

return [
    "sections" =>[
        "_backend"=> [
            "section_name" => "Админка",
            "icon" => "fa fa-file-code-o"
        ],
        "_default"=> [
            "section_name" => "Сайт",
            "icon" => "fa fa-laptop"
        ],
        //------------------------------------
        "blocks"=> [
            "section_name" => "Блоки главной",
            "instance_name" => "Блок главной",
            "instance_class" => \App\Models\Block::class,
            "icon" => "fa fa-home"
        ],
        "blogs"=> [
            "section_name" => "Статьи",
            "instance_name" => "Статья",
            "instance_class" => \App\Models\Blog::class,
            "name_field" => "title",
            "icon" => "fa fa-book"
        ],
        "brands"=> [
            "section_name" => "Бренды",
            "instance_name" => "Бренд",
            "instance_class" => \App\Models\Brand::class,
            "icon" => "fa fa-certificate"
        ],
        "callbacks"=> [
            "section_name" => "Перезвоны",
            "instance_name" => "Перезвон",
            "icon" => "fa fa-reply"
        ],
        "categories"=> [
            "section_name" => "Категории",
            "instance_name" => "Категория",
            "instance_class" => \App\Models\Category::class,
            "icon" => "fa fa-tags"
        ],
        "cities"=> [
            "section_name" => "Города",
            "instance_name" => "Город",
            "instance_class" => \App\Models\City::class,
            "icon" => "fa fa-file-image-o"
        ],
        "comments"=> [
            "section_name" => "Комментарии",
            "instance_name" => "Комментарий",
            "icon" => "fa fa-comments"
        ],
        "configs"=> [
            "section_name" => "Настройки",
            "instance_name" => "Настройка",
            "instance_class" => \App\Models\Config::class,
            "icon" => "fa fa-cogs"
        ],
        "corrects"=> [
            "section_name" => "Автозамены",
            "instance_name" => "Автозамена",
            "instance_class" => \App\Models\Correct::class,
            "icon" => "fa fa-random"
        ],
        "countries"=> [
            "section_name" => "Страны",
            "instance_name" => "Страна",
            "instance_class" => \App\Models\Country::class,
            "icon" => "fa fa-map-marker"
        ],
        "dev"=> [
            "section_name" => "Раздел разработчика",
            "icon" => "fa fa-code"
        ],
        "editor"=> [
            "section_name" => "Редактор",
            "icon" => "fa fa-table"
        ],
        "env"=> [
            "section_name" => "Конфигурация",
            "icon" => "fa fa-code"
        ],
        "history"=> [
            "section_name" => "Журнал действий",
            "instance_name" => "Запись в журнале действий",
            "icon" => "fa fa-history"
        ],
        "members"=> [
            "section_name" => "Сотрудники",
            "instance_name" => "Сотрудник",
            "icon" => "fa fa-users"
        ],
        "messages"=> [
            "section_name" => "Сообщения",
            "instance_name" => "Сообщение",
            "icon" => "fa fa-sticky-note"
        ],
        "metas"=> [
            "section_name" => "Мета",
            "instance_name" => "Мета",
            "instance_class" => \App\Models\Meta::class,
            "icon" => "fa fa-bullseye"
        ],
        "news"=> [
            "section_name" => "Новости",
            "instance_name" => "Новость",
            "instance_class" => \App\Models\News::class,
            "name_field" => "title",
            "icon" => "fa fa-book"
        ],
        "orders" => [
            "section_name" => "Заказы",
            "instance_name" => "Заказ",
            "icon" => "fa fa-shopping-cart"
        ],
        "pages"=> [
            "section_name" => "Страницы",
            "instance_name" => "Страница",
            "instance_class" => \App\Models\Page::class,
            "icon" => "fa fa-list"
        ],
        "products"=> [
            "section_name" => "Товары",
            "instance_name" => "Товар",
            "instance_class" => \App\Models\Product::class,
            "icon" => "fa fa-product-hunt"
        ],
        "promos"=> [
            "section_name" => "Акции",
            "instance_name" => "Акция",
            "instance_class" => \App\Models\Promo::class,
            "name_field" => "title",
            "icon" => "fa fa-book"
        ],
        "questions"=> [
            "section_name" => "Вопросы",
            "instance_name" => "Вопрос",
            "icon" => "fa fa-question"
        ],
        "reviews"=> [
            "section_name" => "Отзывы",
            "instance_name" => "Отзыв",
            "icon" => "fa fa-quote-right"
        ],
        "sets"=> [
            "section_name" => "Подборки",
            "instance_name" => "Подборка",
            "instance_class" => \App\Models\Set::class,
            "icon" => "fa fa-tags"
        ],
        "sizes"=> [
            "section_name" => "Размеры",
            "instance_name" => "Размер",
            "instance_class" => \App\Models\Size::class,
            "icon" => "fa fa-tags"
        ],
        "types"=> [
            "section_name" => "Типы",
            "instance_name" => "Тип",
            "instance_class" => \App\Models\Type::class,
            "icon" => "fa fa-tags"
        ],
        "users"=> [
            "section_name" => "Аккаунты",
            "instance_name" => "Аккаунт",
            "instance_class" => \App\Models\User::class,
            "icon" => "fa fa-lock"
        ],
    ],
    'types'=>[
        "message"=>[
            "name"=>"Сообщение",
            "icon"=>"fa fa-sticky-note-o"
        ],
        "resolved"=>[
            "name"=>"Закрыто",
            "icon"=>"fa fa-check"
        ],
        "problem"=>[
            "name"=>"Проблема",
            "icon"=>"fa fa-flag"
        ],
        "bug"=>[
            "name"=>"Баг",
            "icon"=>"fa fa-bug"
        ],
        "note"=>[
            "name"=>"Заметка",
            "icon"=>"fa fa-warning"
        ],

    ]
];
