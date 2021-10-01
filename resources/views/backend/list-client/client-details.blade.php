@if($isParent == true)
<div class="row">
    <div class="master-balance">
        <div class="text-center">
            <span id="down" onclick="hideShow('down');" class="far fa-arrow-alt-circle-down" id="user-balance" style="display: inline;"></span>
            <span id="up" onclick="hideShow('up');" class="far fa-arrow-alt-circle-up" style="display: none;"></span>
        </div>
        <div id="hideShowDiv" class="master-balance-detail m-t-20" id="master-balance-detail" style="display: none;">
            <ul class="row">
                @if(strtoupper(Auth::user()->roles->first()->name) == 'ADMINISTRATOR')
                <li class="col-md-12 col-sm-12">
                    <label class="col-md-2 text-left col-sm-8"><input type="text" id="amountAdmin" class="form-control"></label>
                    <span class="text-right col-md-1 col-sm-2"><input type="button" class="btn btn-diamond" onclick="addAmountAdmin();" value="Submit"></span>
                    
                </li>
<!--                <li class="col-md-4 col-sm-4">
                    <label class="col-md-8 text-left">Fixed Loss :</label>
                    <span class="text-right col-md-4">{{$mainCalArr['FixedLoss']}}</span>
                </li>-->
                @else
                <li class="col-md-12 col-sm-12">
                    
                </li>
<!--                <li class="col-md-4 col-sm-4">
                    <label class="col-md-8 text-left">Fixed Loss :</label>
                    <span class="text-right col-md-4">{{$mainCalArr['FixedLoss']}}</span>
                </li>-->
                
                @endif
                @if(strtoupper(Auth::user()->roles->first()->name) == 'ADMINISTRATOR')
                  <li class="col-md-4 col-sm-12">
                      <label class="col-md-8 col-sm-8 text-left">Upper Level Credit Referance :</label>
                      <span class="text-right col-md-4 col-sm-4">{{$mainCalArr['MasterBalance']}}</span>
                  </li>
                @else
                  <li class="col-md-4 col-sm-12">
                      <label class="col-md-8 col-sm-8 text-left">Upper Level Credit Referance :</label>
                      <span class="text-right col-md-4 col-sm-4">{{$mainCalArr['CreditReferance']}}</span>
                  </li>
                @endif
                <li class="col-md-4 col-sm-12">
                    <label class="col-md-8 col-sm-8 text-left">Down level Occupy Balance :</label>
                    <span class="text-right col-md-4 col-sm-4">{{$mainCalArr['DownLevelOccupyBalance']}}</span>
                </li>
                <li class="col-md-4 col-sm-12">
                    <label class="col-md-8 col-sm-8 text-left">Down Level Credit Referance :</label>
                    <span class="text-right col-md-4 col-sm-4">{{$mainCalArr['DownLevelCreditReferance']}}</span>
                </li>
                <li class="col-md-4 col-sm-12">
                    <label class="col-md-8 col-sm-8 text-left">Total Master Balance : </label>
                    <span class="text-right col-md-4 col-sm-4">{{$mainCalArr['MasterBalance']}}</span>
                </li>
                <li class="col-md-4 col-sm-12">
                    <label class="col-md-8 col-sm-8 text-left">Upper Level :</label>
                    <?php 
//                    dd($mainCalArr['UpperLevel']);
                    if($mainCalArr['UpperLevel'] != 0){
                        $UpperLevel = ($mainCalArr['UpperLevel']*(-1));
                    }else{
                        $UpperLevel = $mainCalArr['UpperLevel'];
                    }
//                    $UpperLevel = $mainCalArr['UpperLevel'];
                    ?>
                    <span class="text-right col-md-4 col-sm-4">{{$UpperLevel}}</span>
                </li>
                <li class="col-md-4 col-sm-12">
                    <label class="col-md-8 col-sm-8 text-left">Down Level Profit/Loss :</label>
                    <?php 
//                    if($mainCalArr['DownLevelProfitLoss'] != 0){
//                        $DownLevelProfitLoss = ($mainCalArr['DownLevelProfitLoss']*(-1));
//                    }else{
//                        $DownLevelProfitLoss = $mainCalArr['DownLevelProfitLoss']; 
//                    }
                    $DownLevelProfitLoss = $mainCalArr['DownLevelProfitLoss']; 
                    ?>
                    <span class="text-right col-md-4 col-sm-4">{{$DownLevelProfitLoss}}</span>
                </li>
                <li class="col-md-4 col-sm-12">
                    <label class="col-md-8 col-sm-8 text-left">Available Balance :</label>
                    <span class="text-right col-md-4 col-sm-4">{{$mainCalArr['AvailableBalance']}}</span>
                </li>
                <li class="col-md-4 col-sm-12">
                    <label class="col-md-8 col-sm-8 text-left">Available Balance With Profit/Loss :</label>
                    <span class="text-right col-md-4 col-sm-4">{{($mainCalArr['AvailableBalanceWithProfitLoss']*(-1))}}</span>
                </li>
                <li class="col-md-4 col-sm-12">
                    <label class="col-md-8 col-sm-8 text-left">My Profit/Loss :</label>
                    <span class="text-right col-md-4 col-sm-4">{{$mainCalArr['MyProfitLoss']}}</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@endif
