<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserDeposite;
use App\MyBets;
use App\Sports;
use App\Games;
use App\MatchFancy;
use App\UpperLevelDownLevel;
use Auth;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Hash;
use App\Models\Auth\User;
use App\Http\Controllers\Frontend\MyBetsController;

class UserDepositesController extends Controller
{
    public function resultcricketsession(Request $request){
      $requestData = $request->all();
      $matchID = $requestData['matchID'];
      $run = $requestData['run'];
      $teamname = $requestData['teamsname'];
      
      $sports = Sports::where(['match_id'=>$matchID])->first();
      $gameModel = Games::find($sports->game_id);
      
      
      /** FANCY ADDED IN DATABASE WITH RESULT STATUS PROCESSING **/
      $matchFancyModel = new MatchFancy();
      $matchFancyModel->result = $run;
      $matchFancyModel->match_id = $matchID;
      $matchFancyModel->fancyType = 'CRICKET';
      $matchFancyModel->fancyName = $teamname;
      $matchFancyModel->status = 'PROCESSING';
      $matchFancyModel->save();
      $fancyID = $matchFancyModel->id;
      
      $betModel = MyBets::where(['match_id'=>$matchID,'bet_type'=>'SESSION','team_name'=>$teamname,'isDeleted'=>0])->get();
      $dataArr = array();
      foreach($betModel as $key=>$data){
        if(isset($dataArr[$data->user_id])){
          $myBetResultModel = MyBets::find($data->id);
          $myBetResultModel->active = 0;
          $myBetResultModel->save();
          continue;
        }
        $dataArr[$data->user_id] = $data->user_id;
        
        $profitResponceData = MyBetsController::getSessionValueByArr($data->match_id,$data->team_name,$data->user_id,$run);
//        dd($profitResponceData);
        $amount = $profitResponceData[$run]['profit'];
        
        $userModel = User::find($data->user_id);
        $sql = "SELECT GROUP_CONCAT(id) as ids FROM `my_bets` WHERE user_id = '".$data->user_id."' AND `team_name` = '".$teamname."' AND match_id = '".$matchID."'";
        $idsArr = DB::select($sql);
        $ids = $idsArr[0]->ids;
        if($amount == 0){
            $model = new UserDeposite();
            $model->deposite_user_id = $userModel->id;
            $model->withdrawal_user_id = $userModel->parent_id;
            $model->amount = '0';
            $model->balanceType = "MATCH-P-L";
            $model->match_id = $data->match_id;
            $model->type = "SESSION";
            $model->bet_id = $data->id;
            $model->fancy_id = $fancyID;
            $model->extra = $ids;
            $model->note = "SESSION Match ID : ".$data->match_id." bet Team : ".$data->team_name." Declear Run : ".$run;
            $model->callType = $gameModel->name;
            $model->save(); 
        }else{
            if($amount > 0){
         
          $model = new UserDeposite();
          $model->deposite_user_id = $userModel->id;
          $model->withdrawal_user_id = $userModel->parent_id;
          $model->amount = $amount;
          $model->balanceType = "MATCH-P-L";
          $model->match_id = $data->match_id;
          $model->type = "SESSION";
          $model->bet_id = $data->id;
          $model->fancy_id = $fancyID;
          $model->extra = $ids;
          $model->note = "SESSION Match ID : ".$data->match_id." bet Team : ".$data->team_name." Declear Run : ".$run;
          $model->callType = $gameModel->name;
          $model->save();
          
          /** USER PARENT CAL **/
          $perentArr = ListClientController::getUserParentPer($userModel->parent_id);
//          dd($perentArr);
          foreach($perentArr as $userID=>$per){
            $userModelPer = User::find($userID);
            $userModelIsAdmin = User::find($userModelPer->parent_id);
//            dd($userModelIsAdmin);
// dd($userModelIsAdmin->roles->first()->name);
            if(isset($perentArr[$userModelPer->parent_id]) && strtoupper($userModelIsAdmin->roles->first()->name) == 'ADMINISTRATOR'){
              $parentPER = $perentArr[$userModelPer->parent_id];
              $downLevel = (($amount*$per)/100);
              $perupleval = (100-$userModelPer->partnership);
              $upperLevel = (($amount*$perupleval)/100);
            }else{
              $downLevel = (($amount*$per)/100);
              $perupleval = (100-$userModelPer->partnership);
              $upperLevel = (($amount*$perupleval)/100);
            }
            
            
            $upDownModel = new UpperLevelDownLevel();
            $upDownModel->deposit_id = $model->id;
            $upDownModel->user_id = $userID;
            $upDownModel->sportID = $data->sportID;
            $upDownModel->matchID = $data->match_id;
            $upDownModel->bet_user_id = $data->user_id;
            $upDownModel->per = $per;
            $upDownModel->upperLevel = $upperLevel;
            $upDownModel->downLevel = $downLevel;
            $upDownModel->save();
            unset($upDownModel);
          }
          
        }else{
          if($amount < 0){           
            $model = new UserDeposite();
            $model->deposite_user_id = $userModel->parent_id;
            $model->withdrawal_user_id = $userModel->id;
            $model->amount = abs($amount);
            $model->match_id = $data->match_id;
            $model->balanceType = "MATCH-P-L";
            $model->type = "SESSION";
            $model->bet_id = $data->id;
            $model->fancy_id = $fancyID;
            $model->extra = $ids;
            $model->note = "SESSION Match ID : ".$data->match_id." bet Team : ".$data->team_name." Declear Run : ".$run;
            $model->callType = $gameModel->name;
            $model->save();
            
            /** USER PARENT CAL **/
            
            $perentArr = ListClientController::getUserParentPer($userModel->parent_id);
            foreach($perentArr as $userID=>$per){
              $userModelPer = User::find($userID);
              $userModelIsAdmin = User::find($userModelPer->parent_id);
              if(isset($perentArr[$userModelPer->parent_id]) && strtoupper($userModelIsAdmin->roles->first()->name) == 'ADMINISTRATOR'){
                $parentPER = $perentArr[$userModelPer->parent_id];
                $downLevel = (($amount*$per)/100);
                $perupleval = (100-$userModelPer->partnership);
                $upperLevel = (($amount*$perupleval)/100);
              }else{
                $downLevel = (($amount*$per)/100);
                $perupleval = (100-$userModelPer->partnership);
                $upperLevel = (($amount*$perupleval)/100);
              }

              $upDownModel = new UpperLevelDownLevel();
              $upDownModel->user_id = $userID;
              $upDownModel->deposit_id = $model->id;
              $upDownModel->sportID = $data->sportID;
              $upDownModel->matchID = $data->match_id;
              $upDownModel->bet_user_id = $data->user_id;
              $upDownModel->per = $per;
              $upDownModel->upperLevel = $upperLevel;
              $upDownModel->downLevel = $downLevel;
//              $upDownModel->upperLevel = ($upperLevel*(-1));
//              $upDownModel->downLevel = ($downLevel*(-1));
              $upDownModel->save();
              unset($upDownModel);
            }
            unset($model);
          }
        }
        }
        /** FANCY EDIT IN CALCULATION COMPLET DONE
         * RESULT STATUS FINISH 
         * **/
        $myBetResultModel = MyBets::find($data->id);
        $myBetResultModel->active = 0;
        $myBetResultModel->save();
      }
      
      $myBetModel = DB::select( "SELECT * FROM `my_bets` WHERE bet_type='SESSION' AND `team_name` = '".$teamname."' AND match_id = '".$matchID."'");
      foreach($myBetModel as $key=>$bets){
        $model = MyBets::find($bets->id);
        $model->active = 0;
        $model->save();
      }
        
      $matchFancyModel = MatchFancy::find($fancyID);
      $matchFancyModel->status = "FINISH";
      $matchFancyModel->save();
      
      return json_encode(array('status'=>true,'message'=>"<div class='alert alert-success'>Result Declear Successfully</div>"));
    }
    
    
    public function resultsoccersession(Request $request){
      $requestData = $request->all();
      $matchID = $requestData['matchID'];
      $unserSession = $requestData['unserSession'];
      $teamname = $requestData['teamsname'];
      
      $sports = Sports::where(['match_id'=>$matchID])->first();
      $gameModel = Games::find($sports->game_id);
      
      /** FANCY ADDED IN DATABASE WITH RESULT STATUS PROCESSING **/
      $matchFancyModel = new MatchFancy();
      $matchFancyModel->result = $teamname;
      $matchFancyModel->match_id = $matchID;
      $matchFancyModel->fancyType = 'SOCCER';
      $matchFancyModel->fancyName = $unserSession;
      $matchFancyModel->status = 'PROCESSING';
      $fancyID = $matchFancyModel->save();
      
      $betType = 'SESSION-'.$unserSession;
      $betModel = MyBets::where(['match_id'=>$matchID,'bet_type'=>$betType,'team_name'=>$teamname,'isDeleted'=>0])->get();
      
      $dataArr = array();
      foreach($betModel as $key=>$data){
        if(isset($dataArr[$data->user_id])){
          $myBetResultModel = MyBets::find($data->id);
          $myBetResultModel->active = 0;
          $myBetResultModel->save();
          continue;
        }
        $dataArr[$data->user_id] = $data->user_id;
        
        $amount = MyBetsController::getsoccersession($data->team_name,$data->match_id,$data->user_id);
        $userModel = User::find($data->user_id);
        if($amount > 0){
          $model = new UserDeposite();
          $model->balanceType = 'MATCH-P-L';
          $model->deposite_user_id = $userModel->id;
          $model->withdrawal_user_id = $userModel->parent_id;
          $model->amount = $amount;
          $model->match_id = $data->match_id;
          $model->type = "SESSION";
          $model->note = "SESSION Match ID : ".$data->match_id." bet Team : ".$data->team_name." Declear Run : ".$run;
          $model->callType = $gameModel->name;
          $model->save();
          
          /** USER PARENT CAL **/
          $perentArr = ListClientController::getUserParentPer($userModel->parent_id);
          foreach($perentArr as $userID=>$per){
            $userModelPer = User::find($userID);
            $userModelIsAdmin = User::find($userModelPer->parent_id);
            if(isset($perentArr[$userModelPer->parent_id]) && strtoupper($userModelIsAdmin->roles->first()->name) == 'ADMINISTRATOR'){
              $parentPER = $perentArr[$userModelPer->parent_id];
              $downLevel = (($amount*$per)/100);
              $perupleval = (100-$userModelPer->partnership);
              $upperLevel = (($amount*$perupleval)/100);
            }else{
              $downLevel = (($amount*$per)/100);
              $perupleval = (100-$userModelPer->partnership);
              $upperLevel = (($amount*$perupleval)/100);
            }
            
            $upDownModel = new UpperLevelDownLevel();
            $upDownModel->user_id = $userID;
            $upDownModel->sportID = $data->sportID;
            $upDownModel->matchID = $data->match_id;
            $upDownModel->bet_user_id = $data->user_id;
            $upDownModel->per = $per;
            $upDownModel->upperLevel = $upperLevel;
            $upDownModel->downLevel = $downLevel;
            $upDownModel->save();
            unset($upDownModel);
          }
          
        }else{
          if($amount < 0){
            $model = new UserDeposite();
            $model->balanceType = 'MATCH-P-L';
            $model->deposite_user_id = $userModel->parent_id;
            $model->withdrawal_user_id = $userModel->id;
            $model->amount = $amount;
            $model->match_id = $data->match_id;
            $model->type = "SESSION";
            $model->note = "SESSION Match ID : ".$data->match_id." bet Team : ".$data->team_name." Declear Run : ".$run;
            $model->callType = $gameModel->name;
            $model->save();
            
            /** USER PARENT CAL **/
            
            $perentArr = ListClientController::getUserParentPer($userModel->parent_id);
            foreach($perentArr as $userID=>$per){
              $userModelPer = User::find($userID);
              $userModelIsAdmin = User::find($userModelPer->parent_id);
             
              if(isset($perentArr[$userModelPer->parent_id]) && strtoupper($userModelIsAdmin->roles->first()->name) == 'ADMINISTRATOR'){
                $parentPER = $perentArr[$userModelPer->parent_id];
                $downLevel = (($amount*$per)/100);
                $perupleval = (100-$userModelPer->partnership);
                $upperLevel = (($amount*$perupleval)/100);
              }else{
                $downLevel = (($amount*$per)/100);
                $perupleval = (100-$userModelPer->partnership);
                $upperLevel = (($amount*$perupleval)/100);
              }

              $upDownModel = new UpperLevelDownLevel();
              $upDownModel->user_id = $userID;
              $upDownModel->sportID = $data->sportID;
              $upDownModel->matchID = $data->match_id;
              $upDownModel->bet_user_id = $data->user_id;
              $upDownModel->per = $per;
              $upDownModel->upperLevel = ($upperLevel*(-1));
              $upDownModel->downLevel = ($downLevel*(-1));
              $upDownModel->save();
              unset($upDownModel);
            }
            
          }
        }
        
        /** FANCY EDIT IN CALCULATION COMPLET DONE
         * RESULT STATUS FINISH 
         * **/
        $myBetResultModel = MyBets::find($data->id);
        $myBetResultModel->active = 0;
        $myBetResultModel->save();
      }
      
      $matchFancyModel = MatchFancy::find($fancyID);
      $matchFancyModel->status = "FINISH";
      $matchFancyModel->save();
      
      return json_encode(array('status'=>true,'message'=>"<div class='alert alert-success'>Result Declear Successfully</div>"));
    }
    
    public static function getBalance($userID){
      $depTot = DB::table('user_deposites')->where(['deposite_user_id'=>$userID])->sum('amount');
      $widTot = DB::table('user_deposites')->where(['withdrawal_user_id'=>$userID])->sum('amount');
      $totBalance = ($depTot-$widTot);
      
      return $totBalance;
    }
    
    public function store(Request $request)
    {
      $requestData = $request->all();
      if(Auth::user()->roles->first()->name == 'administrator' && isset($requestData['supperAdmin']) && $requestData['supperAdmin'] == '1'){
        $model = new UserDeposite();
        $model->deposite_user_id = Auth::user()->id;
        $model->withdrawal_user_id = 0;
        $model->amount = $requestData['amount'];
        $model->note = 'Super Admin add amount';
        if($model->save()){
          return json_encode(array('status'=>true,'message'=>"Transaction Completed"));
        }else{
          return json_encode(array('status'=>false,'message'=>"Transaction Not Completed"));
        }
      }else{
        $userId = Auth::user()->id;
        $m_pwd =  $requestData['m_pwd'];
        $user = User::find($userId);
        if (!Hash::check($m_pwd, $user->password)) {
          return json_encode(array('status'=>false,'message'=>'Master Password Wrong'));
        }
        $userModel = User::find($requestData['withdrawal_user_id']);
        $userModelDepo = User::find($requestData['deposite_user_id']);
        if(strtoupper($userModel->roles->first()->name) != 'USER'){
          $userData = ListClientController::getMainCal($requestData['withdrawal_user_id']);
          $withdrawUserBaalanceAmount = $userData['AvailableBalance'];
          //$withdrawUserBaalanceAmount = ListClientController::getUserAvalableBalanceADMIN($requestData['withdrawal_user_id']);
        }else{
          $withdrawUserBaalanceAmount = ListClientController::getUserAvalableBalance($requestData['withdrawal_user_id']);
        }
//        echo $requestData['withdrawal_user_id']."<br>";
        
        if($withdrawUserBaalanceAmount < $requestData['amount']){
          return json_encode(array('status'=>false,'message'=>"Insufficint Balance"));
        }
        if(strtoupper($userModel->roles->first()->name) != 'USER' && strtoupper($userModelDepo->roles->first()->name) != 'USER'){
            $isParent = true;
            if($requestData['balanceType'] == 'WITHDRAWAL'){
              $isParent = false;  
            }
    //        $isParent = true;
            if(strtoupper($userModel->roles->first()->name) == 'MASTER'){
                $isParent = false;
            }
            $upperLevelAmt = 0;
            if(strtoupper($userModel->roles->first()->name) == 'ADMINISTRATOR'){
                $isParent = false;
                $userModel = User::find($requestData['deposite_user_id']);
                $upperLevelAmt = ListClientController::getGetUserUpperLevalAmount($requestData['withdrawal_user_id'],$requestData['deposite_user_id'],$isParent);
                if($upperLevelAmt == 0){
                    $isParent = true;
                }
            }
            $upperLevelAmt = ListClientController::getGetUserUpperLevalAmount($requestData['withdrawal_user_id'],$requestData['deposite_user_id'],$isParent);

            if($upperLevelAmt !=0){
              if((int)$upperLevelAmt < 0){
                if($requestData['amount'] <=  $upperLevelAmt){
                  $upperLevelAmt = $requestData['amount'];
                  $requestData['amount'] = 0;
                }else{
                  $requestData['amount'] = $requestData['amount']-abs($upperLevelAmt);
                }

                $model = new UserDeposite();
                $model->balanceType = "UPPER-LEVEL";
                $model->deposite_user_id = $requestData['deposite_user_id'];
                $model->withdrawal_user_id = $requestData['withdrawal_user_id'];
                $model->amount = abs($upperLevelAmt);
                $model->note = "Upper Level Settled";
                $model->save();
                $userModel = User::find($requestData['deposite_user_id']);
                if(strtoupper($userModel->roles->first()->name) == 'MASTER'){
                    $updownModel = UpperLevelDownLevel::where(['user_id'=>$requestData['deposite_user_id'],'active'=>1])->get();
                    foreach($updownModel as $key=>$updown){
                      $mod12 = UpperLevelDownLevel::find($updown->id);
                      $mod12->active = 0;
                      $mod12->save();
                    }
                }

                $updownModel = UpperLevelDownLevel::where(['user_id'=>$requestData['withdrawal_user_id'],'active'=>1])->get();
                $userModel = User::find($requestData['deposite_user_id']);
                if($userModel->roles->first()->name == 'administrator' || strtoupper($userModel->roles->first()->name) == 'MASTER'){
                    foreach($updownModel as $key=>$updown){
                      $mod12 = UpperLevelDownLevel::find($updown->id);
                      $mod12->active = 0;
                      $mod12->save();
                    }
                    if(is_array($updownModel) && count($updownModel) == 0){
                        $updownModel = UpperLevelDownLevel::where(['user_id'=>$requestData['deposite_user_id'],'active'=>1])->get();
                    }
                }

                $upperLevelAmt = abs($upperLevelAmt);
                foreach($updownModel as $key=>$updown){
                  if(abs($updown->upperLevel) <= $upperLevelAmt){
                    $mod12 = UpperLevelDownLevel::find($updown->id);
                    $mod12->active = 0;
                    $mod12->save();
                    $upperLevelAmt -=abs($updown->upperLevel);
                  }else{
                    if($upperLevelAmt > 0){
                      $mod = UpperLevelDownLevel::find($updown->id);
                      $mod->active = 0;
                      $mod->save();
    //                  DB::table('upper_level_down_levels')
    //                ->where('id', $updown->id)
    //                ->update(['active' => 0]);
                      $amt = $updown->upperLevel-$upperLevelAmt;
                      $upModel = new UpperLevelDownLevel();
                      $upModel->deposit_id = $mod->deposit_id;
                      $upModel->user_id = $mod->user_id;
                      $upModel->bet_user_id = $mod->bet_user_id;
                      $upModel->sportID = $mod->sportID;
                      $upModel->matchID = $mod->matchID;
                      $upModel->per = $mod->per;
                      $upModel->upperLevel = $amt;
                      $upModel->downLevel = 0;
                      $upModel->active = 1;
                      $upModel->save();
                    }else{
                      break;
                    }
                  }
                }

                $updownModel = UpperLevelDownLevel::where(['user_id'=>$requestData['withdrawal_user_id']])->get();
                foreach($updownModel as $key=>$updown){
                  $userModel = User::find($updown->bet_user_id);
                  if($updown->user_id == $userModel->parent_id ){
                    $mod = UpperLevelDownLevel::find($updown->id);
                    $mod->active = 0;
                    $mod->save();
                  }
                }
              }else{
    //            if($requestData['amount'] <=  abs($upperLevelAmt)){
    //              $upperLevelAmt = $requestData['amount'];
    //            }else{
    //              $requestData['amount'] -=abs($upperLevelAmt);
    //            }

                $userModelWid = User::find($requestData['withdrawal_user_id']);
                $userModelDeposit = User::find($requestData['deposite_user_id']);
                $updownModel = UpperLevelDownLevel::where(['user_id'=>$requestData['withdrawal_user_id'],'active'=>1])->get();
                $updownModelDeposit = UpperLevelDownLevel::where(['user_id'=>$requestData['deposite_user_id'],'active'=>1])->get();
    //            echo $userModelDeposit->roles->first()->name;die();
                if($userModelDeposit->roles->first()->name == 'administrator' || $userModelDeposit->roles->first()->name == 'master'){
                    $childUserArr = AccountsController::getChildUserListArr($requestData['withdrawal_user_id']);
                    foreach($updownModelDeposit as $key=>$updown){
                        if(!in_array($updown->bet_user_id,$childUserArr)){
                            continue;
                        }
                        $userModelBetUser = User::find($updown->bet_user_id);

                        if(abs($updown->downLevel) <= abs($upperLevelAmt)){
                            $mod = UpperLevelDownLevel::find($updown->id);
                            $mod->active = 0;
                            $mod->save();

                            $model = new UserDeposite();
                            $model->balanceType = "UPPER-LEVEL";
                            $model->deposite_user_id = $requestData['deposite_user_id'];
                            $model->withdrawal_user_id = $requestData['withdrawal_user_id'];
                            $model->amount = abs($updown->downLevel);
                            $model->note = "Upper Level Settled";
                            $model->save();
                            if($userModelBetUser->parent_id == $requestData['withdrawal_user_id']){
                                $modWid = UpperLevelDownLevel::where(['user_id'=>$requestData['withdrawal_user_id']])->get();
                                foreach($modWid as $k=>$mod){
                                    $mod->active = 0;
                                    $mod->save();

                                }
                            }
                            $upperLevelAmt = abs($upperLevelAmt)-abs($updown->downLevel);
    //                        echo "<br> Upper LEvel ==>".$upperLevelAmt;
                        }else{
                            if($upperLevelAmt > 0){
                                $mod = UpperLevelDownLevel::find($updown->id);
                                $mod->active = 0;
                                $mod->save();

                                $amt = $updown->upperLevel-$upperLevelAmt;
                                $upModel = new UpperLevelDownLevel();
                                $upModel->deposit_id = $mod->deposit_id;
                                $upModel->user_id = $mod->user_id;
                                $upModel->bet_user_id = $mod->bet_user_id;
                                $upModel->sportID = $mod->sportID;
                                $upModel->matchID = $mod->matchID;
                                $upModel->per = $mod->per;
                                $upModel->upperLevel = $amt;
                                $upModel->downLevel = 0;
                                $upModel->active = 1;
                                $upModel->save();

                                $model = new UserDeposite();
                                $model->balanceType = "UPPER-LEVEL";
                                $model->deposite_user_id = $requestData['deposite_user_id'];
                                $model->withdrawal_user_id = $requestData['withdrawal_user_id'];
                                $model->amount = $upperLevelAmt;
                                $model->note = "Upper Level Settled";
                                $model->save();

                                if($userModelBetUser->parent_id == $requestData['withdrawal_user_id']){
                                    $modWid = UpperLevelDownLevel::where(['user_id'=>$requestData['withdrawal_user_id']])->get();
                                    foreach($modWid as $k=>$mod){
                                        $mod->active = 0;
                                        $mod->save();

                                    }
                                }
                            }
                        }
                    }
                    if($upperLevelAmt > 0){
                        $requestData['amount'] = abs($upperLevelAmt);
                    }else{
                        $requestData['amount'] =0;
                    }
                }else{
                    $childUserArr = AccountsController::getChildUserListArr($requestData['withdrawal_user_id']);
                    foreach($updownModelDeposit as $key=>$updown){
                        if(!in_array($updown->bet_user_id,$childUserArr)){
                            continue;
                        }
                        $userModelBetUser = User::find($updown->bet_user_id);
    //                    if($userModelBetUser->parent_id == $requestData['deposite_user_id']){
                           $amountUplevel =  (abs($updown->upperLevel)+abs($updown->downLevel));
    //                    }else{
    //                        $amountUplevel =  abs($updown->upperLevel);
    //                    }
                        if(abs($amountUplevel) <= abs($upperLevelAmt)){
                            $mod = UpperLevelDownLevel::find($updown->id);
                            $mod->active = 0;
                            $mod->save();

                            $model = new UserDeposite();
                            $model->balanceType = "UPPER-LEVEL";
                            $model->deposite_user_id = $requestData['deposite_user_id'];
                            $model->withdrawal_user_id = $requestData['withdrawal_user_id'];
                            $model->amount = abs($amountUplevel);
                            $model->note = "Upper Level Settled";
                            $model->save();

                            if($userModelBetUser->parent_id == $requestData['withdrawal_user_id']){
                                $modWid = UpperLevelDownLevel::where(['user_id'=>$requestData['withdrawal_user_id']])->get();
                                foreach($modWid as $k=>$mod){
                                    $mod->active = 0;
                                    $mod->save();

                                }
                            }

                            $upperLevelAmt = abs($upperLevelAmt)-abs($amountUplevel);
    //                        echo "<br> Upper LEvel ==>".$upperLevelAmt;
                        }else{
                            if($upperLevelAmt > 0){
                                $mod = UpperLevelDownLevel::find($updown->id);
                                $mod->active = 0;
                                $mod->save();

                                $amt = abs($amountUplevel)-$upperLevelAmt;
                                $upModel = new UpperLevelDownLevel();
                                $upModel->deposit_id = $mod->deposit_id;
                                $upModel->user_id = $mod->user_id;
                                $upModel->bet_user_id = $mod->bet_user_id;
                                $upModel->sportID = $mod->sportID;
                                $upModel->matchID = $mod->matchID;
                                $upModel->per = $mod->per;
                                $upModel->upperLevel = $amt;
                                $upModel->downLevel = 0;
                                $upModel->active = 1;
                                $upModel->save();

                                $model = new UserDeposite();
                                $model->balanceType = "UPPER-LEVEL";
                                $model->deposite_user_id = $requestData['deposite_user_id'];
                                $model->withdrawal_user_id = $requestData['withdrawal_user_id'];
                                $model->amount = $upperLevelAmt;
                                $model->note = "Upper Level Settled";
                                $model->save();

                                if($userModelBetUser->parent_id == $requestData['withdrawal_user_id']){
                                    $modWid = UpperLevelDownLevel::where(['user_id'=>$requestData['withdrawal_user_id']])->get();
                                    foreach($modWid as $k=>$mod){
                                        $mod->active = 0;
                                        $mod->save();

                                    }
                                }
                            }
                        }
                    }
                    if($upperLevelAmt > 0){
                        $requestData['amount'] = abs($upperLevelAmt);
                    }else{
                        $requestData['amount'] =0;
                    }
                }
            }
            if($requestData['amount'] <= 0 || $requestData['amount'] == 0){
               return json_encode(array('status'=>true,'message'=>"Transaction Completed"));
            }
            }
        }
        if($requestData['amount'] > 0){
          $model = new UserDeposite();
          $model->balanceType = $requestData['balanceType'];
          $model->deposite_user_id = $requestData['deposite_user_id'];
          $model->withdrawal_user_id = $requestData['withdrawal_user_id'];
          $model->amount = $requestData['amount'];
          $model->note = $requestData['note'];
          if($model->save()){
            return json_encode(array('status'=>true,'message'=>"Transaction Completed"));
          }else{
            return json_encode(array('status'=>false,'message'=>"Transaction Not Completed"));
          }
        }
      
    }
    }
}
