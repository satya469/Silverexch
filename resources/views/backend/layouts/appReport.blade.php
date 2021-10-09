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
<!--    <title>{{app_name()}}</title>-->
    <title>DIAMONDEXCHANGE</title>
    <meta name="description" content="@yield('meta_description', 'DIAMONDEXCHANGE')">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
    <!--<meta http-equiv="refresh" content="5; {{ route('frontend.auth.login') }}" />-->
    @yield('meta')
    <link rel="icon" href="{{url('/new/img/flogo.png')}}">
    {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
    @stack('before-styles')
    <style>
    .app-body {
    margin-top: 73px;
}
    </style>
    <!-- Check if the language is set to RTL, so apply the RTL layouts -->
    <!-- Otherwise apply the normal LTR layouts -->
    {{ style(mix('css/backend.css')) }}
    <link rel="stylesheet" href="{{asset('backend/css/bootstrap-datepicker.standalone.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/jquery-ui.min.css')}}">
    <!--<link rel="stylesheet" href="{{asset('backend/css/style.css')}}">-->
    <link rel="stylesheet" href="{{asset('backend/css/theme.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/custome.css')}}">
    <link rel="stylesheet" href="{{asset('backend/custom.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('new/css/backend_mobileView.css')}}">
    <link rel="icon" href="https://dzm0kbaskt4pv.cloudfront.net/v1/static/fav-icon.png">
<link rel="stylesheet" href="https://dzm0kbaskt4pv.cloudfront.net/v1/static/backend/vendor/font-awesome/web-fonts-with-css/css/fontawesome-all.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://dzm0kbaskt4pv.cloudfront.net/v1/static/backend/vendor/jquery-ui/jquery-ui.min.css">
<!--<link rel="stylesheet" href="{{asset('backend/css/b_css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/b_css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/b_css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/b_css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/b_css/bootstrap-datepicker.standalone.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/b_css/theme.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/b_css/all.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/b_css/style.css')}}">-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.standalone.min.css">
<link rel="stylesheet" type="text/css" href="https://dzm0kbaskt4pv.cloudfront.net/v1/static/themes/diamondexch.com/admin/theme.css">
<link rel="stylesheet" type="text/css" href="https://dzm0kbaskt4pv.cloudfront.net/v1/static/backend/css/all.css">
<link rel="stylesheet" type="text/css" href="https://dzm0kbaskt4pv.cloudfront.net/v1/static/backend/css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    @stack('after-styles')
    @include('frontend.includes.sideColor')
    <style>
            .header-bottom li a:hover{
              color: var(--secondary-color) !important;
            }
            .app-header .navbar-nav .dropdown-menu-right {
                  right: 0;
                  left: 3px;
                  min-width: 180px;
              }
            .loader1{
                background: transparent url('{{asset('new/loader.gif')}}') center no-repeat;
                z-index: 9999999;
              }
              @-webkit-keyframes spin {
                0% { -webkit-transform: rotate(0deg); }
                100% { -webkit-transform: rotate(360deg); }
              }

              @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
              }
                @media only screen and (max-width: 768px) {
                    .mobile-menu-pass{
                        margin-top: 0px;
                        text-align: right;
                        font-size: 12px;
                    }
                    .navbar-brand-full{
                        width: 65%;
                        margin-top: 60px;
                        margin-left: 24px;
                    }
                }
        </style>
</head>

{{--
     * CoreUI BODY options, add following classes to body to change options
     * // Header options
     * 1. '.header-fixed'					- Fixed Header
     *
     * // Sidebar options
     * 1. '.sidebar-fixed'					- Fixed Sidebar
     * 2. '.sidebar-hidden'				- Hidden Sidebar
     * 3. '.sidebar-off-canvas'		    - Off Canvas Sidebar
     * 4. '.sidebar-minimized'			    - Minimized Sidebar (Only icons)
     * 5. '.sidebar-compact'			    - Compact Sidebar
     *
     * // Aside options
     * 1. '.aside-menu-fixed'			    - Fixed Aside Menu
     * 2. ''			    - Hidden Aside Menu
     * 3. '.aside-menu-off-canvas'	        - Off Canvas Aside Menu
     *
     * // Breadcrumb options
     * 1. '.breadcrumb-fixed'			    - Fixed Breadcrumb
     *
     * // Footer options
     * 1. '.footer-fixed'					- Fixed footer
--}}
<!--<body class="app header-fixed sidebar-fixed aside-menu-off-canvas sidebar-lg-show">-->
    <body class="app header-fixed sidebar-fixed aside-menu-off-canvas">
    @include('backend.includes.header')

    <div class="app-body" style="margin-top: 75px;">
        @include('backend.includes.sidebar')

        <main class="main">
            @include('includes.partials.read-only')
            @include('includes.partials.logged-in-as')
            <div class="container-fluid" style="margin-top: 10px;">
                <div class="animated fadeIn">
                    <div class="content-header">
                        @yield('page-header')
                    </div><!--content-header-->

                    @include('includes.partials.messages')
                    @yield('content')
                </div><!--animated-->
            </div><!--container-fluid-->
        </main><!--main-->

        @include('backend.includes.aside')
    </div><!--app-body-->

    @include('backend.includes.footer')

    <!-- Scripts -->
    @stack('before-scripts')
    {!! script(mix('js/manifest.js')) !!}
    {!! script(mix('js/vendor.js')) !!}
    {!! script(mix('js/backend.js')) !!}

    <script src="{{asset('backend/js/jquery.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery-ui.min.js')}}"></script>
    <!--<script src="{{asset('backend/js/bet.js')}}"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <!--<script src="{{asset('backend/js/b_js/select2.min.js')}}"></script>-->
    <!--<script src="{{asset('backend/js/game.js')}}"></script>-->
    <!--<script src="{{asset('backend/js/jquery.beefup.js')}}"></script>-->
    <script src="{{asset('backend/js/jquery.dataTables.min.js')}}"></script>
    <!--<script src="{{asset('backend/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>-->



    <!--<script src="{{asset('backend/js/jquery.min.js')}}"></script>-->
    <!--<script src="{{asset('backend/js/jquery-ui.min.js')}}"></script>-->
    <!--<script src="{{asset('backend/js/all.js')}}"></script>-->
    <!--<script src="{{asset('backend/js/bet.js')}}"></script>-->
    <!--<script src="{{asset('backend/js/bootstrap-datepicker.min.js')}}"></script>-->
    <!--<script src="{{asset('backend/js/custom.js')}}"></script>-->
    <!--<script src="{{asset('backend/js/custom_new.js')}}"></script>-->
    <!--<script src="{{asset('backend/js/customjs.js')}}"></script>-->
    <!--<script src="{{asset('backend/js/game.js')}}"></script>-->
    <!--<script src="{{asset('backend/js/jquery.beefup.js')}}"></script>-->
    <!--<script src="{{asset('backend/js/jquery.dataTables.min.js')}}"></script>-->
    <!--<script src="{{asset('backend/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>-->

    <script src="{{asset('backend/js/b_js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/js/b_js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('backend/js/b_js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('backend/js/b_js/pdfmake.min.js')}}"></script>
    <script src="{{asset('backend/js/b_js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('backend/js/b_js/vfs_fonts.js')}}"></script>


    <script src="{{asset('new/index.js')}}"></script>
    <script type="module">
    //   $( document ).ready(function() {
    //     if(window.devtools.isOpen){
    //       logout();
    //     }
    //     window.addEventListener('devtoolschange', event => {
    //       if(event.detail.isOpen){
    //         logout();
    //       }
    //     });
    //   });
    //   function logout(){
    //     window.location.href ='/logout';
    //   }
    </script>
    @stack('after-scripts')
    <script>
      var isCallLogout = false;
      function showLoading(id){
        $('#'+id).addClass('loader1');
      }
      function hideLoading(id){
        $('#'+id).removeClass('loader1');
      }

      function reloadpage(){
//        $('head').append("<meta http-equiv=\"refresh\" content=\"5; {{ route('frontend.auth.login') }}\" />");
         window.location.href ='/login';
      }
      $(function () {
          $(document).ajaxError(function (event, request, options) {

            if (request.status === 401) {
                if(isCallLogout == false){
                    reloadpage();
                    isCallLogout = true;
                }
            }
          });
      });
    </script>
    <script>
  $( document ).ready(function() {
    $( ".dropdown" ).hover(
      function() {
        $( this ).addClass('show');
        $( this ).closest('.dropdown-toggle').attr('aria-expanded',true);
        $( this ).find('.dropdown-menu').addClass('show');
      }, function() {
        $( this ).removeClass('show');
        $( this ).closest('.dropdown-toggle').attr('aria-expanded',false);
        $( this ).find('.dropdown-menu').removeClass('show');
      }
    );
});
</script>
</body>
</html>
