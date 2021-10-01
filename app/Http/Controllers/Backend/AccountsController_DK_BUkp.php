<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MyBets;
use App\Sports;
use App\Casino;
use App\Games;
use App\MatchFancy;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;
use Auth;

class AccountsController extends Controller
{
  public function accountstatement(){
    $gameModel = Games::where(['name'=>'CASINO'])->first();
    $sportModel = Sports::where(['active'=>1,'game_id'=>$gameModel->id])->get();
    $user = User::find(['id'=>Auth::user()->id]);
    $userModel = self::getChildUserList(Auth::user()->id);
//    $userModel = self::getChildUserList(46);
    return view('backend.accounts.accountstatement', compact('sportModel','userModel'));
  }
  public function getGameDropdownList(Request $request){
    $requestData = $request->all();
    $html = '';
    if($requestData['accounttype'] == '1'){
//        $html = '<option value="ALL">All</option>';
    }elseif($requestData['accounttype'] == '2'){
        $html .= '<option value="UPPER">Upper</option>';
        $html .= '<option value="DOWN">Down</option>';
    }else{
      $html = '<option value="ALL">All</option>';
      $html .= '<option value="CRICKET">Cricket</option>';
      $html .= '<option value="SOCCER">Soccer</option>';
      $html .= '<option value="TENNIS">Tennis</option>';
      $gameModel = Games::where(['name'=>'CASINO'])->first();
      $sportModel = Sports::where(['active'=>1,'game_id'=>$gameModel->id])->get();
      foreach($sportModel as $key=>$data){
        $html .= '<option value="'.$data->id.'">'.$data->match_name.'</option>';
      }
    }
    return $html;
  }
  public static function getChildUserList($userID){
    
    $model = User::where(['parent_id'=>$userID])->get();
    $userArr = array();
    foreach($model as $key=>$user){
//      if(strtoupper($user->roles->first()->name) == 'USER'){
        $userArr[] = $user;
//      }else{
        $data = self::getChildUserList($user->id);
        foreach($data as $j=>$val){
           $userArr[] = $val;
        }
//      }
    }
    return $userArr;
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
  public function accountstatementList(Request $request){
      
      $requestData = $request->all();
      
      $user_id = $requestData['user_id'];
      // 1 == ALL,   2 == BALANCE REPORT ,  3 == GAME REPORT
      if($requestData['reportType'] == '2'){
        $where = '';
        
        if($requestData['gameID'] == 'UPPER'){
          if($user_id == "ALL"){
            $userID = Auth::user()->id;
            $where = "((ud.balanceType = 'DEPOSIT' OR ud.balanceType = 'WITHDRAWAL')";
            $where .= " AND (u1.id ='".$userID."'";
            $where .= " OR u2.id ='".$userID."'))";
          }else{
            $userID = $user_id;
            $user = User::find($userID);
            $where = "((ud.balanceType = 'DEPOSIT' AND ((ud.withdrawal_user_id = '".$userID."' AND ud.deposite_user_id = '".$user->parent_id."') OR (ud.deposite_user_id = '".$userID."' AND ud.withdrawal_user_id = '".$user->parent_id."')))";
            $where .= " OR (ud.balanceType = 'WITHDRAWAL' AND ((ud.withdrawal_user_id = '".$userID."' AND ud.deposite_user_id = '".$user->parent_id."') OR (ud.deposite_user_id = '".$userID."' AND ud.withdrawal_user_id = '".$user->parent_id."'))))";
//            
          }
          
        }else if($requestData['gameID'] == 'DOWN'){
          if($user_id == "ALL"){
            $userID = Auth::user()->id;
          }else{
            $userID = $user_id;
          }
          
          if($user_id == "ALL"){
            $where = "((ud.balanceType = 'DEPOSIT' OR ud.balanceType = 'WITHDRAWAL')";
            $where .= " AND (u1.parent_id ='".$userID."'";
            $where .= " OR u2.parent_id ='".$userID."'))";
          }else{
            $user = User::find($userID);
            $where = "(ud.balanceType = 'DEPOSIT' OR ud.balanceType = 'WITHDRAWAL')";
            $where .= " AND (u1.id ='".$userID."'";
            $where .= " OR u2.id ='".$userID."')";
            $where .= " AND u1.id !='".$user->parent_id."'";
            $where .= " AND u2.id !='".$user->parent_id."'";
          }
        }else{
          $user = User::find(Auth::user()->id);
          if($user_id == "ALL"){
            $userID = Auth::user()->id;
          }else{
            $userID = $user_id;
          }
          
          $where = "(ud.balanceType = 'DEPOSIT' OR ud.balanceType = 'WITHDRAWAL') 
                            AND (ud.`deposite_user_id` ='".$userID."' OR ud.`withdrawal_user_id` = '".$userID."')";
           if($user_id == "ALL"){
                $where .= " AND (u1.parent_id ='".$userID."'";
                $where .= " OR u2.parent_id ='".$userID."')";
           }
        }
        
         $sql = "SELECT ud.*, ud.note as details ,CONCAT(u2.first_name,'/',u1.first_name) as Username
                    FROM `user_deposites` ud 
                    LEFT JOIN users u1 ON(ud.deposite_user_id = u1.id)
                    LEFT JOIN users u2 ON(ud.withdrawal_user_id = u2.id)
                    WHERE ".$where;
         
         if(isset($requestData['sDate']) && !empty($requestData['sDate'])){
          $sql .= " AND ud.`created_at` >= '".date('Y-m-d',strtotime($requestData['sDate']))."'";
         }
         
         if(isset($requestData['eDate']) && !empty($requestData['eDate'])){
           $sql .= " AND  ud.`created_at` <= '".date('Y-m-d',strtotime($requestData['eDate']))." 23:59:59'";
         }
//         $sql .= " ORDER BY  ud.`created_at`'";
         $betModel = DB::select($sql);
//         die($sql);
//         dd($sql);
          $sqlDep = "SELECT SUM(`amount`) as totDep 
                            FROM `user_deposites`
                            WHERE balanceType = 'DEPOSIT' AND `deposite_user_id`='".$userID."'";
          $optDate = '';
          if(isset($requestData['sDate']) && !empty($requestData['sDate'])){
           $sqlDep .= " AND `created_at` < '".date('Y-m-d',strtotime($requestData['sDate']))."'";
           $optDate = date('Y-m-d',strtotime($requestData['sDate']))." 00:00:00";
          }

          $sqlWid = "SELECT SUM(`amount`) as totWid 
                            FROM `user_deposites` 
                            WHERE balanceType = 'WITHDRAWAL' AND `withdrawal_user_id`='".$userID."'";
          
          if(isset($requestData['sDate']) && !empty($requestData['sDate'])){ 
            $sqlWid .= " AND `created_at` < '".date('Y-m-d',strtotime($requestData['sDate']))."'";
          } 
//          dd($requestData);
        
        if(isset($requestData['sDate']) && !empty($requestData['sDate'])){ 
          $DepModel = DB::select($sqlDep);
          $widModel = DB::select($sqlWid);
          $depTot = $DepModel[0]->totDep;
          $widTot = $widModel[0]->totWid;
          $optBal = ($depTot-$widTot);
        }else{
          $optBal = 0;
        }
        $options = view("backend.accounts.accountstatement-game-row",compact('betModel','optBal','optDate','userID'))->render();
        return $options;
         
      }elseif($requestData['reportType'] == '3'){
        if($user_id == "ALL"){
          $userID = Auth::user()->id;
        }else{
          $userID = $user_id;
        }
        $user1 = User::find($userID);
        if(strtoupper($user1->roles->first()->name) != 'USER'){
            $html = '<tr>';
            $html .= '<td class="text-center" colspan="6">No Record Found</td>';
            $html .= '</tr>';
            return $html;
        }
        $where = '';
        $whereData = ''; 
        if(isset($requestData['sDate']) && !empty($requestData['sDate'])){
          $where .= " AND ud.`created_at` >= '".date('Y-m-d',strtotime($requestData['sDate']))."'";
          $whereData .= " AND ud.`created_at` >= '".date('Y-m-d',strtotime($requestData['sDate']))."'";
        }
         
         if(isset($requestData['eDate']) && !empty($requestData['eDate'])){
           $where .= " AND ud.`created_at` <= '".date('Y-m-d',strtotime($requestData['eDate']))." 23:59:59'";
           $whereData .= " AND ud.`created_at` <= '".date('Y-m-d',strtotime($requestData['eDate']))." 23:59:59'";
         }
//          if(Auth::user()->roles->first()->name != 'administrator'){  
            $user = User::find($userID);
            if($user_id != "ALL"){
                 $where .= " AND (ud.`deposite_user_id` = '".$userID."' OR ud.`withdrawal_user_id` = '".$userID."')";
                 $whereData .= " AND (ud.`deposite_user_id` = '".$userID."' OR ud.`withdrawal_user_id`= '".$userID."')";
            }
         if(isset($requestData['gameID']) && !empty($requestData['gameID'])){
           if($requestData['gameID'] != "ALL"){
            $where .= ' AND g.name="'.$requestData['gameID'].'"';
            $whereData .= ' AND s.id ="'.$requestData['gameID'].'"';
           }
         }
         $sql = "SELECT * FROM (
                    SELECT ud.*,CONCAT(g.name,' // ',s.match_name,' // ',mf.fancyName,' // ',mf.result) as details,CONCAT(u2.first_name,'/',u1.first_name) as Username
                        FROM `user_deposites` ud
                            LEFT JOIN my_bets mb ON(mb.id = ud.bet_id )
                            LEFT JOIN match_fancies mf ON(mf.id = ud.fancy_id)
                            LEFT JOIN sports s ON (s.match_id = ud.match_id)
                            LEFT JOIN games g ON (g.id = s.game_id)
                            LEFT JOIN users u1 ON(ud.deposite_user_id = u1.id)
                            LEFT JOIN users u2 ON(ud.withdrawal_user_id = u2.id)
                            WHERE SUBSTRING_INDEX(ud.type,'-',1) IN ('SESSION') AND 
                                  ud.`callType` IN ('CRICKET','SOCCER')
                                  ".$where."
                             GROUP BY ud.id        
              
                UNION

                SELECT ud.*,CONCAT(g.name,' // ',s.match_name,' // ',s.winner) as details,CONCAT(u2.first_name,'/',u1.first_name) as Username
                    FROM `user_deposites` ud
                        LEFT JOIN my_bets mb ON(ud.match_id = mb.match_id AND mb.bet_type IN ('ODDS','BOOKMAKER'))
                        LEFT JOIN sports s ON (s.match_id = mb.match_id)
                        LEFT JOIN games g ON (g.id = s.game_id)
                        LEFT JOIN users u1 ON(ud.deposite_user_id = u1.id)
                        LEFT JOIN users u2 ON(ud.withdrawal_user_id = u2.id)
                        WHERE ud.`type` IN ('ODDS_BOOKMEKER') AND 
                              ud.`callType` IN ('CRICKET','TENNIS','SOCCER')
                               ".$where."
                         GROUP BY mb.match_id         
                UNION

                SELECT ud.*,CONCAT(s.match_name,' // Round ID : ',mb.match_id,' // ',c.result) as details,CONCAT(u2.first_name,'/',u1.first_name) as Username
                    FROM `user_deposites` ud
                        LEFT JOIN my_bets mb ON(ud.match_id = mb.match_id AND mb.bet_type IN ('ODDS','BOOKMEKER'))
                        LEFT JOIN sports s ON (s.id = mb.sportID)
                        LEFT JOIN casinos c ON (c.roundID = mb.match_id)
                        LEFT JOIN users u1 ON(ud.deposite_user_id = u1.id)
                        LEFT JOIN users u2 ON(ud.withdrawal_user_id = u2.id)
                        WHERE ud.`type` IN ('ODDS_BOOKMEKER') AND 
                              ud.`callType` IN ('LiveTeenPati','AndarBahar','Poker','UpDown7','CardScasin032','TeenPati20','AmarAkbarAnthony','DragOnTiger')
                               ".$whereData."
                         GROUP BY mb.match_id  ) temp      
                Order by temp.id";
//         die($sql);
         $betModel = DB::select($sql);
         
            if(isset($requestData['sDate']) && !empty($requestData['sDate'])){
                $sDate =  $requestData['sDate'];
            }else{
                $sDate = date('Y-m-d');
            }
            $sqlDep = "SELECT SUM(`amount`) as depTot 
                            FROM `user_deposites` 
                            WHERE `balanceType` NOT IN('WITHDRAWAL','DEPOSIT') 
                            AND `deposite_user_id` = '".$userID."'  
                            AND DATE_FORMAT(created_at, '%Y-%m-%d') >= '".date('Y-m-d',strtotime("-30 day", strtotime($sDate)))."'
                            AND DATE_FORMAT(created_at, '%Y-%m-%d') < '".date('Y-m-d',strtotime($sDate))."'";
        
            $depModel = DB::select($sqlDep); 

            $sqlWid = "SELECT SUM(`amount`) as widTot 
                            FROM `user_deposites` 
                            WHERE `balanceType` NOT IN('WITHDRAWAL','DEPOSIT') 
                            AND `withdrawal_user_id` = '".$userID."' 
                            AND DATE_FORMAT(created_at, '%Y-%m-%d') >= '".date('Y-m-d',strtotime("-30 day", strtotime($sDate)))."'
                            AND DATE_FORMAT(created_at, '%Y-%m-%d') < '".date('Y-m-d',strtotime($sDate))."'";
//        die($sqlDep);
        $widModel = DB::select($sqlWid);
        if(isset($depModel[0]->depTot)){
            if(isset($widModel[0]->widTot)){
                $optBal = (($depModel[0]->depTot)-($widModel[0]->widTot));
            }else{
                $optBal = $depModel[0]->depTot;
            }
        }else{
            if(isset($widModel[0]->widTot)){
                $optBal = (($widModel[0]->widTot)*(-1));
            }else{
                $optBal = '0';
            } 
        }
        $optDate = $sDate;
         
//         $optBal = $optDate = 0;
         $options = view("backend.accounts.accountstatement-game-row",compact('betModel','optBal','optDate','userID'))->render();
         return $options;
      }else{
        if($user_id == "ALL"){
          $userID = Auth::user()->id;
        }else{
          $userID = $user_id;
        }
        $where = '';
        if(isset($requestData['sDate']) && !empty($requestData['sDate'])){
          $where .= " AND ud.`created_at` >= '".date('Y-m-d',strtotime($request['sDate']))."'";
         }
         if(isset($requestData['eDate']) && !empty($requestData['eDate'])){
           $where .= " AND ud.`created_at` <= '".date('Y-m-d',strtotime($request['eDate']))." 23:59:59'";
         }
         if($userID != 'ALL'){
           $where .= " AND (ud.`deposite_user_id` ='".$userID."' OR ud.`withdrawal_user_id` = '".$userID."')";
         }
         
         if(isset($requestData['gameID']) && !empty($requestData['gameID']) && $requestData['gameID'] != 'ALL'){
           $where .= " AND s.id=".$requestData['gameID'];
         }
         $sql = "Select *
                  from
                  (SELECT ud.*, ud.note as details,CONCAT(u2.first_name,'/',u1.first_name) as Username
                          FROM `user_deposites` ud 
                          LEFT JOIN users u1 ON(ud.deposite_user_id = u1.id)
                          LEFT JOIN users u2 ON(ud.withdrawal_user_id = u2.id)
                          WHERE (ud.balanceType = 'DEPOSIT' OR ud.balanceType = 'WITHDRAWAL') AND (ud.`deposite_user_id` ='".$userID."' OR ud.`withdrawal_user_id` = '".$userID."')
                           ".$where."  
                    UNION ALL
                
                    SELECT ud.*,CONCAT(g.name,' // ',s.match_name,' // ',mf.fancyName,' // ',mf.result) as details,CONCAT(u2.first_name,'/',u1.first_name) as Username
                        FROM `user_deposites` ud
                            LEFT JOIN my_bets mb ON(ud.match_id = mb.match_id AND mb.bet_type IN ('SESSION'))
                            LEFT JOIN match_fancies mf ON (mf.match_id = mb.match_id AND mf.fancyName = mb.team_name)
                            LEFT JOIN sports s ON (s.match_id = mb.match_id)
                            LEFT JOIN games g ON (g.id = s.game_id)
                            LEFT JOIN users u1 ON(ud.deposite_user_id = u1.id)
                            LEFT JOIN users u2 ON(ud.withdrawal_user_id = u2.id)
                            WHERE ud.`type` IN ('SESSION') AND 
                                  ud.`callType` IN ('CRICKET','SOCCER')
                                  ".$where."
                             GROUP BY mb.match_id        
              
                    UNION ALL

                    SELECT ud.*,CONCAT(g.name,' // ',s.match_name,' // ',s.winner) as details,CONCAT(u2.first_name,'/',u1.first_name) as Username
                          FROM `user_deposites` ud
                          LEFT JOIN my_bets mb ON(ud.match_id = mb.match_id AND mb.bet_type IN ('ODDS','BOOKMEKER'))
                          LEFT JOIN sports s ON (s.match_id = mb.match_id)
                          LEFT JOIN games g ON (g.id = s.game_id)
                          LEFT JOIN users u1 ON(ud.deposite_user_id = u1.id)
                          LEFT JOIN users u2 ON(ud.withdrawal_user_id = u2.id)
                          WHERE ud.`type` IN ('ODDS_BOOKMEKER') AND 
                              ud.`callType` IN ('CRICKET','TENNIS','SOCCER')
                               ".$where."
                          GROUP BY mb.match_id         
                    UNION ALL

                    SELECT ud.*,CONCAT(s.match_name,' // Round ID : ',mb.match_id,' // ',c.result) as details,CONCAT(u2.first_name,'/',u1.first_name) as Username
                          FROM `user_deposites` ud
                          LEFT JOIN my_bets mb ON(ud.match_id = mb.match_id AND mb.bet_type IN ('ODDS','BOOKMEKER'))
                          LEFT JOIN sports s ON (s.id = mb.sportID)
                          LEFT JOIN casinos c ON (c.roundID = mb.match_id)
                          LEFT JOIN users u1 ON(ud.deposite_user_id = u1.id)
                          LEFT JOIN users u2 ON(ud.withdrawal_user_id = u2.id)
                          WHERE ud.`type` IN ('ODDS_BOOKMEKER') AND 
                              ud.`callType` IN ('LiveTeenPati','AndarBahar','Poker','UpDown7','CardScasin032','TeenPati20','AmarAkbarAnthony','DragOnTiger')
                               ".$where."
                        GROUP BY mb.match_id) temp
                Order by created_at";
         
         $betModel = DB::select($sql);
         
         $sqlDep = "SELECT SUM(`amount`) as totDep FROM `user_deposites` WHERE balanceType = 'DEPOSIT' AND `deposite_user_id`='".$userID."'";
         //dd($requestData);
         $optDate = $optBal = '';
         if(isset($requestData['sDate']) && !empty($requestData['sDate'])){
         $sqlDep .= " AND `created_at` < '".date('Y-m-d',strtotime($requestData['sDate']))."'";
          $optDate = date('Y-m-d',strtotime($requestData['sDate']))." 00:00:00";
        }
        
        $sqlWid = "SELECT SUM(`amount`) as totWid FROM `user_deposites` WHERE balanceType = 'WITHDRAWAL' AND `withdrawal_user_id`='".$userID."'";
        if(isset($requestData['sDate']) && !empty($requestData['sDate'])){ 
          $sqlWid .= " AND `created_at` < '".date('Y-m-d',strtotime($requestData['sDate']))."'";
        } 
        if(isset($requestData['sDate']) && !empty($requestData['sDate'])){
            $DepModel = DB::select($sqlDep);
            $widModel = DB::select($sqlWid);
            $depTot = $DepModel[0]->totDep;
            $widTot = $widModel[0]->totWid;
            $optBal = ($depTot-$widTot);
        }
         $options = view("backend.accounts.accountstatement-game-row",compact('betModel','optBal','optDate','userID'))->render();
         return $options;
      }
     
    }
  public function getbetList(Request $request){
     
    $requestData = $request->all();
//    dd($requestData);
    $udModel = \App\UserDeposite::find($requestData['id']);
//    dd($udModel);

    $exp = explode('-', $udModel->type);
//    dd($requestData);
    switch($exp[0]){
        case 'ODDS_BOOKMEKER':{
            if(in_array($udModel->callType,array('CRICKET','TENNIS','SOCCER'))){
                $sql = "SELECT mb.*,u.first_name as UserName,u1.first_name as upLink,s.winner as results,g.name as gameName
                                FROM `my_bets` mb
                                LEFT JOIN users u ON (u.id = mb.user_id)
                                LEFT JOIN users u1 ON (u1.id = u.parent_id)
                                LEFT JOIN sports s ON(s.match_id = mb.match_id)
                                LEFT JOIN games g ON(g.id = s.game_id)
                                WHERE mb.bet_type IN('ODDS','BOOKMAKER')
                                AND mb.match_id = '".$udModel->match_id."'
                                AND mb.isDeleted='0'    
                                AND mb.user_id IN (".$requestData['user_id'].")"; 
            }else{
                $sql = "SELECT mb.*,u.first_name as UserName,u1.first_name as upLink,c.result as results,'CASINO' as gameName
                                FROM `my_bets` mb
                                LEFT JOIN users u ON (u.id = mb.user_id)
                                LEFT JOIN users u1 ON (u1.id = u.parent_id)
                                LEFT JOIN casinos c ON(c.roundID = mb.match_id)
                                WHERE mb.match_id = '".$udModel->match_id."'
                                AND mb.isDeleted='0' 
                                AND mb.user_id IN (".$requestData['user_id'].")
                                AND mb.bet_type IN('ODDS','BOOKMAKER')";
            }
            break;
        }
        case 'SESSION':{
            if($udModel->callType == 'CRICKET'){
                $sql = "SELECT mb.*,u.first_name as UserName,u1.first_name as upLink,mf.result as results,g.name as gameName 
                        FROM `my_bets` mb
                        LEFT JOIN users u ON (u.id = mb.user_id)
                        LEFT JOIN users u1 ON (u1.id = u.parent_id)
                        JOIN match_fancies mf ON(mf.fancyName = mb.team_name)
                        LEFT JOIN sports s ON(s.id = mb.sportID)
                        LEFT JOIN games g ON(g.id = s.game_id)
                        WHERE mb.id IN (".$udModel->extra.") AND mb.match_id = '".$udModel->match_id."'
                        AND mb.isDeleted='0'     
                        AND SUBSTRING_INDEX(mb.bet_type,'-',1) = 'SESSION' GROUP BY mb.id";
            }else{
            $sql = "SELECT mb.*,u.first_name as UserName,u1.first_name as upLink,mf.result as results,g.name as gameName 
                        FROM `my_bets` mb
                        LEFT JOIN users u ON (u.id = mb.user_id)
                        LEFT JOIN users u1 ON (u1.id = u.parent_id)
                        JOIN match_fancies mf ON(mf.fancyName = SUBSTRING_INDEX(mb.bet_type,'-',-1))
                        LEFT JOIN sports s ON(s.id = mb.sportID)
                        LEFT JOIN games g ON(g.id = s.game_id)
                        WHERE mb.id IN (".$udModel->extra.") AND mb.match_id = '".$requestData['matchID']."'
                        AND mb.isDeleted='0' 
                        AND SUBSTRING_INDEX(mb.bet_type,'-',1) = 'SESSION' GROUP BY mb.id";
            }
            break;
        }
    }
    
    $betModel = DB::select($sql);
//    dd($requestData);
    $html = '';
    $html .= '<table class="table">';
      $html .= '<thead>';
        $html .= '<tr>';
        if($requestData['isCallSide'] == "userSide"){
          $html .= '<th>Sr.No.</th>';
          $html .= '<th>Nation</th>';
          $html .= '<th>Side</th>';
          $html .= '<th>Rate</th>';
          $html .= '<th>Amount</th>';
          $html .= '<th>Win/Loss</th>';
          $html .= '<th>PlaceDate</th>';
          $html .= '<th>Match Date</th>';
        }else{
            $html .= '<th>UPlevel</th>';
            $html .= '<th>UserName</th>';
            $html .= '<th>Nation</th>';
            $html .= '<th>UserRate</th>';
            $html .= '<th>Amount</th>';
            $html .= '<th>WinLoss</th>';
            $html .= '<th>PlaceDate</th>';
            $html .= '<th>Match Date</th>';
            $html .= '<th>IP</th>';
            $html .= '<th>Browser Details</th>';
        }
        $html .= '</tr>';
      $html .= '</thead>';
      $html .= '<tbody>';
      $i = 0;
      $tot= 0;
      $j = 1;
      $t = 0;
        foreach($betModel as $key=>$data){
          $i++;
          $class = 'lay-color';
          if($data->bet_side == 'back'){
            $class = 'back-color';
          }
          if(in_array($data->gameName,array('CRICKET','TENNIS','SOCCER')) && !in_array($data->bet_type,array('SESSION'))){
            if($data->team_name == $data->results){
              $winloss = $winloss = "<span style='color:green;'>".$data->bet_profit."</span>";
              $tot +=$data->bet_profit;
            }else{
              $winloss = $winloss = "<span style='color:red;'>-".$data->bet_amount."</span>";
              $tot -=$data->bet_amount;
            }
          }
          if($data->gameName == 'CRICKET' && $data->bet_type == 'SESSION'){
            if($udModel->deposite_user_id == $data->user_id){
              $winloss = "<span style='color:green;'>".(($data->bet_oddsk*$data->bet_amount)/100)."</span>";
              $tot +=$data->bet_profit;
            }else{
              $winloss = "<span style='color:red;'>-".$data->bet_amount."</span>";
              $tot -=$data->bet_amount;
            }
          }
          if($data->gameName == 'SOCCER' && $exp[0] == 'SESSION'){
            if($data->bet_side == 'back'){  
                $winloss = "<span style='color:green;'>".$data->bet_profit."</span>";
                $tot +=$data->bet_profit;
            }else{
                $winloss = "<span style='color:red;'>".(0-$data->bet_profit)."</span>";
                $tot -=$data->bet_profit;
            }
            
            
          }
          if($data->gameName == 'CASINO'){
            $winnerTeam = '';
            $i=1;
            switch($udModel->callType){
              case 'LiveTeenPati':{
                $winnerTeam = 'Player '.$data->results;
                break;
              }
              case 'AndarBahar':{
                $winnerTeam = ($data->results == 'A' ? 'Andar' : 'Bahar');
                break;
              }
              case 'Poker':{
                $winnerTeam = 'Player '.$data->results;
                break;
              }
              case 'UpDown7':{
                if($data->results > 7){
                  $winnerTeam = '7Up';
                }else if($data->results == 7){
                  $winnerTeam = '7';
                 }else if($data->results < 7){
                  $winnerTeam = '7Down';
                }
                break;
              }
              case 'CardScasin032':{
                $winnerTeam = 'Player '.$data->results;
                break;
              }
              case 'TeenPati20':{
                $winnerTeam = 'Player '.$data->results;
                break;
              }
              case 'AmarAkbarAnthony':{
                if($data->results >= 1 && $data->results <= 6){
                  $winnerTeam = 'Amar';
                }else if(($data->results >= 7 && $data->results <= 10)){
                  $winnerTeam = 'Akbar';
                 }else if(($data->results >= 11 && $data->results <= 13)){
                  $winnerTeam = 'Anthony';
                }
                break;
              }
              case 'DragOnTiger':{
                if(strtoupper($data->results) == 'D'){
                  $winnerTeam = 'Dragon';
                }else if(strtoupper($data->results) == 'T'){
                  $winnerTeam = 'Tiger';
                }else if(strtoupper($data->results) == 'TIE'){
                  $winnerTeam = 'Tie (Rank Only)';
                }else if(strtoupper($data->results) == 'ST'){
                  $winnerTeam = 'Suited Tie';
                }
                break;
              }
            }
            if($winnerTeam == $data->team_name){
              $winloss = "<span style='color:green;'>".$data->bet_profit."<span>";
              $tot +=$data->bet_profit;
            }else{
              $winloss = "<span style='color:red;'>-".$data->bet_amount."<span>";
              $tot -=abs($data->bet_amount);
            }
          }
          if($requestData['isCallSide'] == "userSide"){
            $html .= '<tr class="'.$class.'">';
                $html .= '<td>'.$j++.'</td>';
                $html .= '<td>'.$data->team_name.'</td>';
                $html .= '<td>'.$data->bet_side.'</td>';
                $html .= '<td>'.$data->bet_odds.'</td>';
                $html .= '<td>'.$data->bet_amount.'</td>';
                $html .= '<td>'.$winloss.'</td>';
                $html .= '<td>'.$data->created_at.'</td>';
                $html .= '<td>'.$data->created_at.'</td>';
            $html .= '</tr>';
          }else{
            $html .= '<tr class="'.$class.'">';
              $html .= '<td>'.$data->upLink.'</td>';
              $html .= '<td>'.$data->UserName.'</td>';
              $html .= '<td>'.$data->team_name.'</td>';
              $html .= '<td>'.$data->bet_odds.'</td>';
              $html .= '<td>'.$data->bet_amount.'</td>';
              $html .= '<td>'.$winloss.'</td>';
              $html .= '<td>'.$data->created_at.'</td>';
              $html .= '<td>'.$data->created_at.'</td>';
              $html .= '<td>'.$data->ip_address.'</td>';
              $html .= '<td><span title="'.$data->browser_details.'">details</span></td>';
            $html .= '</tr>';
          }
        }
      $html .= '</tbody>';
    $html .= '</table>';
    $arr = array();
    $arr['html'] = $html;
    $arr['count'] = $i;
    $uExp = explode(',', $requestData['user_id']);
    $user1 = User::find($uExp[0]);
    if(isset($uExp[0])){
        if(strtoupper($user1->roles->first()->name) == 'USER'){
            if($udModel->deposite_user_id == $uExp[0]){
                $arr['tot'] = $udModel->amount;
            }else{
                $arr['tot'] = (0-$udModel->amount);
            }
        }else{
            if(isset($uExp[1])){
                $user2 = User::find($uExp[1]);
                if(strtoupper($user2->roles->first()->name) == 'USER'){
//                    die($udModel->deposite_user_id." == ".$uExp[1]);
                    if($udModel->deposite_user_id == $uExp[1]){
                        $arr['tot'] = $udModel->amount;
                    }else{
                        $arr['tot'] = (0-$udModel->amount);
                    }
                }
            }
        }
    }
    if(!isset($arr['tot'])){
       $arr['tot'] = 0; 
    }
    return json_encode($arr);
  }
  public static function getUserIDString($userID = ''){
    if(empty($userID)){
        $userID = Auth::user()->id;
    }  
    $userArr = self::getChildUserListArr($userID);
    if(is_array($userArr) && count($userArr) == 0){
        $userArr[] = $userID;
    }
    return implode(',', $userArr);
  }
  public function currentbets(){
//     $betModel = MyBets::where(['active'=>1])->get();
     $userIDS = self::getUserIDString();
     $sql = "SELECT mb.*,u.first_name as userName,s.match_name as sportName,g.name as gameName
                    FROM `my_bets` mb
                    LEFT JOIN sports s ON (s.id = mb.sportID)
                    LEFT JOIN users u ON(u.id = mb.user_id)
                    LEFT JOIN games g ON(g.id = s.game_id)
                    WHERE mb.user_id IN(".$userIDS.")
                    AND mb.active = 1 
                    AND mb.isDeleted = 0 
                    AND s.match_id = mb.match_id";
     
     $betModel = DB::select($sql);
     return view('backend.accounts.currentbets', compact('betModel'));
  }
  
  public function currentbetsList(Request $request){
    $requestData = $request->all();
    if($requestData['type'] == 'matched'){
    $userIDS = self::getUserIDString();    
    $sql = "SELECT mb.*,u.first_name as userName,s.match_name as sportName,g.name as gameName
                    FROM `my_bets` mb
                    LEFT JOIN sports s ON (s.id = mb.sportID)
                    LEFT JOIN users u ON(u.id = mb.user_id)
                    LEFT JOIN games g ON(g.id = s.game_id)
                    WHERE mb.user_id IN(".$userIDS.")
                    AND mb.active = 1 
                    AND mb.isDeleted = 0 
                    AND s.match_id = mb.match_id  
                    ORDER BY mb.created_at DESC";
     
     $betModel = DB::select($sql);
     $options = view("backend.accounts.currentBel-row",compact('betModel'))->render();
      return $options;
    }else{
      $html = '<tr><td colspan="9">Record Not available</td></tr>';
      
      return $html;
    }
  }

  public function generalreport(){
    $userIDs = self::getUserIDString();  
    $sql = "SELECT * FROM `users` WHERE active=1 AND id IN(".$userIDs.")";
    $userModel = DB::select($sql);
    $report = 1; // 1 => General Report
    return view('backend.accounts.generalreport', compact('userModel','report'));
  }
  public function generalreportList(Request $request){
    $requestData = $request->all();
    $userIDs = self::getUserIDString(); 
    $sql = "SELECT * FROM `users` WHERE active=1 AND id IN(".$userIDs.")";
    $userModel = DB::select($sql);
    $report = $requestData['type']; // 1 => General Report
    return view('backend.accounts.general-report-row', compact('userModel','report'));
  }
  
  public function gamereport(){
     return view('backend.accounts.gamereport');
  }
  
  public function getgameandfancylist(Request $request){
    $requestData = $request->all();
    
    if($requestData['type'] == 'MATCH'){
      $where = '';
      if(isset($requestData['fromdate'])){
        $where .= ' AND s.created_at >= "'.date('Y-m-d',strtotime($requestData['fromdate'])).'"';
      }
      if(isset($requestData['todate'])){
         $where .= ' AND s.created_at <= "'.date('Y-m-d',strtotime($requestData['todate'])).'"';
      }
      $sql = "SELECT CONCAT(s.match_name,', ',g.name,', (',s.created_at,') ') as title,CONCAT(s.id,'-MATCH-',g.name) as IDs
                     FROM `sports` s
                     JOIN games g ON (s.game_id = g.id)
                     WHERE s.`winner` !='' AND g.name != 'CASINO'
                     ".$where."
                     GROUP BY s.id";
    }elseif($requestData['type'] == 'FANCY'){
      $where = '';
      if(isset($requestData['fromdate'])){
        $where .= ' AND mf.created_at >= "'.date('Y-m-d',strtotime($requestData['fromdate'])).'"';
      }
      if(isset($requestData['todate'])){
         $where .= ' AND mf.created_at <= "'.date('Y-m-d',strtotime($requestData['todate'])).'"';
      }
      $sql = "SELECT  CONCAT(mf.fancyName,', ',mf.fancyType,', (',mf.created_at,') ') as title,CONCAT(mf.id,'-FANCY-',g.name) as IDs
                      FROM match_fancies mf
                      JOIN `sports` s ON(mf.match_id = s.match_id)
                      JOIN games g ON (s.game_id = g.id)
                      WHERE mf.`result` !='' AND g.name != 'CASINO'
                      ".$where."
                      GROUP BY mf.fancyName";
    }else{
      $where = $where1 = $where2 = '';
      if(isset($requestData['fromdate'])){
        $where .= ' AND mf.created_at >= "'.date('Y-m-d',strtotime($requestData['fromdate'])).'"';
        $where1 .= ' AND s.created_at >= "'.date('Y-m-d',strtotime($requestData['fromdate'])).'"';
        $where2 .= ' AND c.created_at >= "'.date('Y-m-d',strtotime($requestData['fromdate'])).'"';
      }
      if(isset($requestData['todate'])){
        $where .= ' AND mf.created_at <= "'.date('Y-m-d',strtotime($requestData['todate'])).'"';
        $where1 .= ' AND s.created_at <= "'.date('Y-m-d',strtotime($requestData['todate'])).'"';
        $where2 .= ' AND c.created_at <= "'.date('Y-m-d',strtotime($requestData['todate'])).'"';
      }
      $sql = "SELECT  CONCAT(mf.fancyName,', ',mf.fancyType,', (',mf.created_at,') ') as title,CONCAT(mf.id,'-FANCY-',g.name) as IDs
                      FROM match_fancies mf
                          JOIN `sports` s ON(mf.match_id = s.match_id)
                          JOIN games g ON (s.game_id = g.id)
                          WHERE mf.`result` !='' AND g.name != 'CASINO'
                          ".$where."
                          GROUP BY mf.fancyName
                  UNION
                  SELECT CONCAT(s.match_name,', ',g.name,', (',s.created_at,') ') as title,CONCAT(s.id,'-MATCH-',g.name) as IDs
                         FROM `sports` s
                         JOIN games g ON (s.game_id = g.id)
                         WHERE s.`winner` !='' AND g.name != 'CASINO'
                         ".$where1."
                  UNION
                  SELECT CONCAT('Round NO : ',c.roundID,', ',s.match_name,', (',c.created_at,') ') as title,CONCAT(c.id,'-CASINO-',s.match_name) as IDs
                         FROM `casinos` c
                         JOIN `sports` s ON(s.id = c.sportID)
                         JOIN my_bets mb ON (mb.match_id = c.roundID)
                         JOIN games g ON (s.game_id = g.id)
                         WHERE c.`result` !='' AND g.name NOT IN ('CRICKET','SOCCER','TENNIS')
                         ".$where2."
                         GROUP BY c.roundID";
    }
    $model = DB::select($sql);
    
    $html = '<option value="ALL">ALL</option>';
    foreach($model as $key=>$data){
      $html .= '<option value="'.$data->IDs.'">'.$data->title.'</option>';
    }
    return $html;
  }
  
  public static function getChildUserOnlyList($userID){
    
    $model = User::where(['parent_id'=>$userID])->get();
    $userArr = array();
    foreach($model as $key=>$user){
      if(strtoupper($user->roles->first()->name) == 'USER'){
        $userArr[] = $user;
      }else{
        $data = self::getChildUserList($user->id);
        foreach($data as $j=>$val){
           $userArr[] = $val;
        }
      }
    }
    return $userArr;
  } 
  
  public function getgamereportList(Request $request){
    $requestData = $request->all();
    $idsArr = explode('-', $requestData['gameview']);
    $type = $requestData['type'];
    $htmlJSon = array();
      switch($idsArr[1]){
        case 'MATCH':{
          $htmlJSon = self::getMatchGameReport($idsArr,$type);
          break;
        }
        case 'FANCY':{
           $htmlJSon = self::getFancyGameReport($idsArr,$type);
          break;
        }
        case 'CASINO':{
          $htmlJSon = self::getMatchGameReport($idsArr,$type);
          break;
        }
      }
      
      $htmlArr = array();
      $htmlArr['sub'] =  $htmlArr['plus'] = '';
      $subcount = $plusCount = 1;
      $tot = $totSun = 0;
      foreach($htmlJSon as $key=>$arr){
        if($arr['tot'] < 0){
          $htmlArr['sub'] .= '<tr>';
            $htmlArr['sub'] .= '<td>'.$subcount++.'</td>';
            $htmlArr['sub'] .= '<td>'.$arr['name'].'</td>';
            $htmlArr['sub'] .= '<td style="color:red;">'.$arr['tot'].'</td>';
          $htmlArr['sub'] .= '</tr>';
          $totSun += $arr['tot'];
        }elseif($arr['tot'] > 0){
          $htmlArr['plus'] .= '<tr>';
            $htmlArr['plus'] .= '<td>'.$plusCount++.'</td>';
            $htmlArr['plus'] .= '<td>'.$arr['name'].'</td>';
            $htmlArr['plus'] .= '<td style="color:green;">'.$arr['tot'].'</td>';
          $htmlArr['plus'] .= '</tr>';
          $tot += $arr['tot'];
        }
      }
      
      $htmlArr['sub'] .= '<tr>';
        $htmlArr['sub'] .= '<td></td>';
        $htmlArr['sub'] .= '<td>General Total :</td>';
        $htmlArr['sub'] .= '<td style="color:red;">'.$totSun.'</td>';
      $htmlArr['sub'] .= '</tr>';
          
      $htmlArr['plus'] .= '<tr>';
        $htmlArr['plus'] .= '<td></td>';
        $htmlArr['plus'] .= '<td>General Total : </td>';
        $htmlArr['plus'] .= '<td style="color:green;">'.$tot.'</td>';
      $htmlArr['plus'] .= '</tr>';
      $tot += $arr['tot'];
      return json_encode($htmlArr);
  }
  
  public static function getFancyGameReport($data,$gameView){
    $childUserArr = self::getChildUserListArr(Auth::user()->id);
    $sportModel = MatchFancy::find($data[0]);
    $matchID = $sportModel->match_id;
    
    $sql = "SELECT 	u.id,u.first_name as userName,SUM(ud.amount) as tot
                    FROM `user_deposites` ud 
                    JOIN users u ON(ud.deposite_user_id = u.id)
                    WHERE ud.match_id = '".$matchID."' AND ud.`type` LIKE '%SESSION%'
                    GROUP BY u.`id`";
    $model = DB::select($sql);
    
    $htmlDataArr = array();
    foreach($model as $key=>$user){
      $userModel = User::find($user->id);
      if($gameView == 'GAME-REPORT' && strtoupper($userModel->roles->first()->name) == 'USER' && in_array($user->id, $childUserArr)){
        $htmlDataArr[$user->id]['tot'] = $user->tot;
        $htmlDataArr[$user->id]['name'] = $user->userName;
      }
      if($gameView == 'MASTER-REPORT' && strtoupper($userModel->roles->first()->name) != 'USER' && in_array($user->id, $childUserArr)){
        $htmlDataArr[$user->id]['tot'] = $user->tot;
        $htmlDataArr[$user->id]['name'] = $user->userName;
      }
    }
    
    $sql = "SELECT 	u.id,u.first_name as userName,SUM(ud.amount) as tot
                    FROM `user_deposites` ud 
                    JOIN users u ON(ud.withdrawal_user_id = u.id)
                    WHERE ud.match_id = '".$matchID."' AND ud.`type` LIKE '%SESSION%'
                    GROUP BY u.`id`";
    $model = DB::select($sql);
    
    foreach($model as $key=>$user){
      $userModel = User::find($user->id);
      if($gameView == 'GAME-REPORT' && strtoupper($userModel->roles->first()->name) == 'USER' && in_array($user->id, $childUserArr)){
        if(isset($htmlDataArr[$user->id]['tot'])){
          $htmlDataArr[$user->id]['tot'] -= $user->tot;
        }else{
          $htmlDataArr[$user->id]['tot'] = ($user->tot*(-1));
        }
        $htmlDataArr[$user->id]['name'] = $user->userName;
      }
      if($gameView == 'MASTER-REPORT' && strtoupper($userModel->roles->first()->name) != 'USER' && in_array($user->id, $childUserArr)){
        if(isset($htmlDataArr['sub'][$user->id]['tot'])){
          $htmlDataArr[$user->id]['tot'] -= $user->tot;
        }else{
          $htmlDataArr[$user->id]['tot'] = ($user->tot*(-1));
        }
        $htmlDataArr[$user->id]['name'] = $user->userName;
      }
    }
    return $htmlDataArr;
    
  }
  public static function getMatchGameReport($data,$gameView){
    if($data[1] == 'CASINO'){
      $sportModel = Casino::find($data[0]);
      $matchID = $sportModel->roundID;
    }else{
      $sportModel = Sports::find($data[0]);
      $matchID = $sportModel->match_id;
    }
    $childUserArr = self::getChildUserListArr(Auth::user()->id);
//    dd($childUserArr);
    
    $sql = "SELECT 	u.id,u.first_name as userName,SUM(ud.amount) as tot
                    FROM `user_deposites` ud 
                    JOIN users u ON(ud.deposite_user_id = u.id)
                    WHERE ud.match_id = '".$matchID."' AND ud.`type` = 'ODDS_BOOKMEKER'
                    GROUP BY u.`id`";
    $model = DB::select($sql);
    
    $htmlDataArr = array();
    foreach($model as $key=>$user){
      $userModel = User::find($user->id);
      if($gameView == 'GAME-REPORT' && strtoupper($userModel->roles->first()->name) == 'USER' && in_array($user->id, $childUserArr)){
        $htmlDataArr[$user->id]['tot'] = $user->tot;
        $htmlDataArr[$user->id]['name'] = $user->userName;
      }
      if($gameView == 'MASTER-REPORT' && strtoupper($userModel->roles->first()->name) != 'USER' && in_array($user->id, $childUserArr)){
        $htmlDataArr[$user->id]['tot'] = $user->tot;
        $htmlDataArr[$user->id]['name'] = $user->userName;
      }
    }
    
    $sql = "SELECT 	u.id,u.first_name as userName,SUM(ud.amount) as tot
                    FROM `user_deposites` ud 
                    JOIN users u ON(ud.withdrawal_user_id = u.id)
                    WHERE ud.match_id = '".$matchID."' AND ud.`type` = 'ODDS_BOOKMEKER'
                    GROUP BY u.`id`";
    $modelArr = DB::select($sql);
    
    
    foreach($modelArr as $key=>$user){
      $userModel = User::find($user->id);
      if($gameView == 'GAME-REPORT' && strtoupper($userModel->roles->first()->name) == 'USER' && in_array($user->id, $childUserArr)){
        if(isset($htmlDataArr[$user->id]['tot'])){
          $htmlDataArr[$user->id]['tot'] -= $user->tot;
        }else{
          $htmlDataArr[$user->id]['tot'] = ($user->tot*(-1));
        }
        $htmlDataArr[$user->id]['name'] = $user->userName;
      }
      if($gameView == 'MASTER-REPORT' && strtoupper($userModel->roles->first()->name) != 'USER' && in_array($user->id, $childUserArr)){
        if(isset($htmlDataArr[$user->id]['tot'])){
          $htmlDataArr[$user->id]['tot'] -= $user->tot;
        }else{
          $htmlDataArr[$user->id]['tot'] = ($user->tot*(-1));
        }
        $htmlDataArr[$user->id]['name'] = $user->userName;
      }
    }
//    dd($htmlDataArr);
    return $htmlDataArr;
    
  }


  public function profitloss(){
    $user = User::find(['id'=>Auth::user()->id]);
//    if(Auth::user()->roles->first()->name == 'administrator'){
//      $userModel = User::where(['active'=>1])->get();
//    }else{
//      $userModel = User::where(['active'=>1,'parent_id'=>Auth::user()->id])->get();
//    }
      $userModel = self::getChildUserList(Auth::user()->id);
    return view('backend.accounts.profitloss', compact('userModel'));
  }
  
   public function profitlossList(Request $request){
    $requestData = $request->all();
    $userModel = User::find($requestData['user']);
    $mainCal = array();
    $mainCal = array();
    $userID =$requestData['user'];
    $sdate=$requestData['sDate'];
    $edate=$requestData['eDate'];
      $mainCal['Cricket']['ODDS_BOOKMEKER'] = self::getODDSBOOKMAKER($userID,'ODDS_BOOKMEKER','Cricket',$sdate,$edate);
      $mainCal['Cricket']['SESSION'] = self::getODDSBOOKMAKER($userID,'SESSION','Cricket',$sdate,$edate);

      $mainCal['Tennis']['ODDS_BOOKMEKER'] = self::getODDSBOOKMAKER($userID,'ODDS_BOOKMEKER','Tennis',$sdate,$edate);

      $mainCal['Soccer']['ODDS_BOOKMEKER'] = self::getODDSBOOKMAKER($userID,'ODDS_BOOKMEKER','Soccer',$sdate,$edate);
      $mainCal['Soccer']['SESSION'] = self::getODDSBOOKMAKER($userID,'SESSION','Soccer',$sdate,$edate);

      $mainCal['LiveTeenPati']['ODDS_BOOKMEKER'] = self::getODDSBOOKMAKERGAME($userID,'ODDS_BOOKMEKER','Live Teenpatti',$sdate,$edate);

      $mainCal['AndarBahar']['ODDS_BOOKMEKER'] = self::getODDSBOOKMAKERGAME($userID,'ODDS_BOOKMEKER','Andar Bahar',$sdate,$edate);

      $mainCal['Poker']['ODDS_BOOKMEKER'] = self::getODDSBOOKMAKERGAME($userID,'ODDS_BOOKMEKER','Poker',$sdate,$edate);

      $mainCal['UpDown7']['ODDS_BOOKMEKER'] = self::getODDSBOOKMAKERGAME($userID,'ODDS_BOOKMEKER','7 up & Down',$sdate,$edate);

      $mainCal['CardScasin032']['ODDS_BOOKMEKER'] = self::getODDSBOOKMAKERGAME($userID,'ODDS_BOOKMEKER','32 cards Casino',$sdate,$edate);

      $mainCal['TeenPati20']['ODDS_BOOKMEKER'] = self::getODDSBOOKMAKERGAME($userID,'ODDS_BOOKMEKER','TeenPatti T20',$sdate,$edate);

      $mainCal['AmarAkbarAnthony']['ODDS_BOOKMEKER'] = self::getODDSBOOKMAKERGAME($userID,'ODDS_BOOKMEKER','Amar Akbar Anthony',$sdate,$edate);

      $mainCal['DragOnTiger']['ODDS_BOOKMEKER'] = self::getODDSBOOKMAKERGAME($userID,'ODDS_BOOKMEKER','Dragon Tiger',$sdate,$edate);
//dd($mainCal);
    return view('backend.accounts.profitloss-row', compact('userModel','mainCal'));
  }
  public static function getODDSBOOKMAKER($userID,$type = 'ODDS_BOOKMEKER',$gameName = 'Cricket',$sdate='',$edate = ''){
  //    return 100;
      /*$sql = 'SELECT ud.*, 
                      sum(ud.amount) as Tot
                      FROM `user_deposites` ud 
                      JOIN sports s ON(s.match_id = ud.match_id)
                      JOIN games g ON(g.id = s.game_id)
                      WHERE SUBSTRING_INDEX(ud.type,"-",1) = "'.$type.'" AND UPPER(g.name) = "'.strtoupper($gameName).'" AND ud.`withdrawal_user_id` = "'.$userID.'"';
      if(!empty($sdate)){
        $sql .= ' AND DATE_FORMAT(ud.created_at, "%Y-%m-%d") >= "'.date('Y-m-d',strtotime($sdate)).'"';
      }
      if(!empty($edate)){
        $sql .= ' AND DATE_FORMAT(ud.created_at, "%Y-%m-%d") <= "'.date('Y-m-d',strtotime($edate)).'  23:59:59"';
      }
      $sql .= 'GROUP BY s.match_id';*/
      
       $sql = 'SELECT SUM(ud.amount) as Tot
                      
                      FROM `user_deposites` ud 
                      JOIN sports s ON(s.match_id = ud.match_id)
                      JOIN games g ON(g.id = s.game_id)
                      WHERE SUBSTRING_INDEX(ud.type,"-",1) = "'.$type.'" AND UPPER(g.name) = "'.strtoupper($gameName).'" AND ud.`withdrawal_user_id` = "'.$userID.'"';
      if(!empty($sdate)){
        $sql .= ' AND DATE_FORMAT(ud.created_at, "%Y-%m-%d") >= "'.date('Y-m-d',strtotime($sdate)).'"';
      }
      if(!empty($edate)){
        $sql .= ' AND DATE_FORMAT(ud.created_at, "%Y-%m-%d") <= "'.date('Y-m-d',strtotime($edate)).'  23:59:59"';
      }
     // $sql .= 'GROUP BY s.match_id';
      
      $betModel = DB::select($sql);
      $totDR = 0;
     if(isset($betModel[0]->Tot)){
        $totDR = $betModel[0]->Tot;
      }
     /* foreach($betModel as $key=>$val){
          $totDR = $val->Tot;
      }*/
 //     echo "<br><br><br>".$sql;
     /* $sql = 'SELECT ud.*, 
                      sum(ud.amount) as Tot
                      FROM `user_deposites` ud 
                      JOIN sports s ON(s.match_id = ud.match_id)
                      JOIN games g ON(g.id = s.game_id)
                      WHERE SUBSTRING_INDEX(ud.type,"-",1) = "'.$type.'" AND UPPER(g.name) = "'.strtoupper($gameName).'" AND ud.`deposite_user_id` = "'.$userID.'"';
      if(!empty($sdate)){
        $sql .= ' AND DATE_FORMAT(ud.created_at, "%Y-%m-%d") >= "'.date('Y-m-d',strtotime($sdate)).'"';
      }
      if(!empty($edate)){
        $sql .= ' AND DATE_FORMAT(ud.created_at, "%Y-%m-%d") <= "'.date('Y-m-d',strtotime($edate)).'  23:59:59"';
      }
      $sql .= 'GROUP BY s.match_id';*/
       $sql = 'SELECT SUM(ud.amount) as Tot
                      FROM `user_deposites` ud 
                      JOIN sports s ON(s.match_id = ud.match_id)
                      JOIN games g ON(g.id = s.game_id)
                      WHERE SUBSTRING_INDEX(ud.type,"-",1) = "'.$type.'" AND UPPER(g.name) = "'.strtoupper($gameName).'" AND ud.`deposite_user_id` = "'.$userID.'"';
      if(!empty($sdate)){
        $sql .= ' AND DATE_FORMAT(ud.created_at, "%Y-%m-%d") >= "'.date('Y-m-d',strtotime($sdate)).'"';
      }
      if(!empty($edate)){
        $sql .= ' AND DATE_FORMAT(ud.created_at, "%Y-%m-%d") <= "'.date('Y-m-d',strtotime($edate)).'  23:59:59"';
      }
      //$sql .= 'GROUP BY s.match_id';
//      dd($sql);
//      echo "<br><br><br>".$sql;
      
      $betModel = DB::select($sql);
      $totCR = 0;
      
      if(isset($betModel[0]->Tot)){
        $totCR = $betModel[0]->Tot;
      }
      /*foreach($betModel as $key=>$val){
          $totCR = $val->Tot;
      }*/
      $tot = $totCR-$totDR;
      return $tot;
    }
  
    public static function getODDSBOOKMAKERGAME($userID,$type = 'ODDS_BOOKMEKER',$gameName = 'Cricket',$sdate='',$edate = ''){
  //    return 100;
      $sql = 'SELECT ud.*, 
                      sum(ud.amount) as Tot
                      FROM `user_deposites` ud 
                      JOIN casinos c ON(c.roundID = ud.match_id)
                      JOIN sports s ON(s.id = c.sportID)
                      WHERE ud.type = "'.$type.'" 
                            AND s.match_name = "'.$gameName.'" 
                            AND ud.`withdrawal_user_id` = "'.$userID.'"';
      if(!empty($sdate)){
        $sql .= ' AND ud.created_at >= "'.date('Y-m-d',strtotime($sdate)).'"';
      }
      if(!empty($edate)){
        $sql .= ' AND ud.created_at <= "'.date('Y-m-d',strtotime($edate)).'"';
      }
      $sql .= 'GROUP BY ud.withdrawal_user_id';
                      

      $betModel = DB::select($sql);
      $totDR = 0;
      /*if(isset($betModel[0]->Tot)){
        $totDR = $betModel[0]->Tot;
      }*/
      foreach($betModel as $key=>$val){
          $totDR = $val->Tot;
      }
      $sql = 'SELECT ud.*, 
                      sum(ud.amount) as Tot
                      FROM `user_deposites` ud 
                      JOIN casinos c ON(c.roundID = ud.match_id)
                      JOIN sports s ON(s.id = c.sportID)
                      WHERE ud.type = "'.$type.'" 
                            AND s.match_name = "'.$gameName.'" 
                            AND ud.`deposite_user_id` = "'.$userID.'"';
      if(!empty($sdate)){
        $sql .= ' AND ud.created_at >= "'.date('Y-m-d',strtotime($sdate)).'"';
      }
      if(!empty($edate)){
        $sql .= ' AND ud.created_at <= "'.date('Y-m-d',strtotime($edate)).'"';
      }
      $sql .= 'GROUP BY ud.deposite_user_id';
      
      $betModel = DB::select($sql);
      $totCR = 0;
      /*if(isset($betModel[0]->Tot)){
        $totCR = $betModel[0]->Tot;
      }*/
      foreach($betModel as $key=>$val){
          $totCR = $val->Tot;
      }
      $tot = $totCR-$totDR;
      return $tot;
    }
    
  public static function OLDgetODDSBOOKMAKER($userID,$type = 'ODDS_BOOKMEKER',$gameName = 'Cricket'){
    $requestDataArr = request()->all();
    
    $where = '';
    if(isset($requestDataArr['sDate'])){
      $where .= ' AND ud.created_at >= "'.date('Y-m-d',strtotime($requestDataArr['sDate'])).'"';
    }
    if(isset($requestDataArr['eDate'])){
      $where .= ' AND ud.created_at <= "'.date('Y-m-d',strtotime($requestDataArr['eDate'])).' 23:59:59"';
    }
    $sql = 'SELECT ud.*, 
                    sum(ud.amount) as Tot
                    FROM `user_deposites` ud 
                    JOIN sports s ON(s.match_id = ud.match_id)
                    JOIN games g ON(g.id = s.game_id)
                    WHERE ud.type = "'.$type.'" AND g.name = "'.$gameName.'" AND ud.`withdrawal_user_id` = "'.$userID.'"
                    '.$where.'  
                    GROUP BY s.match_id';
    
    $betModel = DB::select($sql);
    $totDR = 0;
    if(isset($betModel[0]->Tot)){
      $totDR = $betModel[0]->Tot;
    }
    $sqlNew = 'SELECT ud.*, 
                    sum(ud.amount) as Tot
                    FROM `user_deposites` ud 
                    JOIN sports s ON(s.match_id = ud.match_id)
                    JOIN games g ON(g.id = s.game_id)
                    WHERE ud.type = "'.$type.'" AND g.name = "'.$gameName.'" AND ud.`deposite_user_id` = "'.$userID.'"
                    '.$where.'    
                    GROUP BY s.match_id';
    
    $betModel = DB::select($sqlNew);
    $totCR = 0;
    if(isset($betModel[0]->Tot)){
      $totCR = $betModel[0]->Tot;
    }
    $tot = $totCR-$totDR;
    return $tot;
  }
  
  public static function OLDgetODDSBOOKMAKERGAME($userID,$type = 'ODDS_BOOKMEKER',$gameName = 'Cricket'){
    $requestDataArr = request()->all();
    
    $where = '';
    if(isset($requestDataArr['sDate'])){
      $where .= ' AND ud.created_at >= "'.date('Y-m-d',strtotime($requestDataArr['sDate'])).'"';
    }
    if(isset($requestDataArr['eDate'])){
      $where .= ' AND ud.created_at <= "'.date('Y-m-d',strtotime($requestDataArr['eDate'])).' 23:59:59"';
    }
    $sql = 'SELECT ud.*, 
                    sum(ud.amount) as Tot
                    FROM `user_deposites` ud 
                    JOIN casinos c ON(c.roundID = ud.match_id)
                    JOIN sports s ON(s.id = c.sportID)
                    WHERE ud.type = "'.$type.'" AND s.match_name = "'.$gameName.'" AND ud.`withdrawal_user_id` = "'.$userID.'"
                    '.$where.'  
                    GROUP BY ud.match_id';
    
    $betModel = DB::select($sql);
    $totDR = 0;
    if(isset($betModel[0]->Tot)){
      $totDR = $betModel[0]->Tot;
    }
    
    $sql = 'SELECT ud.*, 
                    sum(ud.amount) as Tot
                    FROM `user_deposites` ud 
                    JOIN casinos c ON(c.roundID = ud.match_id)
                    JOIN sports s ON(s.id = c.sportID)
                    WHERE ud.type = "'.$type.'" AND s.match_name = "'.$gameName.'" AND ud.`deposite_user_id` = "'.$userID.'"
                    '.$where.'  
                    GROUP BY ud.match_id';
    
    $betModel = DB::select($sql);
    $totCR = 0;
    if(isset($betModel[0]->Tot)){
      $totCR = $betModel[0]->Tot;
    }
    $tot = $totCR-$totDR;
    return $tot;
  }

  public function casinoresultreport(){
    $gameModel = Games::where(['name'=>'CASINO'])->first();
    $sportModel = Sports::where(['active'=>1,'game_id'=>$gameModel->id])->get();
    return view('backend.accounts.casinoresultreport', compact('sportModel'));
  }
  
  public function casinoresultreportList(Request $request){
    $requestData = $request->all();
//    $casinoModel = Casino::where(['result'!='','sportID'=>$request['sportID']])->get();
    $sql = "SELECT * FROM `casinos` WHERE `sportID`='".$request['sportID']."' AND `result`!=''";
    if(isset($requestData['sDate'])){
      $sql .= " AND DATE(created_at) = '".date('Y-m-d',strtotime($requestData['sDate']))."'";
    }
    $sql .= " ORDER BY `id` DESC";
    $casinoModel = DB::select($sql);
    return view('backend.accounts.casinoresultreport-row', compact('casinoModel'));
  }

  public static function getSportDetails($sportID,$userID = ''){
    $response = array();
    $sportModel = Sports::find($sportID);
    $response['eventName'] = $sportModel->match_name;
    
    $gameModel = Games::find($sportModel->sportID);
    
    $response['eventType'] = $gameModel->name;
    
    
  }
}
