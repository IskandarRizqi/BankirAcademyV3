<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-B24NF4VVV9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-B24NF4VVV9');
    </script>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Stylesheets
        ============================================= -->
    <link
        href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&display=swap"
        rel="stylesheet" type="text/css" />
    <link rel="icon" type="image/x-icon" href="{{env('CUSTOM_FAVICON','/359x404.png')}}" />
    <link rel="stylesheet" href="{{asset('front/css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/dark.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/font-icons.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/animate.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/magnific-popup.css')}}" type="text/css" />

    <link rel="stylesheet" href="{{asset('front/css/custom.css')}}" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- SLIDER REVOLUTION 5.x CSS SETTINGS -->
    {{--
    <link rel="stylesheet" type="text/css" href="{{asset('front/include/rs-plugin/css/settings.css')}}"
        media="screen" />
    <link rel="stylesheet" type="text/css" href="{{asset('front/include/rs-plugin/css/layers.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('front/include/rs-plugin/css/navigation.css')}}"> --}}
    <link rel="stylesheet" href="{{asset('front/css/components/ion.rangeslider.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/components/radio-checkbox.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/components/bs-datatable.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/components/bs-filestyle.css')}}" type="text/css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="{{asset('front/toast/dist/css/iziToast.min.css')}}">

    {{--
    <link rel="stylesheet" href="{{asset('front/css/components/datepicker.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/components/timepicker.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/components/daterangepicker.css')}}" type="text/css" /> --}}
    <!-- Document Title
        ============================================= -->
    {{-- <title>{{env('APP_NAME','Bankir Academy')}}</title> --}}
    <title>{{isset($title)?$title:'Bankir Academy'}}</title>

    @isset($class->meta)
    @if ($class->meta != null && is_object(json_decode($class->meta)))
    @for ($i=0;$i<count(json_decode($class->meta)->name);$i++)
        <meta name="{{json_decode($class->meta)->name[$i]}}" content="{{json_decode($class->meta)->content[$i]}}" />
        @endfor
        <meta name="description" content="{{json_decode($class->og)->description}}">

        <!-- Facebook Meta Tags -->
        <meta property="og:url" content="{{url()->current()}}">
        <meta property="og:type" content="website">
        <meta property="og:title" content="{{json_decode($class->og)->title}}">
        <meta property="og:description" content="{{json_decode($class->og)->description}}">
        <meta property="og:image" content="{{asset('/Image/laman/meta_image/'.json_decode($class->og)->image)}}">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta property="twitter:domain" content="{{env('APP_URL','localhost')}}">
        <meta property="twitter:url" content="{{url()->current()}}">
        <meta name="twitter:title" content="{{json_decode($class->og)->title}}">
        <meta name="twitter:description" content="{{json_decode($class->og)->description}}">
        <meta name="twitter:image" content="{{asset('/Image/laman/meta_image/'.json_decode($class->og)->image)}}">
        @endif
        @endisset
        
    @isset($lokergoogle)
    {{-- {{$lokergoogle}} --}}
    <script type="application/ld+json">
        {
          "@context" : "https://schema.org/",
          "@type" : "JobPosting",
          "title" : "{{$lokergoogle['title']}}",
          "description" : "{!!$lokergoogle['description']!!}",
          "identifier": {
            "@type": "PropertyValue",
            "name": "Google",
            "value": "1234567"
          },
          "datePosted" : "{{$lokergoogle['dateposted']}}",
          "validThrough" : "{{$lokergoogle['validThrough']}}",
          "applicantLocationRequirements": {
            "@type": "Country",
            "name": "INA"
          },
          "jobLocation": {
            "@type": "Place",
              "address": {
              "@type": "PostalAddress",
              "streetAddress": "{{$lokergoogle['streetAddress']}}",
              "addressLocality": "{{$lokergoogle['addressLocality']}}",
              "addressRegion": "{{$lokergoogle['addressRegion']}}",
              "postalCode": "{{$lokergoogle['postalCode']}}",
              "addressCountry": "ID"
              }
            },
          "hiringOrganization" : {
            "@type" : "Organization",
            "name" : "{{$lokergoogle['name']}}",
            "sameAs" : "{{$lokergoogle['sameAs']}}",
            "logo" : "{{$lokergoogle['logo']}}"
          },
          "baseSalary": {
            "@type": "MonetaryAmount",
            "currency": "IDR",
            "value": {
              "@type": "QuantitativeValue",
              "value":00,
              "unitText": "Month"
            }
          }
        }
        </script>
    @endisset
        <!-- JavaScripts
            ============================================= -->
        <script src="https://code.jquery.com/jquery-3.6.1.js"
            integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <script src="{{asset('front/js/plugins.min.js')}}"></script>
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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