<?php 
use App\AdminSetting;
use App\Http\Controllers\Frontend\MyBetsController;
$message = '';
if (!Auth::guest()){
  $adminSetting = AdminSetting::first();
  $message =$adminSetting->user_message;
  switch (Auth::user()->roles->first()->name){
    case 'administrator':
    case 'admin':
    case 'subadmin':
    case 'supermaster':
    case 'master':{
      header('Location: /admin');
      exit;
      break;
    }
  }
}
$exposureAmt = MyBetsController::getExAmount();
$headerUserBalance = MyBetsController::getBlanceAmount();
?>

<nav class="navbar navbar-expand-lg navbar-light header" style="margin-bottom: -10px !important;">
    <a href="{{ route('frontend.index') }}" class="navbar-brand"><img src="{{ url('/new/img/logo.png')}}" class="logo-login"></a>

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="@lang('labels.general.toggle_navigation')">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav">
            @auth
                <li class="nav-item">
                    <a href="javascript:void(0);"  style="text-decoration: none;" 
                       class="rules-link m-r-5">
                        <span>Balance:</span>
                        <b><span>{{$headerUserBalance}}</span></b>
                    </a><br>
                    <a href="javascript:void(0);" style="line-height: 2;text-decoration: underline;"
                       class="rules-link m-r-5">
                        <span>Exposure:</span>
                        <b><span>{{$exposureAmt}}</span></b>
                    </a>
                </li>
            @endauth

            @guest
                <li class="nav-item"><a href="{{route('frontend.auth.login')}}" class="rules-link m-r-5 {{ active_class(Route::is('frontend.auth.login')) }}">@lang('navs.frontend.login')</a></li>

                @if(config('access.registration'))
                    <li class="nav-item"><a href="{{route('frontend.auth.register')}}" class="rules-link m-r-5 {{ active_class(Route::is('frontend.auth.register')) }}">@lang('navs.frontend.register')</a></li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a href="#" class="rules-link m-r-5 dropdown-toggle" id="navbarDropdownMenuUser" data-toggle="dropdown" style="vertical-align: -moz-middle-with-baseline;"
                       aria-haspopup="true" aria-expanded="false">{{ Auth::user()->first_name }}</a>

                    <div class="dropdown-menu" style="left:-70px;" styaria-labelledby="navbarDropdownMenuUser">
                        @can('view backend')
                            <a style="color:#000;" href="{{ route('admin.dashboard') }}" class="dropdown-item">@lang('navs.frontend.user.administration')</a>
                        @endcan

                        <!--<a style="color:#000;" href="{{ route('frontend.user.account') }}" class="dropdown-item {{ active_class(Route::is('frontend.user.account')) }}">@lang('navs.frontend.user.account')</a>-->
                        <!--<a style="color:#000;" href="{{ route('frontend.auth.logout') }}" class="dropdown-item">@lang('navs.general.logout')</a>-->
                        
                        <a style="color:#000;" href="{{ route('frontend.accountstatement') }}" class="dropdown-item">Account Statement</a>
                        <a style="color:#000;" href="{{ route('frontend.profitloss') }}" class="dropdown-item">Profit Loss Report</a>
                        <a style="color:#000;" href="{{ route('frontend.bethistory') }}" class="dropdown-item">Bet History</a>
                        <a style="color:#000;" href="{{ route('frontend.unsetteledbet') }}" class="dropdown-item">Unsetteled Bet</a>
                        <a style="color:#000;" href="{{ route('frontend.changebtnvalue') }}" class="dropdown-item">Set Button Values</a>
                        <a style="color:#000;" href="{{ route('frontend.changepassword') }}" class="dropdown-item">Change Password</a>
                        <br>
                        <hr>
                        <a style="color:#000;" href="{{ route('frontend.auth.logout') }}" class="dropdown-item">signout</a>
                    </div>
                </li>
            @endguest

        </ul>
        <marquee style="bottom: 2px;" scrollamount="3">Cards Cricket Started in Our Exchange.</marquee>
    </div>
    
</nav>
<div class="header-bottom m-t-10 col-md-12">
        <nav class="navbar navbar-expand-md btco-hover-menu">
            <button type="button" data-toggle="collapse" 
                    data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" 
                    aria-expanded="false" aria-label="Toggle navigation" 
                    class="navbar-toggler">
                <span class="navbar-toggler-icon"></span>
            </button> 
            <div class="collapse navbar-collapse">
                <ul class="list-unstyled navbar-nav">
                    <li class="nav-item active">
                        <a href="/" class="router-link-exact-active router-link-active"><b>Home</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.cricket')}}" class=""><b>Cricket</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.tennis')}}" class=""><b>Tennis</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.footboll')}}" class=""><b>Football</b></a>
                    </li> 
                     <li class="nav-item">
                        <a href="{{ route('frontend.game-list.icehockey')}}" class=""><b>ICE HOCKEY</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.volleball')}}" class=""><b>VOLLEBALL</b></a>
                    </li> <li class="nav-item">
                        <a href="{{ route('frontend.game-list.basketball')}}" class=""><b>BASKETBALL</b></a>
                    </li> <li class="nav-item">
                        <a href="{{ route('frontend.game-list.tabletennis')}}" class=""><b>TABLE TENNIS</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.darts')}}" class=""><b>DARTS</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.badminton')}}" class=""><b>BADMINTON</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.kabdi')}}" class=""><b>KABADDI</b></a>
                    </li> <li class="nav-item">
                        <a href="{{ route('frontend.game-list.boxing')}}" class=""><span><b>BOXING</b></span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.mixedmartialarts')}}" class=""><span><b>MIXED MARTIAL ARTS</b></span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.motorsport')}}" class=""><span><b>MOTOR SPORT</b></span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
