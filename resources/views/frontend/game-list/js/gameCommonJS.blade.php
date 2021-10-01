
@include('frontend.game-list.js.sideBarScroll')
<script type="text/javascript">
    $( document ).ready(function() {
        setInterval(function(){ getBetsList(); }, 9000);
    });
  var isMobile = false; //initiate as false
   // device detection
   if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
       || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
       isMobile = true;
   }
   $( "#myModalBetView" ).on('shown.bs.modal', function (e) {
       
        $('.navbar ').hide();
        
    });
    $('#myModalBetView').on('hidden.bs.modal', function () {
        clearBetVal();
        $('.navbar ').show();
    })
  function declearResult(roundID,teamName){
  
     $.ajax({
      url: '{{route("frontend.my-bets.declearCasinoResult")}}',
      dataType: 'json',
      type: "POST",
      data: '_token={{csrf_token()}}&sportID={{$sports->id}}&roundID='+roundID+'&teamName='+teamName,
      success: function(dataJson){
        if(dataJson.status == false){
          return false;
        }else{
          return true;
        }
      }
    });
  }
   
  function saveBet(){
    var bet_type = $('#betTypeAdd').val();
    var bet_site = $('#betSide').val();
    var bet_odds = $('.amountint').val();
    var team_name = $('#teamNameBet').text();
    var amount = $(this).closest('.table-row').find('.back1t').text();
    var bet_amount = $('#betAmount').val();
    var bet_amountK = $('#betOddk').val();
    var bet_profit = $('#bet-profit').text();
    var match_id = $('#roundID').val();
    var suspendedMsg = '<div class="alert alert-danger">Game Suspended Bet Not Allowed</div>';
    if(bet_type == 'ODDS'){
      if($('.ODDS').hasClass('suspended')){
        $('#betMsgALL').html(suspendedMsg);
        betMsgEmpty();
        return false;
      }
    }
    var betPosition =  $('#betPosition').val();
    var parameter = "";
    if(bet_type == 'ODDSPAIR'){
      var teamname1 = $('.ODDSPAIR').find('.team-name0 > b').text();
      var teamname2 = $('.ODDSPAIR').find('.team-name1 > b').text();
      var teamname3 = $('.ODDSPAIR').find('.team-name2 > b').text();
      var teamname4 = $('.ODDSPAIR').find('.team-name3 > b').text();
    }else{
      var teamname1 = $('.ODDS').find('.team-name0 > b').text();
      var teamname2 = $('.ODDS').find('.team-name1 > b').text();
      var teamname3 = $('.ODDS').find('.team-name2 > b').text();
      var teamname4 = $('.ODDS').find('.team-name3 > b').text();
    }
    var newOdds = '';
    if(teamname1 == team_name){
       newOdds = $('.ODDS').find('.oddssteam0 > .'+betPosition+' > .odd').text();
       
        teamname2 = teamname2.replace("+", "#");
        parameter = "&teamname2="+teamname2;
        if (typeof teamname3 !== 'undefined') {
           parameter += "&teamname3="+teamname3;
        }
        if (typeof teamname4 !== 'undefined') {
           parameter += "&teamname4="+teamname4;
        }
      }else if(teamname2 == team_name){
          newOdds = $('.ODDS').find('.oddssteam1 > .'+betPosition+' > .odd').text();
        teamname1 = teamname1.replace("+", "#");
        parameter = "&teamname1="+teamname1;
        if (typeof teamname3 !== 'undefined') {
           parameter += "&teamname3="+teamname3;
        }
        if (typeof teamname4 !== 'undefined') {
           parameter += "&teamname4="+teamname4;
        }
      }else if(teamname3 == team_name){
          newOdds = $('.ODDS').find('.oddssteam2 > .'+betPosition+' > .odd').text();
        teamname1 = teamname1.replace("+", "#");
        parameter = "&teamname1="+teamname1;
        parameter += "&teamname2="+teamname2;
        if (typeof teamname4 !== 'undefined') {
           parameter += "&teamname4="+teamname4;
        }
      }else{
         newOdds = $('.ODDS').find('.oddssteam3 > .'+betPosition+' > .odd').text();
        teamname1 = teamname1.replace("+", "#");
        parameter = "&teamname1="+teamname1;
         parameter += "&teamname2="+teamname2;
        if (typeof teamname3 !== 'undefined') {
           parameter += "&teamname3="+teamname3;
        }
      }
        if(bet_odds != newOdds){
           $('#betMsgALL').html("<div class='alert alert-danger'>Bet Not Confirm Reason Odds Change</div>");
           betMsgEmpty();
            if(isMobile){
              setTimeout(function(){ $('#myModalBetView').modal('hide'); }, 1000);
           }
           return false;
       }
     team_name = team_name.replace("+", "#");    
    $.ajax({
      url: '{{route("frontend.my-bets.store")}}',
      dataType: 'json',
      type: "POST",
      data : "match_id="+match_id+"&sportID={{$sports->id}}&_token={{csrf_token()}}&bet_profit="+bet_profit+"&bet_type="+bet_type+"&bet_side="+bet_site+"&bet_odds="+bet_odds+"&bet_amount="+bet_amount+"&bet_oddsK="+bet_amountK+"&team_name="+team_name+parameter,
      success: function(data){
        $('#betMsgALL').html(data.message);
        if(data.status == true){
          $('.rootClass').find('.country-name .float-right ').text('');
          $('#bet-profit').text('');
          $('#betAmount').val('');
          $('.amountint').val('');
        }
        betMsgEmpty();
        if(isMobile){
          setTimeout(function(){ $('#myModalBetView').modal('hide'); }, 1000);
       }
        getBetsList();
      }
    });
  }
  
  function getBetsList(){
    var match_id = $('#roundID').val();
    $.ajax({
      url: '{{route("frontend.my-bets.list")}}',
      dataType: 'json',
      type: "POST",
      data: '_token={{csrf_token()}}&sportID={{$sports->id}}&match_id='+match_id,
      success: function(dataJson){
        $('.matchValClear').text('');
        $('#myBet  tbody').html(dataJson.myBetData);
        if (typeof dataJson.exposureAmt !== 'undefined') {
          $('#headerExposureLimit').text(calc(dataJson.exposureAmt));
        }
        if (typeof dataJson.headerUserBalance !== 'undefined') {
          $('#headerUserBalance').text(calc(dataJson.headerUserBalance));
        }
        if (typeof dataJson.ODDS !== 'undefined') {
          $.each(dataJson.ODDS, function(i, data) {
            var teamname1 = $('.ODDS').find('.team-name0 > b').text();
            var teamname2 = $('.ODDS').find('.team-name1 > b').text();
            var teamname3 = $('.ODDS').find('.team-name2 > b').text();
            
            if(teamname1 == i){
              objteam1 = $('.ODDS').find('.team-name0 > b');

              if(parseFloat(data.ODDS_profitLost) >= 0){
                $(objteam1).closest('.country-name').find('.float-left').css('color','green');
              }else{
                $(objteam1).closest('.country-name').find('.float-left').css('color','red');
              }

              $(objteam1).closest('.country-name').find('.float-left').text(data.ODDS_profitLost);
            }else if(teamname2 == i){
              objteam1 = $('.ODDS').find('.team-name1 > b');

              if(parseFloat(data.ODDS_profitLost) >= 0){
                $(objteam1).closest('.country-name').find('.float-left').css('color','green');
              }else{
                $(objteam1).closest('.country-name').find('.float-left').css('color','red');
              }

              $(objteam1).closest('.country-name').find('.float-left').text(data.ODDS_profitLost);
            }else if(teamname3 == i){
              objteam1 = $('.ODDS').find('.team-name2 > b');

              if(parseFloat(data.ODDS_profitLost) >= 0){
                $(objteam1).closest('.country-name').find('.float-left').css('color','green');
              }else{
                $(objteam1).closest('.country-name').find('.float-left').css('color','red');
              }

              $(objteam1).closest('.country-name').find('.float-left').text(data.ODDS_profitLost);
            }else{
              objteam2 = $('.ODDS').find('.team-name3 > b');
              if(parseFloat(data.ODDS_profitLost) >= 0){
                $(objteam2).closest('.country-name').find('.float-left').css('color','green');
              }else{
                $(objteam2).closest('.country-name').find('.float-left').css('color','red');
              }
              $(objteam2).closest('.country-name').find('.float-left').text(data.ODDS_profitLost);
            }
          });
        }
        if (typeof dataJson.ODDSPAIR !== 'undefined') {
          $.each(dataJson.ODDSPAIR, function(i, data) {
            var teamname = $('.ODDSPAIR').find('.pairPlussteam0 .teamName').text();
            if(teamname == i){
              objteam1 = $('.ODDSPAIR').find('.pairPlussteam0 .teamName');
              if(parseFloat(data.ODDSPAIR_profitLost) >= 0){
                $(objteam1).closest('.country-name').find('.float-left').css('color','green');
              }else{
                $(objteam1).closest('.country-name').find('.float-left').css('color','red');
              }
              $(objteam1).closest('.country-name').find('.float-left').text(data.ODDSPAIR_profitLost);
            }else{
              objteam2 = $('.ODDSPAIR').find('.pairPlussteam1 .teamName');
              if(parseFloat(data.ODDSPAIR_profitLost) >= 0){
                $(objteam2).closest('.country-name').find('.float-left').css('color','green');
              }else{
                $(objteam2).closest('.country-name').find('.float-left').css('color','red');
              }
              $(objteam2).closest('.country-name').find('.float-left').text(data.ODDSPAIR_profitLost);
            }
         });
        }
      }
    });
  }
  
  function getDataAAA(){
    $.ajax({
      url: '{{ route("frontend.getcasinoData")}}',
      dataType: 'json',
      type: "POST",
      cache: false,
      async: false, 
      data : "gameName=AmarAkbarAnthony&sportID={{$sports->id}}&_token={{csrf_token()}}",
      success: function(data){
        setDetails(data.detail,'AmarAkbarAnthony');
        setodd(data.runner,'AmarAkbarAnthony');
        setResult(data.result,'AmarAkbarAnthony');
        getBetsList();
      }
    });
  }
</script>

