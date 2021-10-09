<?php
use App\Http\Controllers\Backend\SportsController;



?>

@extends('backend.layouts.appReport')

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

</style>

<div class="row">


<div class="container-fluid mt-4" style="padding: 0 2% !important;">
  <div class="man_bglight">
    <h4 class="market-h4">Market-Analysis

    </h4>
    <div class="pb-3">
        <ul role="tablist" id="home-events" class="nav nav-tabs nav-tabs22" style="">
          <li class="new-nav-item nav-item activeUL tabli"><a href="javascript:void(1);" onclick="openTab('criket',this);" class="nav-link">CRICKET</a></li>
          <li class="new-nav-item nav-item tabli"><a href="javascript:void(1);" onclick="openTab('soccer',this);" class="nav-link">SOCCER</a></li>
          <li class="new-nav-item nav-item  tabli"><a href="javascript:void(1);" onclick="openTab('tennis',this);" class="nav-link" >TENNIS</a></li>
        </ul>
    </div>
    <div class="">
      <div id="tennis" class="allhide hideActive dataTables_wrapper ">
        <div class="">
          <div class="market_t1">
            <div class="react-bs-table-container">
              <div class="react-bs-table-tool-bar ">
                <div class="row">
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
                    <div class="btn-group btn-group-sm" role="group">
<!--                        <button type="button" class="btn btn-success react-bs-table-csv-btn  hidden-print">
                            <span>
                                <i class="fa glyphicon glyphicon-export fa-download"></i>
                                Export to CSV
                            </span>
                        </button>-->
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group form-group-sm react-bs-table-search-form">
                        <input class="form-control " type="text" placeholder="input something..." style="z-index: 0;" value="">
                        <span class="input-group-btn"></span>
                    </div>
                  </div>
                </div>
              </div>

              <div  class=" react-bs-table react-bs-table-bordered" style="height: 100%;">
                <div class="table-responsive react-bs-container-header table-header-wrapper">
                  <table class="table table-hover table-bordered col-hidden">
                    <thead>
                      <tr>
                        <th class="" style="text-align: left;" data-is-only-head="false" title="Event Name" data-field="event_name">
                          Event Name

                        </th>
                        <th class="" style="text-align: left;" title="First Team">
                          First Team

                        </th>
                        <th class="" style="text-align: left;" title="Second Team">
                          Second Team

                        </th>
                        <th class="" style="text-align: left;" title="Draw">
                          Draw

                        </th>
                        <th class="" style="text-align: left;"  title="Total Bids">
                          Total Bids

                        </th>
                      </tr>
                    </thead>
                    <tbody class="Tennis">
                        <?php
                      if(isset($sportsTennis)){

                      foreach($sportsTennis as $tkey=>$tennis){

                      $dataArr = SportsController::getTeamName('TENNIS',$tennis->match_id);
                      $betCount = SportsController::getBetCount($tennis->match_id);
                      ?>
                      <tr class="{{$tennis->match_id}}">
                          <td ><a href="{{route('admin.MADTennis',$tennis->match_id)}}">{{$tennis->match_name}}</a></td>
                          <td>
                            {{-- <span class="tennisTeamName1">{{$dataArr['teamname'][1]}}</span> --}}
                            <span style="padding-left: 10px;" class="tennisTeam1"></span>
                          </td>
                          <td>
                              {{-- <span class="tennisTeamName2">{{$dataArr['teamname'][2]}}</span> --}}
                            <span style="padding-left: 10px;" class="tennisTeam2"></span>
                          </td>
                          <td></td>
                          <td>Total Bets : <b>{{ $betCount }}</b>
                              <input type="hidden" class="matchIDClass" value="{{$tennis->match_id}}">
                              <input type="hidden" class="sportIDClass" value="{{$tennis->id}}">
                          </td>
                      </tr>
                      <?php } }?>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="s-alert-wrapper"></div>
            </div>
          </div>
        </div>
      </div>

        <div id="soccer" class="hideActive allhide dataTables_wrapper ">
        <div class="">
          <div class="market_t1">
            <div class="react-bs-table-container">
              <div class="react-bs-table-tool-bar ">
                <div class="row">
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
                    <div class="btn-group btn-group-sm" role="group">
<!--                        <button type="button" class="btn btn-success react-bs-table-csv-btn  hidden-print">
                            <span>
                                <i class="fa glyphicon glyphicon-export fa-download"></i>
                                Export to CSV
                            </span>
                        </button>-->
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group form-group-sm react-bs-table-search-form">
                        <input class="form-control " type="text" placeholder="input something..." style="z-index: 0;" value="">
                        <span class="input-group-btn"></span>
                    </div>
                  </div>
                </div>
              </div>

              <div  class=" react-bs-table react-bs-table-bordered" style="height: 100%;">
                <div class="table-responsive react-bs-container-header table-header-wrapper">
                  <table class="table table-hover table-bordered col-hidden">
                    <thead>
                      <tr>
                        <th class="" style="text-align: left;" data-is-only-head="false" title="Event Name" data-field="event_name">
                          Event Name

                        </th>
                        <th class="" style="text-align: left;" title="First Team">
                          First Team

                        </th>
                        <th class="" style="text-align: left;" title="Second Team">
                          Second Team

                        </th>
                        <th class="" style="text-align: left;" title="Draw">
                          Draw

                        </th>
                        <th class="" style="text-align: left;"  title="Total Bids">
                          Total Bids

                        </th>
                      </tr>
                    </thead>
                    <tbody class="Soccer">
                        <?php
                      if(isset($sportsSoccer)){
                      foreach($sportsSoccer as $skey=>$soccer){

                      $dataArr = SportsController::getTeamName('SOCCER',$soccer->match_id);
                      $betCount = SportsController::getBetCount($soccer->match_id);
//                      $betCount = 0;
                      ?>
                      <tr class="{{$soccer->match_id}}">
                          <td><a href="{{route('admin.MADSoccer',$soccer->match_id)}}">{{$soccer->match_name}}</a></td>
                          <td>

                            <span style="padding-left: 10px;" class="cricketTeam0"></span>
                          </td>
                          <td>

                            <span style="padding-left: 10px;" class="cricketTeam1"></span>
                          </td>
                          <td>

                            <span style="padding-left: 10px;" class="cricketTeam2"></span>
                          </td>
                          <td>Total Bets : <b><?= $betCount ?></b>
                          <input type="hidden" class="matchIDClass" value="{{$soccer->match_id}}">
                          <input type="hidden" class="sportIDClass" value="{{$soccer->id}}">
                          </td>
                      </tr>
                      <?php } } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="s-alert-wrapper"></div>
            </div>
          </div>
        </div>
      </div>

      <div id="criket" class=" tabActive allhide dataTables_wrapper ">
        <div class="">
          <div class="market_t1">
            <div class="react-bs-table-container">
              <div class="react-bs-table-tool-bar ">
                <div class="row">
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
                    <div class="btn-group btn-group-sm" role="group">
<!--                        <button type="button" class="btn btn-success react-bs-table-csv-btn  hidden-print">
                            <span>
                                <i class="fa glyphicon glyphicon-export fa-download"></i>
                                Export to CSV
                            </span>
                        </button>-->
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group form-group-sm react-bs-table-search-form">
                        <input class="form-control " type="text" placeholder="input something..." style="z-index: 0;" value="">
                        <span class="input-group-btn"></span>
                    </div>
                  </div>
                </div>
              </div>
              <div id="" class=" react-bs-table react-bs-table-bordered" style="height: 100%;">
                <div class="table-responsive react-bs-container-header table-header-wrapper">
                  <table class="table table-hover table-bordered col-hidden">
                    <thead>
                      <tr>
                        <th class="" style="text-align: left;" data-is-only-head="false" title="Event Name" data-field="event_name">
                          Event Name

                        </th>
                        <th class="" style="text-align: left;" title="First Team">
                          First Team

                        </th>
                        <th class="" style="text-align: left;" title="Second Team">
                          Second Team

                        </th>
                        <th class="" style="text-align: left;" title="Draw">
                          Draw

                        </th>
                        <th class="" style="text-align: left;"  title="Total Bids">
                          Total Bids

                        </th>
                      </tr>
                    </thead>
                    <tbody class="Cricket">
                        <?php
                     if(isset($sportsCricket)){
                      foreach($sportsCricket as $ckey=>$criket){

                      $dataArr = SportsController::getTeamName('CRICKET',$criket->match_id);
                      $betCount = SportsController::getBetCount($criket->match_id);
                    //   dd($dataArr);
                      ?>

                      <tr class="{{$criket->match_id}}">
                          <td><a href="{{route('admin.MADCricket',$criket->match_id)}}">{{$criket->match_name}}</a></td>
                          <td>
                              <span class="cricketTeamName1">{{$dataArr['teamname'][1]}}</span>
                              <span style="padding-left: 10px;" class="cricketTeam1"></span>
                          </td>
                          <td>
                              <span class="cricketTeamName2">{{$dataArr['teamname'][2]}}</span>
                              <span style="padding-left: 10px;" class="cricketTeam2"></span>
                          </td>
                          <td>
                              <?php if(isset($dataArr['teamname'][3]) && !empty($dataArr['teamname'][3])){ ?>
                                    <span class="cricketTeamName3">{{$dataArr['teamname'][3]}}</span>
                                    <span style="padding-left: 10px;" class="cricketTeam3"></span>
                              <?php } ?>
                          </td>
                          <td>Total Bets : <b>{{ $betCount }}</b>
                          <input type="hidden" class="matchIDClass" value="{{$criket->match_id}}">
                          <input type="hidden" class="sportIDClass" value="{{$criket->id}}">
                          </td>
                      </tr>
                     <?php } } ?>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="s-alert-wrapper"></div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>


</div>


@endsection


@push('after-scripts')
<!--@include('backend.reloadJS')-->
<script type="text/javascript">
  function openTab(tabid,obj){
    $('.allhide').addClass(' hideActive');
    $('#'+tabid).removeClass(' hideActive');
    $('#'+tabid).addClass(' tabActive');

    $('.tabli').removeClass('activeUL')
    $(obj).closest('li').addClass(' activeUL');
  }
  $(document).ready(function() {
      $('#clientListTable').DataTable( {
            "pageLength": 50,
            "order": [],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    title: 'Client List Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
                {
                    extend: 'excel',
                    title: 'Client List Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }
            ]
      });
  } );

  $( document ).ready(function() {
    setInterval(function(){ getBetsList();getBetsListSoccer();getBetsListTennis(); }, 10000);
  });
  function getBetsListSoccer(){
     $('.Soccer').find('.matchIDClass').each(function(){
      var Obj1 = this;
      var matchID = $(this).val();
      var sportID = $(this).closest('td').find('.sportIDClass').val();
      $.ajax({
        url: '{{route("admin.my-bets.soccerlist")}}',
        dataType: 'json',
        type: "POST",
        data: '_token={{csrf_token()}}&match_id='+matchID+'&sportID='+sportID,
        success: function(dataJson){

          objteam1 = $('.'+matchID).find('.cricketTeam0');
          objteam2 = $('.'+matchID).find('.cricketTeam1');
          objteam3 = $('.'+matchID).find('.cricketTeam2');
          $(objteam1).find('.lefttxt .book').text('');
          $(objteam2).find('.lefttxt .book').text('');
          $(objteam3).find('.lefttxt .book').text('');

          if (typeof dataJson.ODDS !== 'undefined') {
            $.each(dataJson.ODDS, function(i, data) {
              var teamname1 = $('.'+matchID).find('.cricketTeamName0').text();
              var teamname2 = $('.'+matchID).find('.cricketTeamName1').text();
              if(teamname1 == i){
                objteam1 = $('.'+matchID).find('.cricketTeam0');
                if(parseFloat(data.ODDS_profitLost) > 0){
                  $(objteam1).css('color','red');
                  var amt = data.ODDS_profitLost;
                  $(objteam1).text((parseFloat(amt)*(-1)));
                }else{
                  $(objteam1).find('.book').css('color','green');
                  $(objteam1).text(Math.abs(data.ODDS_profitLost));
                }
              }else if(teamname2 == i){
                objteam2 = $('.'+matchID).find('.cricketTeam1');

                if(parseFloat(data.ODDS_profitLost) > 0){
                  $(objteam2).css('color','red');
                  var amt = data.ODDS_profitLost;
                  $(objteam2).text((amt*(-1)));
                }else{
                  $(objteam2).css('color','green');
                  $(objteam2).text(Math.abs(data.ODDS_profitLost));
                }
              }else{
                objteam3 = $('.'+matchID).find('.cricketTeam2');

                if(parseFloat(data.ODDS_profitLost) > 0){
                  $(objteam3).css('color','red');
                  var amt = data.ODDS_profitLost;
                  $(objteam3).text((amt*(-1)));
                }else{
                  $(objteam3).css('color','Green');
                  $(objteam3).text(Math.abs(data.ODDS_profitLost));
                }
              }
            });
          }
        }
      });
      });
    }
  function getBetsList(){
    $('.Cricket').find('.matchIDClass').each(function(){
      var Obj1 = this;
      var matchID = $(this).val();
      var sportID = $(this).closest('td').find('.sportIDClass').val();
       $.ajax({
        url: '{{route("admin.my-bets.list")}}',
        dataType: 'json',
        type: "POST",
        data: '_token={{csrf_token()}}&match_id='+matchID+'&sportID='+sportID,
        success: function(dataJson){
          if (typeof dataJson.ODDS !== 'undefined') {
            $.each(dataJson.ODDS, function(i, data) {
                var teamname = $('.'+matchID).find('.cricketTeamName1').text();
                var teamname1 = $('.'+matchID).find('.cricketTeamName2').text();
                if(teamname == i){
                  objteam1 = $('.'+matchID).find('.cricketTeam1');
                  if(parseFloat(data.ODDS_profitLost) >= 0){
                    $(objteam1).css('color','red');
                    var amt = data.ODDS_profitLost;
                    $(objteam1).text((parseFloat(amt)*(-1)));
                  }else{
                    $(objteam1).css('color','green');
                    $(objteam1).text(Math.abs(data.ODDS_profitLost));
                  }
                }else if(teamname1 == i){
                  objteam1 = $('.'+matchID).find('.cricketTeam2');
                  if(parseFloat(data.ODDS_profitLost) >= 0){
                    $(objteam1).css('color','red');
                    var amt = data.ODDS_profitLost;
                    $(objteam1).text((parseFloat(amt)*(-1)));
                  }else{
                    $(objteam1).css('color','green');
                    $(objteam1).text(Math.abs(data.ODDS_profitLost));
                  }
                }else{
                  objteam2 = $('.'+matchID).find('.cricketTeam3');
                  if(parseFloat(data.ODDS_profitLost) >= 0){
                    $(objteam2).css('color','red');
                    var amt = data.ODDS_profitLost;
                    $(objteam2).text((amt*(-1)));
                  }else{
                    $(objteam2).css('color','green');
                    $(objteam2).text(Math.abs(data.ODDS_profitLost));
                  }
                }
            });
          }
        }

      });

    });
  }
  function getBetsListTennis(){
    $('.Tennis').find('.matchIDClass').each(function(){
      var Obj1 = this;
      var matchID = $(this).val();
      var sportID = $(this).closest('td').find('.sportIDClass').val();
       $.ajax({
        url: '{{route("admin.my-bets.list")}}',
        dataType: 'json',
        type: "POST",
        data: '_token={{csrf_token()}}&match_id='+matchID+'&sportID='+sportID,
        success: function(dataJson){
          if (typeof dataJson.ODDS !== 'undefined') {
            $.each(dataJson.ODDS, function(i, data) {
                var teamname = $('.'+matchID).find('.tennisTeamName1').text();
                if(teamname == i){
                  objteam1 = $('.'+matchID).find('.tennisTeam1');
                  if(parseFloat(data.ODDS_profitLost) >= 0){
                    $(objteam1).css('color','red');
                    var amt = data.ODDS_profitLost;
                    $(objteam1).text((parseFloat(amt)*(-1)));
                  }else{
                    $(objteam1).css('color','green');
                    $(objteam1).text(Math.abs(data.ODDS_profitLost));
                  }
                }else{
                  objteam2 = $('.'+matchID).find('.tennisTeam2');
                  if(parseFloat(data.ODDS_profitLost) >= 0){
                    $(objteam2).css('color','red');
                    var amt = data.ODDS_profitLost;
                    $(objteam2).text((amt*(-1)));
                  }else{
                    $(objteam2).css('color','green');
                    $(objteam2).text(Math.abs(data.ODDS_profitLost));
                  }
                }
            });
          }
        }

      });

    });
  }
</script>

@endpush
