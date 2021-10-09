<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Request as resAll;
use App\MyBets;
use App\Sports;
use App\Games;
use App\LockUnlockBet;
use Auth;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Auth as AuthNew;
class MyBetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     /** CRITECT AND TENNIS LIST BETS**/
     public function userBooks(Request $request){
        $requestData = $request->all();
        $sportsModel =  Sports::where(['id'=>$requestData['sportID']])->first();
        $gameModel = Games::where(["id" => $sportsModel->game_id])->first();
        if(strtoupper($gameModel->name) == 'SOCCER'){
//          $html = self::getUserDataSoccer($requestData['sportID'],$requestData['type']);
          $html = self::getUserDataCricketTennis($requestData['sportID'],$requestData['type']);
        }else{
          $html = self::getUserDataCricketTennis($requestData['sportID'],$requestData['type']);
        }
        return $html;
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
     public static function getUserDataCricketTennis($sportID,$type){
        $myBetsModel = MyBets::where(['sportID'=>$sportID,'active'=>1,'isDeleted'=>0])->first();
        $teamNameArr = array();
        $sportModel = Sports::find($sportID);
        $extra = json_decode($sportModel->extra,true);
//        dd($extra);
        foreach($extra as $key=>$team){
          $teamNameArr[] = $team;
        }
        $betType = '';
        if($type == 'UserBook'){
          $betType = 'ODDS';
        }else{
          $betType = 'BOOKMAKER';
        }
          $body = '';
          $userd = User::where(['id'=>AuthNew::user()->id])->first();
          if(strtoupper($userd->roles->first()->name) == 'ADMINISTRATOR'){
            $betModel = MyBets::where(['sportID'=>$sportID,'bet_type'=>$betType,'active'=>1,'isDeleted'=>0])->get();
            $userArr = array();
            $i = 1;
            foreach($betModel as $key=>$bet){
              if(isset($userArr[$bet->user_id])){
                continue;
              }
              $userArr[$bet->user_id] = $bet->user_id;
              $uArr = User::where(['id'=>$bet->user_id])->first();

              $data = self::getuserbet($sportID,$bet->user_id);
//              if(!isset($data[$betType][$name][$betType.'_profitLost'])){
//                continue;
//              }
              $body .= '<tr>';
              $body .= '<td>'.$i++.'</td>';
              $body .= '<td>'.$uArr->first_name.'</td>';
              foreach($teamNameArr as $key=>$name){
                $color = "style='color:red;'";
                if(isset($data[$betType][$name][$betType.'_profitLost']) && $data[$betType][$name][$betType.'_profitLost'] > 0){
                  $color = "style='color:Green;'";
                }
                $body .= '<td '.$color.'>'.(isset($data[$betType][$name][$betType.'_profitLost']) ? $data[$betType][$name][$betType.'_profitLost'] : '').'</td>';
              }
              $body .= '</tr>';
            }
          }else{
            $userModel = self::getChildUserList(AuthNew::user()->id);
             $i = 1;
            foreach($userModel as $key=>$user){
              if(strtoupper($user->roles->first()->name) != 'USER'){
                continue;
              }
              $data = self::getuserbet($sportID,$user->id);
              if(!isset($data[$betType])){
                continue;
              }
              $body .= '<tr>';
              $body .= '<td>'.$i++.'</td>';
              $body .= '<td><b>'.$user->first_name.'</b></td>';
              foreach($teamNameArr as $key=>$name){
                $color = "style='color:red;'";
                if(isset($data[$betType][$name][$betType.'_profitLost']) && $data[$betType][$name][$betType.'_profitLost'] > 0){
                  $color = "style='color:Green;'";
                }
                $body .= '<td '.$color.'>'.(isset($data[$betType][$name][$betType.'_profitLost']) ? $data[$betType][$name][$betType.'_profitLost'] : '').'</td>';

//                $body .= '<td>'.(isset($data['ODDS'][$name]['ODDS_profitLost']) ? $data['ODDS'][$name]['ODDS_profitLost'] : '').'</td>';
              }
              $body .= '</tr>';
            }
          }



        $header = '<tr>';
        $header .= '<td><b>Sr. No.</b></td>';
        $header .= '<td><b>User Name</b></td>';
        foreach($teamNameArr as $key=>$name){
          $header .= '<td><b>'.$name.'</b></td>';
        }
        $header .= '</tr>';

        $html = '<table class="table table-bordered">';
        $html .= '<thead>';
          $html .= $header;
        $html .= '</thead>';
        $html .= '<tbody>';
          $html .= $body;
        $html .= '</tbody>';
        $html .= '</table>';
       return $html;
     }
     public static function getuserbet($sportID,$userID){

      $myBetsModel = MyBets::where(['sportID'=>$sportID,'user_id'=>$userID,'active'=>1,'isDeleted'=>0])->get();
      $response = array();
      $arr = array();
      foreach($myBetsModel as $key=>$bet){
        $extra = json_decode($bet->extra,true);
        switch($bet['bet_type']){
          case "ODDS":{
            $profitAmt = $bet['bet_profit'];
            if($bet['bet_side'] == 'lay'){
              $profitAmt = ($profitAmt*(-1));
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
              if(isset($extra['teamname4']) && !empty($extra['teamname4'])){
                if(!isset($response['ODDS'][$extra['teamname4']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname4']]['ODDS_profitLost'] = $bet['bet_amount'];
                }else{
                  $response['ODDS'][$extra['teamname4']]['ODDS_profitLost'] += $bet['bet_amount'];
                }
              }

            }else{
              $bet_amt = ($bet['bet_amount']*(-1));
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
            $profitAmt = $bet['bet_profit'];
            if($bet['bet_side'] == 'lay'){
              $profitAmt = ($profitAmt*(-1));
              if(!isset($response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'])){
                $response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] = $profitAmt;
              }else{
                $response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] += $profitAmt;
              }
              if(isset($extra['teamname1']) && !empty($extra['teamname1'])){
                if(!isset($response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'])){
                  $response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'] = $bet['bet_amount'];
                }else{
                  $response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'] += $bet['bet_amount'];
                }
              }

              if(isset($extra['teamname2']) && !empty($extra['teamname2'])){
                if(!isset($response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'])){
                  $response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'] = $bet['bet_amount'];
                }else{
                 $response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'] += $bet['bet_amount'];
                }
              }

              if(isset($extra['teamname3']) && !empty($extra['teamname3'])){
                if(!isset($response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'])){
                  $response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'] = $bet['bet_amount'];
                }else{
                  $response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'] += $bet['bet_amount'];
                }
              }

            }else{
              $bet_amt = ($bet['bet_amount']*(-1));
              if(!isset($response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'])){
                $response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] = $profitAmt;
              }else{
                $response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] += $profitAmt;
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

        }
      }
      return $response;
     }
     public function index(Request $request)
    {
    // dd(1);
      $requestData = $request->all();
      $sportsModel =  Sports::where(['id'=>$requestData['sportID']])->first();
      $gameModel = Games::where(["id" => $sportsModel->game_id])->first();
      $myBetsModel = MyBets::where(['sportID'=>$requestData['sportID'],'user_id'=>AuthNew::user()->id,'active'=>1,'isDeleted'=>0])->orderBy('id','DESC')->get();
      $response = array();
      $arr = array();
      $tot = 0;
      foreach($myBetsModel as $key=>$bet){
        $extra = json_decode($bet->extra,true);
        switch($bet['bet_type']){
          case "ODDS":{
            $profitAmt = $bet['bet_profit'];
            if($bet['bet_side'] == 'lay'){
//               $tot +=$profitAmt;
              $profitAmt = ($profitAmt*(-1));
              if(!isset($response['ODDS'][$bet['team_name']]['ODDS_profitLost'])){
//                  $tot +=$profitAmt;
                $response['ODDS'][$bet['team_name']]['ODDS_profitLost'] = $profitAmt;
              }else{
//                   $tot +=$profitAmt;
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
              if(isset($extra['teamname4']) && !empty($extra['teamname4'])){
                if(!isset($response['ODDS'][$extra['teamname4']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname4']]['ODDS_profitLost'] = $bet['bet_amount'];
                }else{
                  $response['ODDS'][$extra['teamname4']]['ODDS_profitLost'] += $bet['bet_amount'];
                }
              }

            }else{
              $bet_amt = ($bet['bet_amount']*(-1));
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
          case "ODDSPAIR":{
            $profitAmt = $bet['bet_profit'];
            if($bet['bet_side'] == 'lay'){
              $profitAmt = ($profitAmt*(-1));
              if(!isset($response['ODDSPAIR'][$bet['team_name']]['ODDSPAIR_profitLost'])){
                $response['ODDSPAIR'][$bet['team_name']]['ODDSPAIR_profitLost'] = $profitAmt;
              }else{
                $response['ODDSPAIR'][$bet['team_name']]['ODDSPAIR_profitLost'] += $profitAmt;
              }
              if(isset($extra['teamname1']) && !empty($extra['teamname1'])){
                if(!isset($response['ODDSPAIR'][$extra['teamname1']]['ODDSPAIR_profitLost'])){
                  $response['ODDSPAIR'][$extra['teamname1']]['ODDSPAIR_profitLost'] = $bet['bet_amount'];
                }else{
                  $response['ODDSPAIR'][$extra['teamname1']]['ODDSPAIR_profitLost'] += $bet['bet_amount'];
                }
              }

              if(isset($extra['teamname2']) && !empty($extra['teamname2'])){
                if(!isset($response['ODDSPAIR'][$extra['teamname2']]['ODDSPAIR_profitLost'])){
                  $response['ODDSPAIR'][$extra['teamname2']]['ODDSPAIR_profitLost'] = $bet['bet_amount'];
                }else{
                 $response['ODDSPAIR'][$extra['teamname2']]['ODDSPAIR_profitLost'] += $bet['bet_amount'];
                }
              }

              if(isset($extra['teamname3']) && !empty($extra['teamname3'])){
                if(!isset($response['ODDSPAIR'][$extra['teamname3']]['ODDSPAIR_profitLost'])){
                  $response['ODDSPAIR'][$extra['teamname3']]['ODDSPAIR_profitLost'] = $bet['bet_amount'];
                }else{
                  $response['ODDSPAIR'][$extra['teamname3']]['ODDSPAIR_profitLost'] += $bet['bet_amount'];
                }
              }

            }else{
              $bet_amt = ($bet['bet_amount']*(-1));
              if(!isset($response['ODDSPAIR'][$bet['team_name']]['ODDSPAIR_profitLost'])){
                $response['ODDSPAIR'][$bet['team_name']]['ODDSPAIR_profitLost'] = $profitAmt;
              }else{
                $response['ODDSPAIR'][$bet['team_name']]['ODDSPAIR_profitLost'] += $profitAmt;
              }

              if(isset($extra['teamname1']) && !empty($extra['teamname1'])){
                if(!isset($response['ODDSPAIR'][$extra['teamname1']]['ODDSPAIR_profitLost'])){
                  $response['ODDSPAIR'][$extra['teamname1']]['ODDSPAIR_profitLost'] = $bet_amt;
                }else{
                  $response['ODDSPAIR'][$extra['teamname1']]['ODDSPAIR_profitLost'] += $bet_amt;
                }
              }

              if(isset($extra['teamname2']) && !empty($extra['teamname2'])){
                if(!isset($response['ODDSPAIR'][$extra['teamname2']]['ODDSPAIR_profitLost'])){
                  $response['ODDSPAIR'][$extra['teamname2']]['ODDSPAIR_profitLost'] = $bet_amt;
                }else{
                 $response['ODDSPAIR'][$extra['teamname2']]['ODDSPAIR_profitLost'] += $bet_amt;
                }
              }

              if(isset($extra['teamname3']) && !empty($extra['teamname3'])){
                if(!isset($response['ODDSPAIR'][$extra['teamname3']]['ODDSPAIR_profitLost'])){
                  $response['ODDSPAIR'][$extra['teamname3']]['ODDSPAIR_profitLost'] = $bet_amt;
                }else{
                  $response['ODDSPAIR'][$extra['teamname3']]['ODDSPAIR_profitLost'] += $bet_amt;
                }
              }
            }
            break;
          }
          case 'BOOKMAKER':{
            $profitAmt = $bet['bet_profit'];
            if($bet['bet_side'] == 'lay'){
              $profitAmt = ($profitAmt*(-1));
              if(!isset($response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'])){
                $response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] = $profitAmt;
              }else{
                $response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] += $profitAmt;
              }
              if(isset($extra['teamname1']) && !empty($extra['teamname1'])){
                if(!isset($response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'])){
                  $response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'] = $bet['bet_amount'];
                }else{
                  $response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'] += $bet['bet_amount'];
                }
              }

              if(isset($extra['teamname2']) && !empty($extra['teamname2'])){
                if(!isset($response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'])){
                  $response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'] = $bet['bet_amount'];
                }else{
                 $response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'] += $bet['bet_amount'];
                }
              }

              if(isset($extra['teamname3']) && !empty($extra['teamname3'])){
                if(!isset($response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'])){
                  $response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'] = $bet['bet_amount'];
                }else{
                  $response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'] += $bet['bet_amount'];
                }
              }

            }else{
              $bet_amt = ($bet['bet_amount']*(-1));
              if(!isset($response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'])){
                $response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] = $profitAmt;
              }else{
                $response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] += $profitAmt;
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
            $response['SESSION'][$bet['team_name']] = $bet['team_name'];
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
//      dd($response);
//      dd($tot);
      $response['exposureAmt'] = SELF::getExAmount();
      $response['headerUserBalance'] = SELF::getBlanceAmount() - SELF::getExAmount() ;
  
      $response['matchSuspended'] = SELF::getMatchSuspended($requestData['sportID']);
      $response['myBetData'] = view("frontend.my-bets.getBet",compact('myBetsModel'))->render();
// dd($response);
      return json_encode($response);
    }
    public static function getMatchSuspended($sportID){

      $userChild = self::getParentUser(Auth::user()->id);
      $userChild[] = Auth::user()->id;

      krsort($userChild);
      foreach($userChild as $key=>$userID){
        $lockUnlockModel = LockUnlockBet::where(['sportID'=>$sportID,'user_id'=>$userID,'lockType'=>'SUSPENDED'])->first();
        if(isset($lockUnlockModel->id) && $lockUnlockModel->type != 'UNSUSPEND'){
          break;
        }
      }

      if(isset($lockUnlockModel)){
        if($lockUnlockModel->lockType == 'SUSPENDED'){
          if($lockUnlockModel->type == 'SUSPEND'){
            return true;
          }else{
            return false;
          }
        }
      }
      foreach($userChild as $key=>$userID){
        $lockUnlockModel = LockUnlockBet::where(['sportID'=>$sportID,'user_id'=>$userID,'lockType'=>'ODDS'])->first();
        if(isset($lockUnlockModel->id) && $lockUnlockModel->type != 'UNLOCK'){
          break;
        }
      }
//      dd($lockUnlockModel);
      if(isset($lockUnlockModel)){
        if($lockUnlockModel->lockType == 'ODDS'){
          if($lockUnlockModel->type == 'SUSPEND'){
            return true;
          }else{
            return false;
          }
        }
      }
      return false;
    }

    /** CRICKET AND TENNIS LIST END **/

    public static function getParentUser($userID){
      $arr = array();
//      dd($userID);
      $userModel = User::where(['id'=>$userID])->get();
      foreach($userModel as $key=>$user){
        if($user->parent_id == 0){
          $arr[] = $userID;
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
    /***** CRICKET TENNIS BET STORE ****/
    public static function getBetActiveStatus($userID){
      $userModel = User::find($userID);
      if($userModel->betActive == 0){
        return true;
      }
      if($userModel->parent_id != 0){
        $data = self::getBetActiveStatus($userModel->parent_id);
        if($data){
          return true;
        }
      }
      return false;
    }
    public function store(Request $request){
      $requestData = $request->all();
      if(isset($requestData['team_name']) && !empty($requestData['team_name'])){
        $requestData['team_name'] = urldecode($requestData['team_name']);
      }
      if(isset($requestData['teamname1']) && !empty($requestData['teamname1'])){
        $requestData['teamname1'] = urldecode($requestData['teamname1']);
      }
      if(isset($requestData['teamname2']) && !empty($requestData['teamname2'])){
        $requestData['teamname2'] = urldecode($requestData['teamname2']);
      }
      if(isset($requestData['teamname3']) && !empty($requestData['teamname3'])){
        $requestData['teamname3'] = urldecode($requestData['teamname3']);
      }
      $parentStatus = self::getBetActiveStatus(Auth::user()->id);
      if($parentStatus){
        $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Lock By Admin</div>';
        return json_encode($responce);
      }
      $requestData['team_name'] = str_replace('#', '+',$requestData['team_name']);

      $responce = array();
      $responce['status'] = false;
      $responce['message'] = '<div class="alert alert-danger">bet not added</div>';

      $userId = Auth::user()->id;
      $user = User::find($userId);
      if($user->betActive != 1){
        $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Lock By Admin</div>';
        return json_encode($responce);
      }

      if((int)$requestData['bet_amount'] > (int)$user->exposelimit){
        $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Exposure Limit Exceed1.1</div>';
        return json_encode($responce);
      }
      $userChild = self::getParentUser(Auth::user()->id);
      krsort($userChild);
      foreach($userChild as $key=>$userID){
        $lockUnlockModel = LockUnlockBet::where(['sportID'=>$requestData['sportID'],'user_id'=>$userID,'lockType'=>$requestData['bet_type']])->first();
        if(isset($lockUnlockModel->id) && $lockUnlockModel->type != 'UNLOCK'){
          break;
        }

      }
      $extra = array();
      if(isset($lockUnlockModel->extra) && !empty($lockUnlockModel->extra)){
        $extra = explode(',', $lockUnlockModel->extra);
      }
      if($lockUnlockModel){
        if($lockUnlockModel->lockType == 'ODDS'){

          if($lockUnlockModel->type == 'LOCK'  && $requestData['bet_type'] == 'ODDS'){

            if(is_array($extra) && count($extra) > 0 && in_array(Auth::user()->id, $extra)){
              $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Lock By Admin</div>';
              return json_encode($responce);
            }
            if(is_array($extra) && count($extra) == 0){
              $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Lock By Admin</div>';
              return json_encode($responce);
            }
          }
        }else if($lockUnlockModel->lockType == 'BOOKMAKER'){

          if($lockUnlockModel->type == 'LOCK' && $requestData['bet_type'] == 'BOOKMAKER'){
            if(is_array($extra) && count($extra) > 0 && in_array(Auth::user()->id, $extra)){
              $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Lock By Admin</div>';
              return json_encode($responce);
            }
            if(is_array($extra) && count($extra) == 0){
              $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Lock By Admin</div>';
              return json_encode($responce);
            }
          }
        }else if($lockUnlockModel->lockType == 'SESSION'){
          if($lockUnlockModel->type == 'LOCK' && $requestData['bet_type'] == 'SESSION'){
            if(is_array($extra) && count($extra) > 0 && in_array(Auth::user()->id, $extra)){
              $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Lock By Admin</div>';
              return json_encode($responce);
            }
            if(is_array($extra) && count($extra) == 0){
              $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Lock By Admin</div>';
              return json_encode($responce);
            }
          }
        }
      }
      $exposureAmt = SELF::getExAmount();
      $expAmt = $exposureAmt;
      if($requestData['bet_type'] == 'SESSION'){
         if($requestData['bet_side'] == 'lay'){
            $betamount = $requestData['bet_amount'];
            $bet_oddsK  = $requestData['bet_oddsK'];
            $expAmt += (($betamount*$bet_oddsK)/100);
         }else{
            $betamount = $requestData['bet_amount'];
            $expAmt += $betamount;
         }
      }

        $headerUserBalance = SELF::getBlanceAmount();
        if($headerUserBalance <= 0){
          $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
          return json_encode($responce);
        }
        $isExBalEq = false;
        if($headerUserBalance == $exposureAmt){
            $isExBalEq = true;
        }
        if($headerUserBalance < ($exposureAmt)){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
            return json_encode($responce);
        }else{
            $exAmtArr = self::getExAmountCricketAndTennis($requestData['sportID'],$requestData['match_id'],$userId);
            if(isset($exAmtArr[$requestData['bet_type']][$requestData['team_name']][$requestData['bet_type']."_profitLost"])){
                $exArrs = array();
                $betprofit = $exAmtArr[$requestData['bet_type']][$requestData['team_name']][$requestData['bet_type']."_profitLost"];
                $exArrs[] = $betprofit;
                if($requestData['bet_type'] == 'BOOKMAKER'){
                    $betamount = (($requestData['bet_odds']*$requestData['bet_amount'])/100);
                }else{
                    $betamount = (($requestData['bet_odds']*$requestData['bet_amount'])-$requestData['bet_amount']);
                }
                $betprofit1 = $betprofit2 = $betprofit3 = '';
                if(isset($requestData['teamname1']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname1']][$requestData['bet_type']."_profitLost"])){
                    $betprofit1 = $exAmtArr[$requestData['bet_type']][$requestData['teamname1']][$requestData['bet_type']."_profitLost"];
                    $exArrs[] = $betprofit1;
                }
                if(isset($requestData['teamname2']) && !empty($requestData['teamname2']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname2']][$requestData['bet_type']."_profitLost"])){
                    $betprofit2 = $exAmtArr[$requestData['bet_type']][$requestData['teamname2']][$requestData['bet_type']."_profitLost"];
                    $exArrs[] = $betprofit2;
                }
                if(isset($requestData['teamname3']) && !empty($requestData['teamname3']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname3']][$requestData['bet_type']."_profitLost"])){
                    $betprofit3= $exAmtArr[$requestData['bet_type']][$requestData['teamname3']][$requestData['bet_type']."_profitLost"];
                    $exArrs[] = $betprofit3;
                }
                $teamMaxEx = min($exArrs);
                if($requestData['bet_side'] == 'lay'){
                    $newExArr = array();
                    if($betprofit > 0){
                        $amt = abs($betprofit)-abs($betamount);
                        if($amt > 0){
                            $amt = 0;
                        }
                        $newExArr['betTeam'] = $amt;
                        if($betprofit1 < 0){
                            if($requestData['bet_amount'] < abs($betprofit1)){
                                $newExArr['betTeam1'] = $requestData['bet_amount']-abs($betprofit1);
                            }else{
                                $newExArr['betTeam1'] = $requestData['bet_amount']-abs($betprofit1);
                            }
                        }
                        if($betprofit2 < 0){
                            if($requestData['bet_amount'] < abs($betprofit2)){
                                $newExArr['betTeam2'] = $requestData['bet_amount']-abs($betprofit2);
                            }else{
                                $newExArr['betTeam2'] = $requestData['bet_amount']-abs($betprofit2);
                            }
                        }
                        if($betprofit3 < 0){
                            if($requestData['bet_amount'] < abs($betprofit3)){
                                $newExArr['betTeam3'] = $requestData['bet_amount']-abs($betprofit3);
                            }else{
                                $newExArr['betTeam3'] = $requestData['bet_amount']-abs($betprofit3);
                            }
                        }

                        $newTeamExMin = MIN($newExArr);
                        if($isExBalEq){
                            if(abs($teamMaxEx) < abs($newTeamExMin)){
                                $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                return json_encode($responce);
                            }
                        }else{
                            if(abs($teamMaxEx) < abs($newTeamExMin)){
                                $amtEx = (abs($newTeamExMin)-abs($teamMaxEx));
                                $ex = 0;
                                if($amtEx < 0){
                                    $ex =  abs($exposureAmt)-abs($amt);
                                }else{
                                    $ex =  abs($exposureAmt)+abs($amt);
                                }
                                if($headerUserBalance < $ex){
                                    $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                    return json_encode($responce);
                                }
                            }
                        }
                    }else{
                        $amt = abs($betamount)+abs($betprofit);
                        $amt = ($exposureAmt+$betamount);
                        if($headerUserBalance < (abs($amt))){
                                $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                return json_encode($responce);
                        }
                    }
                    if(isset($requestData['teamname1']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname1']][$requestData['bet_type']."_profitLost"])){
                            $betprofit1 = $exAmtArr[$requestData['bet_type']][$requestData['teamname1']][$requestData['bet_type']."_profitLost"];
                            if($betprofit1 >= 0){
                                    $betamount = $requestData['bet_amount'];
                                    $amt = $betprofit1 - abs($betamount);
                                    $amt = 0;
                                    if($headerUserBalance < ($exposureAmt+abs($amt))){
                                            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                            return json_encode($responce);
                                    }
                            }
                    }
                    if(isset($requestData['teamname2']) && !empty($requestData['teamname2']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname2']][$requestData['bet_type']."_profitLost"])){
                            $betprofit2 = $exAmtArr[$requestData['bet_type']][$requestData['teamname2']][$requestData['bet_type']."_profitLost"];
                           if($betprofit2 >= 0){
                                    $betamount = $requestData['bet_amount'];
                                    $amt = $betprofit2 - abs($betamount);
                                    $amt = 0;
                                    if($amt < 0){
                                        if($headerUserBalance < ($exposureAmt+abs($amt))){
                                                $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                                return json_encode($responce);
                                        }
                                    }
                            }
                    }
                    if(isset($requestData['teamname3']) && !empty($requestData['teamname3']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname3']][$requestData['bet_type']."_profitLost"])){
                            $betprofit3= $exAmtArr[$requestData['bet_type']][$requestData['teamname3']][$requestData['bet_type']."_profitLost"];
                            if($betprofit3 >= 0){
                                $betamount = $requestData['bet_amount'];
                                $amt = $betprofit3 - abs($betamount);
                                $amt = 0;
                                if($headerUserBalance < ($exposureAmt+abs($amt))){
                                        $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                        return json_encode($responce);
                                }
                            }
                    }
                }else{
                    $newExArr = array();
                    if($betprofit < 0){
                       $amt = abs($betamount)-abs($betprofit);
                        if($amt > 0){
                            $amt = 0;
                        }
                        $newExArr['betTeam'] = $amt;
                        if($betprofit1 < 0){
                            $newExArr['betTeam1'] = ($betprofit1-$requestData['bet_amount']);
                        }
                        if($betprofit2 < 0){
                            $newExArr['betTeam2'] = $betprofit2-$requestData['bet_amount'];

                        }
                        if($betprofit3 < 0){
                            $newExArr['betTeam3'] = $betprofit3-$requestData['bet_amount'];
                        }

                        $newTeamExMin = MIN($newExArr);
                        if($isExBalEq){
                            if(abs($teamMaxEx) < abs($newTeamExMin)){
                                $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                return json_encode($responce);
                            }
                        }else{
                            if(abs($teamMaxEx) < abs($newTeamExMin)){
                                $amtEx = (abs($teamMaxEx)-abs($newTeamExMin));
                                $ex = 0;
                                if($amtEx < 0){
                                    $ex =  abs($exposureAmt)+abs($amtEx);
                                }else{
                                    $ex =  abs($exposureAmt)-abs($amtEx);
                                }
                                if($headerUserBalance < $ex){
                                    $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                    return json_encode($responce);
                                }
                            }
                        }
                    }else{
                        $newExArr = array();
                        $amt = abs($betamount)+abs($betprofit);
                        if($amt > 0){
                            $amt = 0;
                        }
                        $newExArr['betTeam'] = $amt;
                        if($betprofit1 < 0){
                            $newExArr['betTeam1'] = ($betprofit1-$requestData['bet_amount']);
                        }
                        if($betprofit2 < 0){
                            $newExArr['betTeam2'] = $betprofit2-$requestData['bet_amount'];

                        }
                        if($betprofit3 < 0){
                            $newExArr['betTeam3'] = $betprofit3-$requestData['bet_amount'];
                        }
                        $newTeamExMin = MIN($newExArr);
                        if($isExBalEq){
                            if(abs($teamMaxEx) < abs($newTeamExMin)){
                                $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                return json_encode($responce);
                            }
                        }else{
                            if(abs($teamMaxEx) < abs($newTeamExMin)){
                                $amtEx = (abs($teamMaxEx)-abs($newTeamExMin));
                                $ex = 0;
                                if($amtEx < 0){
                                    $ex =  abs($exposureAmt)+abs($amtEx);
                                }else{
                                    $ex =  abs($exposureAmt)-abs($amtEx);
                                }
                                if($headerUserBalance < $ex){
                                    $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                    return json_encode($responce);
                                }
                            }
                        }
                    }
                }
            }else{
                if($requestData['bet_side'] == 'lay'){
                    if($requestData['bet_type'] == 'BOOKMAKER'){
                        $betamount = (($requestData['bet_odds']*$requestData['bet_amount'])/100);
                    }else if($requestData['bet_type'] == 'SESSION'){
                        $betamount = (($requestData['bet_oddsK']*$requestData['bet_amount'])/100);
                    }else{
                        $betamount = (($requestData['bet_odds']*$requestData['bet_amount'])-$requestData['bet_amount']);
                    }
                    if($headerUserBalance < ($exposureAmt+$betamount)){
                        $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                        return json_encode($responce);
                    }
                }else{
                    $betamount = $requestData['bet_amount'];
                    if($headerUserBalance < ($exposureAmt+$betamount)){
                        $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                        return json_encode($responce);
                    }
                }
            }
        }

      $sportsModel =  Sports::where(['id'=>$requestData['sportID']])->first();

      switch($requestData['bet_type']){
        case "ODDSPAIR":
        case "ODDS":{
          if(isset($sportsModel->odd_min_limit) && empty($sportsModel->odd_min_limit) &&
            (isset($sportsModel->odd_max_limit) && empty($sportsModel->odd_max_limit))){
            $responce['message'] = '<div id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Limit not Set.</div>';
            return json_encode($responce);
          }
          if($requestData['bet_amount'] < $sportsModel->odd_min_limit){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Min Max Bet Limit Exceed</div>';
            return json_encode($responce);
          }
          if($sportsModel->odd_max_limit < $requestData['bet_amount']){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Min Max Bet Limit Exceed1.2</div>';
            return json_encode($responce);
          }
          break;
        }
        case 'BOOKMAKER':{
          if(isset($sportsModel->bookmaker_min_limit) && empty($sportsModel->bookmaker_min_limit) &&
            (isset($sportsModel->bookmaker_max_limit) && empty($sportsModel->bookmaker_max_limit))){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Limit not Set.</div>';
            return json_encode($responce);
          }
          if($requestData['bet_amount'] < $sportsModel->bookmaker_min_limit){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Min Max Bet Limit Exceed</div>';
            return json_encode($responce);
          }
          if($sportsModel->bookmaker_max_limit < $requestData['bet_amount']){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Min Max Bet Limit Exceed</div>';
            return json_encode($responce);
          }
          break;
        }
        case 'SESSION':{
          if(isset($sportsModel->fancy_min_limit) && empty($sportsModel->fancy_min_limit) &&
            (isset($sportsModel->fancy_max_limit) && empty($sportsModel->fancy_max_limit))){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Limit not Set.</div>';
            return json_encode($responce);
          }
          if($requestData['bet_amount'] < $sportsModel->fancy_min_limit){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Min Max Bet Limit Exceed</div>';
            return json_encode($responce);
          }
          if($sportsModel->fancy_max_limit < $requestData['bet_amount']){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" style="margin-top: -7px;" class="close" data-dismiss="alert">x</button>Min Max Bet Limit Exceed</div>';
            return json_encode($responce);
          }
          break;
        }
      }

      $teamNameArr = array();
      if(isset($requestData['teamname1']) && !empty($requestData['teamname1'])){
        $requestData['teamname1'] = str_replace('#', '+',$requestData['teamname1']);
        $teamNameArr['teamname1'] = $requestData['teamname1'];
      }
      if(isset($requestData['teamname2']) && !empty($requestData['teamname2'])){
        $requestData['teamname2'] = str_replace('#', '+',$requestData['teamname2']);
        $teamNameArr['teamname2'] = $requestData['teamname2'];
      }
      if(isset($requestData['teamname3']) && !empty($requestData['teamname3'])){
        $requestData['teamname3'] = str_replace('#', '+',$requestData['teamname3']);
        $teamNameArr['teamname3'] = $requestData['teamname3'];
      }
      if(isset($requestData['teamname4']) && !empty($requestData['teamname4'])){
        $requestData['teamname4'] = str_replace('#', '+',$requestData['teamname4']);
        $teamNameArr['teamname4'] = $requestData['teamname4'];
      }

      $betModel = new MyBets();
      $betModel->sportID = $requestData['sportID'];
      $betModel->user_id = AuthNew::user()->id;
      $betModel->match_id = $requestData['match_id'];
      $betModel->bet_type = $requestData['bet_type'];
      $betModel->bet_side = $requestData['bet_side'];
      $betModel->bet_odds = $requestData['bet_odds'];
      if(isset($requestData['bet_oddsK']) && !empty($requestData['bet_oddsK'])){
        $betModel->bet_oddsK = $requestData['bet_oddsK'];
      }
//      return $requestData['team_name'];
      $betModel->bet_amount = $requestData['bet_amount'];
      $betModel->bet_profit = $requestData['bet_profit'];
      $betModel->team_name = $requestData['team_name'];
//      $betModel->team_name = (string)iconv(mb_detect_encoding($requestData['team_name'], mb_detect_order(), true), "UTF-8", $requestData['team_name']);;
      if(is_array($teamNameArr) && count($teamNameArr) > 0){
        $betModel->extra = json_encode($teamNameArr);
      }
      if($betModel->bet_side == 'lay'){
        $betModel->exposureAmt = $requestData['bet_profit'];
      }else{
        $betModel->exposureAmt = $requestData['bet_amount'];
      }
      $betModel->ip_address = resAll::ip();
      $betModel->browser_details = $_SERVER['HTTP_USER_AGENT'];
      if($betModel->save()){
        $responce['status'] = true;
        $responce['message'] = '<div  id="msg-alert" class="alert alert-success"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Added Succesfully</div>';
      }
      return json_encode($responce);
    }

    /*** CRICKET SESSION CALCULATION SHOW BOOK BUTTON DATA ****/
    public function getsessionsetsata(Request $request){
      $requestData = $request->all();
      $resultArr = SELF::getSessionValueByArr($requestData['match_id'],$requestData['teamName'],AuthNew::user()->id);
//      dd($resultArr);
      return view("frontend.my-bets.getBetSession",compact('resultArr'))->render();
    }
    public function __getsessionsetsata(Request $request){
      $requestData = $request->all();
      $myBetsModelLayMin = MyBets::where([
                                    'bet_side'=>'lay',
                                    'bet_type'=>'SESSION',
                                    'team_name'=>$requestData['teamName'],
                                    'match_id'=>$requestData['match_id'],
                                    'user_id'=>AuthNew::user()->id
                                  ])->min('bet_odds');

      $myBetsModelBackMax = MyBets::where([
                                    'bet_side'=>'back',
                                    'bet_type'=>'SESSION',
                                    'team_name'=>$requestData['teamName'],
                                    'match_id'=>$requestData['match_id'],
                                    'user_id'=>AuthNew::user()->id
                                  ])->max('bet_odds');

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
        $amtB = self::getCalBackSession($requestData['teamName'],$requestData['match_id'],AuthNew::user()->id,$i);
        $ResultArr['back'][$i] = $amtB;

        $amtL = self::getCalLaySession($requestData['teamName'],$requestData['match_id'],AuthNew::user()->id,$i);
        $ResultArr['lay'][$i] = $amtL;
        $i++;
      }
      return view("frontend.my-bets.getBetSession",compact('ResultArr'))->render();
    }

    public static function getSessionValueByArr($match_id,$teamName,$userID,$winnerRun = NULL){
      $myBetsModelLayMin = MyBets::where([
                                    'bet_side'=>'lay',
                                    'bet_type'=>'SESSION',
                                    'team_name'=>$teamName,
                                    'match_id'=>$match_id,
                                    'user_id'=>$userID,
                                    'isDeleted'=>0
                                  ])->min('bet_odds');

      $myBetsModelBackMax = MyBets::where([
                                    'bet_side'=>'back',
                                    'bet_type'=>'SESSION',
                                    'team_name'=>$teamName,
                                    'match_id'=>$match_id,
                                    'user_id'=>$userID,
                                    'isDeleted'=>0
                                  ])->max('bet_odds');

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
      if(!is_null($winnerRun)){
      if(!empty($winnerRun) || $winnerRun == 0 ){
        if($min > $winnerRun){
          $min = $winnerRun-2;
        }
        if($max < $winnerRun){
          $max = $winnerRun+2;
        }
      }
      }
      $i = $min;
      $ResultArr = array();
      while($max >= $i){
        $amtB = self::getCalBackSession($teamName,$match_id,$userID,$i);
        $ResultArr['back'][$i] = $amtB;

        $amtL = self::getCalLaySession($teamName,$match_id,$userID,$i);
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
      return $dataArr;
    }


    public static function getCalBackSession($teanName,$matchID,$userID,$run){
      $myBetsModelBack = MyBets::where([
                                    'bet_side'=>'back',
                                    'bet_type'=>'SESSION',
                                    'team_name'=>$teanName,
                                    'match_id'=>$matchID,
                                    'user_id'=>$userID,
                                    'isDeleted'=>0
                                  ])->get();
      $backAmount = 0;
//      $run = 46;
      foreach($myBetsModelBack as $key=>$backVal){
        // 73 >= 73
        if($run >= $backVal->bet_odds){
          if($backAmount > 0){
            $backAmount = ($backAmount+(($backVal->bet_oddsk*$backVal->bet_amount)/100));
          }else{
            // -100 +200
            $backAmount = ((($backVal->bet_oddsk*$backVal->bet_amount)/100)-abs($backAmount));
          }
        }else{
          $backAmount += ($backVal->bet_amount*(-1));
        }
      }
      return $backAmount;
    }

     public static function getCalLaySession($teanName,$matchID,$userID,$run){
      $myBetsModelLay = MyBets::where([
                                    'bet_side'=>'lay',
                                    'bet_type'=>'SESSION',
                                    'team_name'=>$teanName,
                                    'match_id'=>$matchID,
                                    'user_id'=>$userID,
                                    'isDeleted'=>0
                                  ])->get();
      $layAmount = 0;
      foreach($myBetsModelLay as $key=>$layVal){
        // 73 >= 73
        if($run >= $layVal->bet_odds){
          $amt = (($layVal->bet_oddsk*$layVal->bet_amount)/100);

          if($layAmount > 0){
            $layAmount = $amt;
          }else{
            $layAmount = (0-(abs($layAmount)+$amt));
          }
        }else{
          if($layAmount > 0){
            $layAmount = ($layAmount+$layVal->bet_amount);
          }else{
            if($layVal->bet_amount > abs($layAmount)){
              $layAmount = ($layVal->bet_amount-abs($layAmount));
            }else{
              $layAmount = ((abs($layAmount)-$layVal->bet_amount)*(-1));
            }
          }
        }
      }
      return $layAmount;
    }

    /**** OLD FUNCTION CAL SESSION ***/
    public static function getCalSession($teanName,$matchID,$userID,$run){
      $responce = array();
      $myBetsModelLay = MyBets::where([
                                    'bet_side'=>'lay',
                                    'bet_type'=>'SESSION',
                                    'team_name'=>$teanName,
                                    'match_id'=>$matchID,
                                    'user_id'=>$userID,
                                    'isDeleted'=>0
                                  ])->get();

      $myBetsModelBack = MyBets::where([
                                    'bet_side'=>'back',
                                    'bet_type'=>'SESSION',
                                    'team_name'=>$teanName,
                                    'match_id'=>$matchID,
                                    'user_id'=>$userID,
                                    'isDeleted'=>0
                                  ])->get();


    }



    /************************************* SOCCER *******************************************/

    /*** SOCCER LIST BETS AND SESSION ***/

    public function soccerindex(Request $request)
    {
      $requestData = $request->all();
      $sportsModel =  Sports::where(['match_id'=>$requestData['match_id']])->first();
      $gameModel = Games::where(["id" => $sportsModel->game_id])->first();
      $myBetsModel = MyBets::where(['match_id'=>$requestData['match_id'],'user_id'=>AuthNew::user()->id,'active'=>1,'isDeleted'=>0])->orderBy('id','DESC')->get();
//      $myBetsModel = MyBets::where(['match_id'=>$requestData['match_id'],'active'=>1,'isDeleted'=>0])->get();
      $response = array();
      $arr = array();
      foreach($myBetsModel as $key=>$bet){
        $extra = json_decode($bet->extra,true);
        $betTypeArr = explode('-', $bet['bet_type']);
        switch($betTypeArr[0]){
          case "ODDS":{
            $profitAmt = $bet['bet_profit'];
            if($bet['bet_side'] == 'lay'){
              $profitAmt = ($profitAmt*(-1));
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
              if(!isset($response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'])){
                $response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'] = $profitAmt;
//                $response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_bet_amount'] = $bet['bet_amount'];
              }else{
                $response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'] += $profitAmt;
//                $response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_bet_amount'] += $bet['bet_amount'];
              }

              if(isset($extra['teamname1']) && !empty($extra['teamname1'])){
                if(!isset($response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost'])){
                  $response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost'] = $bet['bet_amount'];
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
      $response['exposureAmt'] = SELF::getExAmount();
      $response['headerUserBalance'] = SELF::getBlanceAmount();
      $response['matchSuspended'] = SELF::getMatchSuspended($requestData['sportID']);
      $response['myBetData'] = view("frontend.my-bets.getBet",compact('myBetsModel'))->render();

      return json_encode($response);
    }

    /****** END OF SOCCER LIST *******/

    /**** SOCCER STORE ****/

    public function soccerstore(Request $request){

        $requestData = $request->all();
        $requestData = $request->all();
        if(isset($requestData['team_name']) && !empty($requestData['team_name'])){
            $requestData['team_name'] = urldecode($requestData['team_name']);
        }
        if(isset($requestData['teamname1']) && !empty($requestData['teamname1'])){
            $requestData['teamname1'] = urldecode($requestData['teamname1']);
        }
        if(isset($requestData['teamname2']) && !empty($requestData['teamname2'])){
            $requestData['teamname2'] = urldecode($requestData['teamname2']);
        }
        if(isset($requestData['teamname3']) && !empty($requestData['teamname3'])){
            $requestData['teamname3'] = urldecode($requestData['teamname3']);
        }
        $userId = Auth::user()->id;
        $user = User::find($userId);
        if($user->betActive != 1){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Lock By Admin</div>';
            return json_encode($responce);
        }

        $userChild = self::getParentUser(Auth::user()->id);
        krsort($userChild);
        foreach($userChild as $key=>$userID){
            $exp = explode('-',$requestData['bet_type']);
            $lockUnlockModel = LockUnlockBet::where(['sportID'=>$requestData['sportID'],'user_id'=>$userID,'lockType'=>$exp[0]])->first();
            if(isset($lockUnlockModel->id) && $lockUnlockModel->type != 'UNLOCK'){
              break;
            }
        }
        $extra = array();

      if(isset($lockUnlockModel->extra) && !empty($lockUnlockModel->extra)){
        $extra = explode(',', $lockUnlockModel->extra);
      }
      if($lockUnlockModel){
        if($lockUnlockModel->lockType == 'ODDS'){
          if($lockUnlockModel->type == 'LOCK'  && $requestData['bet_type'] == 'ODDS'){

            if(is_array($extra) && count($extra) > 0 && in_array(Auth::user()->id, $extra)){
              $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Lock By Admin</div>';
              return json_encode($responce);
            }
            if(is_array($extra) && count($extra) == 0){
              $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Lock By Admin</div>';
              return json_encode($responce);
            }
          }
        }else if($lockUnlockModel->lockType == 'BOOKMAKER'){

          if($lockUnlockModel->type == 'LOCK' && $requestData['bet_type'] == 'BOOKMAKER'){
            if(is_array($extra) && count($extra) > 0 && in_array(Auth::user()->id, $extra)){
              $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Lock By Admin</div>';
              return json_encode($responce);
            }
            if(is_array($extra) && count($extra) == 0){
              $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Lock By Admin</div>';
              return json_encode($responce);
            }
          }
        }else if($lockUnlockModel->lockType == 'SESSION'){
          $arrData = explode('-', $requestData['bet_type']);
          if($lockUnlockModel->type == 'LOCK' && $arrData[0] == 'SESSION'){
            if(is_array($extra) && count($extra) > 0 && in_array(Auth::user()->id, $extra)){
              $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Lock By Admin</div>';
              return json_encode($responce);
            }
            if(is_array($extra) && count($extra) == 0){
              $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Lock By Admin</div>';
              return json_encode($responce);
            }
          }
        }
      }

        if((int)$requestData['bet_amount'] > (int)$user->exposelimit){
          $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Exposure Limit Exceed</div>';
          return json_encode($responce);
        }
        $responce = array();
        $responce['status'] = false;
        $responce['message'] = '<div class="alert alert-danger">bet not added</div>';

        $sportsModel =  Sports::where(['match_id'=>$requestData['match_id']])->first();
        $exArr = explode('-', $requestData['bet_type']);
        $betTypeOld = $requestData['bet_type'];
        $requestData['bet_type'] = $exArr[0];

        $betamount = $requestData['bet_amount'];
        $headerUserBalance = SELF::getBlanceAmount();
        if($headerUserBalance <= 0){
          $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
          return json_encode($responce);
        }

        $exposureAmt = SELF::getExAmount();
        $isExBalEq = false;
        if($headerUserBalance == $exposureAmt){
            $isExBalEq = true;
        }
      if($headerUserBalance < ($exposureAmt)){
          $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
          return json_encode($responce);
       }else{
                $exAmtArr = self::getExAmountCricketAndTennis($requestData['sportID'],$requestData['match_id'],$userId);
                if(isset($exAmtArr[$requestData['bet_type']][$requestData['team_name']][$requestData['bet_type']."_profitLost"])){
                       $exArrs = array();
                $betprofit = $exAmtArr[$requestData['bet_type']][$requestData['team_name']][$requestData['bet_type']."_profitLost"];
                $exArrs[] = $betprofit;
                if($requestData['bet_type'] == 'BOOKMAKER'){
                    $betamount = (($requestData['bet_odds']*$requestData['bet_amount'])/100);
                }else{
                    $betamount = (($requestData['bet_odds']*$requestData['bet_amount'])-$requestData['bet_amount']);
                }
                $betprofit1 = $betprofit2 = $betprofit3 = '';
                if(isset($requestData['teamname1']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname1']][$requestData['bet_type']."_profitLost"])){
                    $betprofit1 = $exAmtArr[$requestData['bet_type']][$requestData['teamname1']][$requestData['bet_type']."_profitLost"];
                    $exArrs[] = $betprofit1;
                }
                if(isset($requestData['teamname2']) && !empty($requestData['teamname2']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname2']][$requestData['bet_type']."_profitLost"])){
                    $betprofit2 = $exAmtArr[$requestData['bet_type']][$requestData['teamname2']][$requestData['bet_type']."_profitLost"];
                    $exArrs[] = $betprofit2;
                }
                if(isset($requestData['teamname3']) && !empty($requestData['teamname3']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname3']][$requestData['bet_type']."_profitLost"])){
                    $betprofit3= $exAmtArr[$requestData['bet_type']][$requestData['teamname3']][$requestData['bet_type']."_profitLost"];
                    $exArrs[] = $betprofit3;
                }
                $teamMaxEx = min($exArrs);
                if($requestData['bet_side'] == 'lay'){
                    $newExArr = array();
                    if($betprofit > 0){
                        $amt = abs($betprofit)-abs($betamount);
                        if($amt > 0){
                            $amt = 0;
                        }
                        $newExArr['betTeam'] = $amt;
                        if($betprofit1 < 0){
                            if($requestData['bet_amount'] < abs($betprofit1)){
                                $newExArr['betTeam1'] = $requestData['bet_amount']-abs($betprofit1);
                            }else{
                                $newExArr['betTeam1'] = $requestData['bet_amount']-abs($betprofit1);
                            }
                        }
                        if($betprofit2 < 0){
                            if($requestData['bet_amount'] < abs($betprofit2)){
                                $newExArr['betTeam2'] = $requestData['bet_amount']-abs($betprofit2);
                            }else{
                                $newExArr['betTeam2'] = $requestData['bet_amount']-abs($betprofit2);
                            }
                        }
                        if($betprofit3 < 0){
                            if($requestData['bet_amount'] < abs($betprofit3)){
                                $newExArr['betTeam3'] = $requestData['bet_amount']-abs($betprofit3);
                            }else{
                                $newExArr['betTeam3'] = $requestData['bet_amount']-abs($betprofit3);
                            }
                        }

                        $newTeamExMin = MIN($newExArr);
                        if($isExBalEq){
                            if(abs($teamMaxEx) < abs($newTeamExMin)){
                                $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                return json_encode($responce);
                            }
                        }else{
                            if(abs($teamMaxEx) < abs($newTeamExMin)){
                                $amtEx = (abs($newTeamExMin)-abs($teamMaxEx));
                                $ex = 0;
                                if($amtEx < 0){
                                    $ex =  abs($exposureAmt)-abs($amtEx);
                                }else{
                                    $ex =  abs($exposureAmt)+abs($amtEx);
                                }
                                if($headerUserBalance < $ex){
                                    $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                    return json_encode($responce);
                                }
                            }
                        }
                    }else{
                        $amt = abs($betamount)+abs($betprofit);
                        $amt = ($exposureAmt+$betamount);
                        if($headerUserBalance < (abs($amt))){
                                $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                return json_encode($responce);
                        }
                    }
                    if(isset($requestData['teamname1']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname1']][$requestData['bet_type']."_profitLost"])){
                            $betprofit1 = $exAmtArr[$requestData['bet_type']][$requestData['teamname1']][$requestData['bet_type']."_profitLost"];
                            if($betprofit1 >= 0){
                                    $betamount = $requestData['bet_amount'];
                                    $amt = $betprofit1 - abs($betamount);
                                    $amt = 0;
                                    if($headerUserBalance < ($exposureAmt+abs($amt))){
                                            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                            return json_encode($responce);
                                    }
                            }
                    }
                    if(isset($requestData['teamname2']) && !empty($requestData['teamname2']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname2']][$requestData['bet_type']."_profitLost"])){
                            $betprofit2 = $exAmtArr[$requestData['bet_type']][$requestData['teamname2']][$requestData['bet_type']."_profitLost"];
                           if($betprofit2 >= 0){
                                    $betamount = $requestData['bet_amount'];
                                    $amt = $betprofit2 - abs($betamount);
                                    $amt = 0;
                                    if($amt < 0){
                                        if($headerUserBalance < ($exposureAmt+abs($amt))){
                                                $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                                return json_encode($responce);
                                        }
                                    }
                            }
                    }
                    if(isset($requestData['teamname3']) && !empty($requestData['teamname3']) && isset($exAmtArr[$requestData['bet_type']][$requestData['teamname3']][$requestData['bet_type']."_profitLost"])){
                            $betprofit3= $exAmtArr[$requestData['bet_type']][$requestData['teamname3']][$requestData['bet_type']."_profitLost"];
                            if($betprofit3 >= 0){
                                $betamount = $requestData['bet_amount'];
                                $amt = $betprofit3 - abs($betamount);
                                $amt = 0;
                                if($headerUserBalance < ($exposureAmt+abs($amt))){
                                        $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                        return json_encode($responce);
                                }
                            }
                    }
                }else{
                    $newExArr = array();
                    if($betprofit < 0){
                       $amt = abs($betamount)-abs($betprofit);
                        if($amt > 0){
                            $amt = 0;
                        }
                        $newExArr['betTeam'] = $amt;
                        if($betprofit1 < 0){
                            $newExArr['betTeam1'] = ($betprofit1-$requestData['bet_amount']);
                        }
                        if($betprofit2 < 0){
                            $newExArr['betTeam2'] = $betprofit2-$requestData['bet_amount'];

                        }
                        if($betprofit3 < 0){
                            $newExArr['betTeam3'] = $betprofit3-$requestData['bet_amount'];
                        }

                        $newTeamExMin = MIN($newExArr);
                        if($isExBalEq){
                            if(abs($teamMaxEx) < abs($newTeamExMin)){
                                $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                return json_encode($responce);
                            }
                        }else{
                            if(abs($teamMaxEx) < abs($newTeamExMin)){
                                $amtEx = (abs($teamMaxEx)-abs($newTeamExMin));
                                $ex = 0;
                                if($amtEx < 0){
                                    $ex =  abs($exposureAmt)+abs($amtEx);
                                }else{
                                    $ex =  abs($exposureAmt)-abs($amtEx);
                                }
                                if($headerUserBalance < $ex){
                                    $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                    return json_encode($responce);
                                }
                            }
                        }
                    }else{
                        $newExArr = array();
                        $amt = abs($betamount)+abs($betprofit);
                        if($amt > 0){
                            $amt = 0;
                        }
                        $newExArr['betTeam'] = $amt;
                        if($betprofit1 < 0){
                            $newExArr['betTeam1'] = ($betprofit1-$requestData['bet_amount']);
                        }
                        if($betprofit2 < 0){
                            $newExArr['betTeam2'] = $betprofit2-$requestData['bet_amount'];

                        }
                        if($betprofit3 < 0){
                            $newExArr['betTeam3'] = $betprofit3-$requestData['bet_amount'];
                        }
                        $newTeamExMin = MIN($newExArr);
                        if($isExBalEq){
                            if(abs($teamMaxEx) < abs($newTeamExMin)){
                                $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                return json_encode($responce);
                            }
                        }else{
                            if(abs($teamMaxEx) < abs($newTeamExMin)){
                                $amtEx = (abs($teamMaxEx)-abs($newTeamExMin));
                                $ex = 0;
                                if($amtEx < 0){
                                    $ex =  abs($exposureAmt)+abs($amtEx);
                                }else{
                                    $ex =  abs($exposureAmt)-abs($amtEx);
                                }
                                if($headerUserBalance < $ex){
                                    $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                    return json_encode($responce);
                                }
                            }
                        }
                    }
                }
                }else{
                        if($requestData['bet_side'] == 'lay'){
                                if($requestData['bet_type'] == 'BOOKMAKER'){
                                        $betamount = (($requestData['bet_odds']*$requestData['bet_amount'])/100);
                                }else{
                                        $betamount = (($requestData['bet_odds']*$requestData['bet_amount'])-$requestData['bet_amount']);
                                }
                                if($headerUserBalance < ($exposureAmt+$betamount)){
                                        $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                        return json_encode($responce);
                                }
                        }else{
                                $betamount = $requestData['bet_amount'];
                                if($headerUserBalance < ($exposureAmt+$betamount)){
                                        $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Insufficent Balance</div>';
                                        return json_encode($responce);
                                }
                        }
                }
        }

      $requestData['bet_type'] = $betTypeOld;

      switch($exArr[0]){
        case "ODDS":{
          if(isset($sportsModel->odd_min_limit) && empty($sportsModel->odd_min_limit) &&
            (isset($sportsModel->odd_max_limit) && empty($sportsModel->odd_max_limit))){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Limit not Set.</div>';
            return json_encode($responce);
          }
          if($requestData['bet_amount'] < $sportsModel->odd_min_limit){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Min Max Bet Limit Exceed</div>';
            return json_encode($responce);
          }
          if($sportsModel->odd_max_limit < $requestData['bet_amount']){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Min Max Bet Limit Exceed</div>';
            return json_encode($responce);
          }
          break;
        }
        case 'BOOKMAKER':{
          if(isset($sportsModel->bookmaker_min_limit) && empty($sportsModel->bookmaker_min_limit) &&
            (isset($sportsModel->bookmaker_max_limit) && empty($sportsModel->bookmaker_max_limit))){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Limit not Set.</div>';
            return json_encode($responce);
          }
          if($requestData['bet_amount'] < $sportsModel->bookmaker_min_limit){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Min Max Bet Limit Exceed</div>';
            return json_encode($responce);
          }
          if($sportsModel->bookmaker_max_limit < $requestData['bet_amount']){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Min Max Bet Limit Exceed</div>';
            return json_encode($responce);
          }
          break;
        }
        case 'SESSION':{
          if(isset($sportsModel->fancy_min_limit) && empty($sportsModel->fancy_min_limit) &&
            (isset($sportsModel->fancy_max_limit) && empty($sportsModel->fancy_max_limit))){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Limit not Set.</div>';
            return json_encode($responce);
          }
          if($requestData['bet_amount'] < $sportsModel->fancy_min_limit){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Min Max Bet Limit Exceed</div>';
            return json_encode($responce);
          }
          if($sportsModel->fancy_max_limit < $requestData['bet_amount']){
            $responce['message'] = '<div  id="msg-alert" class="alert alert-danger"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Min Max Bet Limit Exceed</div>';
            return json_encode($responce);
          }
          break;
        }
      }
      $teamNameArr = array();
      if(isset($requestData['teamname1']) && !empty($requestData['teamname1'])){
        $teamNameArr['teamname1'] = $requestData['teamname1'];
      }
      if(isset($requestData['teamname2']) && !empty($requestData['teamname2'])){
        $teamNameArr['teamname2'] = $requestData['teamname2'];
      }
      if(isset($requestData['teamname3']) && !empty($requestData['teamname3'])){
        $teamNameArr['teamname3'] = $requestData['teamname3'];
      }

      $betModel = new MyBets();
      $betModel->sportID = $requestData['sportID'];
      $betModel->user_id = AuthNew::user()->id;
      $betModel->match_id = $requestData['match_id'];
      $betModel->bet_type = $requestData['bet_type'];
      $betModel->bet_side = $requestData['bet_side'];
      $betModel->bet_odds = $requestData['bet_odds'];
      $betModel->bet_amount = $requestData['bet_amount'];
      $betModel->bet_profit = $requestData['bet_profit'];
      $betModel->team_name = $requestData['team_name'];
      if(is_array($teamNameArr) && count($teamNameArr) > 0){
        $betModel->extra = json_encode($teamNameArr);
      }
      if($betModel->bet_side == 'lay'){
        $betModel->exposureAmt = $requestData['bet_profit'];
      }else{
        $betModel->exposureAmt = $requestData['bet_amount'];
      }
      $betModel->ip_address = resAll::ip();
      $betModel->browser_details = $_SERVER['HTTP_USER_AGENT'];
      if($betModel->save()){
        $responce['status'] = true;
        $responce['message'] = '<div  id="msg-alert" class="alert alert-success"><button type="button" class="close" style="margin-top: -7px;" data-dismiss="alert">x</button>Bet Added Succesfully</div>';
      }
      return json_encode($responce);
    }








    public static function getsoccersession($teanName,$matchID,$userID){
//      $amt = self::getExAmountByMatchWithDetail($userID,$matchID,$teanName);
//      dd($amt);
    }



   /*********** GENERALK FUNCTION ************/

    /************* EXPENSE CAL DATA **************/

   Public Static function getExAmount($sportID='',$id = ''){
      if(!empty($sportID)){
        $sportsModel =  Sports::where(["id" => $sportID])->first();
      }else{
        $sportsModel = DB::select( "SELECT * FROM `sports` WHERE winner = '' OR winner IS NULL");
      }

      $exAmtTot = 0;
      foreach($sportsModel as $keyMatch=>$matchVal){
        $gameModel = Games::where(["id" => $matchVal->game_id])->first();

        if(strtoupper($gameModel->name) == 'CRICKET' ||
           strtoupper($gameModel->name) == 'TENNIS' ||
           strtoupper($gameModel->name) == 'CASINO') {

          if(strtoupper($gameModel->name) == 'CASINO'){
            $exAmtArr = self::getExAmountCricketAndTennis($matchVal->id,'',$id);
          }else{
            $matchid = $matchVal->match_id;
            $exAmtArr = self::getExAmountCricketAndTennis('',$matchid,$id);

          }
          if(isset($exAmtArr['ODDS'])){
            $arr = array();
            foreach($exAmtArr['ODDS'] as $key=>$profitLos){
              if($profitLos['ODDS_profitLost'] < 0){
//                $exAmtTot += $profitLos['ODDS_profitLost'];
                $arr[abs($profitLos['ODDS_profitLost'])] = abs($profitLos['ODDS_profitLost']);
//                break;
              }
            }
            if(is_array($arr) && count($arr) > 0){
              $exAmtTot += max($arr);
            }

          }
          if(isset($exAmtArr['BOOKMAKER'])){
              $arrB = array();
            foreach($exAmtArr['BOOKMAKER'] as $key=>$profitLos){
              if($profitLos['BOOKMAKER_profitLost'] < 0){
//                $exAmtTot += abs($profitLos['BOOKMAKER_profitLost']);
                $arrB[abs($profitLos['BOOKMAKER_profitLost'])] = abs($profitLos['BOOKMAKER_profitLost']);
              }
            }
            if(is_array($arrB) && count($arrB) > 0){
              $exAmtTot += max($arrB);
            }
          }
          if(isset($exAmtArr['SESSION'])){
            foreach($exAmtArr['SESSION']['exposure'] as $key=>$sesVal){
              $exAmtTot += abs($sesVal['SESSION_profitLost']);
            }
          }

        }else{
          $exAmtArr = self::getExAmountSoccer($matchVal->id,$id);
          $OddsTot = 0;
          if(isset($exAmtArr['ODDS'])){
              $arr = array();
            foreach($exAmtArr['ODDS'] as $key=>$profitLos){
                if($profitLos['ODDS_profitLost'] < 0){
                    $arr[abs($profitLos['ODDS_profitLost'])] = abs($profitLos['ODDS_profitLost']);
                }
              /*if($profitLos['ODDS_profitLost'] < 0){
                if($OddsTot < 0){
                  if(abs($OddsTot) < abs($profitLos['ODDS_profitLost'])){
                    $OddsTot = $profitLos['ODDS_profitLost'];
                  }
                }else{
                  $OddsTot = $profitLos['ODDS_profitLost'];
                }
              }*/
            }
            if(isset($arr) && is_array($arr) && count($arr) > 0){
                $exAmtTot += min($arr);
              }
           // $exAmtTot += abs($OddsTot);
          }
          $sessionTot = 0;
          if(isset($exAmtArr['SESSION'])){
            foreach($exAmtArr['SESSION'] as $key=>$profitLosData){
                $arr = array();
              foreach($profitLosData as $key1=>$profitLos){
                  if($profitLos['SESSION_profitLost'] < 0){
                    $arr[abs($profitLos['SESSION_profitLost'])] = abs($profitLos['SESSION_profitLost']);
                  }
                /*if($sessionTot < 0){
                  if(abs($sessionTot) < abs($profitLos['SESSION_profitLost'])){
                      $sessionTot = $profitLos['SESSION_profitLost'];
                  }
                }else{
                  $sessionTot = $profitLos['SESSION_profitLost'];
                }*/
              }
              //$exAmtTot += abs($sessionTot);
              if(isset($arr) && is_array($arr) && count($arr) > 0){
                $exAmtTot += min($arr);
              }
            }

          }
        }

      }
      return round(abs($exAmtTot));
   }

   Public Static function getExAmountCricketAndTennis($sportID='',$matchid='',$userID=''){
     if(empty($userID)){
       $userID = AuthNew::user()->id;
     }
     if(empty($sportID) && empty($matchid)){
       $myBetsModel = MyBets::where(['user_id'=>$userID,'active'=>1,'isDeleted'=>0])->get();
     }elseif(empty($matchid)){
      $myBetsModel = MyBets::where(['sportID'=>$sportID,'user_id'=>$userID,'active'=>1,'isDeleted'=>0])->get();
     }elseif(empty($sportID)){
      $myBetsModel = MyBets::where(['match_id'=>$matchid,'user_id'=>$userID,'active'=>1,'isDeleted'=>0])->get();
     }else{
       $myBetsModel = MyBets::where(['sportID'=>$sportID,'match_id'=>$matchid,'user_id'=>$userID,'active'=>1,'isDeleted'=>0])->get();
     }
      $response = array();
      $arr = array();
      foreach($myBetsModel as $key=>$bet){
        $extra = json_decode($bet->extra,true);
        switch($bet['bet_type']){
          case "ODDS":{
            $profitAmt = $bet['bet_profit'];
            if($bet['bet_side'] == 'lay'){
              $profitAmt = ($profitAmt*(-1));
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
              if(isset($extra['teamname4']) && !empty($extra['teamname4'])){
                if(!isset($response['ODDS'][$extra['teamname4']]['ODDS_profitLost'])){
                  $response['ODDS'][$extra['teamname4']]['ODDS_profitLost'] = $bet['bet_amount'];
                }else{
                  $response['ODDS'][$extra['teamname4']]['ODDS_profitLost'] += $bet['bet_amount'];
                }
              }
            }else{
              $bet_amt = ($bet['bet_amount']*(-1));
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
            $profitAmt = $bet['bet_profit'];
            if($bet['bet_side'] == 'lay'){
              $profitAmt = ($profitAmt*(-1));
              if(!isset($response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'])){
                $response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] = $profitAmt;
              }else{
                $response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] += $profitAmt;
              }
              if(isset($extra['teamname1']) && !empty($extra['teamname1'])){
                if(!isset($response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'])){
                  $response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'] = $bet['bet_amount'];
                }else{
                  $response['BOOKMAKER'][$extra['teamname1']]['BOOKMAKER_profitLost'] += $bet['bet_amount'];
                }
              }

              if(isset($extra['teamname2']) && !empty($extra['teamname2'])){
                if(!isset($response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'])){
                  $response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'] = $bet['bet_amount'];
                }else{
                 $response['BOOKMAKER'][$extra['teamname2']]['BOOKMAKER_profitLost'] += $bet['bet_amount'];
                }
              }

              if(isset($extra['teamname3']) && !empty($extra['teamname3'])){
                if(!isset($response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'])){
                  $response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'] = $bet['bet_amount'];
                }else{
                  $response['BOOKMAKER'][$extra['teamname3']]['BOOKMAKER_profitLost'] += $bet['bet_amount'];
                }
              }

            }else{
              $bet_amt = ($bet['bet_amount']*(-1));
              if(!isset($response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'])){
                $response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] = $profitAmt;
              }else{
                $response['BOOKMAKER'][$bet['team_name']]['BOOKMAKER_profitLost'] += $profitAmt;
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
            $response['SESSION']['teamname'][$bet['team_name']] = $bet['team_name'];
            $exArrData = self::getSessionValueByArr($bet['match_id'],$bet['team_name'],$bet['user_id']);

            $finalExSes = 0;
            foreach ($exArrData as $key=>$arr){
              if($finalExSes > $arr['profit']){
                $finalExSes = $arr['profit'];
              }
            }
            $response['SESSION']['exposure'][$bet['team_name']]['SESSION_profitLost'] = $finalExSes;

//            $response['SESSION']['exposure']['SESSION_profitLost'] = $exTot;
            break;
          }
        }
      }
//      dd($response);
      return $response;
   }

   Public Static function getExAmountSoccer($sportID='',$userID=''){
     if(empty($userID)){
       $userID = AuthNew::user()->id;
     }
//     dd($sportID);
     $myBetsModel = MyBets::where(['sportID'=>$sportID,'user_id'=>$userID,'active'=>1,'isDeleted'=>0])->get();

     $response = array();
      $arr = array();
      foreach($myBetsModel as $key=>$bet){
//        dd($bet);
        $extra = json_decode($bet->extra,true);
        $betTypeArr = explode('-', $bet['bet_type']);
        switch($betTypeArr[0]){
          case "ODDS":{
            $profitAmt = $bet['bet_profit'];
            if($bet['bet_side'] == 'lay'){
              $profitAmt = ($profitAmt*(-1));
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
              if(!isset($response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'])){
                $response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'] = $profitAmt;
              }else{
                $response['SESSION'][$betTypeArr[1]][$bet['team_name']]['SESSION_profitLost'] += $profitAmt;
              }

              if(isset($extra['teamname1']) && !empty($extra['teamname1'])){
                if(!isset($response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost'])){
                  $response['SESSION'][$betTypeArr[1]][$extra['teamname1']]['SESSION_profitLost'] = $bet['bet_amount'];
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
//      dd($response);
      return $response;
   }

   /**** BALANCE GET FUNCTION ****/
   Public Static function getBlanceAmount($id = ''){
      if(empty($id)){
        $id = AuthNew::user()->id;
      }
      //$exBalance = self::getExAmount();

      $depTot = DB::table('user_deposites')->where(['deposite_user_id'=>$id])->sum('amount');
      $widTot = DB::table('user_deposites')->where(['withdrawal_user_id'=>$id])->sum('amount');
      $totBalance = ($depTot-$widTot);

      return $totBalance;
   }


   /*********** MATCH BY MATCH WINNER GAME AMOUNT GET ALL **************/

   public static function getExAmountByMatchWithDetail($sportID,$userID,$matchID,$winnerTeam){
    $sportsModel =  Sports::where(["id" => $sportID])->first();
    $gameModel = Games::where(["id" => $sportsModel->game_id])->first();
    $exAmtTot = 0;
    if(strtoupper($gameModel->name) == 'CRICKET' || strtoupper($gameModel->name) == 'TENNIS' || strtoupper($gameModel->name) == 'CASINO'){
        $exAmtArr = self::getExAmountCricketAndTennis($sportID,$matchID,$userID);
        $OddsTot = 0;
        if(isset($exAmtArr['ODDS'])){
            if(isset($exAmtArr['ODDS'][$winnerTeam]['ODDS_profitLost'])){
              $exAmtTot += $exAmtArr['ODDS'][$winnerTeam]['ODDS_profitLost'];
            }else{
              foreach($exAmtArr['ODDS'] as $key=>$profitLos){
                if($profitLos['ODDS_profitLost'] < 0){
                  $exAmtTot += $profitLos['ODDS_profitLost'];
                }
              }
            }
        }
        if(isset($exAmtArr['BOOKMAKER'])){
          if(isset($exAmtArr['BOOKMAKER'][$winnerTeam]['BOOKMAKER_profitLost'])){
            $exAmtTot += $exAmtArr['BOOKMAKER'][$winnerTeam]['BOOKMAKER_profitLost'];
          }else{
            foreach($exAmtArr['BOOKMAKER'] as $key=>$profitLos){
              if($profitLos['BOOKMAKER_profitLost'] < 0){
                $exAmtTot += $profitLos['BOOKMAKER_profitLost'];
              }
            }
          }
        }
     }else{
//        dd($matchID);
        $exAmtArr = self::getExAmountSoccer($sportID,$userID);
        $OddsTot = 0;
        if(isset($exAmtArr['ODDS'])){
          if(isset($exAmtArr['ODDS'][$winnerTeam]['ODDS_profitLost'])){
            $exAmtTot += $exAmtArr['ODDS'][$winnerTeam]['ODDS_profitLost'];
          }else{
            $OddsTot = 0;
            foreach($exAmtArr['ODDS'] as $key=>$profitLos){
              if($OddsTot < 0){
                if(abs($OddsTot) < abs($profitLos['ODDS_profitLost'])){
                  $OddsTot = $profitLos['ODDS_profitLost'];
                }
              }else{
                $OddsTot = $profitLos['ODDS_profitLost'];
              }
            }
            $exAmtTot +=$OddsTot;
          }
        }
        $exAmtTot += $OddsTot;
      }
      return $exAmtTot;
    }


  public function getExBlance(){
    $response = array();
    $response['exposureAmt'] = SELF::getExAmount();

    $response['headerUserBalance'] = SELF::getBlanceAmount() - $response['exposureAmt'];
    // dd($response);
    return json_encode($response);
  }
}
