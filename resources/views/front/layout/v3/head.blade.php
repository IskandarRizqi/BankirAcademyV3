<head>
         <title>{{isset($title)?$title:'Bankir Academy'}}</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="author" content="ThemeZaa">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="description" content="Elevate your online presence with Crafto - a modern, versatile, multipurpose Bootstrap 5 responsive HTML5, SCSS template using highly creative 56+ ready demos.">
        <!-- favicon icon -->
        <link rel="icon" type="image/x-icon" href="{{env('CUSTOM_FAVICON','/359x404.png')}}" />
        {{-- <link rel="shortcut icon" href="{{ asset('FE/favicons/608-images-favicon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('FE/favicons/4010-images-apple-touch-icon-57x57.png') }}"> --}}
        {{-- <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('FE/favicons/6952-images-apple-touch-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('FE/favicons/8487-images-apple-touch-icon-114x114.png') }}"> --}}

        <link rel="stylesheet" href="{{ asset('FE/css/css-vendors.min.css') }}">
        <link rel="stylesheet" href="{{ asset('FE/css/css-icon.min.css') }}">
        <link rel="stylesheet" href="{{ asset('FE/css/css-style.min.css') }}">
        <link rel="stylesheet" href="{{ asset('FE/css/css-responsive.min.css') }}">
        <link rel="stylesheet" href="{{ asset('FE/css/consulting-consulting.css') }}">

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
</head>