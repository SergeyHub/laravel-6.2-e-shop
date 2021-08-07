<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="HandheldFriendly" content="true"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--------------------- CANONICAL SELF-RELATIVE LINK -------------------}}
    <link rel="canonical" href="{{request()->url()}}/" />

    <title>{{ rv(meta()->title)}}</title>
    <meta property="og:title" content="{{rv(strip_tags(meta()->title))}}"/>
    @if(meta()->description)
        <meta content="{{ rv(meta()->description)}}" name="description"/>
        <meta property="og:description" content="{{ strip_tags(rv(meta()->description))}}"/>
    @endif
    @if(meta()->keywords)
        <meta content="{{ rv(meta()->keywords)}}" name="keywords"/>
    @endif

    {{---------------------- OPEN GRAPH ------------------------------}}

    @if(isset($video_included) && $video_included)
        <meta property="og:video" content="{{rv(strip_tags(meta()->title))}}"/>
    @endif

    <meta property="og:image:height" content="400" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{request()->url()}}" />
    <meta property="og:image" content="http://{{$_SERVER['SERVER_NAME']}}/images/icons/og_logo.jpg" />
    <meta property="og:image:secure_url" content="https://{{$_SERVER['SERVER_NAME']}}/images/icons/og_logo.jpg" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="200" />
    <meta property="og:image:height" content="100" />

    {{---------------------- END OPEN GRAPH -------------------------}}

    <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <style>.loading .loader {position: fixed; width: 100%; height: 100%; top:0; left: 0; background: #fff}</style>

    <link href="{{ mix('css/app.css') }}?v4" rel="stylesheet">
    {!! getConfigValue('scripts_head') !!}

</head>
<body class="body loading @if (!\Request::is('/'))no-front @else front @endif @isset($view){{ $view }} @endisset">
    <div class="root">

        @include('shared.header')
        @yield('content')

        @include('shared.footer')
    </div>

    @include('shared.popups')
    <div class="loader"></div>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>


    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap&subset=cyrillic" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fonts/BebasNeue/stylesheet.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <script src="{{ asset('js/manifest.js') }}"></script>

    <script>
        var currency = '{{ country()->currency }}';
        var actions_minutes = '{{ discountDate() }}';
        console.log(actions_minutes);
    </script>
    <script src="{{ mix('js/app.js') }}"></script>

    {{-- <script src="{{ asset('libs/owl.carousel/dist/owl.carousel.min.js') }}"></script> --}}
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script> --}}
    {!! getConfigValue('scripts') !!}
    @yield('scripts')
</body>
</html>
