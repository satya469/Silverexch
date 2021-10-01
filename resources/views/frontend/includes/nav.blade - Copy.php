<?php 
use App\AdminSetting;
use App\Http\Controllers\Frontend\MyBetsController;
$message = '';
$exposureAmt = $headerUserBalance = 0.00;
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
  $exposureAmt = MyBetsController::getExAmount();
  $headerUserBalance = MyBetsController::getBlanceAmount();
}

?>

<nav class="navbar navbar-expand-lg navbar-light header" style="margin-bottom: -10px !important;">
    <i class="fas fa-home-lg mobileView" style="margin-top: -20px;font-size: 15px;"></i>
    <i class="fas fa-search mobileView mobileView-search" style=""></i>
    <a style="" href="{{ route('frontend.index') }}" class="navbar-brand navbar-brand-m"><img src="{{ url('/new/img/logo.png')}}" class="logo-login"></a>
    
    <div class="mobileView mobile-menu">
        <!--<span onclick="mainRules();">Rules</span>-->
        <span><i class="far fa-university"></i></span>
        <b><span id="headerUserBalance">{{$headerUserBalance}}</span></b><br style="margin-bottom: 7px;">
        <span>Exp:</span>
        <b><span style="padding-right: 5px;" id="headerExposureLimit">{{$exposureAmt}}</span></b>
        <ul class="navbar-nav navbar-nav-new">
            
            @guest
               
            @else
            <li  class="nav-item dropdown">
                    <a href="#" class="rules-link m-r-5 dropdown-toggle chnagePass" id="navbarDropdownMenuUser" data-toggle="dropdown" style="vertical-align: -moz-middle-with-baseline;"
                       aria-haspopup="true" aria-expanded="false">{{ Auth::user()->first_name }}</a>

                    <div class="dropdown-menu" style="left:-80px;position: absolute;" styaria-labelledby="navbarDropdownMenuUser">
                        @can('view backend')
                            <a style="color:#000;" href="{{ route('admin.dashboard') }}" class="dropdown-item">@lang('navs.frontend.user.administration')</a>
                        @endcan
                        <a style="color:#000;" href="{{ route('frontend.accountstatement') }}" class="dropdown-item">Account Statement</a>
                        <a style="color:#000;" href="{{ route('frontend.profitloss') }}" class="dropdown-item">Profit Loss Report</a>
                        <a style="color:#000;" href="{{ route('frontend.bethistory') }}" class="dropdown-item">Bet History</a>
                        <a style="color:#000;" href="{{ route('frontend.unsetteledbet') }}" class="dropdown-item">Unsetteled Bet</a>
                        <a style="color:#000;" href="{{ route('frontend.casinoresultreport') }}" class="dropdown-item">Casino Result Report</a>
                        <a style="color:#000;" href="{{ route('frontend.changebtnvalue') }}" class="dropdown-item">Set Button Values</a>
                        <a style="color:#000;" href="{{ route('frontend.changepassword') }}" class="dropdown-item">Change Password</a>
                        
                        <a style="color:#000;" href="{{ route('frontend.auth.logout') }}" class="dropdown-item chnagePass">signout</a>
                    </div>
                </li>
            @endguest

        </ul>
        @if(!empty($message))
          <marquee style="bottom: 2px;width: 94%;" scrollamount="3">{{$message}}</marquee>
        @endif
    </div>
    

    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav destopView">
            @auth
                <li class="float-left download-apklink">
                    <div>
                        <a href="javascript:void(0);" onclick="mainRules();" class="rules-link m-r-5"><b>Rules</b></a>
                    </div> 
                    <div style="margin-right: 12px;">
                      <a href="javascript:void(0)">
                        <span><b>Download Apk</b> 
                          <i class="fab fa-android"></i>
                        </span>
                      </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);"  style="text-decoration: none;" 
                       class="rules-link m-r-5">
                        <span>Balance:</span>
                        <b><span id="headerUserBalance">{{$headerUserBalance}}</span></b>
                    </a><br>
                    <a href="javascript:void(0);" style="line-height: 2;text-decoration: underline;"
                       class="rules-link m-r-5">
                        <span>Exposure:</span>
                        <b><span id="headerExposureLimit">{{$exposureAmt}}</span></b>
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
                    <a href="#" class="rules-link m-r-5 dropdown-toggle chnagePass" id="navbarDropdownMenuUser" data-toggle="dropdown" style="vertical-align: -moz-middle-with-baseline;"
                       aria-haspopup="true" aria-expanded="false">{{ Auth::user()->first_name }}</a>

                    <div class="dropdown-menu" style="left:-70px;" styaria-labelledby="navbarDropdownMenuUser">
                        @can('view backend')
                            <a style="color:#000;" href="{{ route('admin.dashboard') }}" class="dropdown-item">@lang('navs.frontend.user.administration')</a>
                        @endcan
                        <a style="color:#000;" href="{{ route('frontend.accountstatement') }}" class="dropdown-item">Account Statement</a>
                        <a style="color:#000;" href="{{ route('frontend.profitloss') }}" class="dropdown-item">Profit Loss Report</a>
                        <a style="color:#000;" href="{{ route('frontend.bethistory') }}" class="dropdown-item">Bet History</a>
                        <a style="color:#000;" href="{{ route('frontend.unsetteledbet') }}" class="dropdown-item">Unsetteled Bet</a>
                        <a style="color:#000;" href="{{ route('frontend.casinoresultreport') }}" class="dropdown-item">Casino Result Report</a>
                        <a style="color:#000;" href="{{ route('frontend.changebtnvalue') }}" class="dropdown-item">Set Button Values</a>
                        <a style="color:#000;" href="{{ route('frontend.changepassword') }}" class="dropdown-item">Change Password</a>
                        <br>
                        <hr>
                        <a style="color:#000;" href="{{ route('frontend.auth.logout') }}" class="dropdown-item chnagePass">signout</a>
                    </div>
                </li>
            @endguest

        </ul>
        @if(!empty($message))
          <marquee style="bottom: 2px;" scrollamount="3">{{$message}}</marquee>
        @endif
    </div>
    
</nav>
<div class="m-t-10 col-md-12 mobileView note-top" style="" >
<p>BIG BASH LEAGUUE 2020</p>
</div>
<div class="header mobilebetOdds text-center">
    <a class="oddsMenu" href="/" >IN-PLAY</a>
    <a class="oddsMenu" href="/" >SPORTS</a>
    <a class="oddsMenu" href="javascript:void(0);" >CASINO + SLOT</a>
    <a class="matchbets" href="javascript:void(0);" >OTHER</a>
</div>
<div class="header-bottom m-t-10 m-t-10-none col-md-12" >
    
        <nav class="navbar navbar-expand-md btco-hover-menu">
                <ul class="list-unstyled navbar-nav navbar-nav123" style="display: none;">
<!--                    <li class="nav-item active">
                        <a href="/" class="router-link-exact-active router-link-active"><b>Home</b></a>
                    </li> -->
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.cricket')}}" class=""><i class="fas fa-baseball-ball menu-font"></i><br><b>Cricket</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.tennis')}}" class=""><i class="fas fa-tennis-ball menu-font"></i><br><b>Tennis</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.footboll')}}" class=""><i class="far fa-futbol menu-font"></i><br><b>Football</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.live-teenpati')}}" class=""><b>Live Teenpatti</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.andar-bahar')}}" class=""><b>Andar Bahar</b></a>
                    </li> <li class="nav-item">
                        <a href="{{ route('frontend.game-list.poker')}}" class=""><b>Poker</b></a>
                    </li> <li class="nav-item">
                        <a href="{{ route('frontend.game-list.7-up-down')}}" class=""><b>7 up & Down</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.32-cards-casino')}}" class=""><b>32 cards Casino</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.teenpati-t20')}}" class=""><b>TeenPatti T20</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.amar-akhbar-anthony')}}" class=""><b>Amar Akbar Anthony</b></a>
                    </li> <li class="nav-item">
                        <a href="{{ route('frontend.game-list.dragon-tiger')}}" class=""><span><b>Dragon Tiger</b></span></a>
                    </li> 
                </ul>
            <!--</button>--> 
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
                        <a href="{{ route('frontend.game-list.live-teenpati')}}" class=""><b>Live Teenpatti</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.andar-bahar')}}" class=""><b>Andar Bahar</b></a>
                    </li> <li class="nav-item">
                        <a href="{{ route('frontend.game-list.poker')}}" class=""><b>Poker</b></a>
                    </li> <li class="nav-item">
                        <a href="{{ route('frontend.game-list.7-up-down')}}" class=""><b>7 up & Down</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.32-cards-casino')}}" class=""><b>32 cards Casino</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.teenpati-t20')}}" class=""><b>TeenPatti T20</b></a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('frontend.game-list.amar-akhbar-anthony')}}" class=""><b>Amar Akbar Anthony</b></a>
                    </li> <li class="nav-item">
                        <a href="{{ route('frontend.game-list.dragon-tiger')}}" class=""><span><b>Dragon Tiger</b></span></a>
                    </li> 
                </ul>
            </div>
        </nav>
    </div>
