@extends('frontend.layouts.app')

@section('title', app_name())

@section('content')

<div class="container-fluid container-fluid-5">
  <div class="row" style="margin-left: 0px;margin-right: 0px;">
    @include('frontend.game-list.leftSide')
    <!--featured-box--> 
    <div class="col-md-10  load game-page" style="margin-top: 5px;">
      <div class="row row5">
        <div class="col-md-9  featured-box-detail sports-wrapper m-b-10">
            <!----> <!----> 
          <div class="header mobilebetOdds">
                <a class="oddsMenu" href="javascript:void(0);" onclick="showoddsBets('odds');">ODDS</a>
                <a class="matchbets" href="javascript:void(0);" onclick="showoddsBets('matchbets');">MATCHED BET</a>
                <a class="mobileTV" href="javascript:void(0);" onclick="showTv();"> <i class="fas fa-tv v-m icon-tv"></i></a>
            </div>
            <div id="tv_status-errordetail" style="background: var(--theme2-bg);" class="tv-container collapse mobilebetOdds" align="center">
              <ul class="nav nav-tabs video_nav_tab">
                  <li onclick="showTvVideo('tv1',this);" class="nav-item navli">Chanel 1</li>
                  <li onclick="showTvVideo('tv2',this);" class="nav-item navli">Chanel 2</li>
                  <li onclick="showTvVideo('tv3',this);" class="nav-item navli">Chanel 3</li>
                  <li onclick="showTvVideo('tv4',this);" class="nav-item navli">Chanel 4</li>
              </ul>  
              <div  class="allVideo" id="tv1">
                  <iframe src="{{$adminSetting->TV_URL_1}}" 
                          class="video-iframe"></iframe>
              </div>
              <div style="display:none;" class="allVideo" id="tv2">
                  <iframe src="{{$adminSetting->TV_URL_2}}" 
                          class="video-iframe"></iframe>
              </div>
              <div style="display:none;" class="allVideo" id="tv3">
                  <iframe src="{{$adminSetting->TV_URL_3}}" 
                          class="video-iframe"></iframe>
              </div>
              <div style="display:none;" class="allVideo" id="tv4">
                  <iframe src="{{$adminSetting->TV_URL_4}}" 
                          class="video-iframe"></iframe>
              </div>
            </div>  
          <div class="game-heading mobileodds">
              <span class="card-header-title">{{$sports->match_name}}</span> 
              <span class="float-right">{{$sports->match_date_time}}</span>
          </div>
          <div class="markets mobileodds">
            <!--START TOP BANER DETAILS-->
            @if(!empty($sports->sb_url) > 0)
              <div>
                <iframe height="auto" src="{{$sports->sb_url}}" class="video-iframe"></iframe>
              </div>
            @endif
            <!--END TOP BANER DETAILS-->
            <input type="hidden" id="matchID" value="{{$sports->id}}">
            <!-- START MATCH ODDS-->

            <div class="main-market rootClass mobileodds">
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
                
                <input type="hidden" class="MatchOdd" id="oddsMax" value="{{$sports->odd_max_limit}}">
                <input type="hidden" class="MatchOdd" id="oddsMin" value="{{$sports->odd_min_limit}}">
                <input type="hidden" class="MatchOdd" id="betType" value="ODDS">
                
              </div>
              <div class="table-header avoid-clicks">
                <div class="float-left mbox-4 box-4 min-max">
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
                <div class="back box-1 float-left text-center mbox-1 font-size-14"><b class="font-size-14">BACK</b></div>
                <div class="lay box-1 float-left text-center mbox-1 font-size-14"><b class="font-size-14">LAY</b></div>
                <div class="box-1 float-left mobileOddsHide"></div>
                <div class="box-1 float-left mobileOddsHide"></div>
              </div>
              <div data-title="OPEN" class="table-body  ODDS">
                @if($dataArr['odd'])
                @foreach($dataArr['odd'] as $key=>$bookmaker)  
                <div data-title="ACTIVE" class="table-row oddsTot oddssteam{{$key}}">
                  <div class="float-left country-name box-4 mbox-4 ">
                      <span class="team-name"><b class="team teamName font-size-14">{{$bookmaker}}</b></span> 
                    <p>
                        <span class="float-left matchValClear123 matchValClearProfit" style="color: black;">0</span> 
                        <span class="float-right matchValClear matchValClearProfit" style="display: none; color: black;">0</span>
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
                      <span class="odd d-block back1t font-size-14"></span> 
                      <span class="d-block back1k"></span>
                  </div>
                  <div class="box-1 lay float-left text-center mbox-1 font-size-14">
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
                <!---->
              </div>
            </div>
            @if(isset($dataArr['session']))
              @foreach($dataArr['session'] as $key=>$session)
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
                        <div class="float-left  box-4 mbox-4 ">
                            <span class="float-right m-r-10 mobileViewBetLimit">
                                @if(!empty($sports->fancy_min_limit))
                                  <span style="padding-right: 10px;">Min Bet : <span>{{$sports->fancy_min_limit}}</span></span>
                                @endif
                                @if(!empty($sports->fancy_max_limit))    
                                  <span> Max Bet : <span>{{$sports->fancy_max_limit}}</span></span>
                                @endif  
                            </span>
                        </div>
                      <div class="box-1 float-left mobileOddsHide"></div>
                      <div class="box-1 float-left mobileOddsHide"></div>
                      <div class="back box-1 float-left text-center mbox-1 font-size-14"><b class="font-size-14">BACK</b></div>
                      <div class="lay box-1 float-left text-center mbox-1 font-size-14"><b class="font-size-14">LAY</b></div>
                      <div class="box-1 float-left mobileOddsHide"></div>
                      <div class="box-1 float-left mobileOddsHide"></div>
                    </div>
                    <div data-title="ACTIVE" class="table-body addSuspended">
                        @if(isset($session['TEAMNAME']))
                        @foreach($session['TEAMNAME'] as $tkey=>$tVal) 
                          <div data-title="ACTIVE" class="table-row  oddsTot OVER_UNDER_{{$tkey}}">
                            <div class="float-left country-name box-4 mbox-4">
                                <span class=" team-name0"><b class="team teamName font-size-14">{{$tVal}}</b></span> 
                              <p>
                                  <span class="float-left matchValClear123 matchValClearProfit" style="color: black;">0</span> 
                                  <span class="float-right matchValClearProfit" style="display: none; color: black;">0</span>
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
                                <span class="odd d-block back1t font-size-14"></span> 
                                <span class="d-block back1k"></span>
                            </div>
                            <div class="box-1 lay float-left text-center mbox-1 font-size-14">
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
          <div class="markets mobilebetsdata" style="display:none;">
            <div id="myBet" class="card-body">
              <table class="coupon-table table  table-borderedless">
                <thead>
                  <tr>
                    <th style="width: 60%;">
                      Team Name
                    </th>
                    <th class="text-left">
                      Odds
                    </th>
                    <th class="text-left">
                      Stake
                    </th>
                  </tr>
                </thead>
                <tbody>
                <tr>
                  <td colspan="3" class="text-center">No records Found</td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>  
        </div>
        <div id="sidebar-right" class="col-md-3 col-sm-12 sidebar-right sidebar-right-bar" style="position: fixed;right: 0;width: 25.5%;">
          <div class="ps">
            <div class="sidebar-right-inner">
              <div class="card m-b-10" style="border: 0px none;">
                <div class="card-header">
                    <h6 onclick="showTv();" class="card-title">Live Match
                    <span class="float-right"><i class="fa fa-tv"></i> live stream started
                    </span>
                  </h6>
                </div>
                  <div id="tv_status-errordetail" style="background-color: var(--theme2-bg);" class="tv-container collapse" align="center">
                      <ul class="nav nav-tabs video_nav_tab">
                          <li onclick="showTvVideo('tv1',this);" class="nav-item navli">Chanel 1</li>
                          <li onclick="showTvVideo('tv2',this);" class="nav-item navli">Chanel 2</li>
                          <li onclick="showTvVideo('tv3',this);" class="nav-item navli">Chanel 3</li>
                          <li onclick="showTvVideo('tv4',this);" class="nav-item navli">Chanel 4</li>
                      </ul>  
                      <div  class="allVideo" id="tv1">
                          <iframe src="{{$adminSetting->TV_URL_1}}" 
                                  class="video-iframe"></iframe>
                      </div>
                      <div style="display:none;" class="allVideo" id="tv2">
                          <iframe src="{{$adminSetting->TV_URL_2}}" 
                                  class="video-iframe"></iframe>
                      </div>
                      <div style="display:none;" class="allVideo" id="tv3">
                          <iframe src="{{$adminSetting->TV_URL_3}}" 
                                  class="video-iframe"></iframe>
                      </div>
                      <div style="display:none;" class="allVideo" id="tv4">
                          <iframe src="{{$adminSetting->TV_URL_4}}" 
                                  class="video-iframe"></iframe>
                      </div>



                </div>
              </div>
              <div class="card m-b-10 place-bet">
                <div class="card-header">
                    <h6 onclick="showBet();" class="card-title d-inline-block">Place Bet</h6>
                </div>
                <div id="showBet" class="collapse" >
                    <form>
                      <table class="coupon-table table table-borderedless">
                        <thead>
                          <tr>
                            <th></th>
                            <th style="width: 35%; text-align: left;">(Bet for)</th>
                            <th style="width: 25%; text-align: left;">Odds</th>
                            <th style="width: 15%; text-align: left;">Stake</th>
                            <th style="width: 15%; text-align: right;">Profit</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="text-center">
                                <a href="javascript:void(0);" onclick="showBet();" class="text-danger">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                            <td id="teamNameBet"></td>
                            <td class="bet-odds">
                              <div class="form-group">
                                <input placeholder="0" type="text" required="required" maxlength="4" readonly="readonly" class="amountint" style="width: 45px; vertical-align: middle;"> 
                               </div>
                            </td>
                            <td class="bet-stakes">
                              <div class="form-group bet-stake">
                                  <input maxlength="10" name="betAmount" id="betAmount" type="number" required="required" type="text">
                              </div>
                            </td>
                            <td id="bet-profit" class="text-right bet-profit matchValClear"></td>
                          </tr>
                          <tr>
                            <td colspan="5" class="value-buttons" style="padding: 5px;">
                              <button type="button" data-bet="{{$buttonValue['price'][0]}}" class="btn btn-secondary m-l-5 m-b-5">
                                {{$buttonValue['label'][0]}}
                              </button><button type="button" data-bet="{{$buttonValue['price'][1]}}" class="btn btn-secondary m-l-5 m-b-5">
                              {{$buttonValue['label'][1]}}
                              </button><button type="button" data-bet="{{$buttonValue['price'][2]}}" class="btn btn-secondary m-l-5 m-b-5">
                              {{$buttonValue['label'][2]}}
                              </button><button type="button" data-bet="{{$buttonValue['price'][3]}}" class="btn btn-secondary m-l-5 m-b-5">
                              {{$buttonValue['label'][3]}}
                              </button><button type="button" data-bet="{{$buttonValue['price'][4]}}" class="btn btn-secondary m-l-5 m-b-5">
                              {{$buttonValue['label'][4]}}
                              </button><button type="button" data-bet="{{$buttonValue['price'][5]}}" class="btn btn-secondary m-l-5 m-b-5">
                              {{$buttonValue['label'][5]}}
                              </button><button type="button" data-bet="{{$buttonValue['price'][6]}}" class="btn btn-secondary m-l-5 m-b-5">
                              {{$buttonValue['label'][6]}}
                              </button><button type="button" data-bet="{{$buttonValue['price'][7]}}" class="btn btn-secondary m-l-5 m-b-5">
                              {{$buttonValue['label'][7]}}
                              </button><button type="button" data-bet="{{$buttonValue['price'][8]}}" class="btn btn-secondary m-l-5 m-b-5">
                              {{$buttonValue['label'][8]}}
                              </button><button type="button" data-bet="{{$buttonValue['price'][9]}}" class="btn btn-secondary m-l-5 m-b-5">
                              {{$buttonValue['label'][9]}}
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <div class="col-md-12">
                        <input type="hidden" id="betTypeAdd" value="">
                        <input type="hidden" id="betSide" value="">
                        <input type="hidden" id="betoption" value="">
                        <input type="hidden" id="betTeamProfit" value="">
                        <span class="" id="betMsgALL"></span> 
                        <button type="button" onclick="showBet();" class="btn btn-sm btn-danger float-left">
                        Reset
                        </button> 
                        <button type="button" onclick="saveBet();" class="btn btn-sm btn-success float-right m-b-5">
                          <!----> Submit
                        </button>
                      </div>
                    </form>
                  </div>
                <!---->
              </div>
              <div class="card m-b-10 my-bet">
                <div class="card-header">
                    <h6 onclick="showMyBet();" class="card-title d-inline-block">My Bet</h6>
                </div>
                <div id="myBet" class="card-body" style="overflow: auto;max-height: 500px;">
                  <table class="coupon-table table  table-borderedless">
                    <thead>
                      <tr>
                        <th style="width: 60%;">
                           Team Name
                        </th>
                        <th class="text-left">
                          Odds
                        </th>
                        <th class="text-left">
                          Stake
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td colspan="3" class="text-center">No records Found</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
              <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
            </div>
            <div class="ps__rail-y" style="top: 0px; right: 0px;">
              <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade myModalBetView" id="myModalBetView" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title text-left headingText">Place Bet</h4>
            <span  class="close" data-dismiss="modal">&times;</span>
          </div>
          <div class="modal-body" id="modelBodyID">
           <div id="showBet" class="collapse" style="display: block;">

              <form>
                <table class="coupon-table table table-borderedless">
                  
                  <tbody>
                     <tr>
                        <td id="teamNameBet" colspan="2"></td>
                        <td class="pull-right float-right">
                            <div class="form-group">
                              <input placeholder="0" type="text" required="required" maxlength="4" readonly="readonly" class="amountint" style="width: 75px; vertical-align: middle;"> 
                            </div>
                        </td>
                    </tr>  
                  <tr>
                    <td class="bet-stakes pull-left">
                      <div class="form-group bet-stake">
                          <input maxlength="10" style="margin-top: 18px;" name="betAmount" id="betAmount" type="text" required="required" type="text">
                      </div>
                    </td>
                    <td>
                        <button type="button" onclick="saveBet();" class="btn btn-sm btn-success submitBtn m-b-5">Submit</button>
                    </td>
                    <td id="bet-profit" class="text-right bet-profit text-center">0</td>
                  </tr>
                  <tr>
                    <td colspan="3" class="value-buttons" style="padding: 5px;">
                        <button type="button" data-bet="{{$buttonValue['price'][0]}}" class="btn btn-secondary m-l-5 m-b-5">
                          {{$buttonValue['label'][0]}}
                        </button><button type="button" data-bet="{{$buttonValue['price'][1]}}" class="btn btn-secondary m-l-5 m-b-5">
                        {{$buttonValue['label'][1]}}
                        </button><button type="button" data-bet="{{$buttonValue['price'][2]}}" class="btn btn-secondary m-l-5 m-b-5">
                        {{$buttonValue['label'][2]}}
                        </button><button type="button" data-bet="{{$buttonValue['price'][3]}}" class="btn btn-secondary m-l-5 m-b-5">
                        {{$buttonValue['label'][3]}}
                        </button><button type="button" data-bet="{{$buttonValue['price'][4]}}" class="btn btn-secondary m-l-5 m-b-5">
                        {{$buttonValue['label'][4]}}
                        </button><button type="button" data-bet="{{$buttonValue['price'][5]}}" class="btn btn-secondary m-l-5 m-b-5">
                        {{$buttonValue['label'][5]}}
                        </button><button type="button" data-bet="{{$buttonValue['price'][6]}}" class="btn btn-secondary m-l-5 m-b-5">
                        {{$buttonValue['label'][6]}}
                        </button><button type="button" data-bet="{{$buttonValue['price'][7]}}" class="btn btn-secondary m-l-5 m-b-5">
                        {{$buttonValue['label'][7]}}
                        </button><button type="button" data-bet="{{$buttonValue['price'][8]}}" class="btn btn-secondary m-l-5 m-b-5">
                        {{$buttonValue['label'][8]}}
                        </button><button type="button" data-bet="{{$buttonValue['price'][9]}}" class="btn btn-secondary m-l-5 m-b-5">
                        {{$buttonValue['label'][9]}}
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table

                <div class="col-md-12">
                  <input type="hidden" id="betTypeAdd" value="">
                  <input type="hidden" id="betSide" value="">
                  <input type="hidden" id="betoption" value="">
                  <input type="hidden" id="betTeamProfit" value="">
                  <span class="" id="betMsgALL"></span> 
                  <!--<button type="button" onclick="saveBet();" class="btn btn-sm btn-success float-right m-b-5">Submit</button>-->
              </form>
              <table class="table showbetTot table-borderedless">
                
              </table>
            </div>

          </div>
        </div>
      </div>
  </div>
@endsection
@push('after-styles')
<style>
  .sidebar {
    padding: 5px 14px 5px 15px;
    min-height: auto;
    max-width: 100% !important;
    background-color: var(--grey-bg);
    color: var(--site-color);
  }
  .tblBorder td,.tblBorder th{
      border: 1px solid #fff;
  }
  .country-name{
      width: 40%;
      background-color: #f2f2f2;
  }
  .video_nav_tab li{
    padding: 4px 12px;
    background: var(--theme2-bg);
    width: 25%;
    color:var(--secondary-color);
  }
  .video-iframe {
      border: 0;
      background: #222;
      height: auto;
      width: 100%;
  }
</style>

@endpush
<script src="{{asset('new/sportJS/soccer.js')}}"></script>
@push('after-scripts')
@include('frontend.game-list.js.sideBarScroll')
@include('frontend.game-list.js.football_js')
@endpush