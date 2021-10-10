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
    <meta name="description" content="@yield('meta_description', 'HP EXCH')">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
    @yield('meta')

    @stack('before-styles')
    <link rel="icon" href="{{ url('/new/img/flogo.png') }}">
    {{ style(mix('css/frontend.css')) }}
    <link rel="stylesheet" href="{{ asset('new/css_new/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new/css_new/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('new/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('new/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('new/css/cssAll.css') }}">
    <link rel="stylesheet" href="{{ asset('new/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('new/css/flipclock.css') }}">
    <link rel="stylesheet" href="{{ asset('new/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('new/css/owl.theme.default.css') }}">
    <link rel="stylesheet" href="{{ asset('new/css/mobileView.css') }}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="{{ asset('new/js_new/jquery.min.js') }}"></script>
    <style>
        .yellow-color {
            background-color: #f5c71a !important;
        }

        .header-bottom li a:hover {
            color: var(--secondary-color) !important;
        }

        .avoid-clicks {
            pointer-events: none;
        }

        .loader1 {
            background: transparent url('{{ asset('new/loader.gif') }}') center no-repeat;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        .app-header .navbar-nav .dropdown-menu-right {
            right: 0;
            left: 3px;
            min-width: 180px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .sidebar .nav-item .nav-link,
        .sidebar .mtree li a {
            font-size: 17px;
        }

        .dot {
            height: 10px;
            width: 10px;
            background-color: #4CAF50;
            border-radius: 50%;
            display: inline-block;
        }

    </style>
    @stack('after-styles')
    @include('frontend.includes.sideColor')

</head>

<body>
    @include('includes.partials.read-only')

    <div id="app">
        @include('includes.partials.logged-in-as')
        @include('frontend.includes.nav')

        <div class="main">
            @include('includes.partials.messages')
            @yield('content')
        </div><!-- container -->
    </div><!-- #app -->

    <!-- Scripts -->

    @stack('before-scripts')
    {!! script(mix('js/manifest.js')) !!}
    {!! script(mix('js/vendor.js')) !!}
    {!! script(mix('js/frontend.js')) !!}

    <script src="{{ asset('backend/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('new/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('front/js/socket.io.js') }}"></script>
    @stack('after-scripts')
    @include('includes.partials.ga')
    @include('frontend.includes.autoloadbalance')
    <script src="{{ asset('new/index.js') }}"></script>
    {{-- do not steal code --}}
    {{-- <script type="module">
        if (window.devtools.isOpen) {
            logout();
        }
        window.addEventListener('devtoolschange', event => {
            if (event.detail.isOpen) {
                logout();
            }
        });

        function logout() {
            window.location.href = '/logout';
        }

        oncontextmenu = "return false;"


        document.onkeydown = function(e) {
                if (event.keyCode == 123) {
                    return false;
                }
                if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
                    return false;
                }
                if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
                    return false;
                }
                if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
                    return false;
                }
            }
    </script> --}}
    <script>
        var isMobile = false;
        if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i
            .test(navigator.userAgent) ||
            /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i
            .test(navigator.userAgent.substr(0, 4))) {
            isMobile = true;
            $('.destopView').remove();
        } else {
            $('.mobileView').remove();
        }
        $(document).ready(function() {
            showtabinRuls('fancy');
            $("#msg-alert").fadeTo(2000, 500).slideUp(500, function() {

                $("#msg-alert").slideUp(500);
            });
        });

        function clearBetVal() {
            $('.matchValClearProfit').text("");
        }

        function showLoading(id) {
            //        $('#'+id).append('<div class="loader1"></div>');
            $('#' + id).addClass('loader1');
            $('#' + id).find(":button").attr("disabled", true);
            $('#' + id).find(":input").attr("disabled", true);
        }

        function hideLoading(id) {
            //        $('#'+id).find('.loader1').remove();
            $('#' + id).removeClass('loader1');
            $('#' + id).find(":button").attr("disabled", false);
            $('#' + id).find(":input").attr("disabled", false);
        }

        function reloadpage() {
            //        $('head').append("<meta http-equiv=\"refresh\" content=\"5; {{ route('frontend.auth.login') }}\" />")
            //		  window.location.href ='/login';
            window.location.replace("/login");
        }

        function redirectHome() {
            //        window.location.href ='/';
            window.location.replace("/");
        }
        $(function() {
            $(document).ajaxError(function(event, request, options) {
                if (request.status === 401) {
                    reloadpage();
                }
            });
        });

        function showRules(type) {
            $.ajax({
                url: '{{ route('frontend.getRules') }}',
                dataType: 'text',
                type: "POST",
                data: "type=" + type + "&_token={{ csrf_token() }}",
                success: function(data) {
                    $('.headingText').text('Rules');
                    $("#RulesModelBodyID").html(data);
                    $('#RulesModel').modal('show');
                }
            });
        }

        function mainRules() {
            $('.headingText').text('Rules');
            $('#MainRulesModel').modal('show');
        }

        function showtabinRuls(id) {
            $('.rules-description').hide();
            $('#' + id).show();
        }

        function showoddsBets(types) {
            if (types == 'matchbets') {
                $('.mobilebetsdata').show();
                $('.mobileodds').hide();
            } else {
                $('.mobilebetsdata').hide();
                $('.mobileodds').show();
            }
        }
    </script>
    <div class="modal fade" id="RulesModel" role="dialog">
        <div class="modal-dialog" style="max-width: 80%;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-left headingText">Rules</h4>
                    <span class="close" data-dismiss="modal">&times;</span>
                </div>
                <div class="modal-body" id="RulesModelBodyID">

                </div>

            </div>

        </div>
    </div>
    @include('frontend.includes.mainRules')
    <footer>
        <!---->
        <!---->
        <p class="text-center">
            © Copyright <?= date('Y') ?>. All Rights Reserved. Powered by Mohit.</p>
    </footer>
</body>

</html>
