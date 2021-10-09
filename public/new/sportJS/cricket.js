function showTv() {
    if ($("#tv_status-errordetail").hasClass("show")) {
        $("#tv_status-errordetail").removeClass('show');
    } else {
        $("#tv_status-errordetail").addClass('show');
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
        $("#showBet").removeClass('show');
        clearBetVal();
    } else {
        $("#showBet").addClass('show');
    }
}

function betMsgEmpty() {
    setTimeout(function() { $('#betMsgALL').html(''); }, 1000);
    setTimeout(function() { showBet(); }, 1000);
}

function setSB(data) {
    var team1 = '';
    var team2 = '';
    if (typeof data.team1 !== 'undefined') {
        if (typeof data.team1.name !== 'undefined') {
            $('.sbTeamName1').text(data.team1.name);
        }
        if (typeof data.team1.score !== 'undefined') {
            $('.sbRun1').text(data.team1.score);
        }
        if (typeof data.team1.CRR !== 'undefined' && data.team1.CRR != '') {
            team1 += 'CRR ' + data.team1.CRR;
        }
        if (typeof data.team1.RR !== 'undefined' && data.team1.RR != '') {
            team1 += ' RR ' + data.team1.RR;
        }
    }

    if (typeof data.team2 !== 'undefined') {
        if (typeof data.team2.name !== 'undefined') {
            $('.sbTeamName2').text(data.team2.name);
        }
        if (typeof data.team2.score !== 'undefined') {
            $('.sbRun2').text(data.team2.score);
        }
        if (typeof data.team2.CRR !== 'undefined' && data.team2.CRR != '') {
            team2 += 'CRR ' + data.team2.CRR;
        }
        if (typeof data.team2.RR !== 'undefined' && data.team2.RR != '') {
            team2 += ' RR ' + data.team2.RR;
        }
    }
    $('.sbRunRate1').text(team1);
    $('.sbRunRate2').text(team2);

    if (typeof data.status !== 'undefined' && data.status != '') {
        $('.sbStatus').text(data.status);
    }
    if (typeof data.last_six_balls !== 'undefined' && data.last_six_balls != '') {
        var htmlTxt = '';
        var colorCode_6 = '#F08080';
        var colorCode_4 = '#008000';
        var colorCode_wicket = 'red';
        var colorCode_reg = 'gray';
        if (typeof data.last_six_balls.last_ball_6 !== 'undefined' && data.last_six_balls.last_ball_6 != '') {
            var colorName = colorCode_reg;
            if (data.last_six_balls.last_ball_6 == 6) {
                colorName = colorCode_6;
            }
            if (data.last_six_balls.last_ball_6 == 4) {
                colorName = colorCode_4;
            }
            if (data.last_six_balls.last_ball_6 == 'ww') {
                colorName = colorCode_wicket;
            }
            htmlTxt += '<span style="padding: 3px 10px;margin: 2px;color:#fff;border-radius:100%;background:' + colorName + '">' + data.last_six_balls.last_ball_6 + '</span>';
        }
        if (typeof data.last_six_balls.last_ball_5 !== 'undefined' && data.last_six_balls.last_ball_5 != '') {
            var colorName = colorCode_reg;
            if (data.last_six_balls.last_ball_5 == 6) {
                colorName = colorCode_6;
            }
            if (data.last_six_balls.last_ball_5 == 4) {
                colorName = colorCode_4;
            }
            if (data.last_six_balls.last_ball_5 == 'ww') {
                colorName = colorCode_wicket;
            }
            htmlTxt += '<span style="padding: 3px 10px;margin: 2px;color:#fff;border-radius:100%;background:' + colorName + '">' + data.last_six_balls.last_ball_5 + '</span>';
        }
        if (typeof data.last_six_balls.last_ball_4 !== 'undefined' && data.last_six_balls.last_ball_4 != '') {
            var colorName = colorCode_reg;
            if (data.last_six_balls.last_ball_4 == 6) {
                colorName = colorCode_6;
            }
            if (data.last_six_balls.last_ball_4 == 4) {
                colorName = colorCode_4;
            }
            if (data.last_six_balls.last_ball_4 == 'ww') {
                colorName = colorCode_wicket;
            }
            htmlTxt += '<span style="padding: 3px 10px;margin: 2px;color:#fff;border-radius:100%;background:' + colorName + '">' + data.last_six_balls.last_ball_4 + '</span>';
        }
        if (typeof data.last_six_balls.last_ball_3 !== 'undefined' && data.last_six_balls.last_ball_3 != '') {
            var colorName = colorCode_reg;
            if (data.last_six_balls.last_ball_3 == 6) {
                colorName = colorCode_6;
            }
            if (data.last_six_balls.last_ball_3 == 4) {
                colorName = colorCode_4;
            }
            if (data.last_six_balls.last_ball_3 == 'ww') {
                colorName = colorCode_wicket;
            }
            htmlTxt += '<span style="padding: 3px 10px;margin: 2px;color:#fff;border-radius:100%;background:' + colorName + '">' + data.last_six_balls.last_ball_3 + '</span>';
        }
        if (typeof data.last_six_balls.last_ball_2 !== 'undefined' && data.last_six_balls.last_ball_2 != '') {
            var colorName = colorCode_reg;
            if (data.last_six_balls.last_ball_2 == 6) {
                colorName = colorCode_6;
            }

            if (data.last_six_balls.last_ball_2 == 4) {
                colorName = colorCode_4;
            }
            if (data.last_six_balls.last_ball_2 == 'ww') {
                colorName = colorCode_wicket;
            }
            htmlTxt += '<span style="padding: 3px 10px;margin: 2px;color:#fff;border-radius:100%;background:' + colorName + '">' + data.last_six_balls.last_ball_2 + '</span>';
        }
        if (typeof data.last_six_balls.last_ball_1 !== 'undefined' && data.last_six_balls.last_ball_1 != '') {
            var colorName = colorCode_reg;
            if (data.last_six_balls.last_ball_1 == 6) {
                colorName = colorCode_6;
            }
            if (data.last_six_balls.last_ball_1 == 4) {
                colorName = colorCode_4;
            }
            if (data.last_six_balls.last_ball_1 == 'ww') {
                colorName = colorCode_wicket;
            }
            htmlTxt += '<span style="padding: 3px 10px;margin: 2px;color:#fff;border-radius:100%;background:' + colorName + '">' + data.last_six_balls.last_ball_1 + '</span>';
        }

        $('.lastSixBol2').html(htmlTxt);
    }
}

function setodd(data) {
    $.each(data, function(i, item) {

        //        $('.oddssteam'+i+' .back1t').text(Math.random());
        //        if($('.oddssteam'+i+' .back1t').text() != item.BackPrice1){
        //            $('.oddssteam'+i+' .back1t').closest('.box-1').removeClass('back');
        //            $('.oddssteam'+i+' .back1t').closest('.box-1').addClass('yellow-color');
        //        }else{
        //            $('.oddssteam'+i+' .back1t').closest('.box-1').addClass('back');
        //            $('.oddssteam'+i+' .back1t').closest('.box-1').removeClass('yellow-color');
        //        }
        if ($('.oddssteam' + i + ' .back2t').text() != item.b2) {
            $('.oddssteam' + i + ' .back2t').closest('.box-1').removeClass('back1');
            $('.oddssteam' + i + ' .back2t').closest('.box-1').addClass('yellow-color');
        } else {
            $('.oddssteam' + i + ' .back2t').closest('.box-1').addClass('back1');
            $('.oddssteam' + i + ' .back2t').closest('.box-1').removeClass('yellow-color');
        }
        if ($('.oddssteam' + i + ' .back13').text() != item.b3) {
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
        if ($('.oddssteam' + i + ' .lay2t').text() != item.l2) {
            $('.oddssteam' + i + ' .lay2t').closest('.box-1').removeClass('lay1');
            $('.oddssteam' + i + ' .lay2t').closest('.box-1').addClass('yellow-color');
        } else {
            $('.oddssteam' + i + ' .lay2t').closest('.box-1').addClass('lay1');
            $('.oddssteam' + i + ' .lay2t').closest('.box-1').removeClass('yellow-color');
        }
        if ($('.oddssteam' + i + ' .lay3t').text() != item.l3) {
            $('.oddssteam' + i + ' .lay3t').closest('.box-1').removeClass('lay2');
            $('.oddssteam' + i + ' .lay3t').closest('.box-1').addClass('yellow-color');
        } else {
            $('.oddssteam' + i + ' .lay3t').closest('.box-1').addClass('lay2');
            $('.oddssteam' + i + ' .lay3t').closest('.box-1').removeClass('yellow-color');
        }



        // console.log(item.nat);
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

function setbookmaker(data) {
    // console.log(data);
    $.each(data, function(i, item) {
        $('.bookmaker' + i + ' .team-name' + i + ' > b').text(item.nat);
        $('.bookmaker' + i + ' .back1t').text(item.b1);
        $('.bookmaker' + i + ' .back2t').text(item.b2);
        $('.bookmaker' + i + ' .back3t').text(item.b3);
        $('.bookmaker' + i + ' .back1k').text(item.bs1 + "k");
        $('.bookmaker' + i + ' .back2k').text(item.bs2 + "k");
        $('.bookmaker' + i + ' .back3k').text(item.bs3 + "k");
        $('.bookmaker' + i + ' .lay1t').text(item.l1);
        $('.bookmaker' + i + ' .lay2t').text(item.l2);
        $('.bookmaker' + i + ' .lay3t').text(item.l3);
        $('.bookmaker' + i + ' .lay1k').text(item.ls1 + "k");
        $('.bookmaker' + i + ' .lay2k').text(item.ls2 + "k");
        $('.bookmaker' + i + ' .lay3k').text(item.ls3 + "k");
        var tot = (parseFloat(item.b1) + parseFloat(item.b2) + parseFloat(item.b3));
        tot = (parseFloat(tot) + parseFloat(item.bs1) + parseFloat(item.bs2) + parseFloat(item.bs3));
        tot = (parseFloat(tot) + parseFloat(item.l1) + parseFloat(item.l2) + parseFloat(item.l3));
        tot = (parseFloat(tot) + parseFloat(item.ls1) + parseFloat(item.ls2) + parseFloat(item.ls3));
        if (parseFloat(tot) <= 0) {
            $('.bookmaker' + i).addClass('suspended');
            $('.bookmaker' + i).attr('data-title', 'SUSPENDED');
        } else {
            $('.bookmaker' + i).removeClass('suspended');
            $('.bookmaker' + i).attr('data-title', 'ACTIVE');
        }
    });
}

function addnewSession(data) {
    var oldCount = $('.SESSIONCount').length;
    var newcount = data.length;
    $.each(data, function(i, item) {
        if (parseInt(newcount) < parseInt(oldCount)) {
            if (parseInt(i) == (parseInt(newcount) - parseInt(1))) {
                for (var j = i; j < parseInt(oldCount); j++) {
                    $('.SES_' + j).closest('.SESSION').remove();
                }
            }
        } else {
            if ((parseInt(oldCount)) <= parseInt(i)) {
                var min_bet = $('#ses_min_bet').val();
                var max_bet = $('#ses_max_bet').val();
                var html = '';
                html += '<div class="fancy-tripple SESSIONCount SESSION SES_' + i + '">';
                html += '<div id="suspended" data-title="" class="table-row">';
                html += '<div class="mbox-4 float-left country-name box-6" style="border-bottom: 0px none;">';
                html += '<span class="bookmakerteamname2 team-name1"><b class="team">' + item.RunnerName + '</b></span>';
                html += '<a href="javascript:void(0);" style="display:none;" class="showBookBtn btn btn-primary tableman_btn pull-right" onclick="showBookSession(this);">Book</a>';
                html += '<br><p style="color: black;">0</p>';
                html += '</div>';
                html += '<div class="box-1 mbox-1 lay float-left text-center">';
                html += '<span class="odd font-size-14 d-block">' + item.LayPrice1 + '</span>';
                html += '<span class="oddk">' + item.LaySize1 + '</span>';
                html += '</div>';
                html += '<div class="box-1 mbox-1 back float-left text-center">';
                html += '<span class="odd font-size-14 d-block">' + item.BackPrice1 + '</span>';
                html += '<span class="oddk">' + item.BackSize1 + '</span>';
                html += '</div>';
                html += '<div class="destopViewBetLimit box-2 float-left text-right min-max" style="border-bottom: 0px none;">';
                html += '<input type="hidden" class="seq" value="' + i + '">';
                html += '<span class="d-block">Min: <span>' + min_bet + '</span></span>';
                html += '<span class="d-block">Max: <span>' + max_bet + '</span></span>';
                html += ' </div>';
                html += '</div>';
                html += '</div>';
                $('.addSessionMarket').append(html);
            }
        }

        var tot = (parseFloat(item.BackPrice1) + parseFloat(item.BackSize1) + parseFloat(item.LaySize1) + parseFloat(item.LaySize1));
        if (item.GameStatus != '' || parseInt(tot) == 0) {
            className = 'suspended';
            dataTitle = 'SUSPENDED';
            $('.SES_' + i).find('#suspended').addClass(className);
            $('.SES_' + i).find('#suspended').attr('data-title', item.GameStatus);
        } else {
            $('.SES_' + i).find('#suspended').removeClass('suspended');
            $('.SES_' + i).find('#suspended').attr('data-title', '')
        }
        var objTeamLay = $('.SES_' + i).find('.lay');
        var objTeamBack = $('.SES_' + i).find('.back');
        var objTeamName = $('.SES_' + i).find('.team');
        if (objTeamName.text() != item.RunnerName) {
            $(objTeamName).closest('div').find('.showBookBtn').hide();
        }
        $(objTeamName).text(item.RunnerName);
        $(objTeamLay).find('.odd').text(item.LayPrice1);
        $(objTeamLay).find('.oddk').text(item.LaySize1);
        $(objTeamBack).find('.odd').text(item.BackPrice1);
        $(objTeamBack).find('.oddk').text(item.BackSize1);
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

    if (betTypeAdd == 'SESSION') {
        return true;
    }
    if (betTypeAdd == 'ODDS') {
        var profitamt = ((parseFloat(getBetVal) * parseFloat(amount)) - parseFloat(amount));
        $('#bet-profit').text(calc(profitamt));

        var teamname = $('.ODDS').find('.oddssteam0 .teamName').text();
        var teamname1 = $('.ODDS').find('.oddssteam1 .teamName').text();
        objteam1 = $('.ODDS').find('.oddssteam0 .teamName');
        objteam2 = $('.ODDS').find('.oddssteam1 .teamName');
        objteam3 = $('.ODDS').find('.oddssteam2 .teamName');
        if (isMobile) {
            mobjteam1 = $('.oddstbl0').find('.profitLoss');
            mobjteam2 = $('.oddstbl1').find('.profitLoss');
            mobjteam3 = $('.oddstbl2').find('.profitLoss');
        }
    }

    if (betTypeAdd == 'BOOKMAKER') {
        var profitamt = ((parseFloat(getBetVal) * parseFloat(amount)) / parseFloat(100));
        $('#bet-profit').text(calc(profitamt));

        var teamname = $('.BOOKMAKER').find('.bookmakerteamname1 > b').text();
        var teamname1 = $('.BOOKMAKER').find('.bookmakerteamname2 > b').text();
        objteam1 = $('.BOOKMAKER').find('.bookmakerteamname1 > b');
        objteam2 = $('.BOOKMAKER').find('.bookmakerteamname2 > b');
        objteam3 = $('.BOOKMAKER').find('.bookmakerteamname3 > b');

        if (isMobile) {
            mobjteam1 = $('.oddstbl0').find('.profitLoss');
            mobjteam2 = $('.oddstbl1').find('.profitLoss');
            mobjteam3 = $('.oddstbl2').find('.profitLoss');
        }
    }
    if (teamname == $('#teamNameBet').text()) {
        var amt = profitamt;
        var betAmt = amount;
        if (betside == 'lay') {
            amt = parseFloat(amt) * parseFloat(-1);
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'red');
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'green');
            if (typeof objteam3 !== "undefined") {
                $(objteam3).closest('.country-name').find('.float-right').css('color', 'green');
            }

            if (isMobile) {
                $(mobjteam1).css('color', 'red');
                $(mobjteam2).css('color', 'green');
                if (typeof objteam3 !== "undefined") {
                    $(mobjteam3).css('color', 'green');
                }
            }
        } else {
            betAmt = parseFloat(betAmt) * parseFloat(-1);
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'green');
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'red');
            if (typeof objteam3 !== "undefined") {
                $(objteam3).closest('.country-name').find('.float-right').css('color', 'red');
            }
            if (isMobile) {
                $(mobjteam2).css('color', 'red');
                $(mobjteam1).css('color', 'green');
                if (typeof objteam3 !== "undefined") {
                    $(mobjteam3).css('color', 'red');
                }
            }
        }

        $(objteam1).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam1).closest('.country-name').find('.float-right').text(calc(amt));

        $(objteam2).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam2).closest('.country-name').find('.float-right').text(calc(betAmt));
        if (typeof objteam3 !== "undefined") {
            $(objteam3).closest('.country-name').find('.float-right').css('display', 'block');
            $(objteam3).closest('.country-name').find('.float-right').text(calc(betAmt));
        }
        if (isMobile) {
            $(mobjteam1).text(calc(amt));
            $(mobjteam2).text(calc(betAmt));
            if (typeof objteam3 !== "undefined") {
                $(mobjteam3).text(calc(betAmt));
            }
        }
    } else if (teamname1 == $('#teamNameBet').text()) {
        var amt = profitamt;
        var betAmt = amount;
        if (betside == 'lay') {
            amt = parseFloat(amt) * parseFloat(-1);
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'green');
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'red');
            if (typeof objteam3 !== "undefined") {
                $(objteam3).closest('.country-name').find('.float-right').css('color', 'green');
            }
            if (isMobile) {
                $(mobjteam2).css('color', 'red');
                $(mobjteam1).css('color', 'green');
                if (typeof objteam3 !== "undefined") {
                    $(mobjteam3).css('color', 'green');
                }
            }
        } else {
            betAmt = parseFloat(betAmt) * parseFloat(-1);
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'red');
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'green');
            if (typeof objteam3 !== "undefined") {
                $(objteam3).closest('.country-name').find('.float-right').css('color', 'red');
            }
            if (isMobile) {
                $(mobjteam1).css('color', 'red');
                $(mobjteam2).css('color', 'green');
                if (typeof objteam3 !== "undefined") {
                    $(mobjteam3).css('color', 'red');
                }
            }
        }
        $(objteam2).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam2).closest('.country-name').find('.float-right').text(calc(amt));

        $(objteam1).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam1).closest('.country-name').find('.float-right').text(calc(betAmt));
        if (typeof objteam3 !== "undefined") {
            $(objteam3).closest('.country-name').find('.float-right').css('display', 'block');
            $(objteam3).closest('.country-name').find('.float-right').text(calc(betAmt));
        }
        if (isMobile) {
            $(mobjteam2).text(calc(amt));
            $(mobjteam1).text(calc(betAmt));
            if (typeof objteam3 !== "undefined") {
                $(mobjteam3).text(calc(betAmt));
            }
        }
    } else {
        var amt = profitamt;
        var betAmt = amount;
        if (betside == 'lay') {
            amt = parseFloat(amt) * parseFloat(-1);
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'green');
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'green');
            if (typeof objteam3 !== "undefined") {
                $(objteam3).closest('.country-name').find('.float-right').css('color', 'red');
            }
            if (isMobile) {
                $(mobjteam1).css('color', 'green');
                $(mobjteam2).css('color', 'green');
                if (typeof objteam3 !== "undefined") {
                    $(mobjteam3).css('color', 'red');
                }
            }
        } else {
            betAmt = parseFloat(betAmt) * parseFloat(-1);
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'red');
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'red');
            if (typeof objteam3 !== "undefined") {
                $(objteam3).closest('.country-name').find('.float-right').css('color', 'green');
            }
            if (isMobile) {
                $(mobjteam1).css('color', 'red');
                $(mobjteam2).css('color', 'red');
                if (typeof objteam3 !== "undefined") {
                    $(mobjteam3).css('color', 'green');
                }
            }
        }
        $(objteam2).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam2).closest('.country-name').find('.float-right').text(calc(betAmt));

        $(objteam1).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam1).closest('.country-name').find('.float-right').text(calc(betAmt));
        if (typeof objteam3 !== "undefined") {
            $(objteam3).closest('.country-name').find('.float-right').css('display', 'block');
            $(objteam3).closest('.country-name').find('.float-right').text(calc(amt));
        }
        if (isMobile) {
            $(mobjteam2).text(calc(betAmt));
            $(mobjteam1).text(calc(betAmt));
            if (typeof objteam3 !== "undefined") {
                $(mobjteam3).text(calc(amt));
            }
        }
    }
}

function calc(num) {
    return Math.round(num);
    var fixed = 2;
    var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (fixed || -1) + '})?');
    if (num == '') {
        return 0;
    }
    return num.toString().match(re)[0];
}
