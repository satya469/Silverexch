<?php 
use App\AdminSetting;
use App\Privilege;
use App\Models\Auth\User;
if (!Auth::guest()){
  switch (Auth::user()->roles->first()->name){
    case 'user':{
      header('Location: /');
      exit;
      break;
    }
  }
}else{
  header('Location: /');
  exit;
}

if(Auth::user()->roles->first()->name == 'administrator'){
  $userPrivilegeCheckModel = Privilege::where(['user_id'=>Auth::user()->id])->first();
  
}
$adminSetting = AdminSetting::first();
$message = $adminSetting->admin_message;


?>



<style>
  .dropdown-item {
    position: relative;
    padding: 8px 20px;
    border-bottom: 1px solid var(--theme1-bg);
    color: #fff;
}
.dropdown-item:hover{
  background: #2f353a;
  color: #fff;
}
.navbar-nav {
    padding-left: 0px;
}
.app-header {
    height: 68px;
}
.dropdown-menu-right {
    right: auto !important;
    left: auto;
}
</style>
<header class="app-header navbar" style="min-height: 83px;">
<!--    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
        <div class="side-menu-button">
          <div class="bar1"></div>
          <div class="bar2"></div>
          <div class="bar3"></div>
        </div>
    </button>-->
    <a class="navbar-brand destopView" href="#">
        <img class="navbar-brand-full" src="{{ url('/new/img/logo.png')}}" style="width:100%;" alt="">
        <img class="navbar-brand-minimized" src="{{ asset('img/backend/brand/sygnet.svg') }}" width="30" height="30" alt="">
    </a>
    <div class="col-sm-3 mobileView">
        <a class="navbar-brand" href="#">
            <img class="navbar-brand-full" src="{{ url('/new/img/logo.png')}}"  alt="">
            <img class="navbar-brand-minimized" src="{{ asset('img/backend/brand/sygnet.svg') }}" width="30" height="30" alt="">
        </a>
    </div>
<!--    <div class="col-sm-9 mobileView mobile-menu-pass" style="margin-top: 4px;text-align: right;font-size: 12px;">-->
<div class="col-sm-9 mobileView mobile-menu-pass">
        <a class="nav-item-top " style="border-right: 1px solid #fff;" href="{{ route('admin.userchangepassword') }}">
          Change Password
        </a>
        <a class="nav-item-top chnagePass" href="{{ route('frontend.auth.logout') }}">
            @lang('navs.general.logout')({{  Auth::user()->first_name }})
        </a>
    </div>
    <ul class="nav navbar-nav d-md-down-none">
        @if(Auth::user()->roles->first()->name == 'administrator' && isset($userPrivilegeCheckModel->id))
            
            @if($userPrivilegeCheckModel->listOfClient == 1)
              <li class="nav-item px-3">
                  <a class="nav-link" href="{{ route('admin.list-client') }}"><b>List Of Client</b></a>
              </li>
            @endif
             
            @if($userPrivilegeCheckModel->mainMarket == 1)
              <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('admin.list-game') }}">
                  <b>Main Market</b>
                </a>
            @endif
            
            @if($userPrivilegeCheckModel->manageFancy == 1)
              <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('admin.manage_fancy.cricket') }}">
                   <b>Manage Fancy</b>
                </a>
              </li>    
            @endif
            
            @if($userPrivilegeCheckModel->fancyHistory == 1)
              <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('admin.fancy_history.cricket') }}">
                   <b>Fancy History</b>
                </a>
              </li>     
            @endif
            
            @if($userPrivilegeCheckModel->matchHistory == 1)
             <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('admin.matchhistory') }}">
                    <b>Match History</b>
                </a>
              </li>    
            @endif
             
        @else    
          <li class="nav-item px-3">
              <a class="nav-link" href="{{ route('admin.list-client') }}"><b>List Of Client</b></a>
          </li>

          <li class="nav-item px-3">
              <a class="nav-link " href="{{ route('admin.marketanalysis') }}"><b>Market Analysis</b></a>
          </li>
        
          <li class="nav-item px-3 dropdown newlacunch-menu">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
               <span class="d-md-down-none"><b>Live Market</b></span>
            </a>
              <div class="dropdown-menu dropdown-menu-right" style="background-color: var(--theme1-bg);">
                <br>
                <a class="dropdown-item" href="{{ route('admin.live-teenpati') }}">
                    <b>Live TeenPatti</b>
                </a>
                <a class="dropdown-item" href="{{ route('admin.andar-bahar') }}">
                   <b>Andar Bahar</b>
                </a>
                <a class="dropdown-item" href="{{ route('admin.poker') }}">
                    <b>Poker</b>
                </a>
                <a class="dropdown-item" href="{{ route('admin.7-up-down') }}">
                   <b>7 Up & Down</b>
                </a>
                <a class="dropdown-item" href="{{ route('admin.32-cards-casino') }}">
                   <b>32 Cards Casino</b>
                </a>
                <a class="dropdown-item" href="{{ route('admin.teenpati-t20') }}">
                   <b>TeenPatti T20</b>
                </a>
                <a class="dropdown-item" href="{{ route('admin.amar-akhbar-anthony') }}">
                    <b>Amar Akbar Anthony</b>
                </a>
                <a class="dropdown-item" href="{{ route('admin.dragon-tiger') }}">
                   <b>Dragon Tiger</b>
                </a>
            </div>
          </li>

          <li class="nav-item px-3 dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="d-md-down-none"><b>Reports</b></span>
          </a>
            <div class="dropdown-menu dropdown-menu-right" style="background-color: var(--theme1-bg);">
              <br>
              <a class="dropdown-item" href="{{ route('admin.accountstatement') }}">
                 <b>Account's Statement</b>
              </a>
              <a class="dropdown-item" href="{{ route('admin.currentbets') }}">
                 <b>Current Bets</b>
              </a>
              <a class="dropdown-item" href="{{ route('admin.generalreport') }}">
                  <b>General Report</b>
              </a>
              <a class="dropdown-item" href="{{ route('admin.gamereport') }}">
                 <b>Game Report</b>
              </a>
<!--              <a class="dropdown-item" href="{{ route('admin.casinoreport') }}">
                  <b>Casino Report</b>
              </a>-->
              <a class="dropdown-item" href="{{ route('admin.profitloss') }}">
                 <b>Profit And Loss</b>
              </a>
              <a class="dropdown-item" href="{{ route('admin.casinoresultreport') }}">
                  <b>Casino Result Report</b>
              </a>
          </div>
        </li>
        
          @if ($logged_in_user->isAdmin() && Auth::user()->roles->first()->name == 'administrator')
            <li class="nav-item px-3 dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="d-md-down-none"><b>Setting</b></span>
            </a>
              <div class="dropdown-menu dropdown-menu-right" style="background-color: var(--theme1-bg);">
                <br>

                  <a class="dropdown-item" href="{{ route('admin.list-game') }}">
                    <b>Main Market</b>
                  </a>
                  <a class="dropdown-item" href="{{ route('admin.manage_fancy.cricket') }}">
                    <b>Manage Fancy</b>
                  </a>
                  <a class="dropdown-item" href="{{ route('admin.fancy_history.cricket') }}">
                      <b>Fancy History</b>
                  </a>
                  <a class="dropdown-item" href="{{ route('admin.matchhistory') }}">
                      <b>Match History</b>
                  </a>

                  <a class="dropdown-item" href="{{ route('admin.admin-setting') }}">
                    <b>Message</b>
                 </a>
                  <a class="dropdown-item" href="{{ route('admin.privilige.list') }}">
                    <b>Manage Privilege</b>
                 </a>
                 <a class="dropdown-item" href="{{ route('admin.settingTvUrl') }}">
                    <b>Manage TV</b>
                </a>


            </div>
          </li>

          @endif
        
        @endif
    </ul>

    <ul class="nav navbar-nav ml-auto mobileView-d-none destopView" style="margin-right: 50px;">
        <li class="nav-item px-3 dropdown destopView">
          <a class="nav-link dropdown-toggle chnagePass" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <!--<img src="{{ $logged_in_user->picture }}" class="img-avatar" alt="{{ $logged_in_user->email }}">-->
            <span class="d-md-down-none">{{  Auth::user()->first_name }}</span>
          </a>
            
            <div class="dropdown-menu dropdown-menu-right" style="background-color: var(--theme1-bg);">
              <br>
              <a class="dropdown-item" href="{{ route('admin.userchangepassword') }}">
                 Change Password
              </a>
              <a class="dropdown-item chnagePass" href="{{ route('frontend.auth.logout') }}">
                  @lang('navs.general.logout')
              </a>
          </div>
        </li>
<!--        <li class="search nav-item ">
            <input id="tags" type="text" name="list" placeholder="All Client" class="ui-autocomplete-input" autocomplete="off" style="padding: 11px;margin-right: -40px;">
            <a data-value="" href="javascript:void(0)" style="font-size: 23px;" id=""><i class="fas fa-search-plus"></i></a>
        </li>-->
        
    </ul>
    <div style="width:50%;float: left;"></div>
    <div style="width:50%;float: right;">
      @if(!empty($message) && Auth::user()->roles->first()->name != 'administrator')
      <marquee style="bottom: 2px;" scrollamount="3">{{$message}}</marquee>
    @endif
    </div>
</header>

