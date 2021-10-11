function setDetails(data, gametype) {
    // console.log(data);
    $('.roundID').text(data[0]['mid']);
    $('#roundID').val(data[0]['mid']);
    if (gametype == 'UpDown7' || gametype == 'AmarAkbarAnthony') {
        $('.cardsDiv').find('.Team0 .card1').html(data.c1);
    } else if (gametype == 'AndarBahar') {
        $('.cardsDiv').find('.MainCard').html(data.headcard);
    } else if (gametype == 'DragOnTiger') {

        $('.cardsDiv').find('.Dragon').html(data[0]['c1']);
        $('.cardsDiv').find('.Tiger').html(data[0]['c2']);
    }

    $('.timerClass').css("display", 'block');
    $('#time').text(data[0]['autotime']);
    var timerArr = (data[0]['autotime']);
    // console.log(timerArr);
    var fiveMinutes = (parseInt(timerArr));

    if (parseInt(fiveMinutes) == 0) {
        $('.ODDS').addClass("suspended");
        $('.ODDS').attr('data-title', 'SUSPENDED');
    } else {
        $('.ODDS').removeClass("suspended");
        $('.ODDS').attr('data-title', 'OPEN');
    }
}

function betMsgEmpty() {
    setTimeout(function() { $('#betMsgALL').html(''); }, 1000);
    setTimeout(function() { showBet(); }, 1000);
}

function showBet() {
    if ($("#showBet").hasClass("show")) {
        clearBetVal();
        $("#showBet").removeClass('show')
    } else {
        $("#showBet").addClass('show')
    }
}

function setResult(data, gametype) {
    $('.resultAdd').html("");
    $.each(data, function(i, item) {
        if (typeof item.result !== 'undefined') {
            if (item.result == '1') {
                var ht = '<span style="margin: 2px;" data-v-2d782e21=""><span data-v-2d782e21="" class="ball-runs playera last-result" style="color:#FFFF33;">' + item.result + '</span></span>';
            } else {
                var ht = '<span style="margin: 2px;" data-v-2d782e21=""><span data-v-2d782e21="" class="ball-runs playera last-result" style="color:#ff4500">' + item.result + '</span></span>';
            }
            var old = $('.resultAdd').html();
            $('.resultAdd').html(ht + old);
        }
    });
}

function setodd(data, gametype) {
    // console.log(data);
    $.each(data, function(i, item) {
        if (parseInt(item.status) == 0) {
            $('.ODDS').addClass("suspended");
            $('.ODDS').attr('data-title', 'SUSPENDED');
        } else {
            $('.ODDS').removeClass("suspended");
            $('.ODDS').attr('data-title', 'OPEN');
        }
        if (gametype == 'LiveTeenPati' || gametype == 'TeenPati20') {
            $('.cardsDiv').find('.Team' + i + ' .card1').html(item.c1);
            $('.cardsDiv').find('.Team' + i + ' .card2').html(item.c2);
            $('.cardsDiv').find('.Team' + i + ' .card3').html(item.c3);
        } else if (gametype == 'AndarBahar') {
            var arr = item.cards;
            $('.cardsDiv').find('.Team' + i + ' .card1').html("");
            if (arr.length <= 4) {
                $('.cardsDiv').find('.Team' + i + ' .card1').html(arr.join(""));
            } else {
                $('.cardsDiv').find('.Team' + i + ' .card1').html(arr[3]);
                $('.cardsDiv').find('.Team' + i + ' .card1').append(arr[2]);
                $('.cardsDiv').find('.Team' + i + ' .card1').append(arr[1]);
                $('.cardsDiv').find('.Team' + i + ' .card1').append(arr[0]);
            }

        } else if (gametype == 'Poker') {
            if (parseInt(i) < parseInt(2)) {
                $('.cardsDiv').find('.Team' + i + ' .card1').html(item.c1);
                $('.cardsDiv').find('.Team' + i + ' .card2').html(item.c2);
            } else if (parseInt(i) == parseInt(2)) {
                $('.cardsDiv').find('.Team' + i + ' .card1').html(item.c1);
                $('.cardsDiv').find('.Team' + i + ' .card2').html(item.c2);
                $('.cardsDiv').find('.Team' + i + ' .card3').html(item.c3);
                $('.cardsDiv').find('.Team' + i + ' .card4').html(item.c4);
                $('.cardsDiv').find('.Team' + i + ' .card5').html(item.c5);
            }
        } else if (gametype == 'CardScasin032') {
            var countNO = item.cards.length;
            $('.cardsDiv').find('.Team' + i + ' .card1').html(item.cards[0]);
            $('.cardsDiv').find('.Team' + i + ' .card4').html(item.cards[countNO - 1]);
            delete item.cards[0];
            delete item.cards[countNO - 1];
            $('.cardsDiv').find('.Team' + i + ' .card3').html(item.cards.join(""));

        }

        $('.oddssteam' + i + ' .team-name' + i + ' > b').text(item.nation);
        if ($('.oddssteam' + i + ' .back1t').text() != item.backprice1) {

            //        $('.oddssteam'+i+' .back1t').css("background-color",'yellow');
            //        $('.oddssteam'+i+' .back1t').closest('.box-1').style('color', 'yellow', 'important');
        } else {
            //        $('.oddssteam'+i+' .back1t').css("background-color",'');
        }

        $('.oddssteam' + i + ' .back1t').text(item.backprice1);
        $('.oddssteam' + i + ' .back2t').text(item.backprice2);
        $('.oddssteam' + i + ' .back3t').text(item.backprice3);

        $('.oddssteam' + i + ' .back1k').text(item.backsize1);
        $('.oddssteam' + i + ' .back2k').text(item.backsize2);
        $('.oddssteam' + i + ' .back3k').text(item.backsize3);

        $('.oddssteam' + i + ' .lay1t').text(item.layprice1);
        $('.oddssteam' + i + ' .lay2t').text(item.layprice2);
        $('.oddssteam' + i + ' .lay3t').text(item.layprice3);

        $('.oddssteam' + i + ' .lay1k').text(item.laysize1);
        $('.oddssteam' + i + ' .lay2k').text(item.laysize2);
        $('.oddssteam' + i + ' .lay3k').text(item.laysize3);

    });
}

function setPairPlus(data) {
    $.each(data, function(i, item) {
        $('.pairPlussteam' + i + ' .team-name' + i + ' > b').text(item.nation);
        $('.pairPlussteam' + i + ' .back1t').text(item.backprice1);
        $('.pairPlussteam' + i + ' .back2t').text(item.backprice2);
        $('.pairPlussteam' + i + ' .back3t').text(item.backprice3);
        $('.pairPlussteam' + i + ' .back1k').text(item.backsize1);
        $('.pairPlussteam' + i + ' .back2k').text(item.backsize2);
        $('.pairPlussteam' + i + ' .back3k').text(item.backsize3);
        $('.pairPlussteam' + i + ' .lay1t').text(item.layprice1);
        $('.pairPlussteam' + i + ' .lay2t').text(item.layprice2);
        $('.pairPlussteam' + i + ' .lay3t').text(item.layprice3);
        $('.pairPlussteam' + i + ' .lay1k').text(item.laysize1);
        $('.pairPlussteam' + i + ' .lay2k').text(item.laysize2);
        $('.pairPlussteam' + i + ' .lay3k').text(item.laysize3);
    });
}

function betODDCalculation(amount) {
    var team_name = $('#teamNameBet').text();
    var getBetVal = $('.amountint').val();
    var betside = $('#betSide').val();
    var betTypeAdd = $('#betTypeAdd').val();
    if (betTypeAdd == 'ODDS') {
        var profitamt = ((parseFloat(getBetVal) * parseFloat(amount)) - parseFloat(amount));
        $('#bet-profit').text(calc(profitamt));

        var teamname1 = $('.ODDS').find('.team-name0 > b').text();
        var teamname2 = $('.ODDS').find('.team-name1 > b').text();
        var teamname3 = $('.ODDS').find('.team-name2 > b').text();
        objteam1 = $('.ODDS').find('.team-name0 > b');
        objteam2 = $('.ODDS').find('.team-name1 > b');
        objteam3 = $('.ODDS').find('.team-name2 > b');
        objteam4 = $('.ODDS').find('.team-name3 > b');

        if (isMobile) {
            mobjteam1 = $('.showbetTot').find('.oddstbl0 > .tname');
            mobjteam2 = $('.showbetTot').find('.oddstbl1 > .tname');
            mobjteam3 = $('.showbetTot').find('.oddstbl2 > .tname');
            mobjteam4 = $('.showbetTot').find('.oddstbl3 > .tname');
        }
    }
    if (betTypeAdd == 'ODDSPAIR') {
        var profitamt = ((parseFloat(getBetVal) * parseFloat(amount)) - parseFloat(amount));
        $('#bet-profit').text(calc(profitamt));

        var teamname = $('.ODDSPAIR').find('.team-name0 > b').text();
        objteam1 = $('.ODDSPAIR').find('.team-name0 > b');
        objteam2 = $('.ODDSPAIR').find('.team-name1 > b');
        objteam3 = $('.ODDSPAIR').find('.team-name2 > b');
        objteam4 = $('.ODDSPAIR').find('.team-name3 > b');


    }
    if (teamname1 == $('#teamNameBet').text()) {
        var amt = profitamt;
        var betAmt = amount;
        if (betside == 'lay') {
            amt = parseFloat(amt) * parseFloat(-1);
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'red');
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'green');

            if (isMobile) {
                $(mobjteam1).closest('.oddstbl0').find('.profitLoss').css('color', 'red');
                $(mobjteam2).closest('.oddstbl1').find('.profitLoss').css('color', 'green');
            }

            if (typeof objteam3 !== 'undefined') {
                $(objteam3).closest('.country-name').find('.float-right').css('color', 'green');
                if (isMobile) {
                    $(mobjteam3).closest('.oddstbl3').find('.profitLoss').css('color', 'green');
                }
            }
            if (typeof objteam4 !== 'undefined') {
                $(objteam4).closest('.country-name').find('.float-right').css('color', 'green');
                if (isMobile) {
                    $(mobjteam4).closest('.oddstbl4').find('.profitLoss').css('color', 'green');
                }
            }
        } else {
            betAmt = parseFloat(betAmt) * parseFloat(-1);
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'red');
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'green');
            if (isMobile) {
                $(mobjteam2).closest('.oddstbl1').find('.profitLoss').css('color', 'red');
                $(mobjteam1).closest('.oddstbl0').find('.profitLoss').css('color', 'green');
            }
            if (typeof objteam3 !== 'undefined') {
                $(objteam3).closest('.country-name').find('.float-right').css('color', 'red');
                if (isMobile) {
                    $(mobjteam3).closest('.oddstbl2').find('.profitLoss').css('color', 'red');
                }
            }
            if (typeof objteam4 !== 'undefined') {
                $(objteam4).closest('.country-name').find('.float-right').css('color', 'red');
                if (isMobile) {
                    $(mobjteam4).closest('.oddstbl3').find('.profitLoss').css('color', 'red');
                }
            }
        }
        $(objteam1).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam1).closest('.country-name').find('.float-right').text(calc(amt));
        if (isMobile) {
            $(mobjteam1).closest('.oddstbl0').find('.profitLoss').text(calc(amt));
            $(mobjteam2).closest('.oddstbl1').find('.profitLoss').text(calc(betAmt));
        }
        $(objteam2).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam2).closest('.country-name').find('.float-right').text(calc(betAmt));
        if (typeof objteam3 !== 'undefined') {
            $(objteam3).closest('.country-name').find('.float-right').css('display', 'block');
            $(objteam3).closest('.country-name').find('.float-right').text(calc(betAmt));
            if (isMobile) {
                $(mobjteam3).closest('.oddstbl2').find('.profitLoss').text(calc(betAmt));
            }
        }
        if (typeof objteam4 !== 'undefined') {
            $(objteam4).closest('.country-name').find('.float-right').css('display', 'block');
            $(objteam4).closest('.country-name').find('.float-right').text(calc(betAmt));
            if (isMobile) {
                $(mobjteam4).closest('.oddstbl3').find('.profitLoss').text(calc(betAmt));
            }
        }
    } else if (teamname2 == $('#teamNameBet').text()) {
        var amt = profitamt;
        var betAmt = amount;
        if (betside == 'lay') {
            amt = parseFloat(amt) * parseFloat(-1);
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'red');
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'green');
            if (isMobile) {
                $(mobjteam2).closest('.oddstbl1').find('.profitLoss').css('color', 'red');
                $(mobjteam1).closest('.oddstbl0').find('.profitLoss').css('color', 'green');
            }
            if (typeof objteam3 !== 'undefined') {
                $(objteam3).closest('.country-name').find('.float-right').css('color', 'green');
                if (isMobile) {
                    $(mobjteam3).closest('.oddstbl2').find('.profitLoss').css('color', 'green');
                }
            }
            if (typeof objteam4 !== 'undefined') {
                $(objteam4).closest('.country-name').find('.float-right').css('color', 'red');
                if (isMobile) {
                    $(mobjteam4).closest('.oddstbl3').find('.profitLoss').css('color', 'green');
                }
            }

        } else {
            betAmt = parseFloat(betAmt) * parseFloat(-1);
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'red');
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'green');

            if (isMobile) {
                $(mobjteam1).closest('.oddstbl1').find('.profitLoss').css('color', 'red');
                $(mobjteam2).closest('.oddstbl0').find('.profitLoss').css('color', 'green');
            }

            if (typeof objteam3 !== 'undefined') {
                $(objteam3).closest('.country-name').find('.float-right').css('color', 'red');
                if (isMobile) {
                    $(mobjteam3).closest('.oddstbl2').find('.profitLoss').css('color', 'red');
                }
            }
            if (typeof objteam4 !== 'undefined') {
                $(objteam4).closest('.country-name').find('.float-right').css('color', 'red');
                if (isMobile) {
                    $(mobjteam4).closest('.oddstbl3').find('.profitLoss').css('color', 'red');
                }
            }
        }
        $(objteam2).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam2).closest('.country-name').find('.float-right').text(calc(amt));

        $(objteam1).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam1).closest('.country-name').find('.float-right').text(calc(betAmt));

        if (isMobile) {
            $(mobjteam1).closest('.oddstbl0').find('.profitLoss').text(calc(betAmt));
            $(mobjteam2).closest('.oddstbl1').find('.profitLoss').text(calc(amt));
        }

        if (typeof objteam3 !== 'undefined') {
            $(objteam3).closest('.country-name').find('.float-right').css('display', 'block');
            $(objteam3).closest('.country-name').find('.float-right').text(calc(betAmt));
            if (isMobile) {
                $(mobjteam3).closest('.oddstbl2').find('.profitLoss').text(calc(betAmt));
            }
        }
        if (typeof objteam4 !== 'undefined') {
            $(objteam4).closest('.country-name').find('.float-right').css('display', 'block');
            $(objteam4).closest('.country-name').find('.float-right').text(calc(betAmt));
            if (isMobile) {
                $(mobjteam4).closest('.oddstbl3').find('.profitLoss').text(calc(betAmt));
            }
        }
    } else if (teamname3 == $('#teamNameBet').text()) {
        var amt = profitamt;
        var betAmt = amount;
        if (betside == 'lay') {
            amt = parseFloat(amt) * parseFloat(-1);
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'green');
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'green');
            if (isMobile) {
                $(mobjteam1).closest('.oddstbl0').find('.profitLoss').css('color', 'green');
                $(mobjteam2).closest('.oddstbl1').find('.profitLoss').css('color', 'green');
            }
            if (typeof objteam3 !== 'undefined') {
                $(objteam3).closest('.country-name').find('.float-right').css('color', 'red');
                if (isMobile) {
                    $(mobjteam3).closest('.oddstbl2').find('.profitLoss').css('color', 'red');
                }
            }
            if (typeof objteam4 !== 'undefined') {
                $(objteam4).closest('.country-name').find('.float-right').css('color', 'green');
                if (isMobile) {
                    $(mobjteam4).closest('.oddstbl3').find('.profitLoss').css('color', 'green');
                }
            }

        } else {
            betAmt = parseFloat(betAmt) * parseFloat(-1);
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'red');
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'red');

            if (isMobile) {
                $(mobjteam1).closest('.oddstbl0').find('.profitLoss').css('color', 'red');
                $(mobjteam2).closest('.oddstbl1').find('.profitLoss').css('color', 'red');
            }

            if (typeof objteam3 !== 'undefined') {
                $(objteam3).closest('.country-name').find('.float-right').css('color', 'green');
                if (isMobile) {
                    $(mobjteam3).closest('.oddstbl2').find('.profitLoss').css('color', 'green');
                }
            }
            if (typeof objteam4 !== 'undefined') {
                $(objteam4).closest('.country-name').find('.float-right').css('color', 'red');
                if (isMobile) {
                    $(mobjteam4).closest('.oddstbl3').find('.profitLoss').css('color', 'red');
                }
            }
        }
        $(objteam2).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam2).closest('.country-name').find('.float-right').text(calc(betAmt));

        $(objteam1).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam1).closest('.country-name').find('.float-right').text(calc(betAmt));
        if (isMobile) {
            $(mobjteam1).closest('.oddstbl0').find('.profitLoss').text(calc(betAmt));
            $(mobjteam2).closest('.showbetTot1').find('.profitLoss').text(calc(betAmt));
        }
        if (typeof objteam3 !== 'undefined') {
            $(objteam3).closest('.country-name').find('.float-right').css('display', 'block');
            $(objteam3).closest('.country-name').find('.float-right').text(calc(amt));
            if (isMobile) {
                $(mobjteam3).closest('.oddstbl2').find('.profitLoss').text(calc(amt));
            }
        }
        if (typeof objteam4 !== 'undefined') {
            $(objteam4).closest('.country-name').find('.float-right').css('display', 'block');
            $(objteam4).closest('.country-name').find('.float-right').text(calc(betAmt));
            if (isMobile) {
                $(mobjteam4).closest('.oddstbl3').find('.profitLoss').text(calc(betAmt));
            }
        }
    } else {
        var amt = profitamt;
        var betAmt = amount;
        if (betside == 'lay') {
            amt = parseFloat(amt) * parseFloat(-1);
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'green');
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'green');
            if (isMobile) {
                $(mobjteam1).closest('.oddstbl0').find('.profitLoss').css('color', 'green');
                $(mobjteam2).closest('.oddstbl1').find('.profitLoss').css('color', 'green');
            }
            if (typeof objteam3 !== 'undefined') {
                $(objteam3).closest('.country-name').find('.float-right').css('color', 'green');
                if (isMobile) {
                    $(mobjteam3).closest('.oddstbl2').find('.profitLoss').css('color', 'green');
                }
            }
            if (typeof objteam4 !== 'undefined') {
                $(objteam4).closest('.country-name').find('.float-right').css('color', 'red');
                if (isMobile) {
                    $(mobjteam4).closest('.oddstbl3').find('.profitLoss').css('color', 'red');
                }
            }

        } else {
            betAmt = parseFloat(betAmt) * parseFloat(-1);
            $(objteam1).closest('.country-name').find('.float-right').css('color', 'red');
            $(objteam2).closest('.country-name').find('.float-right').css('color', 'red');

            if (isMobile) {
                $(mobjteam1).closest('.oddstbl0').find('.profitLoss').css('color', 'red');
                $(mobjteam2).closest('.oddstbl1').find('.profitLoss').css('color', 'red');
            }
            if (typeof objteam3 !== 'undefined') {
                $(objteam3).closest('.country-name').find('.float-right').css('color', 'red');
                if (isMobile) {
                    $(mobjteam3).closest('.oddstbl2').find('.profitLoss').css('color', 'red');
                }
            }
            if (typeof objteam4 !== 'undefined') {
                $(objteam4).closest('.country-name').find('.float-right').css('color', 'green');
                if (isMobile) {
                    $(mobjteam4).closest('.oddstbl3').find('.profitLoss').css('color', 'green');
                }
            }
        }
        $(objteam2).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam2).closest('.country-name').find('.float-right').text(calc(betAmt));

        $(objteam1).closest('.country-name').find('.float-right').css('display', 'block');
        $(objteam1).closest('.country-name').find('.float-right').text(calc(betAmt));
        if (isMobile) {
            $(mobjteam1).closest('.oddstbl0').find('.profitLoss').text(calc(betAmt));
            $(mobjteam2).closest('.oddstbl1').find('.profitLoss').text(calc(betAmt));
        }
        if (typeof objteam3 !== 'undefined') {
            $(objteam3).closest('.country-name').find('.float-right').css('display', 'block');
            $(objteam3).closest('.country-name').find('.float-right').text(calc(betAmt));
            if (isMobile) {
                $(mobjteam3).closest('.oddstbl2').find('.profitLoss').text(calc(betAmt));
            }
        }
        if (typeof objteam4 !== 'undefined') {
            $(objteam4).closest('.country-name').find('.float-right').css('display', 'block');
            $(objteam4).closest('.country-name').find('.float-right').text(calc(amt));
            if (isMobile) {
                $(mobjteam4).closest('.oddstbl3').find('.profitLoss').text(calc(amt));
            }
        }
    }
}


function calc(num) {
    return Math.round(num);
    var fixed = 2;
    var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (fixed || -1) + '})?');
    return num.toString().match(re)[0];
}
