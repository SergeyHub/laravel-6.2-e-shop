@extends('layouts.app')
@section('content')
    <div class="container">
        @include('shared.breadcrumb')
        <h1 class="main-title text-center">Карта сайта</h1>
        <h4 class="my-4">Меню</h4>
        <ul>
            @foreach ($list ?? [] as $item)
                <li>
                    <a class="mb-2 d-block" href="{{ $item['href'] }}">{{ $item['title'] }}</a>
                    @if (count($item['sub'] ?? []))
                        <ul>
                            @foreach ($item['sub'] as $subItem)
                                <li><a class="mb-2 d-block" href="{{ $subItem['href'] }}">{{ $subItem['title'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endsection


{{-- <div class="contacts__rec" id="details">
    <h2 class="contacts__rec__title">Реквизиты</h2>
    <h3 class="d-none" itemprop="name">{{ cv("company_name") }}</h3>
    <h3>Юридическое лицо</h3>
    <div class="d-flex flex-wrap">
    @foreach ($lines as $row)
        <ul class="list-unstyled mb-0">
            @foreach ($row as $item)
                <li>{!! rv($item) !!}</li>
            @endforeach
        </ul>
    @endforeach
    </div>
</div> --}}
