<?php 
use App\Http\Controllers\Backend\SportsController;
$betsHtml = SportsController::getMyAllBets($sports->match_id);
//dd($sports->gameName);
?>
<style>
    .btn-primary{
        background-color:var(--theme1-bg);
    }
    .card-header{
      background-color:var(--theme2-bg);
    }
</style>
  <div class="col-md-4 col-sm-12 sidebar-right sidebar-right-bar">
     <div class="card-header" >
        <div class="row33">
           <div class="col-33">
            <div class="dropdown">   
              <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle mobile-view-btm" id="dropdownMenuButton123" aria-haspopup="true" aria-expanded="false">Bet Lock <span class="caret"></span></button>
              <div class="dropdown-menu dropdown-menuTXT " aria-labelledby="dropdownMenuButton123">
                 <li><a href="javascript:void(0);" onclick="lockFancyBet('{{$sports->id}}','FULLMATCH','LOCK');">Lock</a></li>
                    <li><a href="javascript:void(0);" onclick="lockFancyBet('{{$sports->id}}','FULLMATCH','UNLOCK');">Unlock</a></li>
                 <li><a href="javascript:void(0);" onclick="lockSelectedUserBet('{{$sports->id}}','FULLMATCH','SELECTEDUSER');">Select user</a></li>
              </div>
              </div>
           </div>
           <div class="col-33">
              <div class="dropdown">
                 <button class="btn btn-primary dropdown-toggle mobile-view-btm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Fancy Lock</button>
                 <div class="dropdown-menu dropdown-menuTXT" aria-labelledby="dropdownMenuButton">
                    <li><a href="javascript:void(0);" onclick="lockFancyBet('{{$sports->id}}','FANCY','LOCK');">Lock</a></li>
                    <li><a href="javascript:void(0);" onclick="lockFancyBet('{{$sports->id}}','FANCY','UNLOCK');">Unlock</a></li>
                    <li><a href="javascript:void(0);" onclick="lockSelectedUserBet('{{$sports->id}}','FANCY','SELECTEDUSER');">Select user</a></li>
                 </div>
              </div>
           </div>
            <div class="col-33"><button onclick="getUserBook('{{$sports->id}}','UserBook');" class="btn btn-primary mobile-view-btm">User Book</button></div>
            @if(strtoupper($sports->gameName) == 'CRICKET')
            <div class="col-33"><button onclick="getUserBook('{{$sports->id}}','BookmakerBook');" class="btn btn-primary mobile-view-btm">Bookmaker Book</button></div>
           @endif
            @if(Auth::user()->roles->first()->name == 'administrator')
           <div class="col-33">
              <div class="dropdown">
                 <button class="btn btn-primary dropdown-toggle mobile-view-btm" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Match Suspend</button>
                 <div class="dropdown-menu dropdown-menuTXT" aria-labelledby="dropdownMenuButton1">
                    <li><a href="javascript:void(0);" onclick="matchSuspend('{{$sports->id}}','SUSPEND');">Suspend</a></li>
                    <li><a href="javascript:void(0);" onclick="matchSuspend('{{$sports->id}}','UNSUSPEND');">UnSuspend</a></li>
                 </div>
              </div>
           </div>
            @endif
             @if(strtoupper($sports->gameName) == 'CRICKET')
           <div class="col-33">
              <div class="dropdown">
                 <button class="btn btn-primary dropdown-toggle mobile-view-btm" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Bookmaker Lock</button>
                 <div class="dropdown-menu dropdown-menuTXT" aria-labelledby="dropdownMenuButton1">
                    <li><a href="javascript:void(0);" onclick="lockFancyBet('{{$sports->id}}','BOOKMAKER','LOCK');">Lock</a></li>
                    <li><a href="javascript:void(0);" onclick="lockFancyBet('{{$sports->id}}','BOOKMAKER','UNLOCK');">Unlock</a></li>
                    <li><a  href="javascript:void(0);" onclick="lockSelectedUserBet('{{$sports->id}}','BOOKMAKER','SELECTEDUSER');">Select user</a></li>
                 </div>
              </div>
           </div>
             @endif
             <div class="col-33"><button onclick="getViewMoreBets('{{$sports->id}}');" class="btn btn-primary mobile-view-btm">View More</button></div>
        </div>
         <h6 class="card-title" data-toggle="collapse" data-target="#demo" style="margin-top: 15px;font-size: 15px;">Live Match <span class="float-right"><i class="fa fa-tv"></i> live stream started</span> </h6>
     </div>
     <div id="demo" class="collapse hide ">
        <ul class="nav nav-tabs video_nav_tab">
           <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#video1">Channel 1</a></li>
           <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#video2">Channel 2</a></li>
           <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#video3">Channel 3</a></li>
           <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#video4">Channel 4</a></li>
        </ul>
        <div class="tab-content">
           <div id="video1" class=" tab-pane active"><iframe class="tab_video" src="{{$adminSetting->TV_URL_1}}"></iframe></div>
           <div id="video2" class=" tab-pane fade"><iframe class="tab_video" src="{{$adminSetting->TV_URL_2}}"></iframe></div>
           <div id="video3" class=" tab-pane fade"><iframe class="tab_video" src="{{$adminSetting->TV_URL_3}}"></iframe></div>
           <div id="video4" class=" tab-pane fade"><iframe class="tab_video" src="{{$adminSetting->TV_URL_4}}"></iframe></div>
        </div>
     </div>
     
     <div class="card m-b-10 place-bet">
        <div class="card-header">
           <h6 class="card-title d-inline-block" style="font-size: 15px;">My Bet</h6>
        </div>
        <div class="table-responsive hide-box-click " style="padding-bottom: 4px; display: block;">
           <div>
<!--              <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Match</a></li>
              </ul>-->
              <div class="tab-content">
                  <div id="home" class="mybetListID container tab-pane active" style="padding:0px;overflow: auto;max-height: 500px;">
                   {!! $betsHtml !!} 
                 </div>
              </div>
           </div>
        </div>
     </div>
     <form method="post" id="frm_placebet">
        <table class="table table-borderedless place-bet">
           <tbody><br></tbody>
        </table>
        <!--<div class="col-md-12"><button class="btn btn-sm btn-danger float-left" type="button">Reset</button><button class="btn btn-sm btn-success float-right" type="submit" id="submit_btn">Submit</button><input id="Odds1" type="hidden" value=""><input id="Odds2" type="hidden" value=""><input id="team_id1" type="hidden" value=""></div>-->
     </form>
  </div>
  <div class="modal fade" id="modal-user">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Select User Lock Type :<span class="typeClass"></span> </h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body" id="modal-user-body">

        </div>
        <div class="modal-footer">
          <span id="message"> </span>
          <input type="hidden" id="lockType" value="">
          <input type="hidden" id="type" value="">
          <input type="hidden" id="sportID" value="">
          <button type="button" class="btn btn-back" data-dismiss="modal"><i class="fas fa-undo"></i>Back</button>
          <button type="button" onclick="saveUserSelectedUser(this);" class="btn btn-submit">submit<i class="fas fa-sign-in-alt"></i></button>
        </div>
        </form>
      </div>
    </div>
  </div>

<div class="modal fade" id="modal-book" style="width:100%;">
    <div class="modal-dialog" style="max-width:90%;display: flex;">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title book-title"></h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body" id="modal-book-body">

        </div>
      </div>
    </div>
  </div>