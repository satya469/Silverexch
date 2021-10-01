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
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'DIAMONDEXCHANGE')">
        <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
        @yield('meta')
<link rel="icon" href="{{url('/new/img/flogo.png')}}">
        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
        @stack('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        {{ style(mix('css/frontend.css')) }}
        <link rel="stylesheet" href="{{asset('new/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('new/css/theme.css')}}">
        
        <link rel="stylesheet" href="{{asset('new/css/all.css')}}">
        <link rel="stylesheet" href="{{asset('new/css/cssAll.css')}}">
        <link rel="stylesheet" href="{{asset('new/css/custom.css')}}">
        <link rel="stylesheet" href="{{asset('new/css/flipclock.css')}}">
        <link rel="stylesheet" href="{{asset('new/css/owl.carousel.css')}}">
        <link rel="stylesheet" href="{{asset('new/css/owl.theme.default.css')}}">
        
        <style>
            .header-bottom li a:hover{
              color: var(--secondary-color) !important;
            }
        </style>
        @stack('after-styles')
        @include('frontend.includes.sideColor')
        
    </head>
    <body>
        @include('includes.partials.read-only')

        <div id="app">
            @include('includes.partials.logged-in-as')
            @include('frontend.includes.navPass')

            <div class="main">
                @include('includes.partials.messages')
                @yield('content')
            </div><!-- container -->
        </div><!-- #app -->

        <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        @stack('before-scripts')
        {!! script(mix('js/manifest.js')) !!}
        {!! script(mix('js/vendor.js')) !!}
        {!! script(mix('js/frontend.js')) !!}
        
        
        <script src="https://cdn.rawgit.com/dcodeIO/protobuf.js/6.8.6/dist/protobuf.min.js"></script>
        <script>$protobuf = protobuf;</script>
        <script src="{{asset('new/js/customjs.js')}}"></script>
    <script src="{{asset('new/js/flipclock.js')}}"></script>
    <script src="{{asset('new/js/messages.js')}}"></script>
    <script src="{{asset('new/js/owl.carousel.min.js')}}"></script>
    <!--<script src="{{asset('new/js/protobuf.min.js')}}"></script>-->
    <!--<script src="{{asset('new/js/socket.io.js')}}"></script>-->
    <!--<script src="{{asset('new/js/jsAll.js')}}"></script>-->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js'></script>
    
      
     <!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">-->  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>    
    @stack('after-scripts')
    @include('includes.partials.ga')
    <script>
      $( document ).ready(function() {
        $("#msg-alert").fadeTo(2000, 500).slideUp(500, function(){
         
            $("#msg-alert").slideUp(500);
        });
      });
    </script>
  </body>
</html>
