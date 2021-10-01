<?php
use App\Http\Controllers\Backend\MyBetsController;
$userModels = MyBetsController::getChildUserRoleOnlyList();
?>

<div class="modal fade" id="viewMore" role="dialog">
    <div class="modal-dialog" style="max-width: 90%;">
        <!-- Modal content-->
        <div class="modal-content" style="padding: 0px;">
            <div class="modal-header">
                <h4 class="modal-title text-left">View More Bets</h4>
                <span  class="close" data-dismiss="modal">&times;</span>
            </div>
            <div class="modal-body" id="viewMoreBodyID" >
                <div class="col-sm-12" style="margin-bottom: 20px">
                    <a  class="btn btn-primary bets metchBetsshow" href="javascript:void(0);" onclick="showDiv('metchBetsshow')">Match Bets</a>
                    <a  class="btn bets unMatchbet" href="javascript:void(0);" onclick="showDiv('unMatchbet')">UNMatch Bets</a>
                    <a  class="btn bets deletedBet" href="javascript:void(0);" onclick="showDiv('deletedBet')">Deleted Bets</a>
                </div>
                <div class="matchBetTEXT">
                    <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12 col-md-1" style="float: left;margin: 10px;">
                            User Name
                        </div>
                        <div class="col-sm-12 col-md-3" style="float: left;margin: 10px;">
                            <select id="userid" class="form-control select2" style="width: 100%;">
                                <option value="ALL">ALL</option>
                                <?php foreach($userModels as $key=>$user){ ?>
                                <option value="<?= $user->id ?>"><?= $user->first_name ?></option>
                                <?php } ?>
                                
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-1" style="float: left;margin: 10px;">
                            Amount
                        </div>
                        <div class="col-sm-12 col-md-4" style="float: left;margin: 10px;">
                            <input type="text" style="width: 45%;display: initial;" id="sAmount" class="form-control">
                            <input type="text" style="width: 45%;display: initial;" id="eAmount" class="form-control">
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 col-md-1" style="float: left;margin: 10px;">
                            IP Address
                        </div>
                        <div class="col-sm-12 col-md-3" style="float: left;margin: 10px;">
                            <input type="text" id="ipAddress" style="width: 100%;" class="form-control">
                        </div>
                        <div class="col-sm-12 col-md-1" style="float: left;margin: 10px;">
                            Type
                        </div>
                        <div class="col-sm-12 col-md-2" style="float: left;margin: 10px;">
                            <select id="bet_side" class="form-control">
                                <option value="ALL">ALL</option>
                                <option value="back">BACK</option>
                                <option value="lay">LAY</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-3" style="float: left;margin: 10px;">
                            <a class="btn btn-primary" href="javascript:void(0);" onclick="searchBets('{{$sports->id}}','Search');">Search</a>
                            <a class="btn btn-info" href="javascript:void(0);" onclick="searchBets('{{$sports->id}}','ViewALL');" style="margin-left: 5px;">View All</a>
                        </div>
                    </div>
                    </div>
                    <div id="addBodyContain" class="col-sm-12" style="margin-top: 20px;">

                    </div> 
                </div>
                <div class="matchBetTEXTUnMatch" style="display: none;">
                    <table class="table coupon-table table-bordered">
                        <thead>
                           <tr>
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">User Name</th>
                                <th style="text-align: center;">Nation</th>
                                <th style="text-align: center;">Bet Type</th>
                                <th style="text-align: center;">Amount</th>
                                <th style="text-align: center;">User Rate</th>
                                <th style="text-align: center;">Place Date</th>
                                <th style="text-align: center;">Match Date</th>
                                <th style="text-align: center;">IP</th>
                                <th style="text-align: center;">Browser Details</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th colspan="10"> No Record Found</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>
