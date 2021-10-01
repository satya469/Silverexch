<div id="sidebar-right" class="col-md-3 sidebar-right sidebar-right-bar" style="position: relative; top: 0px; right: 0px; width: 25.5%;">
    <div class="ps">
        <div class="sidebar-right-inner">
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
                                        <a href="javascript:void(0);" onclick="showBet();" class="text-danger">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                    <td id="teamNameBet"></td>
                                    <td class="bet-odds">
                                        <div class="form-group">
                                            <input placeholder="0" type="text" required="required" maxlength="4" readonly="readonly" class="amountint" style="width: 45px; vertical-align: middle;"> 
                                        </div>
                                    </td>
                                    <td class="bet-stakes">
                                        <div class="form-group bet-stake">
                                            <input maxlength="10" name="betAmount" id="betAmount" type="number" required="required" type="text">
                                        </div>
                                    </td>
                                    <td id="bet-profit" class="text-right bet-profit"></td>
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
                        </table

                        <div class="col-md-12">
                            <input type="hidden" id="betTypeAdd" value="">
                            <input type="hidden" id="betSide" value="">
                            <input type="hidden" id="betTeamProfit" value="">
                            <input type="hidden" id="betOddk" value="">
                            <input type="hidden" id="betPosition" value="">
                            <span class="" id="betMsgALL"></span> 
                            <button type="button" onclick="showBet();" class="btn btn-sm btn-danger float-left">
                                Reset
                            </button> 

                            <button type="button" onclick="saveBet();" class="btn btn-sm btn-success float-right m-b-5">
                                <!----> Submit
                            </button>
                        </div>

                    </form>
                    <!--</div>-->
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
                                        Team Name
                                    </th>
                                    <th class="text-left">
                                        Odds
                                    </th>
                                    <th class="text-left">
                                        Stake
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3" class="text-center">No records Found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
            </div>
            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
            </div>
        </div>
    </div>