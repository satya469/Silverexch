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
    <h4 class="">Dashboard
        
    </h4>
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
      $.ajax({
        url: '{{route("admin.my-bets.soccerlist")}}',
        dataType: 'json',
        type: "POST",
        data: '_token={{csrf_token()}}&match_id='+matchID,
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
       $.ajax({
        url: '{{route("admin.my-bets.list")}}',
        dataType: 'json',
        type: "POST",
        data: '_token={{csrf_token()}}&match_id='+matchID,
        success: function(dataJson){
          if (typeof dataJson.ODDS !== 'undefined') {
            $.each(dataJson.ODDS, function(i, data) {
                var teamname = $('.'+matchID).find('.cricketTeamName1').text();
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
                }else{
                  objteam2 = $('.'+matchID).find('.cricketTeam2');
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
       $.ajax({
        url: '{{route("admin.my-bets.list")}}',
        dataType: 'json',
        type: "POST",
        data: '_token={{csrf_token()}}&match_id='+matchID,
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
