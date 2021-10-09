function showTv() {
    if ($("#tv_status-errordetail").hasClass("show")) {
        $("#tv_status-errordetail").removeClass('show')
    } else {
        $("#tv_status-errordetail").addClass('show')
    }
}

function showTvVideo(id, obj) {
    $('.allVideo').hide();
    $('.navli').css('background', 'red');
    $('#' + id).show();
    $(obj).css('background', '#0088cc');
}

function showBet() {
    if ($("#showBet").hasClass("show")) {
        clearBetVal();
        $("#showBet").removeClass('show')
    } else {
        $("#showBet").addClass('show')
    }
}

function betMsgEmpty() {
    setTimeout(function() { $('#betMsgALL').html(''); }, 1000);
    setTimeout(function() { showBet(); }, 1000);
}

function setodd(data) {
    $.each(data, function(i, item) {
        //        if($('.oddssteam'+i+' .back1t').text() != item.BackPrice1){
        //            $('.oddssteam'+i+' .back1t').closest('.box-1').removeClass('back');
        //            $('.oddssteam'+i+' .back1t').closest('.box-1').addClass('yellow-color');
        //        }else{
        //            $('.oddssteam'+i+' .back1t').closest('.box-1').addClass('back');
        //            $('.oddssteam'+i+' .back1t').closest('.box-1').removeClass('yellow-color');
        //        }
        if ($('.oddssteam' + i + ' .back2t').text() != item.BackPrice2) {
            $('.oddssteam' + i + ' .back2t').closest('.box-1').removeClass('back1');
            $('.oddssteam' + i + ' .back2t').closest('.box-1').addClass('yellow-color');
        } else {
            $('.oddssteam' + i + ' .back2t').closest('.box-1').addClass('back1');
            $('.oddssteam' + i + ' .back2t').closest('.box-1').removeClass('yellow-color');
        }
        if ($('.oddssteam' + i + ' .back13').text() != item.BackPrice3) {
            $('.oddssteam' + i + ' .back13').closest('.box-1').removeClass('back2');
            $('.oddssteam' + i + ' .back13').closest('.box-1').addClass('yellow-color');
        } else {
            $('.oddssteam' + i + ' .back13').closest('.box-1').addClass('back2');
            $('.oddssteam' + i + ' .back13').closest('.box-1').removeClass('yellow-color');
        }



        //        if($('.oddssteam'+i+' .lay1t').text() != item.LayPrice1){
        //            $('.oddssteam'+i+' .lay1t').closest('.box-1').removeClass('lay');
        //            $('.oddssteam'+i+' .lay1t').closest('.box-1').addClass('yellow-color');
        //        }else{
        //            $('.oddssteam'+i+' .lay1t').closest('.box-1').addClass('lay');
        //            $('.oddssteam'+i+' .lay1t').closest('.box-1').removeClass('yellow-color');
        //        }
        if ($('.oddssteam' + i + ' .lay2t').text() != item.LayPrice2) {
            $('.oddssteam' + i + ' .lay2t').closest('.box-1').removeClass('lay1');
            $('.oddssteam' + i + ' .lay2t').closest('.box-1').addClass('yellow-color');
        } else {
            $('.oddssteam' + i + ' .lay2t').closest('.box-1').addClass('lay1');
            $('.oddssteam' + i + ' .lay2t').closest('.box-1').removeClass('yellow-color');
        }
        if ($('.oddssteam' + i + ' .lay3t').text() != item.LayPrice3) {
            $('.oddssteam' + i + ' .lay3t').closest('.box-1').removeClass('lay2');
            $('.oddssteam' + i + ' .lay3t').closest('.box-1').addClass('yellow-color');
        } else {
            $('.oddssteam' + i + ' .lay3t').closest('.box-1').addClass('lay2');
            $('.oddssteam' + i + ' .lay3t').closest('.box-1').removeClass('yellow-color');
        }

        $('.oddssteam' + i + ' .team-name' + i + ' > b').text(item.nat);
        $('.oddssteam' + i + ' .back1t').text(item.b1);
        $('.oddssteam' + i + ' .back2t').text(item.b2);
        $('.oddssteam' + i + ' .back3t').text(item.b3);
        $('.oddssteam' + i + ' .back1k').text(item.bs1 + "k");
        $('.oddssteam' + i + ' .back2k').text(item.bs2 + "k");
        $('.oddssteam' + i + ' .back3k').text(item.bs3 + "k");
        $('.oddssteam' + i + ' .lay1t').text(item.l1);
        $('.oddssteam' + i + ' .lay2t').text(item.l2);
        $('.oddssteam' + i + ' .lay3t').text(item.l3);
        $('.oddssteam' + i + ' .lay1k').text(item.ls1 + "k");
        $('.oddssteam' + i + ' .lay2k').text(item.ls2 + "k");
        $('.oddssteam' + i + ' .lay3k').text(item.ls3 + "k");

        var tot = (parseFloat(item.b1) + parseFloat(item.b2) + parseFloat(item.b3));
        tot = (parseFloat(tot) + parseFloat(item.bs1) + parseFloat(item.bs2) + parseFloat(item.bs3));
        tot = (parseFloat(tot) + parseFloat(item.l1) + parseFloat(item.l2) + parseFloat(item.l3));
        tot = (parseFloat(tot) + parseFloat(item.ls1) + parseFloat(item.ls2) + parseFloat(item.ls3));

        if (parseFloat(tot) <= 0) {
            $('.oddssteam' + i).closest('.table-row').addClass('suspended');
            $('.oddssteam' + i).closest('.table-row').attr('data-title', 'SUSPENDED');
        } else {
            $('.oddssteam' + i).closest('.table-row').removeClass('suspended');
            $('.oddssteam' + i).closest('.table-row').attr('data-title', 'ACTIVE');
        }
    });
}

function myBet() {
    if ($("#showBet").hasClass("show")) {
        clearBetVal();
        $("#showBet").removeClass('show');
    } else {
        $('#showBet').addClass('show');
    }
}

function betODDCalculation(amount) {
    var team_name = $('#teamNameBet').text();
    var getBetVal = $('.amountint').val();
    var betside = $('#betSide').val();
    var betTypeAdd = $('#betTypeAdd').val();
    if (betTypeAdd == 'ODDS') {
        var profitamt = ((parseFloat(getBetVal) * parseFloat(amount)) - parseFloat(amount));
        $('#bet-profit').text(calc(profitamt));

        var teamname = $('.ODDS').find('.oddteamname1 > b').text();
        objteam1 = $('.ODDS').find('.oddteamname1 > b');
        objteam2 = $('.ODDS').find('.oddteamname2 > b');

        if (isMobile) {
            mobjteam1 = $('.oddstbl0').find('.profitLoss');
            mobjteam2 = $('.oddstbl1').find('.profitLoss');
        }
    }

    if (betTypeAdd == 'BOOKMAKER') {
        var profitamt = ((parseFloat(getBetVal) * parseFloat(amount)) / parseFloat(100));
        $('#bet-profit').text(calc(profitamt));

        var teamname = $('.BOOKMAKER').find('.bookmakerteamname1 > b').text();
        objteam1 = $('.BOOKMAKER').find('.bookmakerteamname1 > b');
        objteam2 = $('.BOOKMAKER').find('.bookmakerteamname2 > b');
    }
    if (teamname == $('#teamNameBet').text()) {
        var amt = profitamt;
        var betAmt = amount;
        if (betside == 'lay') {
            amt = parseFloat(amt) * parseFloat(-1);

            $(objteam1).closest('.country-name').find('.float-right').css('color', 'red');
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'green');

            if (isMobile) {
                $(mobjteam1).css('color', 'red');
                $(mobjteam2).css('color', 'green');
            }
        } else {
            betAmt = parseFloat(betAmt) * parseFloat(-1);
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'red');
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'green');
            if (isMobile) {
                $(mobjteam2).css('color', 'red');
                $(mobjteam1).css('color', 'green');
            }
        }
        $(objteam1).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam1).closest('.country-name').find('.float-right').text(calc(amt));

        $(objteam2).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam2).closest('.country-name').find('.float-right').text(calc(betAmt));

        if (isMobile) {
            $(mobjteam1).text(calc(amt));
            $(mobjteam2).text(calc(betAmt));
        }
    } else {
        var amt = profitamt;
        var betAmt = amount;
        if (betside == 'lay') {
            amt = parseFloat(amt) * parseFloat(-1);
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'red');
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'green');
            if (isMobile) {
                $(mobjteam2).css('color', 'red');
                $(mobjteam1).css('color', 'green');
            }
        } else {
            betAmt = parseFloat(betAmt) * parseFloat(-1);
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'red');
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'green');

            if (isMobile) {
                $(mobjteam1).css('color', 'red');
                $(mobjteam2).css('color', 'green');
            }
        }
        $(objteam2).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam2).closest('.country-name').find('.float-right').text(calc(amt));

        $(objteam1).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam1).closest('.country-name').find('.float-right').text(calc(betAmt));

        if (isMobile) {
            $(mobjteam2).text(calc(amt));
            $(mobjteam1).text(calc(betAmt));
        }
    }
}

function calc(num) {
    return Math.round(num);
    var fixed = 2;
    var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (fixed || -1) + '})?');
    return num.toString().match(re)[0];
}
