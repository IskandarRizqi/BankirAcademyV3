<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Stylesheets
	============================================= -->
    <link
        href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&display=swap"
        rel="stylesheet" type="text/css" />
    <link rel="icon" type="image/x-icon" href="{{env('CUSTOM_FAVICON','/Backend/logo_12.png')}}" />
    <link rel="stylesheet" href="{{asset('front/css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/dark.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/font-icons.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/animate.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/magnific-popup.css')}}" type="text/css" />

    <link rel="stylesheet" href="{{asset('front/css/custom.css')}}" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @yield('seo-head')

    <!-- SLIDER REVOLUTION 5.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="{{asset('front/include/rs-plugin/css/settings.css')}}"
        media="screen" />
    <link rel="stylesheet" type="text/css" href="{{asset('front/include/rs-plugin/css/layers.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('front/include/rs-plugin/css/navigation.css')}}">
    <link rel="stylesheet" href="{{asset('front/css/components/ion.rangeslider.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/components/radio-checkbox.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/components/bs-datatable.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/components/bs-filestyle.css')}}" type="text/css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="{{asset('front/toast/dist/css/iziToast.min.css')}}">

    <link rel="stylesheet" href="{{asset('front/css/components/datepicker.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/components/timepicker.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/components/daterangepicker.css')}}" type="text/css" />
    <!-- Document Title
	============================================= -->
    <title>E-class Akarindo</title>

    <!-- JavaScripts
============================================= -->
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="{{asset('front/js/plugins.min.js')}}"></script>
    <style>
        .revo-slider-emphasis-text {
            font-size: 58px;
            font-weight: 700;
            letter-spacing: 1px;
            font-family: 'Poppins', sans-serif;
            padding: 15px 20px;
            border-top: 2px solid #FFF;
            border-bottom: 2px solid #FFF;
        }

        .revo-slider-desc-text {
            font-size: 20px;
            font-family: 'Lato', sans-serif;
            width: 650px;
            text-align: center;
            line-height: 1.5;
        }

        .revo-slider-caps-text {
            font-size: 16px;
            font-weight: 400;
            letter-spacing: 3px;
            font-family: 'Poppins', sans-serif;
        }

        .tp-video-play-button {
            display: none !important;
        }

        .tp-caption {
            white-space: nowrap;
        }
		.longtextoverflow {
			text-overflow: ellipsis;
			overflow: hidden;
			white-space: nowrap;
			max-width: 150px;
		}
    </style>

</head>

<body class="stretched">
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper" class="clearfix">