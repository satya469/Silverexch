<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MyBets;
use App\Sports;
use App\Games;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use Auth;
use App\LockUnlockBet;
class MyBetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function getUserPartnershipPer($userID,$downLinkper = 0,$parentCount = 0){
      $userModel = User::find($userID);
      $userData = array();
      $realCurrent = ($userModel->partnership-$downLinkper);
      if($parentCount == 1){
        $userData[$userID]['realCurrent'] = $userModel->partnership;
        $userData[$userID]['current'] = $userModel->partnership;
        $userData[$userID]['downlink'] = $downLinkper;
      }else{
        $userData[$userID]['realCurrent'] = $realCurrent;
        $userData[$userID]['current'] = $userModel->partnership;
        $userData[$userID]['downlink'] = $downLinkper;
      }
      
      
      if($userModel->parent_id != 0){
        $parentCount++;
        $data = self::getUserPartnershipPer($userModel->parent_id,$userModel->partnership,$parentCount);
        foreach($data as $user=>$users){
          $userData[$user] = $users;
        }
      }
      return $userData;
    }
    public static function getCalPerByUser($loginUserID,$partnershipArr,$profitAmtTot){
      if(isset($partnershipArr[$loginUserID]['realCurrent']) && $partnershipArr[$loginUserID]['realCurrent'] > 0){
        $per = $partnershipArr[$loginUserID]['realCurrent'];
        if($profitAmtTot > 0 ){
           $amt = (($profitAmtTot*$per)/100);
           return $amt;
        }else{
          $amt = ((abs($profitAmtTot)*$per)/100);
          return ($amt*(-1));
        }
      }
      return 0;
    }
    public static function getParentUser($userID){
      $arr = array();
      $userModel = User::where(['id'=>$userID])->get();
      foreach($userModel as $key=>$user){
        if($user->parent_id == 0){
          break;
        }
        $arr[] = $user->parent_id;
        $data = self::getParentUser($user->parent_id);
        foreach($data as $k=>$val){
          $arr[] = $val;
        }
      }
      return $arr;
    }
    public static function getMatchSuspended($sportID){
      $userChild = self::getParentUser(Auth::user()->id);
      krsort($userChild);
      foreach($userChild as $key=>$userID){
        $lockUnlockModel = LockUnlockBet::where(['sportID'=>$requestData['sportID'],'user_id'=>$userID,'lockType'=>$requestData['bet_type']])->first();
        if(isset($lockUnlockModel->id) && $lockUnlockModel->type != 'UNLOCK'){
          break;
        }
      }
      if($lockUnlockModel){
        if($lockUnlockModel->lockType == 'SUSPENDED'){
          if($lockUnlockModel->type == 'SUSPEND'){
            return true;
          }else{
            return false;
          }
        }
      }
    }
    public function index(Request $request)
    {
      $requestData = $request->all();
      $sportsModel =  Sports::where(['id'=>$requestData['sportID']])->first();
      $gameModel = Games::where(["id" => $sportsModel->game_id])->first();
      if(Auth::user()->roles->first()->name == 'administrator'){
        if(empty($requestData['match_id'])){
          $myBetsModel = MyBets::where(['sportID'=>$requestData['sportID'],'active'=>1,'isDeleted'=>0])->orderBy('id', 'DESC')->get();
        }else{
          $myBetsModel = MyBets::where(['sportID'=>$requestData['sportID'],'match_id'=>$requestData['match_id'],'active'=>1,'isDeleted'=>0])->orderBy('id', 'DESC')->get();
        }
      }else{
            $userChildArr = \App\Http\Controllers\Backend\AccountsController::getChildUserListArr(Auth::user()->id);
            $txt = implode(',', $userChildArr);
            if(empty($txt)){
                $txt = Auth::user()->id;
            }
            $sql = "SELECT * FROM `my_bets` WHERE sportID='".$requestData['sportID']."' ";
            $sql .= " AND active = '1' AND `isDeleted`='0' AND user_id IN (".$txt.")";
            if(!empty($requestData['match_id'])){
//            $myBetsModel = MyBets::where(['sportID'=>$requestData['sportID'],'active'=>1,'isDeleted'=>0])->orderBy('id', 'DESC')->get();
                $sql .= " AND match_id='".$requestData['match_id']."'";
            }
//            else{
//              $myBetsModel = MyBets::where(['sportID'=>$requestData['sportID'],'match_id'=>$requestData['match_id'],'active'=>1,'isDeleted'=>0])->orderBy('id', 'DESC')->get();
//            }
            
            $sql .= " Order by id DESC";
//            echo $sql;die();
            $myBetsModel = DB::select($sql);
      }
      
      
      $loginUserID = Auth::user()->id;

      $response = array();
      $arr = array();
      foreach($myBetsModel as $key=>$bet){
        $partnershipArr = self::getUserPartnershipPer($bet->user_id);       
        $extra = json_decode($bet->extra,true);
        switch($bet->bet_type){
          case "ODDS":{
            $profitAmt = $bet->bet_profit;
            if($bet->bet_side == 'lay'){
              $profitAmtTot = ($profitAmt*(-1));
              $profitAmt = self::getCalPerByUser($loginUserID,$partnershipArr,$profitAmtTot);
              $bet->bet_amount = self::getCalPerByUser($loginUserID,$partnershipArr,$bet->bet_amount);
              if(!isset($response['ODDS'][$bet->team_name]['ODDS_profitLost'])){
                $response['ODDS'][$bet->team_name]['ODDS_profitLost'] = $profitAmt;
              }else{
                $response['ODDS'][$bet->team_name]['ODDS_profitLost'] += $profitAmt;
              }
              if(isset($extra['teamname1']) && !empty($extra['teamname1'])){
                if(!isset($response['ODDS'][$extra['teamname1']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] = $bet->bet_amount;
                }else{
                  $response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] += $bet->bet_amount;
                }
              }

              if(isset($extra['teamname2']) && !empty($extra['teamname2'])){
                if(!isset($response['ODDS'][$extra['teamname2']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] = $bet->bet_amount;
                }else{
                 $response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] += $bet->bet_amount;
                }
              }

              if(isset($extra['teamname3']) && !empty($extra['teamname3'])){
                if(!isset($response['ODDS'][$extra['teamname3']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] = $bet->bet_amount;
                }else{
                  $response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] += $bet->bet_amount;
                }
              }
              if(isset($extra['teamname4']) && !empty($extra['teamname4'])){
                if(!isset($response['ODDS'][$extra['teamname4']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname4']]['ODDS_profitLost'] = $bet->bet_amount;
                }else{
                  $response['ODDS'][$extra['teamname4']]['ODDS_profitLost'] += $bet->bet_amount;
                }
              }

            }else{
              $bet_amt = ($bet->bet_amount*(-1));
              $profitAmt = self::getCalPerByUser($loginUserID,$partnershipArr,$profitAmt);
              $bet_amt = self::getCalPerByUser($loginUserID,$partnershipArr,$bet_amt);
              if(!isset($response['ODDS'][$bet->team_name]['ODDS_profitLost'])){
                $response['ODDS'][$bet->team_name]['ODDS_profitLost'] = $profitAmt;
              }else{
                $response['ODDS'][$bet->team_name]['ODDS_profitLost'] += $profitAmt;
              }

              if(isset($extra['teamname1']) && !empty($extra['teamname1'])){
                if(!isset($response['ODDS'][$extra['teamname1']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] = $bet_amt;
                }else{
                  $response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] += $bet_amt;
                }
              }

              if(isset($extra['teamname2']) && !empty($extra['teamname2'])){
                if(!isset($response['ODDS'][$extra['teamname2']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] = $bet_amt;
                }else{
                 $response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] += $bet_amt;
                }
              }

              if(isset($extra['teamname3']) && !empty($extra['teamname3'])){
                if(!isset($response['ODDS'][$extra['teamname3']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] = $bet_amt;
                }else{
                  $response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] += $bet_amt;
                }
              }
              if(isset($extra['teamname4']) && !empty($extra['teamname4'])){
                if(!isset($response['ODDS'][$extra['teamname4']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname4']]['ODDS_profitLost'] = $bet_amt;
                }else{
                  $response['ODDS'][$extra['teamname4']]['ODDS_profitLost'] += $bet_amt;
                }
              }  
            }
            break;
          }
          case 'BOOKMAKER':{
            $profitAmt = $bet->bet_profit;
            if($bet->bet_side == 'lay'){
              $profitAmt = ($profitAmt*(-1));
              $profitAmt = self::getCalPerByUser($loginUserID,$partnershipArr,$profitAmt);
              $bet->bet_amount = self::getCalPerByUser($loginUserID,$partnershipArr,$bet->bet_amount);
              if(!isset($response['BOOKMAKER'][$bet->team_name]['BOOKMAKER_profitLost'])){
                $response['BOOKMAKER'][$bet->team_name]['BOOKMAKER_profitLost'] = $profitAmt;
              }else{
                $response['BOOKMAKER'][$bet->team_name]['BOOKMAKER_profitLost'] += $profitAmt;
              }
              if(isset($extra['teamname1']) && !empty($extra['teamname1'])){
                if(!isset($response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'])){
                  $response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'] = $bet->bet_amount;
                }else{
                  $response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'] += $bet->bet_amount;
                }
              }

              if(isset($extra['teamname2']) && !empty($extra['teamname2'])){
                if(!isset($response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'])){
                  $response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'] = $bet->bet_amount;
                }else{
                 $response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'] += $bet->bet_amount;
                }
              }

              if(isset($extra['teamname3']) && !empty($extra['teamname3'])){
                if(!isset($response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'])){
                  $response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'] = $bet->bet_amount;
                }else{
                  $response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'] += $bet->bet_amount;
                }
              }

            }else{
              $bet_amt = ($bet->bet_amount*(-1));
              $profitAmt = self::getCalPerByUser($loginUserID,$partnershipArr,$profitAmt);
              $bet_amt = self::getCalPerByUser($loginUserID,$partnershipArr,$bet_amt);
              if(!isset($response['BOOKMAKER'][$bet->team_name]['BOOKMAKER_profitLost'])){
                $response['BOOKMAKER'][$bet->team_name]['BOOKMAKER_profitLost'] = $profitAmt;
              }else{
                $response['BOOKMAKER'][$bet->team_name]['BOOKMAKER_profitLost'] += $profitAmt;
              }

              if(isset($extra['teamname1']) && !empty($extra['teamname1'])){
                if(!isset($response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'])){
                  $response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'] = $bet_amt;
                }else{
                  $response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'] += $bet_amt;
                }
              }

              if(isset($extra['teamname2']) && !empty($extra['teamname2'])){
                if(!isset($response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'])){
                  $response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'] = $bet_amt;
                }else{
                 $response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'] += $bet_amt;
                }
              }

              if(isset($extra['teamname3']) && !empty($extra['teamname3'])){
                if(!isset($response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'])){
                  $response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'] = $bet_amt;
                }else{
                  $response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'] += $bet_amt;
                }
              }  
            }
            break;
          }
          case 'SESSION':{
             $response['SESSION'][$bet->team_name] = $bet->team_name;
            break;
          }
          
        }
        
      }
      foreach($response as $key=>$data){
         if($key == 'SESSION'){
             continue;
         } 
        foreach($data as $key1=>$val){
          if(isset($val['BOOKMAKER_profitLost'])){
              $response[$key][$key1]['BOOKMAKER_profitLost'] = round($val['BOOKMAKER_profitLost']);
          }
          if(isset($val['ODDS_profitLost'])){
              $response[$key][$key1]['ODDS_profitLost'] = round($val['ODDS_profitLost']);
          }
        }
      } 
      $response['myBetsHtml'] = SportsController::getMyAllBets($requestData['match_id']);
      return json_encode($response);
    }
    public function soccerindex(Request $request)
    {
      $requestData = $request->all();
      $sportsModel =  Sports::where(['match_id'=>$requestData['match_id']])->first();
      $gameModel = Games::where(["id" => $sportsModel->game_id])->first();
      $myBetsModel = MyBets::where(['match_id'=>$requestData['match_id'],'active'=>1,'isDeleted'=>0])->get();
      $response = array();
      $arr = array();
      $loginUserID = Auth::user()->id;
      foreach($myBetsModel as $key=>$bet){
        $partnershipArr = self::getUserPartnershipPer($bet->user_id);  
        $extra = json_decode($bet->extra,true);
        $betTypeArr = explode('-', $bet['bet_type']);
        switch($betTypeArr[0]){
          case "ODDS":{
            $profitAmt = $bet['bet_profit'];
            if($bet['bet_side'] == 'lay'){
              $profitAmt = ($profitAmt*(-1));
              $profitAmt = self::getCalPerByUser($loginUserID,$partnershipArr,$profitAmt);
              $bet['bet_amount'] = self::getCalPerByUser($loginUserID,$partnershipArr,$bet['bet_amount']);
              if(!isset($response['ODDS'][$bet['team_name']]['ODDS_profitLost'])){
                $response['ODDS'][$bet['team_name']]['ODDS_profitLost'] = $profitAmt;
              }else{
                $response['ODDS'][$bet['team_name']]['ODDS_profitLost'] += $profitAmt;
              }
              if(isset($extra['teamname1']) && !empty($extra['teamname1'])){
                if(!isset($response['ODDS'][$extra['teamname1']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] = $bet['bet_amount'];
                }else{
                  $response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] += $bet['bet_amount'];
                }
              }

              if(isset($extra['teamname2']) && !empty($extra['teamname2'])){
                if(!isset($response['ODDS'][$extra['teamname2']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] = $bet['bet_amount'];
                }else{
                 $response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] += $bet['bet_amount'];
                }
              }

              if(isset($extra['teamname3']) && !empty($extra['teamname3'])){
                if(!isset($response['ODDS'][$extra['teamname3']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] = $bet['bet_amount'];
                }else{
                  $response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] += $bet['bet_amount'];
                }
              }

            }else{
              $bet_amt = ($bet['bet_amount']*(-1));
              $profitAmt = self::getCalPerByUser($loginUserID,$partnershipArr,$profitAmt);
              $bet_amt = self::getCalPerByUser($loginUserID,$partnershipArr,$bet_amt);
              if(!isset($response['ODDS'][$bet['team_name']]['ODDS_profitLost'])){
                $response['ODDS'][$bet['team_name']]['ODDS_profitLost'] = $profitAmt;
              }else{
                $response['ODDS'][$bet['team_name']]['ODDS_profitLost'] += $profitAmt;
              }

              if(isset($extra['teamname1']) && !empty($extra['teamname1'])){
                if(!isset($response['ODDS'][$extra['teamname1']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] = $bet_amt;
                }else{
                  $response['ODDS'][$extra['teamname1']]['ODDS_profitLost'] += $bet_amt;
                }
              }

              if(isset($extra['teamname2']) && !empty($extra['teamname2'])){
                if(!isset($response['ODDS'][$extra['teamname2']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] = $bet_amt;
                }else{
                 $response['ODDS'][$extra['teamname2']]['ODDS_profitLost'] += $bet_amt;
                }
              }

              if(isset($extra['teamname3']) && !empty($extra['teamname3'])){
                if(!isset($response['ODDS'][$extra['teamname3']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] = $bet_amt;
                }else{
                  $response['ODDS'][$extra['teamname3']]['ODDS_profitLost'] += $bet_amt;
                }
              }  
            }
            break;
          }
          case 'SESSION':{
            $profitAmt = $bet['bet_profit'];
            if($bet['bet_side'] == 'lay'){
              $profitAmt = ($profitAmt*(-1));
              $profitAmt = self::getCalPerByUser($loginUserID,$partnershipArr,$profitAmt);
              $bet['bet_amount'] = self::getCalPerByUser($loginUserID,$partnershipArr,$bet['bet_amount']);
              if(!isset($response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'])){
                $response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'] = $profitAmt;
              }else{
                $response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'] += $profitAmt;
              }
              
              if(isset($extra['teamname1']) && !empty($extra['teamname1'])){
                if(!isset($response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost'])){
                  $response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost'] += $bet['bet_amount'];
                }else{
                  $response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost'] += $bet['bet_amount'];
                }
              }

              if(isset($extra['teamname2']) && !empty($extra['teamname2'])){
                if(!isset($response['SESSION'][$betTypeArr[1]][$extra['teamname2']]['SESSION_profitLost'])){
                  $response['SESSION'][$betTypeArr[1]][$extra['teamname2']]['SESSION_profitLost'] = $bet['bet_amount'];
                }else{
                 $response['SESSION'][$betTypeArr[1]][$extra['teamname2']]['SESSION_profitLost'] += $bet['bet_amount'];
                }
              }
            }else{
              $bet_amt = ($bet['bet_amount']*(-1));
              if(!isset($response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'])){
                $response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'] = $profitAmt;
              }else{
                $response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'] += $profitAmt;
            }
              
              if(isset($extra['teamname1']) && !empty($extra['teamname1'])){
                if(!isset($response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost'])){
                  $response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost'] = $bet_amt;
                }else{
                  $response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost'] += $bet_amt;
                }
              }

              if(isset($extra['teamname2']) && !empty($extra['teamname2'])){
                if(!isset($response['SESSION'][$betTypeArr[1]][$extra['teamname2']]['SESSION_profitLost'])){
                  $response['SESSION'][$betTypeArr[1]][$extra['teamname2']]['SESSION_profitLost'] = $bet_amt;
                }else{
                 $response['SESSION'][$betTypeArr[1]][$extra['teamname2']]['SESSION_profitLost'] += $bet_amt;
                }
              }
            }
            
            break;
          }
        }  
      }
      foreach($response as $key=>$data){
        foreach($data as $key1=>$val){
          if(isset($val['SESSION_profitLost'])){
              $response[$key][$key1]['SESSION_profitLost'] = round($val['SESSION_profitLost']);
          }
          if(isset($val['ODDS_profitLost'])){
              $response[$key][$key1]['ODDS_profitLost'] = round($val['ODDS_profitLost']);
          }
        }
      } 
      $response['myBetsHtml'] = SportsController::getMyAllBets($requestData['match_id']);
      return json_encode($response);
    }
    
    public function getsessionsetsata(Request $request){
      $requestData = $request->all();
      $resultArr = self::getSessionValueByArr($requestData['match_id'],$requestData['teamName']);
//      dd($resultArr);
      if(!$resultArr){
        return "<div class='alert alert-danger'>Bet Not Avaliable</div>";
      }
      return view("backend.my-bets.getBetSession",compact('resultArr'))->render();
    }
    
    public static function getSessionValueByArr($match_id,$teamName){
      $myBetsModelLayMin = MyBets::where([
                                    'bet_side'=>'lay',
                                    'bet_type'=>'SESSION',
                                    'team_name'=>$teamName,
                                    'match_id'=>$match_id,
                                    'isDeleted'=>0
                                  ])->min('bet_odds');
      
      $myBetsModelBackMax = MyBets::where([
                                    'bet_side'=>'back',
                                    'bet_type'=>'SESSION',
                                    'team_name'=>$teamName,
                                    'match_id'=>$match_id,
                                    'isDeleted'=>0
                                  ])->max('bet_odds');
//      dd($myBetsModelBackMax);
      if((!isset($myBetsModelLayMin) && !isset($myBetsModelBackMax)) || 
        (is_null($myBetsModelLayMin) && is_null($myBetsModelBackMax)) || 
        ($myBetsModelLayMin == NULL && $myBetsModelBackMax == NULL)){
        return false;
      }
      if(!empty($myBetsModelLayMin) && !empty($myBetsModelBackMax)){
        $min = ($myBetsModelLayMin- 2);
        $max = ($myBetsModelBackMax+2);
      }elseif(!empty($myBetsModelLayMin)){
        $min = ($myBetsModelLayMin- 2);
        $max = ($myBetsModelLayMin+2);
      }elseif(!empty($myBetsModelBackMax)){
        $min = ($myBetsModelBackMax- 2);
        $max = ($myBetsModelBackMax+2);
      }
      
      $i = $min;
      $ResultArr = array();
      while($max >= $i){
        $amtB = self::getCalBackSession($teamName,$match_id,$i);
        $ResultArr['back'][$i] = $amtB;
        
        $amtL = self::getCalLaySession($teamName,$match_id,$i);
        $ResultArr['lay'][$i] = $amtL;
        $i++;
      }
      $dataArr = array();
      if(isset($ResultArr['lay'])){
        foreach($ResultArr['lay'] as $run=>$val){
          $pL = 0;
          $profitB = isset($ResultArr['back'][$run]) ? $ResultArr['back'][$run] : 0;
          
          $profitL =  $val;
          if($profitB < 0 && $profitL < 0){
            $pL = (abs($profitB)+abs($profitL))*(-1);
          }else if($profitB >= 0 && $profitL >= 0){
            $pL = ($profitB+$profitL);
          }else if($profitB >= 0 && $profitL <= 0){
            $pL = ($profitB - abs($profitL));
          }else if($profitB <= 0 && $profitL >= 0){
            if($profitL >= abs($profitB)){
              $pL = ($profitL-abs($profitB));
            }else{
              $pL = ($profitL-abs($profitB));
            }
          }
          $dataArr[$run]['profitLay'] = $profitL;
          $dataArr[$run]['profitBack'] = $profitB;
          $dataArr[$run]['profit'] = $pL;
        }
      }elseIf(isset($ResultArr['back'])){
        foreach($ResultArr['back'] as $run=>$val){
          $pL = 0;
          $profitL = isset($ResultArr['lay'][$run]) ? $ResultArr['lay'][$run] : 0;
          $profitB =  $val;
          if($profitB < 0 && $profitL < 0){
            $pL = (abs($profitB)+abs($profitL))*(-1);
          }else if($profitB > 0 && $profitL > 0){
            $pL = ($profitB+$profitL);
          }else if($profitB > 0 && $profitL < 0){
            $pL = ($profitB - abs($profitL));
          }else if($profitB < 0 && $profitL > 0){
            if($profitL > abs($profitB)){
              $pL = ($profitL-abs($profitB));
            }else{
             $pL = ($profitL-abs($profitB));
            }
          }
          $dataArr[$run]['profitLay'] = $profitL;
          $dataArr[$run]['profitBack'] = $profitB;
          $dataArr[$run]['profit'] = $pL;
        }
      }
//      dd($dataArr);
      return $dataArr;
    }
    public static function getChildUserListArr($userID){
    
    $model = User::where(['parent_id'=>$userID])->get();
    $userArr = array();
    foreach($model as $key=>$user){
      $userArr[] = $user->id;
      $data = self::getChildUserListArr($user->id);
      foreach($data as $j=>$val){
        $userArr[] = $val;
      }
    }
    return $userArr;
  }
    
    public static function getCalBackSession($teanName,$matchID,$run){
        $loginUserID = Auth::user()->id;
        $childUsers = self::getChildUserListArr($loginUserID);
        if(is_array($childUsers) && count($childUsers) > 0){
            $userTxt = implode(',',$childUsers);
        }else{
            $userTxt = Auth::user()->id;
        }
        $sql = "SELECT * FROM `my_bets` 
                        WHERE bet_side='back' 
                        AND bet_type='SESSION' 
                        AND team_name='".$teanName."'
                        AND match_id = '".$matchID."'
                        AND isDeleted=0 AND active=1
                        AND user_id IN (".$userTxt.")";
        
        $myBetsModelBack = DB::select($sql); 
      
        $backAmount = 0;
        $amtData = 0;
//      $run = 46;
        $loginUserID = Auth::user()->id;
        $partnershipArr = array();
        foreach($myBetsModelBack as $key=>$backVal){
            // 73 >= 73
            $partnershipArr = self::getUserPartnershipPer($backVal->user_id);
            if(isset($partnershipArr[$loginUserID]) && $partnershipArr[$loginUserID]['current'] > 0){
                if($run >= $backVal->bet_odds){
                    if($backAmount > 0){
                        $amt = ($backAmount+(($backVal->bet_oddsk*$backVal->bet_amount)/100));
                        $amt = self::getCalPerByUser($loginUserID,$partnershipArr,$amt);
                        $amtData += $amt;
                    }else{
                      // -100 +200
                        $amt = ((($backVal->bet_oddsk*$backVal->bet_amount)/100)-abs($backAmount));
                        $amt = self::getCalPerByUser($loginUserID,$partnershipArr,$amt); 
                        $amtData += $amt;
                    }
                }else{
                    $amt = ($backVal->bet_amount*(-1));
                    $amt = self::getCalPerByUser($loginUserID,$partnershipArr,$amt);
                    $amtData += $amt;
                }
            }
        }
        return $amtData;
    }
    public static function getChildUserList($userID = ''){
        if(empty($userID)){
            $userID = Auth::user()->id;
        } 
        $model = User::where(['parent_id'=>$userID])->get();
        $userArr = array();
        foreach($model as $key=>$user){
            $userArr[] = $user;
            $data = self::getChildUserList($user->id);
            foreach($data as $j=>$val){
               $userArr[] = $val;
            }
        }
        return $userArr;
      } 
    public static function getChildUserRoleOnlyList($userID = ''){
        if(empty($userID)){
            $userID = Auth::user()->id;
        } 
        $model = User::where(['parent_id'=>$userID])->get();
        $userArr = array();
        foreach($model as $key=>$user){
            if($user->roles->first()->name == 'user'){
              $userArr[] = $user;  
            }
            $data = self::getChildUserList($user->id);
            foreach($data as $j=>$val){
                if($val->roles->first()->name == 'user'){
                    $userArr[] = $val;
                }
            }
        }
        return $userArr;
      }   
     public static function getCalLaySession($teanName,$matchID,$run){
        $loginUserID = Auth::user()->id;
        $childUsers = self::getChildUserListArr($loginUserID);
        if(is_array($childUsers) && count($childUsers) > 0){
            $userTxt = implode(',',$childUsers);
        }else{
            $userTxt = Auth::user()->id;
        }
        $sql = "SELECT * FROM `my_bets` 
                        WHERE bet_side='lay' 
                        AND bet_type='SESSION' 
                        AND team_name='".$teanName."'
                        AND match_id = '".$matchID."'
                        AND isDeleted=0 AND active=1
                        AND user_id IN (".$userTxt.")";
        
        $myBetsModelLay = DB::select($sql);        
        
        $layAmount = 0;
        $amtData = 0;
        $partnershipArr = array();
        foreach($myBetsModelLay as $key=>$layVal){
            $partnershipArr = self::getUserPartnershipPer($layVal->user_id);
            if($run >= $layVal->bet_odds){
                $amt = (($layVal->bet_oddsk*$layVal->bet_amount)/100);
                if($layAmount > 0){
                  $layAmount += $amt;
                }else{
                  $layAmount = (0-(abs($layAmount)+$amt));
                }
                $amtData = self::getCalPerByUser($loginUserID,$partnershipArr,$layAmount);
            }else{
                if($layAmount >= 0){
                  $layAmount = ($layAmount+$layVal->bet_amount);
                  $amtData = self::getCalPerByUser($loginUserID,$partnershipArr,$layAmount);
                }else{
                    if($layVal->bet_amount > abs($layAmount)){
                        $layAmount = ($layVal->bet_amount-abs($layAmount));
                        $amtData = self::getCalPerByUser($loginUserID,$partnershipArr,$layAmount);
                    }else{
                        $layAmount = ((abs($layAmount)-$layVal->bet_amount)*(-1));
                        $amtData = self::getCalPerByUser($loginUserID,$partnershipArr,$layAmount);
                    }
                }
            }
        }
      return $amtData;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteMyBet(Request $request){
      $requestData = $request->all();
      $model = MyBets::find($requestData['id']);
      $model->isDeleted = 1;
//      $model->active = 0;
      if($model->save()){
        $responce['status'] = true;
        $responce['message'] = 'Bet deleted';
        return json_encode($responce);
      }
      $responce['status'] = false;
      $responce['message'] = 'Bet Not deleted';
      return json_encode($responce);
    }
    public function rollBackMyBet(Request $request){
      $requestData = $request->all();
      $model = MyBets::find($requestData['id']);
      $model->isDeleted = 0;
//      $model->active = 1;
      if($model->save()){
        $responce['status'] = true;
        $responce['message'] = 'Bet RollBack';
        return json_encode($responce);
      }
      $responce['status'] = false;
      $responce['message'] = 'Bet Not RollBack';
      return json_encode($responce);
    }
    
    public function viewMoreBets(Request $request){
        $requestData = $request->all();
        $sportModel = Sports::find($requestData['sportID']);
        $html = SportsController::getMyAllBets($sportModel->match_id,true);
        return $html;
    }
    
    public function viewMoreBetsAll(Request $request){
        $requestData = $request->all();
        $sportModel = Sports::find($requestData['sportID']);
        $html = SportsController::getMyAllBetsViewAll($sportModel->match_id,$requestData);
        return $html;
    }
    
}
