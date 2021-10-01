<script type="text/javascript">
  function setDetails(data,gametype){
      $('.roundID').text(data.roundId);
      $('#roundID').val(data.roundId);
      if(gametype == 'UpDown7' || gametype == 'AmarAkbarAnthony'){
        $('.cardsDiv').find('.Team0 .card1').html(data.c1);
      }else if(gametype == 'AndarBahar'){
        $('.cardsDiv').find('.MainCard').html(data.headcard);
      }else if(gametype == 'DragOnTiger'){
        $('.cardsDiv').find('.Dragon').html(data.c1);
        $('.cardsDiv').find('.Tiger').html(data.c2);
      }
      $('.timerClass').css("display",'block');
      $('#time').text(data.timer);
      var timerArr = (data.timer).split(":");
      var fiveMinutes = (parseInt(timerArr[1])+(parseInt(timerArr[0]*60)));
      if(parseInt(fiveMinutes) == 0){
        $('.ODDS').addClass("suspended");
        $('.ODDS').attr('data-title','SUSPENDED');
      }else{
        $('.ODDS').removeClass("suspended");
        $('.ODDS').attr('data-title','OPEN');
      }
  }
  
  function setResult(data,gametype){
    $('.resultAdd').html("");
    $.each(data, function(i, item) {
      if (typeof item.result !== 'undefined') {
        if(item.result == 'A'){
          var ht = '<span style="margin: 2px;" data-v-2d782e21=""><span data-v-2d782e21="" class="ball-runs playera last-result" style="color:#FFFF33;">'+item.result+'</span></span>';
        }else{
          var ht = '<span style="margin: 2px;" data-v-2d782e21=""><span data-v-2d782e21="" class="ball-runs playera last-result" style="color:#ff4500">'+item.result+'</span></span>';
        }
        var old = $('.resultAdd').html();
        $('.resultAdd').html(ht+old);
      }
    });
    
  }
  
 
  
  function setodd(data,gametype){
    $.each(data, function(i, item){
//      if(gametype == 'AmarAkbarAnthony' && i >= 3){
////        break;
//      }
      if(gametype == 'LiveTeenPati' || gametype == 'TeenPati20'){
        $('.cardsDiv').find('.Team'+i+' .card1').html(item.c1);
        $('.cardsDiv').find('.Team'+i+' .card2').html(item.c2);
        $('.cardsDiv').find('.Team'+i+' .card3').html(item.c3);
      }else if(gametype == 'AndarBahar'){
        var arr = item.cards;
        $('.cardsDiv').find('.Team'+i+' .card1').html("");
        $('.cardsDiv').find('.Team'+i+' .card1').html(arr.join(""));
       
      }else if(gametype == 'Poker'){
        if(parseInt(i) < parseInt(2)){
          $('.cardsDiv').find('.Team'+i+' .card1').html(item.c1);
          $('.cardsDiv').find('.Team'+i+' .card2').html(item.c2);
        }else if(parseInt(i) == parseInt(2)){
          $('.cardsDiv').find('.Team'+i+' .card1').html(item.c1);
          $('.cardsDiv').find('.Team'+i+' .card2').html(item.c2);
          $('.cardsDiv').find('.Team'+i+' .card3').html(item.c3);
          $('.cardsDiv').find('.Team'+i+' .card4').html(item.c4);
          $('.cardsDiv').find('.Team'+i+' .card5').html(item.c5);
        }
      }else if(gametype == 'CardScasin032'){
        var countNO = item.cards.length;
        $('.cardsDiv').find('.Team'+i+' .card1').html(item.cards[0]);
        $('.cardsDiv').find('.Team'+i+' .card4').html(item.cards[countNO-1]);
        delete item.cards[0];
        delete item.cards[countNO-1];
        $('.cardsDiv').find('.Team'+i+' .card3').html(item.cards.join(""));
        
      }
      
      $('.oddssteam'+i+' .team-name'+i+' > b').text(item.nation);
      if($('.oddssteam'+i+' .back1t').text() != item.backprice1){
        $('.oddssteam'+i+' .back1t').text(item.backprice1);
//        $('.oddssteam'+i+' .back1t').css("background-color",'yellow');
//        $('.oddssteam'+i+' .back1t').closest('.box-1').style('color', 'yellow', 'important');
      }else{
//        $('.oddssteam'+i+' .back1t').css("background-color",'');
      }
      
      $('.oddssteam'+i+' .back2t').text(item.backprice2);
      $('.oddssteam'+i+' .back3t').text(item.backprice3);
      $('.oddssteam'+i+' .back1k').text(item.backsize1);
      $('.oddssteam'+i+' .back2k').text(item.backsize2);
      $('.oddssteam'+i+' .back3k').text(item.backsize3);
      $('.oddssteam'+i+' .lay1t').text(item.layprice1);
      $('.oddssteam'+i+' .lay2t').text(item.layprice2);
      $('.oddssteam'+i+' .lay3t').text(item.layprice3);
      $('.oddssteam'+i+' .lay1k').text(item.laysize1);
      $('.oddssteam'+i+' .lay2k').text(item.laysize2);
      $('.oddssteam'+i+' .lay3k').text(item.laysize3);
      
    });
  }
  
  function calc(num) {
    var fixed = 2;
    var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (fixed || -1) + '})?');
    return num.toString().match(re)[0];
  }
   
  function getBetsList1231123(){
    var match_id = $('#roundID').val();
    $.ajax({
      url: '{{route("admin.my-bets.list")}}',
      dataType: 'json',
      type: "POST",
      data: '_token={{csrf_token()}}&sportID={{$sports->id}}&match_id='+match_id,
      success: function(dataJson){
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
      }
    });
  }
  function betMsgEmpty(){
    setTimeout(function(){ $('#betMsgALL').html(''); }, 1000);
    setTimeout(function(){ showBet(); }, 1000);

  }
  function getBetsList(){
    var roundid = $('#roundID').val();
      $.ajax({
        url: '{{route("admin.my-bets.list")}}',
        dataType: 'json',
        type: "POST",
        data: 'sportID={{$sports->id}}&_token={{csrf_token()}}&match_id='+roundid,
//        data: 'sportID={{$sports->id}}&_token={{csrf_token()}}&match_id=5764539',
//        data: 'sportID=52&_token={{csrf_token()}}&match_id=5764539',
        success: function(dataJson){
          if (typeof dataJson.myBetsHtml !== 'undefined') {
            $('#myBet').html(dataJson.myBetsHtml);
          }
          
          objteam1 = $('.ODDS').find('.oddssteam0');
          $(objteam1).find('.lefttxt .book').text('');
          objteam2 = $('.ODDS').find('.oddssteam1');
          $(objteam2).find('.lefttxt .book').text('');
          objteam3 = $('.ODDS').find('.oddssteam2');
          $(objteam3).find('.lefttxt .book').text('');
          objteam4 = $('.ODDS').find('.oddssteam3');
          $(objteam4).find('.lefttxt .book').text('');
          
          if (typeof dataJson.ODDS !== 'undefined') {
          $.each(dataJson.ODDS, function(i, data) {
//            if(data.ODDS_team_name){
              var teamname = $('.ODDS').find('.oddssteam0 .team').text();
              var teamname1 = $('.ODDS').find('.oddssteam1 .team').text();
              var teamname2 = $('.ODDS').find('.oddssteam2 .team').text();
              var teamname3 = $('.ODDS').find('.oddssteam3 .team').text();
              if(teamname == i){
                objteam1 = $('.ODDS').find('.oddssteam0');
                if(parseFloat(data.ODDS_profitLost) >= 0){
                  $(objteam1).find('.lefttxt .book').css('color','red');
                  var amt = data.ODDS_profitLost;
                  $(objteam1).find('.lefttxt .book').text((parseFloat(amt)*(-1)));
                }else{
                  $(objteam1).find('.lefttxt .book').css('color','green');
                  $(objteam1).find('.lefttxt .book').text(Math.abs(data.ODDS_profitLost));
                }
              }else if(teamname1 == i){
                objteam2 = $('.ODDS').find('.oddssteam1');
                if(parseFloat(data.ODDS_profitLost) >= 0){
                  $(objteam2).find('.lefttxt .book').css('color','red');
                  var amt = data.ODDS_profitLost;
                  $(objteam2).find('.lefttxt .book').text((amt*(-1)));
                }else{
                  $(objteam2).find('.lefttxt .book').css('color','green');
                  $(objteam2).find('.lefttxt .book').text(Math.abs(data.ODDS_profitLost));
                }
              }else if(teamname2 == i){
                objteam2 = $('.ODDS').find('.oddssteam2');
                if(parseFloat(data.ODDS_profitLost) >= 0){
                  $(objteam2).find('.lefttxt .book').css('color','red');
                  var amt = data.ODDS_profitLost;
                  $(objteam2).find('.lefttxt .book').text((amt*(-1)));
                }else{
                  $(objteam2).find('.lefttxt .book').css('color','green');
                  $(objteam2).find('.lefttxt .book').text(Math.abs(data.ODDS_profitLost));
                }
              }else if(teamname3 == i){
                objteam2 = $('.ODDS').find('.oddssteam3');
                if(parseFloat(data.ODDS_profitLost) >= 0){
                  $(objteam2).find('.lefttxt .book').css('color','red');
                  var amt = data.ODDS_profitLost;
                  $(objteam2).find('.lefttxt .book').text((amt*(-1)));
                }else{
                  $(objteam2).find('.lefttxt .book').css('color','green');
                  $(objteam2).find('.lefttxt .book').text(Math.abs(data.ODDS_profitLost));
                }
              }
          });
          }
       }
      });
    }
</script>

