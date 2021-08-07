<?php
return [
    "types" => [
        "create" => [
            "name" => "Создан",
            "icon" => "fa fa-plus",
        ],
        "update" => [
            "name" => "Изменён",
            "icon" => "fa fa-edit",
        ],
        "delete" => [
            "name" => "Удалён",
            "icon" => "fa fa-remove",
        ]
    ],
    "models" => [
        \App\Models\Block::class => [
            "name" => "Блок главной",
            "icon" => "fa fa-home",
        ],
        \App\Models\Blog::class => [
            "name" => "Статья",
            "icon" => "fa fa-book",
        ],
        \App\Models\Brand::class => [
            "name" => "Бренд",
            "icon" => "fa fa-certificate",
        ],
        \App\Models\Callback::class => [
            "name" => "Перезвон",
            "icon" => "fa fa-reply",
        ],
        \App\Models\Category::class => [
            "name" => "Категория",
            "icon" => "fa fa-tags",
        ],
        \App\Models\City::class => [
            "name" => "Город",
            "icon" => "fa fa-file-image-o",
        ],
        \App\Models\Comment::class => [
            "name" => "Комментарий",
            "icon" => "fa fa-comments",
        ],
        \App\Models\Config::class => [
            "name" => "Настройка",
            "icon" => "fa fa-cogs",
        ],
        \App\Models\Correct::class => [
            "name" => "Замена",
            "icon" => "fa fa-random",
        ],
        \App\Models\CorrectItem::class => [
            "name" => "Замена",
            "icon" => "fa fa-random",
            "edit"=> false
        ],
        \App\Models\Country::class => [
            "name" => "Страна",
            "icon" => "fa fa-map-marker",
        ],
        \App\Models\Member::class => [
            "name" => "Сотрудник",
            "icon" => "fa fa-users",
        ],
        \App\Models\Meta::class => [
            "name" => "Мета",
            "icon" => "fa fa-bullseye",
        ],
        \App\Models\Message::class => [
            "name" => "Сообщение",
            "icon" => "fa fa-sticky-note-o",
            "edit"=> false
        ],
        \App\Models\News::class => [
            "name" => "Новость",
            "icon" => "fa fa-book",
        ],
        \App\Models\Order::class => [
            "name" => "Заказ",
            "icon" => "fa fa-shopping-cart",
        ],
        \App\Models\Page::class => [
            "name" => "Страница",
            "icon" => "fa fa-list",
        ],
        \App\Models\Product::class => [
            "name" => "Товар",
            "icon" => "fa fa-product-hunt",
        ],
        \App\Models\Promo::class => [
            "name" => "Акция",
            "icon" => "fa fa-book",
        ],
        \App\Models\Question::class => [
            "name" => "Вопрос",
            "icon" => "fa fa-question",
        ],
        \App\Models\Review::class => [
            "name" => "Отзыв",
            "icon" => "fa fa-quote-right",
        ],
        \App\Models\Set::class => [
            "name" => "Подборка",
            "icon" => "fa fa-tags",
        ],
        \App\Models\User::class => [
            "name" => "Аккаунт",
            "icon" => "fa fa-lock",
        ],
    ]
];
