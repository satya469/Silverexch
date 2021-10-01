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

<?php 
    $dataArr = SportsController::getTeamName('SOCCER',$sports->match_id);
//  dd($session['soccer']['session']);
?>
<div class="row">
   <div class="col-md-8 featured-box-detail">
      <div class="coupon-card">
          <div class="game-heading">
            <span class="card-header-title">{{$sports->match_name}}</span> 
            <span class="float-right">{{$sports->match_date_time}}</span>
          </div>
          <div class="header mobilebetOdds">
              <a class="odds" href="javascript:void(0);" style="color: #fff;border-right: 1px solid #fff;margin-right: 10px;border-right: 1px solid #fff;padding-right: 10px;" onclick="showoddsBets('leftSideView');">ODDS</a>
              <a class="matchbets" href="javascript:void(0);" style="color: #fff;" onclick="showoddsBets('sidebar-right-bar');">Match BET</a>
              <!--<a class="mobileTV" href="javascript:void(0);" onclick="showTv();"> <i class="fas fa-tv v-m icon-tv"></i></a>-->
          </div>
          <div class="markets mobileodds leftSideView">
             <!--START TOP BANER DETAILS-->
            @if(!empty($sports->sb_url) > 0)
            <div class="leftSideView">
                <iframe height="auto" src="{{$sports->sb_url}}" class="video-iframe"></iframe>
              </div>
            @endif
            <!--END TOP BANER DETAILS-->  
            <div class="main-market rootClass">
              <div class="market-title mt-1">
                MATCH_ODDS
                <a href="javascript:void(0)" onclick="showRules('ODDS');" class="m-r-5 game-rules-icon">
                  <span><i class="fa fa-info-circle float-right"></i></span>
                </a> 
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
                 @if($dataArr['teamname'])   
                    @foreach($dataArr['teamname'] as $key=>$val)  
                      <div data-title="ACTIVE" class="table-row oddsTot oddssteam{{$key}}">
                        <div class="float-left country-name box-4 mbox-4">
                            <span class="oddteamname1 team-name0"><b class="team font-size-14">{{$val}}</b></span> 
                          <p class="lefttxt">
                              <span class="float-left book" style="color: black;">0</span> 
                              <span class="float-right " style="display: none; color: black;">0</span>
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
                        <div class="box-1 back float-left back lock text-center mbox-1">
                            <span class="odd d-block back1t font-size-14"></span> 
                            <span class="d-block back1k"></span>
                        </div>
                        <div class="box-1 lay float-left text-center mbox-1">
                            <span class="odd d-block lay1t font-size-14"></span> 
                            <span class="d-block lay1k"></span>
                        </div>
                        <div class="box-1 lay1 float-left text-center mobileOddsHide">
                            <span class="odd d-block lay2t"></span> 
                            <span class="d-block lay2k"></span>
                        </div>
                        <div class="box-1 lay2 float-left text-center mobileOddsHide">
                            <span class="odd d-block lay3t"></span> 
                            <span class="d-block lay3k"></span>
                        </div>
                      </div>
                  @endforeach
                @endif
              </div>
              @if(isset($dataArr['sessionType']))
                @foreach($dataArr['sessionType'] as $key=>$session)
                  <div class="row row5 bookmaker-market mt-1 rootClass SESSION ">
                    <div data-title="{{$session['TITLE']}}" class="bm1 SessionTitle col-12 {{$session['TITLE']}}">
                      <div>
                        <div class="market-title mt-1">
                          {{$session['TITLE']}}
                          <a href="javascript:void(0)" onclick="showRules('SESSION');" class="m-r-5 game-rules-icon">
                              <span><i class="fa fa-info-circle float-right"></i></span>
                          </a>
                          <b>
                              <span class="destopViewBetLimit float-right m-r-10">
                            @if(!empty($sports->fancy_min_limit))
                              <span style="padding-right: 10px;">Min Bet : <span>{{$sports->fancy_min_limit}}</span></span>
                            @endif
                            @if(!empty($sports->fancy_max_limit))    
                              <span> Max Bet : <span>{{$sports->fancy_max_limit}}</span></span>
                            @endif  
                            </span>
                          </b>
                          <input type="hidden" class="MatchOdd" id="sessionMax" value="5000">
                          <input type="hidden" class="MatchOdd" id="sessionMin" value="500">
                          <input type="hidden" class="MatchOdd" id="betType" value="SESSION">
                          <input type="hidden" class="options" id="options" value="{{$session['TITLE']}}">
                        </div>
                        <div class="table-header avoid-clicks">
                            <div class="float-left  box-4 mbox-4">
                                <span class="mobileViewBetLimit float-right m-r-10">
                                    @if(!empty($sports->fancy_min_limit))
                                      <span style="padding-right: 10px;">Min Bet : <span>{{$sports->fancy_min_limit}}</span></span>
                                    @endif
                                    @if(!empty($sports->fancy_max_limit))    
                                      <span> Max Bet : <span>{{$sports->fancy_max_limit}}</span></span>
                                    @endif  
                                </span>

                            </div>
                            <div class="box-1 float-left mobileOddsHide"></div>
                            <div class="box-1 float-left mobileOddsHide" ></div>
                            <div class="back box-1  text-center mbox-1"><b class="font-size-14">BACK</b></div>
                            <div class="lay box-1  text-center mbox-1"><b class="font-size-14">LAY</b></div>
                            <div class="box-1 float-left mobileOddsHide"></div>
                            <div class="box-1 float-left mobileOddsHide"></div>
                        </div>
                        <div class="table-body ">
                          @if(isset($session['TEAMNAME']))
                            @foreach($session['TEAMNAME'] as $tkey=>$tVal)
                              <div data-title="ACTIVE" class="table-row oddsTot OVER_UNDER_{{$tkey}}">
                                <div class="float-left country-name box-4 mbox-4">
                                    <span class=" team-name0"><b class="team teamName font-size-14">{{$tVal}}</b></span> 
                                  <p class="lefttxt">
                                      <span class="float-left book" style="color: black;">0</span> 
                                      <span class="float-right " style="display: none; color: black;">0</span>
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
                                <div class="box-1 back float-left back lock mbox-1 text-center">
                                    <span class="odd d-block back1t font-size-14"></span> 
                                    <span class="d-block back1k"></span>
                                </div>
                                <div class="box-1 lay float-left text-center mbox-1">
                                    <span class="odd d-block lay1t font-size-14"></span> 
                                    <span class="d-block lay1k"></span>
                                </div>
                                <div class="box-1 lay1 float-left text-center mobileOddsHide">
                                    <span class="odd d-block lay2t"></span> 
                                    <span class="d-block lay2k"></span>
                                </div>
                                <div class="box-1 lay2 float-left text-center mobileOddsHide">
                                    <span class="odd d-block lay3t"></span> 
                                    <span class="d-block lay3k"></span>
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
                @endforeach
              @endif  
            </div>
          </div>
      </div>
   </div>
  @include('backend.market.market-detail-right')
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

<!--@include('backend.reloadJS')-->
<script type="text/javascript">
$( document ).ready(function() {
 
     var isMobile = false; //initiate as false
    // device detection
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
        isMobile = true;
        showoddsBets('leftSideView');
    }
  setInterval(function(){ getData(); }, 2000);
});
function showoddsBets(ids){
    if(ids == 'leftSideView'){
      $('.leftSideView').show();
       $('.leftSideView').css('display',"block");
      $('.sidebar-right-bar').hide();
    }else{
      $('.sidebar-right-bar').show();
      $('.leftSideView').css('display',"none");
      $('.leftSideView').hide();
    }
  }
function getData(){
    $.ajax({
      url: '{{route("frontend.getdatasoccer",$sports->match_id)}}',
      dataType: 'json',
      type: "get",
      success: function(data){
        if(data.matchDeclear == true){
             redirectHome();
        }else{
            if(data.matchSuspended == true){
                $('.oddsTot').attr('data-title','SUSPENDED');
                $('.oddsTot').addClass('suspended');
                $('.ODDS').attr('data-title','SUSPENDED');
                $('.ODDS').addClass('suspended');
            }else{
                $('.oddsTot').attr('data-title','Active');
                $('.oddsTot').removeClass('suspended');
                $('.ODDS').attr('data-title','Active');
                $('.ODDS').removeClass('suspended');
            }
            setodd(data.odd);
            setbookmaker(data.session);
            getBetsList();
        }
      }
    });
  }
  
  function setodd(data){
    $.each(data, function(i, item) {
      $('.oddssteam'+i+' .back1t').text(item.BackPrice1);
      $('.oddssteam'+i+' .back2t').text(item.BackPrice2);
      $('.oddssteam'+i+' .back3t').text(item.BackPrice3);

      $('.oddssteam'+i+' .back1k').text(item.BackSize1);
      $('.oddssteam'+i+' .back2k').text(item.BackSize2);
      $('.oddssteam'+i+' .back3k').text(item.BackSize3);

      $('.oddssteam'+i+' .lay1t').text(item.LayPrice1);
      $('.oddssteam'+i+' .lay2t').text(item.LayPrice2);
      $('.oddssteam'+i+' .lay3t').text(item.LayPrice3);

      $('.oddssteam'+i+' .lay1k').text(item.LaySize1);
      $('.oddssteam'+i+' .lay2k').text(item.LaySize2);
      $('.oddssteam'+i+' .lay3k').text(item.LaySize3);

      var tot = (parseFloat(item.BackPrice1)+parseFloat(item.BackPrice2)+parseFloat(item.BackPrice3));
      tot = (parseFloat(tot)+parseFloat(item.BackSize1)+parseFloat(item.BackSize2)+parseFloat(item.BackSize3));
      tot = (parseFloat(tot)+parseFloat(item.LayPrice1)+parseFloat(item.LayPrice2)+parseFloat(item.LayPrice3));
      tot = (parseFloat(tot)+parseFloat(item.LaySize1)+parseFloat(item.LaySize2)+parseFloat(item.LaySize3));

      if(parseFloat(tot) <= 0){
        $('.oddssteam'+i).closest('.table-row').addClass('suspended');
        $('.oddssteam'+i).closest('.table-row').attr('data-title','SUSPENDED');
      }else{
        $('.oddssteam'+i).closest('.table-row').removeClass('suspended');
        $('.oddssteam'+i).closest('.table-row').attr('data-title','ACTIVE');
      }
    });
  }
  function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
  }
  var sesssionArr1 = sesssionArr.filter(onlyUnique);
    $('.SessionTitle').each(function(){
        var title = $(this).attr('data-title');
        var temp = false;
        $.each(sesssionArr1, function(j, item) {
           if(title == item){
               temp = true;
           }
        });
        if(temp == false){
            $(this).remove();
        }
    });
  function setbookmaker(data){
    var i = 0;
    var sesssionArr = [];
    $.each(data, function(j, item) {
      var ret = item.RunnerName.split(" ");
      var text = ret[1].replace('.','');
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back1t').text(item.BackPrice1);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back2t').text(item.BackPrice2);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back3t').text(item.BackPrice3);

      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back1k').text(item.BackSize1);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back2k').text(item.BackSize2);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back3k').text(item.BackSize3);

      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay1t').text(item.LayPrice1);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay2t').text(item.LayPrice2);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay3t').text(item.LayPrice3);

      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay1k').text(item.LaySize1);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay2k').text(item.LaySize2);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay3k').text(item.LaySize3);
      sesssionArr.push('OVER_UNDER_'+text);
      var tot = (parseFloat(item.BackPrice1)+parseFloat(item.BackPrice2)+parseFloat(item.BackPrice3));
      tot = (parseFloat(tot)+parseFloat(item.BackSize1)+parseFloat(item.BackSize2)+parseFloat(item.BackSize3));
      tot = (parseFloat(tot)+parseFloat(item.LayPrice1)+parseFloat(item.LayPrice2)+parseFloat(item.LayPrice3));
      tot = (parseFloat(tot)+parseFloat(item.LaySize1)+parseFloat(item.LaySize2)+parseFloat(item.LaySize3));

      if(parseFloat(tot) <= 0){
        $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i).addClass('suspended');
        $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i).attr('data-title','SUSPENDED');
      }else{
        $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i).removeClass('suspended');
        $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i).attr('data-title','ACTIVE');
      }
      
      i = parseInt(i)+parseInt(1);
      if(parseInt(i) == 2){
        i = 0;
      }
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
        url: '{{route("admin.my-bets.soccerlist")}}',
        dataType: 'json',
        type: "POST",
        data: 'sportID={{$sports->id}}&_token={{csrf_token()}}&match_id={{$sports->match_id}}',
        success: function(dataJson){
          if (typeof dataJson.myBetsHtml !== 'undefined') {
            $('.mybetListID').html(dataJson.myBetsHtml);
          }
          objteam1 = $('.ODDS').find('.oddssteam0');
          objteam2 = $('.ODDS').find('.oddssteam1');
          objteam3 = $('.ODDS').find('.oddssteam2');
          $(objteam1).find('.lefttxt .book').text('');
          $(objteam2).find('.lefttxt .book').text('');
          $(objteam3).find('.lefttxt .book').text('');
          
          if (typeof dataJson.ODDS !== 'undefined') {
            $.each(dataJson.ODDS, function(i, data) {
              var teamname1 = $('.ODDS').find('.oddssteam0 .team').text();
              var teamname2 = $('.ODDS').find('.oddssteam1 .team').text();
              if(teamname1 == i){
                objteam1 = $('.ODDS').find('.oddssteam0');
                if(parseFloat(data.ODDS_profitLost) > 0){
                  $(objteam1).find('.lefttxt .book').css('color','red');
                  var amt = data.ODDS_profitLost;
                  $(objteam1).find('.lefttxt .book').text((parseFloat(amt)*(-1)));
                }else{
                  $(objteam1).find('.lefttxt .book').find('.book').css('color','green');
                  $(objteam1).find('.lefttxt .book').text(Math.abs(data.ODDS_profitLost));
                }
              }else if(teamname2 == i){
                objteam2 = $('.ODDS').find('.oddssteam1');

                if(parseFloat(data.ODDS_profitLost) > 0){
                  $(objteam2).find('.lefttxt .book').css('color','red');
                  var amt = data.ODDS_profitLost;
                  $(objteam2).find('.lefttxt .book').text((amt*(-1)));
                }else{
                  $(objteam2).find('.lefttxt .book').css('color','green');
                  $(objteam2).find('.lefttxt .book').text(Math.abs(data.ODDS_profitLost));
                }
              }else{
                objteam1 = $('.ODDS').find('.oddssteam0');
                objteam2 = $('.ODDS').find('.oddssteam1');
                objteam3 = $('.ODDS').find('.oddssteam2');

                if(parseFloat(data.ODDS_profitLost) > 0){
                  $(objteam3).find('.lefttxt .book').css('color','red');
                  var amt = data.ODDS_profitLost;
                  $(objteam3).find('.lefttxt .book').text((amt*(-1)));
                }else{
                  $(objteam3).find('.lefttxt .book').css('color','Green');
                  $(objteam3).find('.lefttxt .book').text(Math.abs(data.ODDS_profitLost));
                }
              }
            });
          }
          $('.OVER_UNDER_0').find('.lefttxt .book').text('');
          $('.OVER_UNDER_1').find('.lefttxt .book').text('');
          if (typeof dataJson.SESSION !== 'undefined') {
            $.each(dataJson.SESSION, function(j, dataArr) {
            $.each(dataArr, function(i, data) {
              var teamname1 = $('.'+j).find('.OVER_UNDER_0 .team').text();
              var teamname2 = $('.'+j).find('.OVER_UNDER_1 .team').text();
              if(teamname1 == i){
                var objteam1 = $('.'+j).find('.OVER_UNDER_0');
                if(parseFloat(data.SESSION_profitLost) > 0){
                  $(objteam1).find('.lefttxt .book').css('color','red');
                   var amt = data.SESSION_profitLost;
                   $(objteam1).find('.lefttxt .book').text((amt*(-1)));
                }else{
                  $(objteam1).find('.lefttxt .book').css('color','green');
                  $(objteam1).find('.lefttxt .book').text(Math.abs(data.SESSION_profitLost));
                }
              }else{
                var objteam2 = $('.'+j).find('.OVER_UNDER_1');
                if(parseFloat(data.SESSION_profitLost) > 0){
                  $(objteam2).find('.lefttxt .book').css('color','red');
                  var amt = data.SESSION_profitLost;
                  $(objteam2).find('.lefttxt .book').text((amt*(-1)));
                }else{
                  $(objteam2).find('.lefttxt .book').css('color','green');
                  $(objteam2).find('.lefttxt .book').text(Math.abs(data.SESSION_profitLost));
                }
              }
            });
          });
          }
        }
      });
    }
</script>
@include('backend.market.marketJS')
@endpush
