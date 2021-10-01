function setodd(data){
    $.each(data, function(i, item) {
      
//      if($('.oddssteam'+i+' .back1t').text() != item.BackPrice1){
//            $('.oddssteam'+i+' .back1t').closest('.box-1').removeClass('back');
//            $('.oddssteam'+i+' .back1t').closest('.box-1').addClass('yellow-color');
//        }else{
//            $('.oddssteam'+i+' .back1t').closest('.box-1').addClass('back');
//            $('.oddssteam'+i+' .back1t').closest('.box-1').removeClass('yellow-color');
//        }
        if($('.oddssteam'+i+' .back2t').text() != item.BackPrice2){
            $('.oddssteam'+i+' .back2t').closest('.box-1').removeClass('back1');
            $('.oddssteam'+i+' .back2t').closest('.box-1').addClass('yellow-color');
        }else{
            $('.oddssteam'+i+' .back2t').closest('.box-1').addClass('back1');
            $('.oddssteam'+i+' .back2t').closest('.box-1').removeClass('yellow-color');
        }
        if($('.oddssteam'+i+' .back13').text() != item.BackPrice3){
            $('.oddssteam'+i+' .back13').closest('.box-1').removeClass('back2');
            $('.oddssteam'+i+' .back13').closest('.box-1').addClass('yellow-color');
        }else{
            $('.oddssteam'+i+' .back13').closest('.box-1').addClass('back2');
            $('.oddssteam'+i+' .back13').closest('.box-1').removeClass('yellow-color');
        }
        
        
        
//        if($('.oddssteam'+i+' .lay1t').text() != item.LayPrice1){
//            $('.oddssteam'+i+' .lay1t').closest('.box-1').removeClass('lay');
//            $('.oddssteam'+i+' .lay1t').closest('.box-1').addClass('yellow-color');
//        }else{
//            $('.oddssteam'+i+' .lay1t').closest('.box-1').addClass('lay');
//            $('.oddssteam'+i+' .lay1t').closest('.box-1').removeClass('yellow-color');
//        }
        if($('.oddssteam'+i+' .lay2t').text() != item.LayPrice2){
            $('.oddssteam'+i+' .lay2t').closest('.box-1').removeClass('lay1');
            $('.oddssteam'+i+' .lay2t').closest('.box-1').addClass('yellow-color');
        }else{
            $('.oddssteam'+i+' .lay2t').closest('.box-1').addClass('lay1');
            $('.oddssteam'+i+' .lay2t').closest('.box-1').removeClass('yellow-color');
        }
        if($('.oddssteam'+i+' .lay3t').text() != item.LayPrice3){
            $('.oddssteam'+i+' .lay3t').closest('.box-1').removeClass('lay2');
            $('.oddssteam'+i+' .lay3t').closest('.box-1').addClass('yellow-color');
        }else{
            $('.oddssteam'+i+' .lay3t').closest('.box-1').addClass('lay2');
            $('.oddssteam'+i+' .lay3t').closest('.box-1').removeClass('yellow-color');
        }
        
      $('.oddssteam'+i+' .back1t').text(item.BackPrice1);
      $('.oddssteam'+i+' .back2t').text(item.BackPrice2);
      $('.oddssteam'+i+' .back3t').text(item.BackPrice3);
      $('.oddssteam'+i+' .back1k').text(item.BackSize1+"k");
      $('.oddssteam'+i+' .back2k').text(item.BackSize2+"k");
      $('.oddssteam'+i+' .back3k').text(item.BackSize3+"k");
      $('.oddssteam'+i+' .lay1t').text(item.LayPrice1);
      $('.oddssteam'+i+' .lay2t').text(item.LayPrice2);
      $('.oddssteam'+i+' .lay3t').text(item.LayPrice3);
      $('.oddssteam'+i+' .lay1k').text(item.LaySize1+"k");
      $('.oddssteam'+i+' .lay2k').text(item.LaySize2+"k");
      $('.oddssteam'+i+' .lay3k').text(item.LaySize3+"k");
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
    var i = 0;
    var sesssionArr = [];
    $.each(data, function(j, item) {
      var ret = item.RunnerName.split(" ");
      var text = ret[1].replace('.','');
      
        if($('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back2t').text() != item.BackPrice2){
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back2t').closest('.box-1').removeClass('back1');
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back2t').closest('.box-1').addClass('yellow-color');
        }else{
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back2t').closest('.box-1').addClass('back1');
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back2t').closest('.box-1').removeClass('yellow-color');
        }
        if($('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back3t').text() != item.BackPrice3){
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back3t').closest('.box-1').removeClass('back2');
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back3t').closest('.box-1').addClass('yellow-color');
        }else{
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back3t').closest('.box-1').addClass('back2');
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back3t').closest('.box-1').removeClass('yellow-color');
        }
        
        if($('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay2t').text() != item.LayPrice2){
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay2t').closest('.box-1').removeClass('lay1');
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay2t').closest('.box-1').addClass('yellow-color');
        }else{
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay2t').closest('.box-1').addClass('lay1');
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay2t').closest('.box-1').removeClass('yellow-color');
        }
        if($('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay3t').text() != item.LayPrice3){
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay3t').closest('.box-1').removeClass('lay2');
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay3t').closest('.box-1').addClass('yellow-color');
        }else{
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay3t').closest('.box-1').addClass('lay2');
            $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay3t').closest('.box-1').removeClass('yellow-color');
        }
      sesssionArr.push('OVER_UNDER_'+text);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back1t').text(item.BackPrice1);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back2t').text(item.BackPrice2);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back3t').text(item.BackPrice3);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back1k').text(item.BackSize1+"k");
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back2k').text(item.BackSize2+"k");
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .back3k').text(item.BackSize3+"k");
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay1t').text(item.LayPrice1);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay2t').text(item.LayPrice2);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay3t').text(item.LayPrice3);
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay1k').text(item.LaySize1+"k");
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay2k').text(item.LaySize2+"k");
      $('.OVER_UNDER_'+text+' .OVER_UNDER_'+i+' .lay3k').text(item.LaySize3+"k");

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
  function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
  }  
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
        $("#showBet").removeClass('show');
    }else{
        $("#showBet").addClass('show');
    }
    $
  }
  
  function myBet(){
    if($("#myBet").hasClass("show")){
      clearBetVal();  
      $("#myBet").removeClass('show')
    }else{
      $("#myBet").addClass('show')
    }
    showBet();
  }
  
  function betODDCalculation(amount){
    var isMobile = false; //initiate as false
    // device detection
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
        isMobile = true;
    }
      var team_name = $('#teamNameBet').text();
      var getBetVal = $('.amountint').val();
      var betside = $('#betSide').val();
      var betTypeAdd = $('#betTypeAdd').val();
     
      if(betTypeAdd == 'ODDS'){
        var profitamt = ((parseFloat(getBetVal)*parseFloat(amount))-parseFloat(amount));
        $('#bet-profit').text(calc(profitamt));
      
        var teamname1 = $('.ODDS').find('.oddssteam0 .team').text();
        var teamname2 = $('.ODDS').find('.oddssteam1 .team').text();
        objteam1 = $('.ODDS').find('.oddssteam0 .team');
        objteam2 = $('.ODDS').find('.oddssteam1 .team');
        objteam3 = $('.ODDS').find('.oddssteam2 .team');
        
        if(isMobile){
          mobjteam1 = $('.oddstbl0').find('.profitLoss123');
          mobjteam2 = $('.oddstbl1').find('.profitLoss123');
          mobjteam3 = $('.oddstbl2').find('.profitLoss123');
        }
        
      }
      if(betTypeAdd == 'BOOKMAKER'){
        var profitamt = ((parseFloat(getBetVal)*parseFloat(amount))/parseFloat(100));
        $('#bet-profit').text(calc(profitamt));
      
        var teamname = $('.BOOKMAKER').find('.bookmakerteamname1 > b').text();
        objteam1 = $('.BOOKMAKER').find('.bookmakerteamname1 > b');
        objteam2 = $('.BOOKMAKER').find('.bookmakerteamname2 > b');
        
        
      }
      
      if(betTypeAdd == 'SESSION'){
        var profitamt = ((parseFloat(getBetVal)*parseFloat(amount))-parseFloat(amount));
        $('#bet-profit').text(calc(profitamt));
        var opttext = $('#betoption').val();
        var teamname1 = $('.'+opttext).find('.OVER_UNDER_0 .team').text();
        var teamname2 = $('.'+opttext).find('.OVER_UNDER_1 .team').text();
        objteam1 = $('.'+opttext).find('.OVER_UNDER_0 .team');
        objteam2 = $('.'+opttext).find('.OVER_UNDER_1 .team');
        
        if(isMobile){
          mobjteam1 = $('.oddstbl0').find('.profitLoss123');
          mobjteam2 = $('.oddstbl1').find('.profitLoss123');
        }
      }
      
      if(teamname1 == $('#teamNameBet').text()){
        var amt = profitamt;
        var betAmt = amount;
        if(betside == 'lay'){
          amt = parseFloat(amt)*parseFloat(-1);
          
          $(objteam1).closest('.country-name').find('.float-right').css('color','red');
          $(objteam2).closest('.country-name').find('.float-right').css('color','green');
          if(isMobile){
            $(mobjteam1).css('color','red');
            $(mobjteam2).css('color','green');
          }
          if(betTypeAdd != 'SESSION'){
            $(objteam3).closest('.country-name').find('.float-right').css('color','green');
            if(isMobile){
              $(mobjteam3).css('color','green');
            }
          }
        }else{
          betAmt = parseFloat(betAmt)*parseFloat(-1);
          
          if(betTypeAdd != 'SESSION'){
            $(objteam3).closest('.country-name').find('.float-right').css('color','red');
            if(isMobile){
              $(mobjteam3).css('color','red');
            }
          }
          if(isMobile){
            $(mobjteam1).css('color','green');
            $(mobjteam2).css('color','red');
          }
          $(objteam2).closest('.country-name').find('.float-right').css('color','red');
          $(objteam1).closest('.country-name').find('.float-right').css('color','green');
        }
        $(objteam1).closest('.country-name').find('.float-right').css('display','block');
        $(objteam1).closest('.country-name').find('.float-right').text(calc(amt));
        
        $(objteam2).closest('.country-name').find('.float-right').css('display','block');
        $(objteam2).closest('.country-name').find('.float-right').text(calc(betAmt));
        if(isMobile){
          $(mobjteam1).text(calc(amt));
          $(mobjteam2).text(calc(betAmt));
        }
        if(betTypeAdd != 'SESSION'){
          $(objteam3).closest('.country-name').find('.float-right').css('display','block');
          $(objteam3).closest('.country-name').find('.float-right').text(calc(betAmt));
          if(isMobile){
            $(mobjteam3).text(calc(betAmt));
          }
        }
      }else if(teamname2 == $('#teamNameBet').text()){
        var amt = profitamt;
        var betAmt = amount;
        if(betside == 'lay'){
          amt = parseFloat(amt)*parseFloat(-1);
          
          $(objteam2).closest('.country-name').find('.float-right').css('color','red');
          $(objteam1).closest('.country-name').find('.float-right').css('color','green');
          if(isMobile){
            $(mobjteam2).css('color','red');
            $(mobjteam1).css('color','green');
          }
          if(betTypeAdd != 'SESSION'){
            $(objteam3).closest('.country-name').find('.float-right').css('color','green');
            if(isMobile){
              $(mobjteam3).css('color','green');
            }
          }
        }else{
          betAmt = parseFloat(betAmt)*parseFloat(-1);
          $(objteam1).closest('.country-name').find('.float-right').css('color','red');
          $(objteam2).closest('.country-name').find('.float-right').css('color','green');
          if(isMobile){
            $(mobjteam1).css('color','red');
            $(mobjteam2).css('color','green');
          }
          if(betTypeAdd != 'SESSION'){
            $(objteam3).closest('.country-name').find('.float-right').css('color','red');
            if(isMobile){
              $(mobjteam3).css('color','red');
            }
          }
        }
        $(objteam1).closest('.country-name').find('.float-right').css('display','block');
        $(objteam1).closest('.country-name').find('.float-right').text(calc(betAmt));
        
        $(objteam2).closest('.country-name').find('.float-right').css('display','block');
        $(objteam2).closest('.country-name').find('.float-right').text(calc(amt));
        if(isMobile){
          $(mobjteam1).text(calc(betAmt));
          $(mobjteam2).text(calc(amt));
        }
        if(betTypeAdd != 'SESSION'){
          $(objteam3).closest('.country-name').find('.float-right').css('display','block');
          $(objteam3).closest('.country-name').find('.float-right').text(calc(betAmt));
          if(isMobile){
            $(mobjteam3).text(calc(betAmt));
          }
        }
      }else{
        var amt = profitamt;
        var betAmt = amount;
        if(betside == 'lay'){
          amt = parseFloat(amt)*parseFloat(-1);
          if(objteam3.length){
            $(objteam3).closest('.country-name').find('.float-right').css('color','red');
            if(isMobile){
              $(mobjteam3).css('color','red');
            }
          }
          
          $(objteam2).closest('.country-name').find('.float-right').css('color','green');
          $(objteam1).closest('.country-name').find('.float-right').css('color','green');
         
          if(isMobile){
            $(mobjteam1).css('color','green');
            $(mobjteam2).css('color','green');
          }
        }else{
          betAmt = parseFloat(betAmt)*parseFloat(-1);
          $(objteam1).closest('.country-name').find('.float-right').css('color','red');
          $(objteam2).closest('.country-name').find('.float-right').css('color','red');
          
          if(isMobile){
            $(mobjteam1).css('color','red');
            $(mobjteam2).css('color','red');
          }
          if(objteam3.length){
            $(objteam3).closest('.country-name').find('.float-right').css('color','green');
            if(isMobile){
              $(mobjteam3).css('color','green');
            }
            
          }
        }
        if(objteam3.length){
          $(objteam3).closest('.country-name').find('.float-right').css('display','block');
          $(objteam3).closest('.country-name').find('.float-right').text(calc(amt));
          if(isMobile){
            $(mobjteam3).text(calc(amt));
          }
        }
        $(objteam2).closest('.country-name').find('.float-right').css('display','block');
        $(objteam2).closest('.country-name').find('.float-right').text(calc(betAmt));
        
        $(objteam1).closest('.country-name').find('.float-right').css('display','block');
        $(objteam1).closest('.country-name').find('.float-right').text(calc(betAmt));
        
        if(isMobile){
          $(mobjteam1).text(calc(betAmt));
          $(mobjteam2).text(calc(betAmt));
        }
      }
    }
    
  function calc(num) {
      if(num == '' || isNaN(num)){
          num = 0;
      }
      return  Math.round(num);
      var fixed = 2;
      var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (fixed || -1) + '})?');
      return num.toString().match(re)[0];
  }
  function betMsgEmpty(){
    setTimeout(function(){ $('#betMsgALL').html(''); }, 1000);
    setTimeout(function(){ showBet(); }, 1000);

  }