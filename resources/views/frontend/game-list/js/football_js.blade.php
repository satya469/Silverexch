<script type="text/javascript">
 var delay = "{{$delay}}";
 </script> 
<script type="text/javascript">
  var isMobile = false; //initiate as false
  // device detection
  if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
      || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
      isMobile = true;
      $('#sidebar-right').remove();
  }else{
    $('.mobilebetOdds').remove();
    $('#myModalBetView').remove();
  }
  $( document ).ready(function() {
    setInterval(function(){  getData(); }, 1000);
  });
   $( "#myModalBetView" ).on('shown.bs.modal', function (e) {
        $('.navbar ').hide();
    });
    $('#myModalBetView').on('hidden.bs.modal', function () {
        $('.navbar ').show();
    })
  $( document ).ready(function() {
    $('.box-1').on('click',function(){
      var betType = $(this).closest('.rootClass').find('#betType').val();
      
      if(isMobile){
        var amount = $(this).find('.odd').text();
        if(amount == 0){
          return false
        }
        $('#showBet').show();
        $('#myModalBetView').modal('show');
        
        var html = '';
        var i = 0;
        var txt = '';
        if($(this).closest('.rootClass').find("#options").length) {
          var opttext = $(this).closest('.rootClass').find("#options").val();
          $('#betoption').val(opttext);
          txt = opttext;
        }else{
          txt = betType;
        }
        $('.'+txt+' .oddsTot').each(function(){
          var teamname = $(this).find('.teamName').text();
          var matchValClear = $(this).find('.matchValClear123').text();
          
          if(matchValClear == ''){
            matchValClear = 0;
          }
          var color = "green";
          if(parseInt(matchValClear) < 0){
            color = 'red';
          }
          html +='<tr class="oddstbl'+i+'">';
            html +='<td style="text-align:left;" class="tname">'+teamname+'</td>';
            html +='<td style="text-align:center;color:'+color+'">'+matchValClear+'</td>';
            html +='<td style="text-align:right;" class="profitLoss123">0</td>';
          html +='</tr>';
          i++;
        });
        $('.showbetTot').html(html);
      }
      $('.rootClass').find('.country-name .float-right ').text('');
      $('#bet-profit').text('');
      $('#betAmount').val('');
      var amount = $(this).find('.odd').text();
      if(amount == 0){
        return false
      }
      var countryName = $(this).closest('.table-row').find('.country-name > span').text();
      var betType = $(this).closest('.rootClass').find('#betType').val();
      $('.amountint').val(amount);
      $('#teamNameBet').text(countryName);
      $('#betTypeAdd').val(betType);
      if($(this).closest('.rootClass').find("#options").length) {
        var opttext = $(this).closest('.rootClass').find("#options").val();
        $('#betoption').val(opttext);
        
      }
      $('#showBet').removeClass('back-color');
      $('#showBet').removeClass('lay-color');
      if(isMobile){
        $('.modal-body').removeClass('back-color');
        $('.modal-body').removeClass('lay-color');
      }
      if($(this).hasClass("back") || $(this).hasClass("back1") || $(this).hasClass("back2")){
        $('#showBet').addClass('back-color');
        $('#betSide').val('back');
        if(isMobile){
          $('.modal-body').addClass('back-color');
        }
      }else{
        $('#showBet').addClass('lay-color');
        $('#betSide').val('lay');
        if(isMobile){
          $('.modal-body').addClass('lay-color');
        }
      }
      if(!$("#showBet").hasClass("show")){
        $('#showBet').addClass('show');
      }
    });
  });
  getData();
  function getData(){
    $.ajax({
      url: '{{route("frontend.getdatasoccer",$sports->match_id)}}',
      dataType: 'json',
      type: "get",
      success: function(data){
//        if(data.matchDeclear == true){
//          redirectHome();
//        }
        if(data.matchSuspended == true){
            $('.addSuspended').attr('data-title','SUSPENDED');
            $('.addSuspended').addClass('suspended');
            $('.ODDS').attr('data-title','SUSPENDED');
            $('.ODDS').addClass('suspended');
        }else{
            $('.addSuspended').attr('data-title','Active');
            $('.addSuspended').removeClass('suspended');
            $('.ODDS').attr('data-title','Active');
            $('.ODDS').removeClass('suspended');
        }
        if(data.matchDeclear == true){
            $('.addSuspended').attr('data-title','SUSPENDED');
            $('.addSuspended').addClass('suspended');
            $('.ODDS').attr('data-title','SUSPENDED');
            $('.ODDS').addClass('suspended');
            redirectHome();
        }else{
            setodd(data.odd);
            setbookmaker(data.session);
            getBetsList();
        }
      }
    });
  }
  
  
  $('.value-buttons').find('button').on('click',function(){
      var amt = $(this).attr('data-bet');
      $('#betAmount').val(amt);
      betODDCalculation(amt);
    });

  $('#betAmount').on('keyup',function(){
      var amt = $(this).val();
      betODDCalculation(amt);
    });
      
  
  function saveBet(){
    var bet_type = $('#betTypeAdd').val();
    showLoading('showBet');
    if(parseInt(delay) > 0){
      if(bet_type == 'ODDS'){
        setTimeout( function () {
          saveBetcall();
          hideLoading('showBet');
      },parseInt(delay));
      }else{
        saveBetcall();
        hideLoading('showBet');
      }
    }else{
      saveBetcall();
      hideLoading('showBet');
    }
  }
  function saveBetcall(){
    $('.btn-success').prop("disabled", false);
    var opttext = $('#betoption').val();
    var bet_type = $('#betTypeAdd').val();
    var bet_site = $('#betSide').val();
    var bet_odds = $('.amountint').val();
    var bet_amount = $('#betAmount').val();
    var team_name = $('#teamNameBet').text();
    var bet_profit = $('#bet-profit').text();
    var suspendedMsg = '<div class="alert alert-danger">Game Suspended Bet Not Allowed</div>';
    if(bet_amount == '' || bet_amount <= 0 || isNaN(bet_amount)){
        $('#betMsgALL').html('<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Min Max Bet Limit Exceed</div>');
        betMsgEmpty();
        hideLoading('showBet');
        return false;
    }
    if(bet_odds >= 5){
        $('#betMsgALL').html('<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Not Accept Rate Over 4.00 on Oneday and T20</div>');
        betMsgEmpty();
        hideLoading('showBet');
        return false;
    }
    if(bet_type == 'ODDS'){
      var team1 = $('.ODDS').find('.oddssteam0 .team').text();
      var team2 = $('.ODDS').find('.oddssteam1 .team').text();
      var team3 = $('.ODDS').find('.oddssteam2 .team').text();
      if(bet_site == 'lay'){
        if(team1 == team_name){
          obj1 = $('.ODDS').find('.oddssteam0 .team');
          var bet_odds = $(obj1).closest('.table-row').find('.lay1t').text();
        }else if(team2 == team_name){
          obj2 = $('.ODDS').find('.oddssteam1 .team');
          var bet_odds = $(obj2).closest('.table-row').find('.lay1t').text();
        }else{
          obj3 = $('.ODDS').find('.oddssteam2 .team');
          var bet_odds = $(obj3).closest('.table-row').find('.lay1t').text();
        }
      }else{
        if(team1 == team_name){
          obj1 = $('.ODDS').find('.oddssteam0 .team');
          var bet_odds = $(obj1).closest('.table-row').find('.back1t').text();
        }else if(team2 == team_name){
          obj2 = $('.ODDS').find('.oddssteam1 .team');
          var bet_odds = $(obj2).closest('.table-row').find('.back1t').text();
        }else{
          obj3 = $('.ODDS').find('.oddssteam2 .team');
          var bet_odds = $(obj3).closest('.table-row').find('.back1t').text();
        }
      }
      $('.amountint').val(bet_odds);
      betODDCalculation(bet_amount);
      var opttext = $('#betoption').val();
      var bet_type = $('#betTypeAdd').val();
      var bet_site = $('#betSide').val();
      var bet_odds = $('.amountint').val();
      var bet_amount = $('#betAmount').val();
      var team_name = $('#teamNameBet').text();
      var bet_profit = $('#bet-profit').text();
    }
    if(bet_amount == '' || bet_amount <= 0 || isNaN(bet_amount)){
        $('#betMsgALL').html('<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Min Max Bet Limit Exceed</div>');
        betMsgEmpty();
        hideLoading('showBet');
        return false;
    }
    if(bet_odds >= 5){
        $('#betMsgALL').html('<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Not Accept Rate Over 4.00 on Oneday and T20</div>');
        betMsgEmpty();
        hideLoading('showBet');
        return false;
    }
    if(bet_type == 'SESSION'){
      var team1 = $('.'+opttext).find('.OVER_UNDER_0 .team').text();
      var teamn2 = $('.'+opttext).find('.OVER_UNDER_1 .team').text();
      if(bet_site == 'lay'){
        if(team1 == team_name){
          obj = $('.'+opttext).find('.OVER_UNDER_0 .team');
          var bet_odds = $(obj).closest('.table-row').find('.lay1t').text();
        }else{
          obj = $('.'+opttext).find('.OVER_UNDER_1 .team');
          var bet_odds = $(obj).closest('.table-row').find('.lay1t').text();
        }
      }else{
        if(team1 == team_name){
          obj = $('.'+opttext).find('.OVER_UNDER_0 .team');
          var bet_odds = $(obj).closest('.table-row').find('.back1t').text();
        }else{
          obj = $('.'+opttext).find('.OVER_UNDER_1 .team');
          var bet_odds = $(obj).closest('.table-row').find('.back1t').text();
        }
      }
      $('.amountint').val(bet_odds);
      betODDCalculation(bet_amount);
      var opttext = $('#betoption').val();
      var bet_type = $('#betTypeAdd').val();
      var bet_site = $('#betSide').val();
      var bet_odds = $('.amountint').val();
      var bet_amount = $('#betAmount').val();
      var team_name = $('#teamNameBet').text();
      var bet_profit = $('#bet-profit').text();
    }

    if(bet_type == 'ODDS'){
      var suspendedCount = $('.ODDS').find('.suspended').length;
      if(suspendedCount == 3){
        $('#betMsgALL').html(suspendedMsg);
        betMsgEmpty();
        hideLoading('showBet');
        return false;
      }
      if(suspendedCount > 0){
        var teams = $('.ODDS').find('.oddssteam0 .team').text();
        if(teams == team_name && $('.ODDS').find('.oddssteam0').hasClass('suspended')){
          $('#betMsgALL').html(suspendedMsg);
          betMsgEmpty();
          hideLoading('showBet');
          return false;
        }

        var teams = $('.ODDS').find('.oddssteam1 .team').text();
        if(teams == team_name && $('.ODDS').find('.oddssteam1').hasClass('suspended')){
          $('#betMsgALL').html(suspendedMsg);
          betMsgEmpty();
          hideLoading('showBet');
          return false;
        }
        var teams = $('.ODDS').find('.oddssteam2 .team').text();
        if(teams == team_name && $('.ODDS').find('.oddssteam2').hasClass('suspended')){
          $('#betMsgALL').html(suspendedMsg);
          betMsgEmpty();
          hideLoading('showBet');
          return false;
        }
      }

    }
    if(bet_type == 'SESSION'){
      var suspendedCount = $('.'+opttext).find('.suspended').length;
      if(suspendedCount == 2){
        $('#betMsgALL').html(suspendedMsg);
        betMsgEmpty();
        hideLoading('showBet');
        return false;
      }
      if(suspendedCount > 0){
        var teams = $('.'+opttext).find('.suspended .team-name0 b').text();
        if(teams == team_name){
          $('#betMsgALL').html(suspendedMsg);
          betMsgEmpty();
          hideLoading('showBet');
          return false;
        }
      }
    }
    if(bet_odds == '' || bet_odds <= 0 || isNaN(bet_odds)){
        $('#betMsgALL').html('<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Odds changed</div>');
        betMsgEmpty();
        hideLoading('showBet');
        return false;
    }
    if(bet_type == 'ODDS'){
      var parameter = "";
      var teamname1 = $('.ODDS').find('.oddssteam0 .team').text();
      var teamname2 = $('.ODDS').find('.oddssteam1 .team').text();
      var teamname3 = $('.ODDS').find('.oddssteam2 .team').text();
      if(teamname1 == team_name){
        parameter = "&teamname2="+encodeURIComponent(teamname2)+"&teamname3="+encodeURIComponent(teamname3);
      }else if(teamname2 == team_name){
        parameter = "&teamname1="+encodeURIComponent(teamname1)+"&teamname3="+encodeURIComponent(teamname3);
      }else{
        parameter = "&teamname1="+encodeURIComponent(teamname1)+"&teamname2="+encodeURIComponent(teamname2);
      }

      $.ajax({
        url: '{{route("frontend.my-bets.soccerstore")}}',
        dataType: 'json',
        type: "POST",
        data : "sportID={{$sports->id}}&match_id={{$sports->match_id}}&_token={{csrf_token()}}&bet_profit="+bet_profit+"&bet_type="+bet_type+"&bet_side="+bet_site+"&bet_odds="+bet_odds+"&bet_amount="+bet_amount+"&team_name="+encodeURIComponent(team_name)+parameter,
        success: function(data){
          $('#betMsgALL').html(data.message);
          if(data.status == true){
            $('.rootClass').find('.country-name .float-right ').text('');
            $('#bet-profit').text('');
            $('#betAmount').val('');

          }
          betMsgEmpty();
          hideLoading('showBet');
          if(isMobile){
            setTimeout(function(){ $('#myModalBetView').modal('hide'); }, 1000);
          }
//          getBetsList();
        }
      });
    }else{
      var parameter = "";

      var teamname1 = $('.'+opttext).find('.OVER_UNDER_0 .team').text();
      var teamname2 = $('.'+opttext).find('.OVER_UNDER_1 .team').text();

      if(teamname1 == team_name){
        parameter = "&teamname2="+teamname2;
      }else if(teamname2 == team_name){
        parameter = "&teamname1="+teamname1;
      }

      bet_type = bet_type+'-'+opttext;
      $.ajax({
      url: '{{route("frontend.my-bets.soccerstore")}}',
      dataType: 'json',
      type: "POST",
      data : "sportID={{$sports->id}}&match_id={{$sports->match_id}}&_token={{csrf_token()}}&bet_profit="+bet_profit+"&bet_type="+bet_type+"&bet_side="+bet_site+"&bet_odds="+bet_odds+"&bet_amount="+bet_amount+"&team_name="+team_name+parameter,
      success: function(data){
        $('#betMsgALL').html(data.message);
        if(data.status == true){
          $('.rootClass').find('.country-name .float-right ').text('');
          $('#bet-profit').text('');
          $('#betAmount').val('');

          betMsgEmpty();
        }
         hideLoading('showBet');
         if(isMobile){
            setTimeout(function(){ $('#myModalBetView').modal('hide'); }, 1000);
          }
        getBetsList();
      }
    });
    }

  }

  function getBetsList(){
      $.ajax({
        url: '{{route("frontend.my-bets.soccerlist")}}',
        dataType: 'json',
        type: "POST",
        data: 'sportID={{$sports->id}}&_token={{csrf_token()}}&match_id={{$sports->match_id}}',
        success: function(dataJson){
            $('.matchValClear123').text("");
          $('#myBet  tbody').html(dataJson.myBetData);
          if (typeof dataJson.exposureAmt !== 'undefined') {
            $('#headerExposureLimit').text(calc(dataJson.exposureAmt));
          }
          if(typeof dataJson.headerUserBalance !== 'undefined') {
            
            $('#headerUserBalance').text(calc(dataJson.headerUserBalance));
          }
          if (typeof dataJson.ODDS !== 'undefined') {
            $.each(dataJson.ODDS, function(i, data) {
              var teamname1 = $('.ODDS').find('.oddssteam0 .team').text();
              var teamname2 = $('.ODDS').find('.oddssteam1 .team').text();
              if(teamname1 == i){
                objteam1 = $('.ODDS').find('.oddssteam0 .team');

                if(parseFloat(data.ODDS_profitLost) > 0){
                  $(objteam1).closest('.country-name').find('.float-left').css('color','green');
                }else{
                  $(objteam1).closest('.country-name').find('.float-left').css('color','red');
                }

                $(objteam1).closest('.country-name').find('.float-left').text(data.ODDS_profitLost);
              }else if(teamname2 == i){
                objteam2 = $('.ODDS').find('.oddssteam1 .team');

                if(parseFloat(data.ODDS_profitLost) > 0){
                  $(objteam2).closest('.country-name').find('.float-left').css('color','green');
                }else{
                  $(objteam2).closest('.country-name').find('.float-left').css('color','red');
                }
                $(objteam2).closest('.country-name').find('.float-left').text(data.ODDS_profitLost);
              }else{
                objteam1 = $('.ODDS').find('.oddssteam0 .team');
                objteam2 = $('.ODDS').find('.oddssteam1 .team');
                objteam3 = $('.ODDS').find('.oddssteam2 .team');

                if(parseFloat(data.ODDS_profitLost) > 0){
                  $(objteam3).closest('.country-name').find('.float-left').css('color','green');
                }else{
                  $(objteam3).closest('.country-name').find('.float-left').css('color','red');
                }

                $(objteam3).closest('.country-name').find('.float-left').text(data.ODDS_profitLost);
              }
          });
          }
          if (typeof dataJson.SESSION !== 'undefined') {
            $.each(dataJson.SESSION, function(j, dataArr) {
            $.each(dataArr, function(i, data) {
              var teamname1 = $('.'+j).find('.OVER_UNDER_0 .team').text();
              var teamname2 = $('.'+j).find('.OVER_UNDER_1 .team').text();
              if(teamname1 == i){
                objteam1 = $('.'+j).find('.OVER_UNDER_0 .team');
                if(parseFloat(data.SESSION_profitLost) > 0){
                  $(objteam1).closest('.country-name').find('.float-left').css('color','green');
                }else{
                  $(objteam1).closest('.country-name').find('.float-left').css('color','red');
                }
                $(objteam1).closest('.country-name').find('.float-left').text(data.SESSION_profitLost);
              }else{
                objteam2 = $('.'+j).find('.OVER_UNDER_1 .team');
                if(parseFloat(data.SESSION_profitLost) > 0){
                  $(objteam2).closest('.country-name').find('.float-left').css('color','green');
                }else{
                  $(objteam2).closest('.country-name').find('.float-left').css('color','red');
                }
                $(objteam2).closest('.country-name').find('.float-left').text(data.SESSION_profitLost);
              }
            });
          });
          }
        }
      });
    }
  
</script>

