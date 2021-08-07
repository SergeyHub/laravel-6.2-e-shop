<?php print '<?xml version="1.0" encoding="UTF-8" ?>'; ?>
<yml_catalog date="{{ date('Y-m-d H:i') }}">
    <shop>
        <name>{{ cv('export_name') }}</name>
        <company>{{ cv('export_company') }}</company>
        <url>https://{{ country()->domain }}</url>
        <agency>{{ cv('export_company') }}</agency>
        <email>leonid@leonidovich.net</email>
        <currencies>
          <currency id="RUB" rate="1"/>
        </currencies>
        <categories>
            @foreach ($categories as $category)
            <category id="{{ $category->id }}">{{ $category->name }}</category>    
            @endforeach
        </categories>
        <delivery-options>
            <option cost="{{ cv('export_cost') }}" days="{{ cv('export_days') }}"/>
        </delivery-options>
        <pickup-options>
            <option cost="{{ cv('export_pickup_cost') }}" days="{{ cv('export_pickup_days') }}"/>
        </pickup-options>
        {{-- <enable_auto_discount>true</enable_auto_discount> --}}
        <offers>
            @foreach ($products as $product)
            <offer id="{{ $product->id }}">
                <name>{{ html_entity_decode(trim(strip_tags($product->name))) }}</name>
                @if ($product->brand)
                <vendor>{{ $product->brand->name }}</vendor>
                @endif
                <url>{{ $product->getUrl() }}</url>
                <price>{{ $product->getPrice() }}</price>
                @if ($product->getPrice(0))
                <oldprice>{{ $product->getPrice(0) }}</oldprice>
                @endif
                <currencyId>RUB</currencyId>
                <categoryId>{{ $product->categories->first()->id }}</categoryId>
                <picture>{{ asset($product->getImage()) }}</picture>
                <store>false</store>
                <pickup>true</pickup>
                <delivery>true</delivery>
                <delivery-options>
                    <option cost="{{ cv('export_cost') }}" days="{{ cv('export_days') }}"/>
                </delivery-options>
                <description>
                <![CDATA[
                  {!! $product->description !!}
                ]]>
                </description>
                @php
                    $specification = explode("\n",$product->feature);
                @endphp
                @foreach ($specification as $item)
                    @php
                        $col = explode('|',$item)
                    @endphp
                    <param name="{{ str_replace(':','',trim($col[0])) }}">{{isset($col[1])?trim($col[1]):''}}</param>
                @endforeach
            </offer>
            @endforeach
        </offers>
    </shop>
</yml_catalog>