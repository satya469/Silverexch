<?php
use App\Http\Controllers\Backend\SportsController;
?>
@extends('backend.layouts.app')
@section('title', app_name())
@section('content')
<style>
    #home-events{
      background: #2f353a;
      padding: 8px;
    }
    #home-events li a{
      color: #fff;
    }
    .tabActive{
      display: block;
    }
    .hideActive{
      display: none;
    }
    .activeUL{
      background-color: var(--theme1-bg);
      color: var(--primary-color);
    }
    .row33 .col-33{
       display: inline-block;
       margin: 2px;
    }
/*    .sidebar-right{
        max-width: 33% !important;
    }*/
    .video_nav_tab .nav-item{
        font-size: 12px;
    }
    .tab_video{
        width:100%;
    }
</style>


<div class="row">

    <div class="col-md-8 col-sm-12 featured-box-detail" style="margin-left:0px;">

      <div class="coupon-card">
         <div class="game-heading">
             <span class="card-header-title">
                 <?= $sports->match_name ?>
             </span>
             <span class="card-header-title" style="float: right;">
                 <?= $sports->match_date_time ?>
             </span>
         </div>
         <div class="header mobilebetOdds">
            <a class="odds" href="javascript:void(0);" style="color: #fff;border-right: 1px solid #fff;margin-right: 10px;border-right: 1px solid #fff;padding-right: 10px;" onclick="showoddsBets('leftSideView');">ODDS</a>
            <a class="matchbets" href="javascript:void(0);" style="color: #fff;" onclick="showoddsBets('sidebar-right-bar');">Match BET</a>
        </div>

          <div class="markets mobileodds leftSideView">
            <!--START TOP BANER DETAILS-->
            <!--style="display:none;"-->
                        <div class="scorecard SBMOBILE" >
                            <div class="row" style="padding:10px 15px;">
                                <div class="col-sm-6 text-left" style="padding-left:0px;">
                                    <span class="sbTeamName1"></span>
                                    <span class="sbRun1"></span>
                                </div>
                                <div class="col-sm-6 text-right" style="padding-right:0px;">
                                    <span class="sbTeamName2"></span>
                                    <span class="sbRun2"></span>
                                </div>
                            </div>
                            <div class="row" style="padding:10px 15px;">
                              <div class="col-sm-12 sbStatus text-left" style="padding-right:0px;"></div>
                            </div>
                            <div class="row" style="padding:10px 15px;">
                                <div class="col-sm-6" style="padding-left:0px;">
                                    <span class="sbRunRate1"></span>
                                    <span class="sbRunRate2"></span>
                                </div>
                                <div class="col-sm-6 lastSixBol2 text-right" style="padding-right:0px;">

                                </div>
                            </div>
                        </div>
                      <div class="scorecard SBDESTOP" >
                          <div class="row" style="padding:10px 15px;">
                            <div class="col-sm-2 sbTeamName1" style="padding-left:0px;"></div>
                            <div class="col-sm-2 sbRun1 text-right"></div>
                            <div class="col-sm-3 sbRunRate1 text-left"></div>
                            <div class="col-sm-5 sbStatus text-right" style="padding-right:0px;"></div>
                          </div>
                          <div class="row" style="padding:10px 15px;">
                            <div class="col-sm-2 sbTeamName2" style="padding-left:0px;"></div>
                            <div class="col-sm-2 sbRun2 text-right"></div>
                            <div class="col-sm-3 sbRunRate2 text-left"></div>
                            <div class="col-sm-5 lastSixBol2 text-right" style="padding-right:0px;">
                                <span style="color:#fff;border-radius:25%;background:gray"></span><span style="color:#fff;border-radius:25%;background:gray"></span><span style="color:#fff;border-radius:25%;background:gray"></span><span style="color:#fff;border-radius:25%;background:gray"></span><span style="color:#fff;border-radius:25%;background:gray"></span><span style="color:#fff;border-radius:25%;background:#008000"></span>
                            </div>
                          </div>
                      </div>
          <!--END TOP BANER DETAILS-->

          <!-- START MATCH ODDS-->
          <input type="hidden" id="matchID" value="{{$sports->id}}">
          <div class="main-market  rootClass desktopodds">
            <div class="header market-title mt-1">
              MATCH_ODDS
<!--              <a href="javascript:void(0)" onclick="showRules('ODDS');" class="m-r-5 game-rules-icon">
                  <span><i class="fa fa-info-circle float-right"></i></span>
              </a> -->
              <span class="destopViewBetLimit float-right m-r-10">
                  @if(!empty($sports->odd_min_limit))
                    <span style="padding-right: 10px;">Min : <span>{{$sports->odd_min_limit}}</span></span>
                  @endif
                  @if(!empty($sports->odd_max_limit))
                    <span> Max : <span>{{$sports->odd_max_limit}}</span></span>
                  @endif
              </span>
              <!-- Hidden Value Of Max & Min Limit -->
              <input type="hidden" class="MatchOdd" id="oddsMax" value="{{$sports->odd_max_limit}}">
              <input type="hidden" class="MatchOdd" id="oddsMin" value="{{$sports->odd_min_limit}}">
              <input type="hidden" class="MatchOdd" id="betType" value="ODDS">


              <!-- End Hidden -->
            </div>
            <div class="table-header avoid-clicks">
              <div class="float-left country-name box-4 mbox-4 min-max">
                  <b>
                    <span class="mobileViewBetLimit float-right m-r-10">
                        @if(!empty($sports->odd_min_limit))
                          <span style="padding-right: 10px;">Min : <span>{{$sports->odd_min_limit}}</span></span>
                        @endif
                        @if(!empty($sports->odd_max_limit))
                          <span> Max : <span>{{$sports->odd_max_limit}}</span></span>
                        @endif
                    </span>
                  </b>
              </div>
              <div class="box-1 float-left mobileOddsHide"></div>
              <div class="box-1 float-left mobileOddsHide"></div>
              <div class="back box-1 float-left text-center mbox-1"><b class="font-size-14">BACK</b></div>
              <div class="lay box-1 float-left text-center mbox-1"><b class="font-size-14">LAY</b></div>
              <div class="box-1 float-left mobileOddsHide"></div>
              <div class="box-1 float-left mobileOddsHide"></div>
            </div>
            <div data-title="OPEN" class="table-body ODDS">
              @foreach($data['odd'] as $key=>$team)
              <div data-title="ACTIVE" class="table-row oddsTot oddssteam{{$key}}">
                <div class="float-left country-name box-4 mbox-4">
                    <span class="oddteamname<?= $key+1 ?> team-name{{$key}}"><b class="teamName font-size-14">{{$team['nat']}}</b></span>
                  <p>
                      <span class="float-left matchValClear finaltot" style="color: black;">0</span>
                      <span class="float-right" style="display: none; color: black;">0</span>
                  </p>
                </div>
                <div class="box-1 back2 float-left back-2 text-center mobileOddsHide">
                    <span class="odd d-block back3t"></span>
                    <span class="d-block back3k"></span>
                </div>
                <div class="box-1 back1 float-left back-1 text-center mobileOddsHide">
                    <span class="odd d-block back2t"></span>
                    <span class="d-block back2k"></span>
                </div>
                <div class="box-1 back float-left back lock text-center mbox-1 font-size-14">
                    <span class="odd d-block back1t"></span>
                    <span class="d-block back1k"></span>
                </div>
                <div class="box-1 lay float-left text-center mbox-1 font-size-14">
                    <span class="odd d-block lay1t font-size-14"></span>
                    <span class="d-block lay1k"></span>
                </div>
                <div class="box-1 lay1 float-left text-center mobileOddsHide">
                    <span class="odd d-block lay2t font-size-14"></span>
                    <span class="d-block lay2k"></span>
                </div>
                <div class="box-1 lay2 float-left text-center mobileOddsHide">
                    <span class="odd d-block lay3t"></span>
                    <span class="d-block lay3k"></span>
                </div>
              </div>
                @endforeach
            </div>

          </div>
          <div class="row row5 bookmaker-market mt-1 rootClass desktopodds">
            <div class="bm1 col-12">
              <div>
                <div class="market-title mt-1">
                <div class="row">
                  <div class="col-sm-4 boolmakertitlediv"> Bookmaker market</div>
                    <div class="col-sm-4 boolmakerNotesdiv">BOOKIE BHAV 0% COMM. 0 SEC DELAY</div>
                    <div class="col-sm-4 boolmakerminmaxdiv">
                        <!--<a href="javascript:void(0)" onclick="showRules('BOOKMAKER');" class="m-r-5 game-rules-icon"><span><i class="fa fa-info-circle float-right"></i></span></a>-->
                        <b>
                            <span class="destopViewBetLimit float-right m-r-10">
                              @if(!empty($sports->bookmaker_min_limit))
                                <span style="padding-right: 10px;">Min : <span>{{$sports->bookmaker_min_limit}}</span></span>
                              @endif
                              @if(!empty($sports->bookmaker_max_limit))
                                <span> Max : <span>{{$sports->bookmaker_max_limit}}</span></span>
                              @endif
                            </span>
                          </b>
                    </div>
                    </div>
                        <!-- Hidden Value Of Max & Min Limit -->
                    <input type="hidden" class="MatchBookmaker" id="oddsMax" value="{{$sports->bookmaker_max_limit}}">
                    <input type="hidden" class="MatchBookmaker" id="oddsMin" value="{{$sports->bookmaker_min_limit}}">
                    <input type="hidden" class="MatchBookmaker" id="betType" value="BOOKMAKER">

                  <!-- End Hidden -->
                </div>
                <div class="table-header avoid-clicks">
                  <div class="float-left country-name box-4">
                        <span class="mobileViewBetLimit float-right m-r-10">
                            @if(!empty($sports->bookmaker_min_limit))
                              <span>Min : <span>{{$sports->bookmaker_min_limit}}</span></span>
                            @endif
                            @if(!empty($sports->bookmaker_max_limit))
                              <span>&nbsp;Max : <span>{{$sports->bookmaker_max_limit}}</span></span>
                            @endif
                        </span>
                  </div>
                  <div class="box-1 float-left"></div>
                  <div class="box-1 float-left"></div>
                  <div class="back box-1 float-left text-center"><b>BACK</b></div>
                  <div class="lay box-1 float-left text-center"><b>LAY</b></div>
                  <div class="box-1 float-left"></div>
                  <div class="box-1 float-left"></div>
                </div>
                <div class="table-body BOOKMAKER">
                @if(!empty($data['bookmaker']))
                @foreach($data['bookmaker'] as $key=>$team)
                  <div data-title="ACTIVE" class="table-row oddsTot bookmaker{{$key}} ">
                    <div class="float-left country-name box-4">
                      <span class="bookmakerteamname<?= $key+1 ?> team-name{{$key}}"><b class="teamName">{{$team['nat']}}</b></span>
                      <p>
                          <span class="float-left matchValClear finaltot" style="color: black;">0</span>
                          <span class="float-right " style="display: none; color: black;">0</span>
                      </p>
                    </div>
                    <div class="box-1 back2 float-left back-2 text-center">
                        <span class="odd d-block back3t"></span>
                        <span class="d-block back3k"></span>
                    </div>
                    <div class="box-1 back1 float-left back-1 text-center">
                        <span class="odd d-block back2t"></span>
                        <span class="d-block back2k"></span>
                    </div>
                    <div class="box-1 back float-left back lock text-center">
                        <span class="odd d-block back1t"></span>
                        <span class="d-block back1k"></span>
                    </div>
                    <div class="box-1 lay float-left text-center">
                        <span class="odd d-block lay1t"></span>
                        <span class="d-block lay1k"></span>
                    </div>
                    <div class="box-1 lay1 float-left text-center">
                        <span class="odd d-block lay2t"></span>
                        <span class="d-block lay2k"></span>
                    </div>
                    <div class="box-1 lay2 float-left text-center">
                        <span class="odd d-block lay3t"></span>
                        <span class="d-block lay3k"></span>
                    </div>
                  </div>
                @endforeach
                @endif
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="fancy-market row row5 mobileodds leftSideView sessionSuppend">
          <div class="col-12">
            <div>
              <div class="market-title mt-1">
                Session Market
              </div>
              <div class="fancy-tripple avoid-clicks">
                  <div id="suspended" data-title="" class="table-row">
                    <div class=" float-left country-name box-6 mbox-4" style="border-bottom: 0px none;">
                        <span class="mobileViewBetLimit">
                        <span class="">Min: <span>{{$sports->fancy_min_limit}}</span></span>
                        <span class="">&nbsp;Max: <span>{{$sports->fancy_max_limit}}</span></span>
                        </span>
                    </div>
                    <div class="lay float-left text-center mbox-1 text-center" style="width: 13%;min-width: 13%;max-width: 13%;">
                      <span class="odd d-block mbox-1 font-size-14 text-center" style="display: inline !important;">NO</span>
                    </div>
                    <div class="back float-left text-center mbox-1 text-center" style="width: 13%;min-width: 13%;max-width: 13%;">
                        <span class="odd d-block mbox-1 font-size-14 text-center" style="display: inline !important;">YES</span>
                    </div>
                    <div class="destopViewBetLimit box-2 float-left text-right min-max" style="border-bottom: 0px none;">
                        <input type="hidden" id="ses_min_bet" value="{{$sports->fancy_min_limit}}">
                        <input type="hidden" id="ses_max_bet" value="{{$sports->fancy_max_limit}}">
                    </div>
                  </div>
               </div>

              <div class="table-body rootClass addSessionMarket">
                <input type="hidden" class="SESSION" id="betType" value="SESSION">
                @if(isset($dataArr['session']))
                @foreach($dataArr['session'] as $key=>$session)
                   <div class="fancy-tripple SESSIONCount SESSION SES_{{$key}}">
                      <div id="suspended" data-title="" class="table-row">
                        <div class="float-left country-name box-6 mbox-4" style="border-bottom: 0px none;">
                         <span class="bookmakerteamname2 team-name1"><b class="team">{{$session['RunnerName']}}</b></span>
                         <br>
                          <a href="javascript:void(0);" style="display:none;"
                             class="showBookBtn btn btn-primary tableman_btn pull-right"
                             onclick="showBookSession(this);">Book</a>
                          <br><p style="color: black;">0</p>
                       </div>
                        <div class="box-1 lay float-left text-center mbox-1 font-size-14">
                          <span class="odd d-block font-size-14">{{$session['LayPrice1']}}</span>
                          <span class="oddk">{{$session['LaySize1']}}</span>
                        </div>
                        <div class="box-1 back float-left text-center mbox-1 font-size-14">
                          <span class="odd d-block font-size-14">{{$session['BackPrice1']}}</span>
                          <span class="oddk">{{$session['BackSize1']}}</span>
                        </div>
                        <div class="mobileOddsHide box-2 float-left text-right min-max" style="border-bottom: 0px none;">
                            <input type="hidden" class="seq" value="{{$key}}">
                         <span class="d-block">Min: <span>{{$sports->fancy_min_limit}}</span></span>
                          <span class="d-block">Max: <span>{{$sports->fancy_max_limit}}</span></span>
                        </div>
                      </div>
                   </div>
                @endforeach
                @endif
              </div>
              <div>
              </div>
            </div>
          </div>
        </div>

      </div>
   </div>
  @include('backend.market.market-detail-right')
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-left headingText">Modal Header</h4>
          <!--<span  class="close" data-dismiss="modal">&times;</span>-->
        </div>
        <div class="modal-body" id="modelBodyID">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

@include('backend.market.more')
@endsection

@push('after-styles')
<style>
    .dropdown-menuTXT li{
        padding: 5px 10px;
    }

</style>
@endpush
@push('after-scripts')


<script type="text/javascript">

  $( document ).ready(function() {
     var isMobile = false; //initiate as false
    // device detection
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
        isMobile = true;
        $('#sidebar-right').remove();
        showoddsBets('leftSideView');
        $('.SBDESTOP').remove();
    }else{
      $('.mobilebetOdds').remove();
      $('.SBMOBILE').remove();
    }

  });
  function showoddsBets(ids){
    if(ids == 'leftSideView'){
      $('.leftSideView').show();
      $('.sidebar-right-bar').hide();
    }else{
      $('.sidebar-right-bar').show();
      $('.leftSideView').hide();
    }
  }

  $( document ).ready(function() {
    setInterval(function(){ getData(); }, 3000);
//    setInterval(function(){  }, 5000);
  });
   getData();
  function setSB(data){
    var team1 = '';
    var team2 = '';
    if (typeof data.team1 !== 'undefined') {
        if (typeof data.team1.name !== 'undefined') {
            $('.sbTeamName1').text(data.team1.name);
        }
        if (typeof data.team1.score !== 'undefined') {
            $('.sbRun1').text(data.team1.score);
        }
        if(typeof data.team1.CRR !== 'undefined' && data.team1.CRR != ''){
            team1 += 'CRR '+data.team1.CRR;
        }
        if(typeof data.team1.RR !== 'undefined' && data.team1.RR != ''){
            team1 += ' RR '+data.team1.RR;
        }
    }

    if (typeof data.team2 !== 'undefined') {
        if (typeof data.team2.name !== 'undefined') {
            $('.sbTeamName2').text(data.team2.name);
        }
        if (typeof data.team2.score !== 'undefined') {
            $('.sbRun2').text(data.team2.score);
        }
        if(typeof data.team2.CRR !== 'undefined' && data.team2.CRR != ''){
            team2 += 'CRR '+data.team2.CRR;
        }
        if(typeof data.team2.RR !== 'undefined' && data.team2.RR != ''){
            team2 += ' RR '+data.team2.RR;
        }
    }
    $('.sbRunRate1').text(team1);
    $('.sbRunRate2').text(team2);

    if(typeof data.status !== 'undefined' && data.status != ''){
        $('.sbStatus').text(data.status);
    }
    if(typeof data.last_six_balls !== 'undefined' && data.last_six_balls != ''){
        var htmlTxt = '';
        var colorCode_6 = '#F08080';
        var colorCode_4 = '#008000';
        var colorCode_wicket = 'red';
        var colorCode_reg = 'gray';
        if(typeof data.last_six_balls.last_ball_6 !== 'undefined' && data.last_six_balls.last_ball_6 != ''){
            var colorName = colorCode_reg;
            if(data.last_six_balls.last_ball_6 == 6){
                colorName = colorCode_6;
            }
            if(data.last_six_balls.last_ball_6 == 4){
                colorName = colorCode_4;
            }
            if(data.last_six_balls.last_ball_6 == 'ww'){
                colorName = colorCode_wicket;
            }
            htmlTxt += '<span style="padding: 3px 10px;margin: 2px;color:#fff;border-radius:100%;background:'+colorName+'">'+data.last_six_balls.last_ball_6+'</span>';
        }
        if(typeof data.last_six_balls.last_ball_5 !== 'undefined' && data.last_six_balls.last_ball_5 != ''){
            var colorName = colorCode_reg;
            if(data.last_six_balls.last_ball_5 == 6){
                colorName = colorCode_6;
            }
            if(data.last_six_balls.last_ball_5 == 4){
                colorName = colorCode_4;
            }
            if(data.last_six_balls.last_ball_5 == 'ww'){
                colorName = colorCode_wicket;
            }
            htmlTxt += '<span style="padding: 3px 10px;margin: 2px;color:#fff;border-radius:100%;background:'+colorName+'">'+data.last_six_balls.last_ball_5+'</span>';
        }
        if(typeof data.last_six_balls.last_ball_4 !== 'undefined' && data.last_six_balls.last_ball_4 != ''){
            var colorName = colorCode_reg;
            if(data.last_six_balls.last_ball_4 == 6){
                colorName = colorCode_6;
            }
            if(data.last_six_balls.last_ball_4 == 4){
                colorName = colorCode_4;
            }
            if(data.last_six_balls.last_ball_4 == 'ww'){
                colorName = colorCode_wicket;
            }
            htmlTxt += '<span style="padding: 3px 10px;margin: 2px;color:#fff;border-radius:100%;background:'+colorName+'">'+data.last_six_balls.last_ball_4+'</span>';
        }
        if(typeof data.last_six_balls.last_ball_3 !== 'undefined' && data.last_six_balls.last_ball_3 != ''){
            var colorName = colorCode_reg;
            if(data.last_six_balls.last_ball_3 == 6){
                colorName = colorCode_6;
            }
            if(data.last_six_balls.last_ball_3 == 4){
                colorName = colorCode_4;
            }
            if(data.last_six_balls.last_ball_3 == 'ww'){
                colorName = colorCode_wicket;
            }
            htmlTxt += '<span style="padding: 3px 10px;margin: 2px;color:#fff;border-radius:100%;background:'+colorName+'">'+data.last_six_balls.last_ball_3+'</span>';
        }
        if(typeof data.last_six_balls.last_ball_2 !== 'undefined' && data.last_six_balls.last_ball_2 != ''){
            var colorName = colorCode_reg;
            if(data.last_six_balls.last_ball_2 == 6){
                colorName = colorCode_6;
            }

            if(data.last_six_balls.last_ball_2 == 4){
                colorName = colorCode_4;
            }
            if(data.last_six_balls.last_ball_2 == 'ww'){
                colorName = colorCode_wicket;
            }
            htmlTxt += '<span style="padding: 3px 10px;margin: 2px;color:#fff;border-radius:100%;background:'+colorName+'">'+data.last_six_balls.last_ball_2+'</span>';
        }
        if(typeof data.last_six_balls.last_ball_1 !== 'undefined' && data.last_six_balls.last_ball_1 != ''){
            var colorName = colorCode_reg;
            if(data.last_six_balls.last_ball_1 == 6){
                colorName = colorCode_6;
            }
            if(data.last_six_balls.last_ball_1 == 4){
                colorName = colorCode_4;
            }
            if(data.last_six_balls.last_ball_1 == 'ww'){
                colorName = colorCode_wicket;
            }
            htmlTxt += '<span style="padding: 3px 10px;margin: 2px;color:#fff;border-radius:100%;background:'+colorName+'">'+data.last_six_balls.last_ball_1+'</span>';
        }

        $('.lastSixBol2').html(htmlTxt);
    }
}
 function getData(){

    $.ajax({
      url: '{{route("frontend.getdata",$sports->match_id)}}',
      dataType: 'json',
      type: "get",
      async:false,
      success: function(data){
        //   console.log(data);return false;
        if(data.matchDeclear == true){
             redirectHome();
        }else{
            if(data.matchSuspended == true){
                $('.addSessionMarket').attr('data-title','SUSPENDED');
                $('.addSessionMarket').addClass('suspended');
                $('.BOOKMAKER-data').attr('data-title','SUSPENDED');
                $('.BOOKMAKER-data').addClass('suspended');
                $('.ODDS').attr('data-title','SUSPENDED');
                $('.ODDS').addClass('suspended');
            }else{
                $('.addSessionMarket').attr('data-title','Active');
                $('.addSessionMarket').removeClass('suspended');
                $('.BOOKMAKER-data').attr('data-title','Active');
                $('.BOOKMAKER-data').removeClass('suspended');
                $('.ODDS').attr('data-title','Active');
                $('.ODDS').removeClass('suspended');
            }
            setodd(data.odd);
            if(typeof data.SB !== 'undefined') {
                $('.scorecard').show();
                setSB(data.SB);
            }else{
                $('.scorecard').hide();
            }
            setbookmaker(data.bookmaker);
            addnewSession(data.session);
            getBetsList();
        }
      }
    });
  }
  function setodd(data){
    $.each(data, function(i, item) {
        $('.oddssteam'+i+' .team-name'+i+' > b').text(item.RunnerName);
        $('.oddssteam'+i+' .back1t').text(item.b1);
        $('.oddssteam'+i+' .back2t').text(item.b2);
        $('.oddssteam'+i+' .back3t').text(item.b3);
        $('.oddssteam'+i+' .back1k').text(item.bs1+"k");
        $('.oddssteam'+i+' .back2k').text(item.bs2+"k");
        $('.oddssteam'+i+' .back3k').text(item.bs3+"k");
        $('.oddssteam'+i+' .lay1t').text(item.l1);
        $('.oddssteam'+i+' .lay2t').text(item.l2);
        $('.oddssteam'+i+' .lay3t').text(item.l3);
        $('.oddssteam'+i+' .lay1k').text(item.ls1+"k");
        $('.oddssteam'+i+' .lay2k').text(item.ls2+"k");
        $('.oddssteam'+i+' .lay3k').text(item.ls3+"k");

        var tot = (parseFloat(item.b1)+parseFloat(item.b2)+parseFloat(item.b3));
        tot = (parseFloat(tot)+parseFloat(item.bs1)+parseFloat(item.bs2)+parseFloat(item.bs3));
        tot = (parseFloat(tot)+parseFloat(item.l1)+parseFloat(item.l2)+parseFloat(item.l3));
        tot = (parseFloat(tot)+parseFloat(item.ls1)+parseFloat(item.ls2)+parseFloat(item.ls3));

        if(parseFloat(tot) <= 0){
          $('.oddssteam'+i).closest('.table-row').addClass('suspended');
          $('.oddssteam'+i).closest('.table-row').attr('data-title','SUSPENDED');
        }else{
          $('.oddssteam'+i).closest('.table-row').removeClass('suspended');
          $('.oddssteam'+i).closest('.table-row').attr('data-title','ACTIVE');
        }
    });
}
  function setbookmaker(data){
    $.each(data, function(i, item) {
        $('.bookmaker'+i+' .team-name'+i+' > b').text(item.RunnerName);
        $('.bookmaker'+i+' .back1t').text(item.BackPrice1);
        $('.bookmaker'+i+' .back2t').text(item.BackPrice2);
        $('.bookmaker'+i+' .back3t').text(item.BackPrice3);
        $('.bookmaker'+i+' .back1k').text(item.BackSize1+"k");
        $('.bookmaker'+i+' .back2k').text(item.BackSize2+"k");
        $('.bookmaker'+i+' .back3k').text(item.BackSize3+"k");
        $('.bookmaker'+i+' .lay1t').text(item.LayPrice1);
        $('.bookmaker'+i+' .lay2t').text(item.LayPrice2);
        $('.bookmaker'+i+' .lay3t').text(item.LayPrice3);
        $('.bookmaker'+i+' .lay1k').text(item.LaySize1+"k");
        $('.bookmaker'+i+' .lay2k').text(item.LaySize2+"k");
        $('.bookmaker'+i+' .lay3k').text(item.LaySize3+"k");
        var tot = (parseFloat(item.BackPrice1)+parseFloat(item.BackPrice2)+parseFloat(item.BackPrice3));
        tot = (parseFloat(tot)+parseFloat(item.BackSize1)+parseFloat(item.BackSize2)+parseFloat(item.BackSize3));
        tot = (parseFloat(tot)+parseFloat(item.LayPrice1)+parseFloat(item.LayPrice2)+parseFloat(item.LayPrice3));
        tot = (parseFloat(tot)+parseFloat(item.LaySize1)+parseFloat(item.LaySize2)+parseFloat(item.LaySize3));
        if(parseFloat(tot) <= 0){
          $('.bookmaker'+i).addClass('suspended');
          $('.bookmaker'+i).attr('data-title','SUSPENDED');
        }else{
          $('.bookmaker'+i).removeClass('suspended');
          $('.bookmaker'+i).attr('data-title','ACTIVE');
        }
    });
}

function addnewSession(data){
    var oldCount = $('.SESSIONCount').length;
    var newcount = data.length;
    $.each(data, function(i, item) {
        if(parseInt(newcount) < parseInt(oldCount)){
         if(parseInt(i) == (parseInt(newcount)-parseInt(1))){
           for(var j = i;j<parseInt(oldCount);j++){
             $('.SES_'+j).closest('.SESSION').remove();
           }
         }
       }else{
            if((parseInt(oldCount)) <= parseInt(i)){
              var min_bet = $('#ses_min_bet').val();
              var max_bet = $('#ses_max_bet').val();
              var html = '';
              html += '<div class="fancy-tripple SESSIONCount SESSION SES_'+i+'">';
                html += '<div id="suspended" data-title="" class="table-row">';
                  html += '<div class="float-left country-name box-6 mbox-4" style="border-bottom: 0px none;">';
                    html += '<span class="bookmakerteamname2 team-name1"><b class="team">'+item.RunnerName+'</b></span>';
                      html += '<br>&nbsp;&nbsp;<a href="javascript:void(0);" style="display:none;" class="showBookBtn btn btn-primary tableman_btn pull-right" onclick="showBookSession(this);">Book</a>';
//                      html += '<br><p style="color: black;">0</p>';
                  html += '</div>';
                  html += '<div class="box-1 lay float-left text-center mbox-1">';
                    html += '<span class="odd d-block font-size-14">'+item.LayPrice1+'</span>';
                    html += '<span class="oddk">'+item.LaySize1+'</span>';
                  html += '</div>';
                  html += '<div class="box-1 back float-left text-center mbox-1">';
                  html += '<span class="odd d-block font-size-14">'+item.BackPrice1+'</span>';
                  html += '<span class="oddk">'+item.BackSize1+'</span>';
                html += '</div>';
                html += '<div class="destopViewBetLimit box-2 float-left text-right min-max" style="border-bottom: 0px none;">';
                  html += '<input type="hidden" class="seq" value="'+i+'">';
                  html += '<span class="d-block">Min: <span>'+min_bet+'</span></span>';
                  html += '<span class="d-block">Max: <span>'+max_bet+'</span></span>';
                html += ' </div>';
              html += '</div>';
            html += '</div>';
            $('.addSessionMarket').append(html);
            }
        }

        var tot = (parseFloat(item.BackPrice1)+parseFloat(item.BackSize1)+parseFloat(item.LaySize1)+parseFloat(item.LaySize1));
        if(item.GameStatus != '' || parseInt(tot) == 0){
            className = 'suspended';
            dataTitle = 'SUSPENDED';
            $('.SES_'+i).find('#suspended').addClass(className);
            $('.SES_'+i).find('#suspended').attr('data-title',item.GameStatus);
        }else{
            $('.SES_'+i).find('#suspended').removeClass('suspended');
            $('.SES_'+i).find('#suspended').attr('data-title','')
        }
        var objTeamLay = $('.SES_'+i).find('.lay');
        var objTeamBack = $('.SES_'+i).find('.back');
        var objTeamName = $('.SES_'+i).find('.team');
        if(objTeamName.text() != item.RunnerName){
            $(objTeamName).closest('div').find('.showBookBtn').hide();
        }
        $(objTeamName).text(item.RunnerName);
//        $(objTeamName).text("denish");
        $(objTeamLay).find('.odd').text(item.LayPrice1);
        $(objTeamLay).find('.oddk').text(item.LaySize1);
        $(objTeamBack).find('.odd').text(item.BackPrice1);
        $(objTeamBack).find('.oddk').text(item.BackSize1);
    });
}
  function deleteMyBets(id){
    if(!confirm("Are You Sure Bet Delete?")){
      return false;
    }
    $.ajax({
      url: '{{route("admin.my-bets.deleteMyBet")}}',
      dataType: 'json',
      type: "POST",
      data: '_token={{csrf_token()}}&id='+id,
      success: function(dataJson){
        alert(dataJson.message);
      }
    });
  }
  function rollbackMyBets(id){
    if(!confirm("Are You Sure Bet RollBack?")){
      return false;
    }
    $.ajax({
      url: '{{route("admin.my-bets.rollBackMyBet")}}',
      dataType: 'json',
      type: "POST",
      data: '_token={{csrf_token()}}&id='+id,
      success: function(dataJson){
        alert(dataJson.message);
      }
    });
  }
  function getBetsList(){
      $.ajax({
        url: '{{route("admin.my-bets.list")}}',
        dataType: 'json',
        type: "POST",
        data: 'sportID={{$sports->id}}&_token={{csrf_token()}}&match_id={{$sports->match_id}}',
        success: function(dataJson){

          if (typeof dataJson.myBetsHtml !== 'undefined') {
            $('.mybetListID').html(dataJson.myBetsHtml);
          }
          if (typeof dataJson.ODDS !== 'undefined') {
          $.each(dataJson.ODDS, function(i, data) {
              var teamname = $('.ODDS').find('.oddteamname1 > b').text();
              var teamname1 = $('.ODDS').find('.oddteamname2 > b').text();
              if(teamname == i){
                objteam1 = $('.ODDS').find('.oddteamname1 > b');
                objteam2 = $('.ODDS').find('.oddteamname2 > b');

                if(parseFloat(data.ODDS_profitLost) >= 0){
                    $(objteam1).closest('.country-name').find('.float-left').css('color','red');
                    var amt = data.ODDS_profitLost;
                    $(objteam1).closest('.country-name').find('.float-left').text((parseFloat(amt)*(-1)));
                }else{
                    $(objteam1).closest('.country-name').find('.float-left').css('color','green');
                    $(objteam1).closest('.country-name').find('.float-left').text(Math.abs(data.ODDS_profitLost));
                }
              }else if(teamname1 == i){
                objteam2 = $('.ODDS').find('.oddteamname2 > b');
                if(parseFloat(data.ODDS_profitLost) >= 0){
                    $(objteam2).closest('.country-name').find('.float-left').css('color','red');
                    var amt = data.ODDS_profitLost;
                    $(objteam2).closest('.country-name').find('.float-left').text((parseFloat(amt)*(-1)));
                }else{
                    $(objteam2).closest('.country-name').find('.float-left').css('color','green');
                    $(objteam2).closest('.country-name').find('.float-left').text(Math.abs(data.ODDS_profitLost));
                }

              }else{
                objteam3 = $('.ODDS').find('.oddteamname3 > b');
                if(parseFloat(data.ODDS_profitLost) >= 0){
                    $(objteam3).closest('.country-name').find('.float-left').css('color','red');
                    var amt = data.ODDS_profitLost;
                    $(objteam3).closest('.country-name').find('.float-left').text((parseFloat(amt)*(-1)));
                }else{
                    $(objteam3).closest('.country-name').find('.float-left').css('color','green');
                    $(objteam3).closest('.country-name').find('.float-left').text(Math.abs(data.ODDS_profitLost));
                }
//                $(objteam3).closest('.country-name').find('.float-left').text(data.ODDS_profitLost);
              }
          });
          }
          if (typeof dataJson.BOOKMAKER !== 'undefined') {
          $.each(dataJson.BOOKMAKER, function(i, data) {
            var teamname = $('.BOOKMAKER').find('.bookmakerteamname1 > b').text();
            var teamname1 = $('.BOOKMAKER').find('.bookmakerteamname2 > b').text();

            if(teamname == i){
              objteam1 = $('.BOOKMAKER').find('.bookmakerteamname1 > b');

              if(parseFloat(data.BOOKMAKER_profitLost) >= 0){
                $(objteam1).closest('.country-name').find('.float-left').css('color','red');
                var amt = data.BOOKMAKER_profitLost;
                $(objteam1).closest('.country-name').find('.float-left').text((parseFloat(amt)*(-1)));
              }else{
                $(objteam1).closest('.country-name').find('.float-left').css('color','green');
                $(objteam1).closest('.country-name').find('.float-left').text(Math.abs(data.BOOKMAKER_profitLost));
              }

//              $(objteam1).closest('.country-name').find('.float-left').text(data.BOOKMAKER_profitLost);
            }else if(teamname1 == i){
              objteam2 = $('.BOOKMAKER').find('.bookmakerteamname2 > b');
              if(parseFloat(data.BOOKMAKER_profitLost) >= 0){
                $(objteam2).closest('.country-name').find('.float-left').css('color','red');
                var amt = data.BOOKMAKER_profitLost;
                $(objteam2).closest('.country-name').find('.float-left').text((parseFloat(amt)*(-1)));
              }else{
                $(objteam2).closest('.country-name').find('.float-left').css('color','green');
                $(objteam2).closest('.country-name').find('.float-left').text(Math.abs(data.BOOKMAKER_profitLost));
              }
//              $(objteam2).closest('.country-name').find('.float-left').text(data.BOOKMAKER_profitLost);
            }else{
              objteam3 = $('.BOOKMAKER').find('.bookmakerteamname3 > b');
              if(parseFloat(data.BOOKMAKER_profitLost) >= 0){
                $(objteam3).closest('.country-name').find('.float-left').css('color','red');
                var amt = data.BOOKMAKER_profitLost;
                $(objteam3).closest('.country-name').find('.float-left').text((parseFloat(amt)*(-1)));
              }else{
                $(objteam3).closest('.country-name').find('.float-left').css('color','green');
                $(objteam3).closest('.country-name').find('.float-left').text(Math.abs(data.BOOKMAKER_profitLost));
              }
//              $(objteam3).closest('.country-name').find('.float-left').text(data.BOOKMAKER_profitLost);
            }
         });
          }
          if (typeof dataJson.SESSION !== 'undefined') {
            $('.SESSION').each(function(){
                var obj = this;
                var isBookShow = false;
                $.each(dataJson.SESSION, function(i, data){

                var teamName = $(obj).find('.team').text();
                if(teamName == data){
                  $(obj).find('.showBookBtn').show();
                  isBookShow = true;
                }
              });
              if(isBookShow == false){
                 $(obj).find('.showBookBtn').hide();
              }
          });
        }else{
            $('.showBookBtn').hide();
        }
        }
      });
    }

  function showBookSession(obj){
      var teamname = $(obj).closest('.SESSION').find('.team').text();
      $.ajax({
        url: '{{route("admin.my-bets.getSessionBetData")}}',
        dataType: 'text',
        type: "POST",
        data : 'sportID={{$sports->id}}&match_id={{$sports->match_id}}&_token={{csrf_token()}}&teamName='+teamname,
        success: function(data){
          $("#modelBodyID").html('');
          $('.headingText').text('');
          $('.headingText').text(teamname);
          $("#modelBodyID").html(data);
          $("#myModal").modal("show");
        }
      });


    }


</script>
@include('backend.market.marketJS')
@include('backend.market.sideBarScroll')
@endpush
