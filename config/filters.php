<?php

/*
    Custom filters for catalog. This filters uses model properties for query

*/

return [
    /*
        Types:
        * variant -> Uses distinct properties
        * flag -> Uses boolean property
        * range -> Uses integer or float property


     */
    "test_range" => [
        "name" => "Тестовый фильтр",
        "type" => "range",
        "property" => "test",
        "step" => 1,
        "unit" => "MHz",
    ],

/*    "test_range2" => [
        "name" => "Тестовый фильтр",
        "type" => "range",
        "property" => "",
        "breakpoints" => [

        ],
        "unit" => "MHz",
    ],*/

    "test_variant" => [
        "name" => "Тестовый фильтр",
        "type" => "variant",
        "property" => "test",
        "variants" =>
        [
            1 => "ТЕСТ1",
            2 => "ТЕСТ2",
        ]
    ],
];
