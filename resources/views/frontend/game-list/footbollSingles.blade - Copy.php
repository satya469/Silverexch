@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')

<div class="container-fluid container-fluid-5">
<div class="row" style="margin-left: 0px;margin-right: 0px;">
  @include('frontend.game-list.leftSide')
  <!----> 
  <div class="col-md-10 featured-box load game-page">
      <div class="row row5">
        <div class="col-md-9 featured-box-detail sports-wrapper m-b-10">
          <!----> <!----> 
          <div class="game-heading">
              <span class="card-header-title">{{$sports->match_name}}</span> 
              <span class="float-right">{{$sports->match_date_time}}</span>
          </div>
          <div class="markets">
              
            <!--START TOP BANER DETAILS-->
            @if(!empty($sports->sb_url) > 0)
           
            <div>
              <iframe height="auto" src="{{$sports->sb_url}}" 
                                  class="video-iframe"></iframe>
            </div>
           @endif
            <!--END TOP BANER DETAILS-->
            
            <!-- START MATCH ODDS-->
            
            <div class="main-market">
              <div class="market-title mt-1">
                MATCH_ODDS
                <a href="javascript:void(0)" class="m-r-5 game-rules-icon">
                    <span><i class="fa fa-info-circle float-right"></i></span>
                </a> 
                <span class="float-right m-r-10">
                    <span style="padding-right: 10px;">Min : <span>500</span></span>
                    <span> Max : <span>500000</span></span>
                </span>
              </div>
              <div class="table-header">
                <div class="float-left country-name box-4 min-max"><b></b></div>
                <div class="box-1 float-left"></div>
                <div class="box-1 float-left"></div>
                <div class="back box-1 float-left text-center"><b>BACK</b></div>
                <div class="lay box-1 float-left text-center"><b>LAY</b></div>
                <div class="box-1 float-left"></div>
                <div class="box-1 float-left"></div>
              </div>
              <div data-title="OPEN" class="table-body">
                <div data-title="ACTIVE" class="table-row oddssteam0">
                  <div class="float-left country-name box-4">
                    <span class="team-name0"><b></b></span> 
                    <p>
                        <span class="float-left" style="color: black;">0</span> 
                        <span class="float-right" style="display: none; color: black;">0</span>
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
                      <span class="d-block lay2k"></span>
                  </div>
                </div>
                <div data-title="ACTIVE" class="table-row oddssteam1">
                  <div class="float-left country-name box-4">
                    <span class="team-name1"><b></b></span> 
                    <p>
                        <span class="float-left" style="color: black;">0</span> 
                        <span class="float-right" style="display: none; color: black;">0</span>
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
                      <span class="d-block lay2k"></span>
                  </div>
                </div>
                <div data-title="ACTIVE" class="table-row oddssteam2">
                  <div class="float-left country-name box-4">
                    <span class="team-name2"><b></b></span> 
                    <p>
                        <span class="float-left" style="color: black;">0</span> 
                        <span class="float-right" style="display: none; color: black;">0</span>
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
                      <span class="d-block lay2k"></span>
                  </div>
                </div>  
              </div>
              <div>
                <!---->
              </div>
            </div>
            <div class="row row5 bookmaker-market mt-1">
              <div class="bm1 col-12">
                <div>
                  <div class="market-title mt-1">
                    OVER_UNDER_05
                    <a href="javascript:void(0)" class="m-r-5 game-rules-icon">
                        <span><i class="fa fa-info-circle float-right"></i></span>
                    </a>
                    <b>
                      <span class="float-right m-r-10">
                        <span> Max Bet : <span>1</span></span>
                      </span>
                    </b>
                  </div>
                  <div class="table-header">
                    <div class="float-left country-name box-4 text-info"></div>
                    <div class="box-1 float-left"></div>
                    <div class="box-1 float-left"></div>
                    <div class="back box-1 float-left text-center"><b>BACK</b></div>
                    <div class="lay box-1 float-left text-center"><b>LAY</b></div>
                    <div class="box-1 float-left"></div>
                    <div class="box-1 float-left"></div>
                  </div>
              <div class="table-body">
                <div data-title="ACTIVE" class="table-row OVER_UNDER_0">
                  <div class="float-left country-name box-4">
                    <span class="team-name0"><b></b></span> 
                    <p>
                        <span class="float-left" style="color: black;">0</span> 
                        <span class="float-right" style="display: none; color: black;">0</span>
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
                      <span class="d-block lay2k"></span>
                  </div>
                </div>
                <div data-title="ACTIVE" class="table-row OVER_UNDER_1">
                  <div class="float-left country-name box-4">
                    <span class="team-name1"><b></b></span> 
                    <p>
                        <span class="float-left" style="color: black;">0</span> 
                        <span class="float-right" style="display: none; color: black;">0</span>
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
                      <span class="d-block lay2k"></span>
                  </div>
                </div>
                  </div>
                  <div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row row5 bookmaker-market mt-1">
              <div class="bm1 col-12">
                <div>
                  <div class="market-title mt-1">
                   OVER_UNDER_25
                    <a href="javascript:void(0)" class="m-r-5 game-rules-icon"><span><i class="fa fa-info-circle float-right"></i></span></a>
                    <b>
                        <span class="float-right m-r-10">
                          <span> Max Bet: <span>1</span></span>
                        </span>
                      </b>
                  </div>
                  <div class="table-header">
                    <div class="float-left country-name box-4 text-info">
                      
                    </div>
                    <div class="box-1 float-left"></div>
                    <div class="box-1 float-left"></div>
                    <div class="back box-1 float-left text-center"><b>BACK</b></div>
                    <div class="lay box-1 float-left text-center"><b>LAY</b></div>
                    <div class="box-1 float-left"></div>
                    <div class="box-1 float-left"></div>
                  </div>
              <div class="table-body">
                <div data-title="ACTIVE" class="table-row OVER_UNDER_2">
                  <div class="float-left country-name box-4">
                    <span class="team-name2"><b></b></span> 
                    <p>
                        <span class="float-left" style="color: black;">0</span> 
                        <span class="float-right" style="display: none; color: black;">0</span>
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
                      <span class="d-block lay2k"></span>
                  </div>
                </div>
                <div data-title="ACTIVE" class="table-row OVER_UNDER_3">
                  <div class="float-left country-name box-4">
                    <span class="team-name3"><b></b></span> 
                    <p>
                        <span class="float-left" style="color: black;">0</span> 
                        <span class="float-right" style="display: none; color: black;">0</span>
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
                      <span class="d-block lay2k"></span>
                  </div>
                </div>
                  </div>
                  <div>
                  </div>
                </div>
              </div>
            </div>
             <div class="row row5 bookmaker-market mt-1">
              <div class="bm1 col-12">
                <div>
                  <div class="market-title mt-1">
                    OVER_UNDER_15

                    <a href="javascript:void(0)" class="m-r-5 game-rules-icon"><span><i class="fa fa-info-circle float-right"></i></span></a>
                    <b>
                        <span class="float-right m-r-10">
                          <span> Max Bet: <span>1</span></span>
                        </span>
                      </b>
                  </div>
                  <div class="table-header">
                    <div class="float-left country-name box-4 text-info">
                      
                    </div>
                    <div class="box-1 float-left"></div>
                    <div class="box-1 float-left"></div>
                    <div class="back box-1 float-left text-center"><b>BACK</b></div>
                    <div class="lay box-1 float-left text-center"><b>LAY</b></div>
                    <div class="box-1 float-left"></div>
                    <div class="box-1 float-left"></div>
                  </div>
              <div class="table-body">
                <div data-title="ACTIVE" class="table-row OVER_UNDER_4">
                  <div class="float-left country-name box-4">
                    <span class="team-name4"><b></b></span> 
                    <p>
                        <span class="float-left" style="color: black;">0</span> 
                        <span class="float-right" style="display: none; color: black;">0</span>
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
                      <span class="d-block lay2k"></span>
                  </div>
                </div>
                <div data-title="ACTIVE" class="table-row OVER_UNDER_5">
                  <div class="float-left country-name box-4">
                    <span class="team-name5"><b></b></span> 
                    <p>
                        <span class="float-left" style="color: black;">0</span> 
                        <span class="float-right" style="display: none; color: black;">0</span>
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
                      <span class="d-block lay2k"></span>
                  </div>
                </div>
                  </div>
                  <div>
                  </div>
                </div>
              </div>
            </div>
            
            <div id="UNSEROVER" class="row row5 bookmaker-market mt-1">
              <table class="table">
                  <tr>
                      <td colspan="7"></td>
                      <td></td>
                      <td></td>
                      <td colspan="2"></td>
                  </tr>
              </table>
            </div>
          </div>
          
          
          <div class="markets">
            <!---->
          </div>
        </div>
        <div id="sidebar-right" class="col-md-3 sidebar-right" style="position: relative; top: 0px; right: 0px; width: 25.5%;">
          <div class="ps">
            <div class="sidebar-right-inner">
              <div class="card m-b-10" style="border: 0px none;">
                <div class="card-header">
                    <h6 onclick="showTv();" class="card-title">Live Match
                    <span class="float-right"><i class="fa fa-tv"></i> live stream started
                    </span>
                  </h6>
                </div>
                  <div id="tv_status-errordetail" style="background: var(--theme2-bg);" class="tv-container collapse" align="center">
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
                <div id="showBet" class="collapse">
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
                                <a href="javascript:void(0);" class="text-danger">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                            <td id="teamNameBet">New Zealand Women</td>
                            <td class="bet-odds">
                              <div class="form-group">
                                <input placeholder="0" type="text" required="required" maxlength="4" readonly="readonly" class="amountint" style="width: 45px; vertical-align: middle;"> 
<!--                                <div class="spinner-buttons input-group-btn btn-group-vertical">
                                    <button type="button" 
                                            class="custom-btn-spinner btn btn-xs btn-default">
                                        <i class="fa fa-angle-up"></i>
                                    </button> 
                                    <button type="button" 
                                            class="custom-btn-spinner btn btn-xs btn-default">
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                </div>-->
                              </div>
                            </td>
                            <td class="bet-stakes">
                              <div class="form-group bet-stake">
                                  <input maxlength="10" name="betAmount" id="betAmount" type="number" required="required" type="text">
                              </div>
                            </td>
                            <td id="bet-profit" class="text-right bet-profit">720000.00</td>
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
                        <button type="button" class="btn btn-sm btn-danger float-left">
                        Reset
                        </button> 
                        <button type="button" class="btn btn-sm btn-success float-right m-b-5">
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
                <div id="myBet" class="card-body">
                  <table class="coupon-table table  table-borderedless">
                    <thead>
                      <tr>
                        <th style="width: 60%;">
                          Matched Bet
                        </th>
                        <th class="text-right">
                          Odds
                        </th>
                        <th class="text-center">
                          Stake
                        </th>
                      </tr>
                    </thead>
                    <tr>
                      <td colspan="3" class="text-center">No records Found</td>
                    </tr>
                  </table>
                </div>
              </div>
              <!---->
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
<script type="text/javascript">
  var jsonData132 = '{"market": [{"marketId": "1.30042557", "inplay": false, "totalMatched": null, "totalAvailable": null, "priceStatus": null, "events": [{"SelectionId": "", "RunnerName": "Kolkata Knight Riders", "LayPrice1": "2.08", "LaySize1": "215.83", "LayPrice2": "2.1", "LaySize2": "219.43", "LayPrice3": "2.12", "LaySize3": "3.2", "BackPrice1": "2.04", "BackSize1": "210.07", "BackPrice2": "2.02", "BackSize2": "550", "BackPrice3": "1.96", "BackSize3": "83.2"}, {"SelectionId": "", "RunnerName": "Chennai Super Kings", "LayPrice1": "1.95", "LaySize1": "8.99", "LayPrice2": "1.96", "LaySize2": "195.13", "LayPrice3": "1.97", "LaySize3": "14.5", "BackPrice1": "1.94", "BackSize1": "9.78", "BackPrice2": "1.93", "BackSize2": "213.31", "BackPrice3": "1.92", "BackSize3": "249.51"}]}], "bookmake": [{"runners": [{"SelectionId": "", "RunnerName": "Kolkata Knight Riders", "LayPrice1": "0", "LaySize1": "0", "LayPrice2": "0", "LaySize2": "0", "LayPrice3": "0", "LaySize3": "0", "BackPrice1": "0", "BackSize1": "0", "BackPrice2": "0", "BackSize2": "0", "BackPrice3": "0", "BackSize3": "0"}, {"SelectionId": "", "RunnerName": "Chennai Super Kings", "LayPrice1": "96", "LaySize1": "100", "LayPrice2": "0", "LaySize2": "0", "LayPrice3": "0", "LaySize3": "0", "BackPrice1": "92", "BackSize1": "100", "BackPrice2": "0", "BackSize2": "0", "BackPrice3": "0", "BackSize3": "0"}]}], "session": [{"SelectionId": "", "RunnerName": "Match 1st over run(KKR vs CSK)adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "6 over runs KKR(KKR vs CSK)adv", "LayPrice1": "46", "LaySize1": "100", "BackPrice1": "48", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "6 over runs CSK(KKR vs CSK)adv", "LayPrice1": "46", "LaySize1": "100", "BackPrice1": "48", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "20 over runs KKR(KKR vs CSK)adv", "LayPrice1": "165", "LaySize1": "100", "BackPrice1": "167", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "20 over runs CSK(KKR vs CSK)adv", "LayPrice1": "167", "LaySize1": "100", "BackPrice1": "169", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Fall of 1st wkt KKR(KKR vs CSK)adv", "LayPrice1": "23", "LaySize1": "110", "BackPrice1": "23", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Fall of 1st wkt CSK(KKR vs CSK)adv", "LayPrice1": "23", "LaySize1": "110", "BackPrice1": "23", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Gill run(KKR vs CSK)adv", "LayPrice1": "26", "LaySize1": "110", "BackPrice1": "26", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine run(KKR vs CSK)adv", "LayPrice1": "16", "LaySize1": "110", "BackPrice1": "16", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "F du Plessis run(KKR vs CSK)adv", "LayPrice1": "25", "LaySize1": "110", "BackPrice1": "25", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Watson run(KKR vs CSK)adv", "LayPrice1": "20", "LaySize1": "110", "BackPrice1": "20", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Gill Boundaries(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine Boundaries(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "115", "BackPrice1": "3", "BackSize1": "85", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "F du Plessis Boundaries(KKR vs CSK)adv", "LayPrice1": "4", "LaySize1": "115", "BackPrice1": "4", "BackSize1": "85", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Watson Boundaries(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "How many balls for 50 runs KKR(KKR vs CSK)adv", "LayPrice1": "38", "LaySize1": "100", "BackPrice1": "40", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "How many balls for 50 runs CSK(KKR vs CSK)adv", "LayPrice1": "38", "LaySize1": "100", "BackPrice1": "40", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Fours(KKR vs CSK)adv", "LayPrice1": "25", "LaySize1": "100", "BackPrice1": "27", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Sixes(KKR vs CSK)adv", "LayPrice1": "11", "LaySize1": "100", "BackPrice1": "12", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Boundaries(KKR vs CSK)adv", "LayPrice1": "36", "LaySize1": "100", "BackPrice1": "38", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Wkts(KKR vs CSK)adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "13", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Wides(KKR vs CSK)adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Extras(KKR vs CSK)adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Caught Outs(KKR vs CSK)adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Bowled(KKR vs CSK)adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match LBW(KKR vs CSK)adv", "LayPrice1": "1", "LaySize1": "100", "BackPrice1": "2", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Fifties(KKR vs CSK)adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Highest Scoring over in match(KKR vs CSK)adv", "LayPrice1": "20", "LaySize1": "100", "BackPrice1": "21", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Top batsman runs in match(KKR vs CSK)adv", "LayPrice1": "66", "LaySize1": "100", "BackPrice1": "68", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "3 wkt or more by bowler in match(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Fours KKR and CSK adv", "LayPrice1": "150", "LaySize1": "100", "BackPrice1": "157", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Sixes KKR and CSK adv", "LayPrice1": "28", "LaySize1": "100", "BackPrice1": "31", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Wkts KKR and CSK adv", "LayPrice1": "32", "LaySize1": "100", "BackPrice1": "37", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Wides KKR and CSK adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Extras KKR and CSK adv", "LayPrice1": "50", "LaySize1": "100", "BackPrice1": "57", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "P Cummins 2 over Runs Session adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "15", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "P Cummins 4 over Runs Session adv", "LayPrice1": "30", "LaySize1": "100", "BackPrice1": "32", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Mavi 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Mavi 4 over Runs Session adv", "LayPrice1": "33", "LaySize1": "100", "BackPrice1": "35", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "V Chakravarthy 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "V Chakravarthy 4 over Runs Session adv", "LayPrice1": "33", "LaySize1": "100", "BackPrice1": "35", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine 2 over Runs Session adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine 4 over Runs Session adv", "LayPrice1": "28", "LaySize1": "100", "BackPrice1": "30", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "A Russell 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "A Russell 4 over Runs Session adv", "LayPrice1": "32", "LaySize1": "100", "BackPrice1": "34", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "D Chahar 2 over Runs Session adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "15", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "D Chahar 4 over Runs Session adv", "LayPrice1": "30", "LaySize1": "100", "BackPrice1": "32", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Curran 2 over Runs Session adv", "LayPrice1": "14", "LaySize1": "100", "BackPrice1": "16", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Curran 4 over Runs Session adv", "LayPrice1": "32", "LaySize1": "100", "BackPrice1": "34", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Thakur 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Thakur 4 over Runs Session adv", "LayPrice1": "33", "LaySize1": "100", "BackPrice1": "35", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Dwayne Bravo 2 over Runs Session adv", "LayPrice1": "14", "LaySize1": "100", "BackPrice1": "16", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Dwayne Bravo 4 over Runs Session adv", "LayPrice1": "31", "LaySize1": "100", "BackPrice1": "33", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "R Jadeja 2 over Runs Session adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "15", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "R Jadeja 4 over Runs Session adv", "LayPrice1": "30", "LaySize1": "100", "BackPrice1": "32", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Wkts KKR adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Extras KKR adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Dot balls KKR adv", "LayPrice1": "22", "LaySize1": "100", "BackPrice1": "24", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 1 runs KKR adv", "LayPrice1": "22", "LaySize1": "100", "BackPrice1": "24", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 2 runs KKR adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Fours KKR adv", "LayPrice1": "7", "LaySize1": "100", "BackPrice1": "8", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Sixes KKR adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Wkts KKR adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Extras KKR adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Dot balls KKR adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 1 runs KKR adv", "LayPrice1": "26", "LaySize1": "100", "BackPrice1": "28", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 2 runs KKR adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Fours KKR adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Sixes KKR adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Wkts KKR adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Extras KKR adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Dot balls KKR adv", "LayPrice1": "34", "LaySize1": "100", "BackPrice1": "36", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 1 runs KKR adv", "LayPrice1": "48", "LaySize1": "100", "BackPrice1": "50", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 2 runs KKR adv", "LayPrice1": "9", "LaySize1": "100", "BackPrice1": "10", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Fours KKR adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Sixes KKR adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Wkts CSK adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Extras CSK adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Dot balls CSK adv", "LayPrice1": "21", "LaySize1": "100", "BackPrice1": "23", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 1 runs CSK adv", "LayPrice1": "23", "LaySize1": "100", "BackPrice1": "25", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 2 runs CSK adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Fours CSK adv", "LayPrice1": "7", "LaySize1": "100", "BackPrice1": "8", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Sixes CSK adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Wkts CSK adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Extras CSK adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Dot balls CSK adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 1 runs CSK adv", "LayPrice1": "27", "LaySize1": "100", "BackPrice1": "29", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 2 runs CSK adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Fours CSK adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Sixes CSK adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Wkts CSK adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Extras CSK adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Dot balls CSK adv", "LayPrice1": "34", "LaySize1": "100", "BackPrice1": "36", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 1 runs CSK adv", "LayPrice1": "50", "LaySize1": "100", "BackPrice1": "52", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 2 runs CSK adv", "LayPrice1": "9", "LaySize1": "100", "BackPrice1": "10", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Fours CSK adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Sixes CSK adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}]}';
</script>
@endsection
@push('after-styles')
<style>
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
@push('after-scripts')
  <script type="text/javascript">
    function showTv(){
      if($("#tv_status-errordetail").hasClass("show")){
        $("#tv_status-errordetail").removeClass('show')
      }else{
        $("#tv_status-errordetail").addClass('show')
      }
    }
    function showTvVideo(id,obj){
      $('.allVideo').hide();
      $('.navli').css('background','red');
      $('#'+id).show();
      $(obj).css('background','#0088cc');
    }
    function showBet(){
      if($("#showBet").hasClass("show")){
        clearBetVal();  
        $("#showBet").removeClass('show')
      }else{
        $("#showBet").addClass('show')
      }
    }
    
    function myBet(){
      if($("#myBet").hasClass("show")){
        clearBetVal();  
        $("#myBet").removeClass('show')
      }else{
        $("#showmyBet").addClass('show')
      }
    }
    getData();
    $( document ).ready(function() {
      setInterval(function(){ getData(); }, 9000);
    });
    function setodd(data){
      $.each(data, function(i, item) {
          $('.oddssteam'+i+' .team-name'+i+' > b').text(item.RunnerName);

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
    function setbookmaker(data){
       var html = '';
      var oldText = '';
      $.each(data, function(i, item) {
//          $('.OVER_UNDER_'+i+' .team-name'+i+' > b').text(item.RunnerName);
//
//          $('.OVER_UNDER_'+i+' .back1t').text(item.BackPrice1);
//          $('.OVER_UNDER_'+i+' .back2t').text(item.BackPrice2);
//          $('.OVER_UNDER_'+i+' .back3t').text(item.BackPrice3);
//
//          $('.OVER_UNDER_'+i+' .back1k').text(item.BackSize1);
//          $('.OVER_UNDER_'+i+' .back2k').text(item.BackSize2);
//          $('.OVER_UNDER_'+i+' .back3k').text(item.BackSize3);
//
//          $('.OVER_UNDER_'+i+' .lay1t').text(item.LayPrice1);
//          $('.OVER_UNDER_'+i+' .lay2t').text(item.LayPrice2);
//          $('.OVER_UNDER_'+i+' .lay3t').text(item.LayPrice3);
//
//          $('.OVER_UNDER_'+i+' .lay1k').text(item.LaySize1);
//          $('.OVER_UNDER_'+i+' .lay2k').text(item.LaySize2);
//          $('.OVER_UNDER_'+i+' .lay3k').text(item.LaySize3);
          
          var ret = item.RunnerName.split(" ");
          var text = ret[1].replace('.','');
          alert(text);
          if(text != oldText || oldText == ''){      
          oldText = text;
          alert("dk"+oldText);
          
//          html += '<div class="row row5 bookmaker-market mt-1">';
//            html += '<div class="bm1 col-12">';
//              html += '<div>';
//                html += '<div class="market-title mt-1">';
//                  html += 'OVER_UNDER_'+text;
//                  html += '<a href="javascript:void(0)" class="m-r-5 game-rules-icon">';
//                    html += '<span><i class="fa fa-info-circle float-right"></i></span>';
//                  html += '</a>';
//                  html += '<b>span class="float-right m-r-10">';
//                    html += '<span> Max Bet : <span>1</span></span>';
//                  html += '</span></a>';
//                html += '</div>';
//                html += '<div class="table-header">';
//                  html += '<div class="float-left country-name box-4 text-info"></div>';
//                  html += '<div class="box-1 float-left"></div>';
//                  html += '<div class="box-1 float-left"></div>';
//                  html += '<div class="back box-1 float-left text-center"><b>BACK</b></div>';
//                  html += '<div class="lay box-1 float-left text-center"><b>LAY</b></div>';
//                  html += '<div class="box-1 float-left"></div>';
//                  html += '<div class="box-1 float-left"></div>';
//                html += '</div>';
//                html += '<div class="table-body">';
              }
//                if (i % 2 !== 0)
//                  html += '<div data-title="ACTIVE" class="table-row OVER_UNDER_'+i+'">';
//                    html += '<div class="float-left country-name box-4">';
//                      html += '<span class="team-name0"><b>'+item.RunnerName+'</b></span> ';
//                      html += '<p>';
//                        html += '<span class="float-left" style="color: black;">0</span> ';
//                        html += '<span class="float-right" style="display: none; color: black;">0</span>';
//                      html += '</p>';
//                    html += '</div>';
//                    html += '<div class="box-1 back2 float-left back-2 text-center">';
//                      html += '<span class="odd d-block back3t">'+item.BackPrice3+'</span>';
//                      html += '<span class="d-block back3k">'+item.BackSize3+'k</span>';
//                    html += '</div>';
//                    html += '<div class="box-1 back1 float-left back-1 text-center">';
//                      html += '<span class="odd d-block back2t">'+item.BackPrice2+'</span>';
//                      html += '<span class="d-block back2k">'+item.BackSize2+'k</span>';
//                    html += '</div>';
//                    html += '<div class="box-1 back float-left back lock text-center">';
//                      html += '<span class="odd d-block back1t">'+item.BackPrice1+'</span>';
//                      html += '<span class="d-block back1k">'+item.BackSize1+'k</span>';
//                    html += '</div>';
//                    html += '<div class="box-1 lay float-left text-center">';
//                      html += '<span class="odd d-block lay1t">'+item.LayPrice1+'</span>';
//                      html += '<span class="d-block lay1k">'+item.LaySize1+'k</span>';
//                    html += '</div>';
//                    html += '<div class="box-1 lay1 float-left text-center">';
//                      html += '<span class="odd d-block lay2t">'+item.LayPrice2+'</span>';
//                      html += '<span class="d-block lay2k">'+item.LaySize2+'k</span>';
//                    html += '</div>';
//                    html += '<div class="box-1 lay2 float-left text-center">';
//                      html += '<span class="odd d-block lay3t">'+item.LayPrice3+'</span>';
//                      html += '<span class="d-block lay2k">'+item.LaySize3+'k</span>';
//                    html += '</div>';
//                  html += '</div>';
//                }else{  
//                  html += '<div data-title="ACTIVE" class="table-row OVER_UNDER_'+i+'">';
//                    html += '<div class="float-left country-name box-4">';
//                    html += '<span class="team-name1"><b></b></span>';
//                    html += '<p>';
//                      html += '<span class="float-left" style="color: black;">0</span>';
//                      html += '<span class="float-right" style="display: none; color: black;">0</span>';
//                    html += '</p>';
//                  html += '</div>';
//                  html += '<div class="box-1 back2 float-left back-2 text-center">';
//                    html += '<span class="odd d-block back3t"></span>';
//                    html += '<span class="d-block back3k"></span>';
//                  html += '</div>';
//                  html += '<div class="box-1 back1 float-left back-1 text-center">';
//                    html += '<span class="odd d-block back2t"></span>';
//                    html += '<span class="d-block back2k"></span>';
//                  html += '</div>';
//                  html += '<div class="box-1 back float-left back lock text-center">';
//                    html += '<span class="odd d-block back1t"></span>';
//                    html += '<span class="d-block back1k"></span>';
//                  html += '</div>';
//                  html += '<div class="box-1 lay float-left text-center">';
//                    html += '<span class="odd d-block lay1t"></span>';
//                    html += '<span class="d-block lay1k"></span>';
//                  html += '</div>';
//                  html += '<div class="box-1 lay1 float-left text-center">';
//                    html += '<span class="odd d-block lay2t"></span>';
//                    html += '<span class="d-block lay2k"></span>';
//                  html += '</div>';
//                  html += '<div class="box-1 lay2 float-left text-center">';
//                    html += '<span class="odd d-block lay3t"></span>';
//                      html += '<span class="d-block lay2k"></span>';
//                    html += '</div>';
//                  html += '</div>';
//                }
           if (parseInt(i)%2 == 0){
//                 html += '</div>';
//                html += '<div>';
//              html += '</div>';
//            html += '</div>';
//            html += '</div>';
//          html += '</div>';
//          
          $('#UNSEROVER').append(html);
           var html = '';
        }
          
          
//          var tot = (parseFloat(item.BackPrice1)+parseFloat(item.BackPrice2)+parseFloat(item.BackPrice3));
//          tot = (parseFloat(tot)+parseFloat(item.BackSize1)+parseFloat(item.BackSize2)+parseFloat(item.BackSize3));
//          tot = (parseFloat(tot)+parseFloat(item.LayPrice1)+parseFloat(item.LayPrice2)+parseFloat(item.LayPrice3));
//          tot = (parseFloat(tot)+parseFloat(item.LaySize1)+parseFloat(item.LaySize2)+parseFloat(item.LaySize3));
//          
//          if(parseFloat(tot) <= 0){
//            $('.OVER_UNDER_'+i).addClass('suspended');
//            $('.OVER_UNDER_'+i).attr('data-title','SUSPENDED');
//          }else{
//            $('.OVER_UNDER_'+i).removeClass('suspended');
//            $('.OVER_UNDER_'+i).attr('data-title','ACTIVE');
//          }
        });
        
    }
    function getData(){
      $.ajax({
        url: '{{route("frontend.getdatasoccer",$sports->match_id)}}',
        dataType: 'json',
        type: "get",
        success: function(data){
            setodd(data.odd);
            setbookmaker(data.session);
            
        }
      });
    }
    $( document ).ready(function() {
      $('.box-1').on('click',function(){
        var amount = $(this).find('.odd').text();
        var countryName = $(this).closest('.table-row').find('.country-name > span').text();
        $('.amountint').val(amount);
        $('#teamNameBet').text(countryName);
        $('#showBet').removeClass('back-color');
        $('#showBet').removeClass('lay-color');
        if($(this).hasClass("back") || $(this).hasClass("back1") || $(this).hasClass("back2")){
          $('#showBet').addClass('back-color');
        }else{
          $('#showBet').addClass('lay-color');
        }
         myBet();
      });
    });
  </script>
@endpush