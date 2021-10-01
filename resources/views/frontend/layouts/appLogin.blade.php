<!DOCTYPE html>
@langrtl
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endlangrtl
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--<title>@yield('title', app_name())</title>-->
        <title>Diamond Exch</title>
        <meta name="description" content="@yield('meta_description', 'Diamond Exch')">
        <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
        @yield('meta')
<link rel="icon" href="{{url('/new/img/flogo.png')}}">
        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
        @stack('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        {{ style(mix('css/frontend.css')) }}
         <link rel="icon" href="{{url('/new/img/flogo.png')}}">
        {{ style(mix('css/frontend.css')) }}
        <link rel="stylesheet" href="{{asset('new/css_new/fontawesome-all.min.css')}}">
        <link rel="stylesheet" href="{{asset('new/css_new/jquery-ui.min.css')}}">
        <link rel="stylesheet" href="{{asset('new/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('new/css/theme.css')}}">
        <link rel="stylesheet" href="{{asset('new/css/all.css')}}">
        <link rel="stylesheet" href="{{asset('new/css/cssAll.css')}}">
        <link rel="stylesheet" href="{{asset('new/css/custom.css')}}">
        <link rel="stylesheet" href="{{asset('new/css/flipclock.css')}}">
        <link rel="stylesheet" href="{{asset('new/css/owl.carousel.css')}}">
        <link rel="stylesheet" href="{{asset('new/css/owl.theme.default.css')}}">
        <link rel="stylesheet" href="{{asset('new/css/mobileView.css')}}">
        @stack('after-styles')
        @include('frontend.includes.sideColor')
        <style>
          .col-sm-8 {
              flex: 0 0 187.667% !important;
              max-width: 64% !important;
          }
          
            html, body{
                width: 100%;
                background-image: linear-gradient(var(--theme1-bg), var(--theme2-bg));
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            
            @media only screen and (max-width: 768px) {
            .col-sm-8 {
                flex: 0 0 187.667% !important;
                max-width: 100% !important;
            }
            }
        </style>
    </head>
    <body>
        @include('includes.partials.read-only')

        <div id="app">
            @include('includes.partials.logged-in-as')
            

            <div class="container login" style="max-width:100%;padding-bottom: 120px;">
<!--                @include('includes.partials.messages')-->
                @yield('content')
            </div><!-- container -->
        </div><!-- #app -->

        <!-- Scripts -->
        @stack('before-scripts')
        {!! script(mix('js/manifest.js')) !!}
        {!! script(mix('js/vendor.js')) !!}
        {!! script(mix('js/frontend.js')) !!}
        @stack('after-scripts')

        @include('includes.partials.ga')
    </body>
</html>
