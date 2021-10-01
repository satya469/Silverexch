<div class="modal fade" id="myModalBetView" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-left headingText">Place Bet</h4>
          <span  class="close" data-dismiss="modal">&times;</span>
        </div>
        <div class="modal-body" id="modelBodyID">
          
            <div id="showBet" class="collapse" style="display: block;">

            <form>
              <table class="coupon-table table table-borderedless">
<!--                <thead>
                  <tr>
                    <th style="width: 35%; text-align: left;">(Bet for)</th>
                    <th style="width: 25%; text-align: left;">Odds</th>
                    <th style="width: 15%; text-align: left;">Stake</th>
                    <th style="width: 15%; text-align: right;">Profit</th>
                  </tr>
                </thead>-->
                <tbody>
                   <tr>
                        <td id="teamNameBet" colspan="2"></td>
                        <td class="pull-right float-right">
                            <div class="form-group">
                              <input placeholder="0" type="text" required="required" maxlength="4" readonly="readonly" class="amountint" style="width: 75px; vertical-align: middle;"> 
                            </div>
                        </td>
                    </tr>  
                  <tr>
                    <td class="bet-stakes pull-left">
                      <div class="form-group bet-stake">
                          <input maxlength="10" style="margin-top: 18px;" name="betAmount" id="betAmount" type="text" required="required" type="text">
                      </div>
                    </td>
                    <td>
                        <button type="button" onclick="saveBet();" class="btn btn-sm btn-success submitBtn m-b-5">Submit</button>
                    </td>
                    <td id="bet-profit" class="text-right bet-profit text-center">0</td>
                  </tr>
                  <tr>
                    <td colspan="3" class="value-buttons" style="padding: 5px;">
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
                  <span></span>  
                <input type="hidden" id="betTypeAdd" value="">
                <input type="hidden" id="betSide" value="">
                <input type="hidden" id="betTeamProfit" value="">
                <input type="hidden" id="betOddk" value="">
                <input type="hidden" id="betPosition" value="">
                <span class="" id="betMsgALL"></span> 
                <!--<button type="button" onclick="saveBet();" class="btn btn-sm btn-success float-right m-b-5">Submit</button>-->
            </form>
            <table class="table showbetTot table-borderedless">
                
            </table>
          </div>
        </div>
        </div>
    </div>
  </div>