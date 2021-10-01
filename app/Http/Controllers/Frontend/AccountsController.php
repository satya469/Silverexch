<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MyBets;
use Auth;
use App\Sports;
use App\Casino;
use App\Games;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;
class AccountsController extends Controller
{
    public function accountstatement(){
      return view('frontend.button-value.accountstatement');
    }
    
    public function accountstatementList(Request $request){
      
        $requestData = $request->all();
        $userID = Auth::user()->id;
        if($requestData['reportType'] == '2'){
            $sql = "SELECT *, note as details 
                       FROM `user_deposites`
                       WHERE (balanceType = 'DEPOSIT' OR balanceType = 'WITHDRAWAL') 
                              AND (`deposite_user_id` ='".$userID."' OR `withdrawal_user_id` = '".$userID."')";
         
        if(isset($request['sDate']) && !empty($request['sDate'])){
            $sql .= " AND DATE_FORMAT(created_at, '%Y-%m-%d') >= '".date('Y-m-d',strtotime($request['sDate']))."'";
        }
        if(isset($request['eDate']) && !empty($request['eDate'])){
            $sql .= " AND DATE_FORMAT(created_at, '%Y-%m-%d') <= '".date('Y-m-d',strtotime($request['eDate']))."'";
        }
        
        $betModel = DB::select($sql);
        $sqlDep = "SELECT SUM(`amount`) as totDep 
                        FROM `user_deposites` 
                        WHERE balanceType = 'DEPOSIT' 
                        AND `deposite_user_id`='".$userID."'";
        
        if(isset($request['sDate']) && !empty($request['sDate'])){
            $sqlDep .= " AND DATE_FORMAT(created_at, '%Y-%m-%d') < '".date('Y-m-d',strtotime($request['sDate']))."'";
        }
        
        $sqlWid = "SELECT SUM(`amount`) as totWid 
            FROM `user_deposites` 
            WHERE balanceType = 'WITHDRAWAL' 
            AND `withdrawal_user_id`='".$userID."'";
        
        if(isset($request['sDate']) && !empty($request['sDate'])){ 
            $sqlWid .= " AND DATE_FORMAT(created_at, '%Y-%m-%d') < '".date('Y-m-d',strtotime($request['sDate']))."'";
        }
        
        $optDate = date('Y-m-d',strtotime($request['sDate']))." 00:00:00";
        
        $DepModel = DB::select($sqlDep);
        $widModel = DB::select($sqlWid);
        $depTot = $DepModel[0]->totDep;
        $widTot = $widModel[0]->totWid;
        $optBal = ($depTot-$widTot);
        
        $options = view("frontend.button-value.accountstatement-game-row",compact('betModel','optBal','optDate'))->render();
        return $options;
         
      }elseif($requestData['reportType'] == '3'){
        $where = '';
        if(isset($request['sDate']) && !empty($request['sDate'])){
            $where .= " AND DATE_FORMAT(ud.created_at, '%Y-%m-%d') >= '".date('Y-m-d',strtotime($request['sDate']))."'";
        }
         
        if(isset($request['eDate']) && !empty($request['eDate'])){
            $where .= " AND DATE_FORMAT(ud.created_at, '%Y-%m-%d')<= '".date('Y-m-d',strtotime($request['eDate']))."'";
        }
        $where .= 'AND '.Auth::user()->id.' IN(ud.`deposite_user_id`,ud.`withdrawal_user_id`)';
        
        $sql = "SELECT t.* FROM (SELECT ud.*,CONCAT(g.name,' // ',s.match_name,' // ',mf.fancyName,' // ',mf.result) as details
                        FROM `user_deposites` ud
                        LEFT JOIN my_bets mb ON(mb.id = ud.bet_id )
                        LEFT JOIN match_fancies mf ON(mf.id = ud.fancy_id)
                        LEFT JOIN sports s ON (s.match_id = ud.match_id)
                        LEFT JOIN games g ON (g.id = s.game_id)
                        WHERE SUBSTRING_INDEX(ud.type,'-',1) = ('SESSION') AND 
                                  ud.`callType` IN ('CRICKET','SOCCER')
                                  ".$where."
                        GROUP BY ud.id ";       
             
        $sql .= "  UNION  ";

        $sql .= " SELECT ud.*,CONCAT(g.name,' // ',s.match_name,' // ',s.winner) as details
                    FROM `user_deposites` ud
                        LEFT JOIN my_bets mb ON(ud.match_id = mb.match_id AND mb.bet_type IN ('ODDS','BOOKMEKER'))
                        LEFT JOIN sports s ON (s.match_id = mb.match_id)
                        LEFT JOIN games g ON (g.id = s.game_id)
                        WHERE ud.`type` IN ('ODDS_BOOKMEKER') AND 
                              ud.`callType` IN ('CRICKET','TENNIS','SOCCER')
                               ".$where."
                         GROUP BY ud.id";         
        $sql .= " UNION ";

        $sql .= "SELECT ud.*,CONCAT(s.match_name,' // Round ID : ',mb.match_id,' // ',c.result) as details
                    FROM `user_deposites` ud
                        LEFT JOIN my_bets mb ON(ud.match_id = mb.match_id AND mb.bet_type IN ('ODDS','BOOKMEKER'))
                        LEFT JOIN sports s ON (s.id = mb.sportID)
                        LEFT JOIN casinos c ON (c.roundID = mb.match_id)
                        WHERE ud.`type` IN ('ODDS_BOOKMEKER') AND 
                              ud.`callType` IN ('LiveTeenPati','AndarBahar','Poker','UpDown7','CardScasin032','TeenPati20','AmarAkbarAnthony','DragOnTiger')
                               ".$where."
                         GROUP BY ud.id";
        
        $sql .= ') t ORDER BY t.created_at';
         $betModel = DB::select($sql);
        if(isset($request['sDate']) && !empty($request['sDate'])){
            $sDate =  $request['sDate'];
        }else{
            $sDate = date('Y-m-d');
        }
        $sqlDep = "SELECT SUM(`amount`) as depTot 
                            FROM `user_deposites` 
                            WHERE `balanceType` NOT IN('WITHDRAWAL','DEPOSIT') 
                            AND `deposite_user_id` = '".Auth::user()->id."'  
                            AND DATE_FORMAT(created_at, '%Y-%m-%d') >= '".date('Y-m-d',strtotime("-30 day", strtotime($sDate)))."'
                            AND DATE_FORMAT(created_at, '%Y-%m-%d') < '".date('Y-m-d',strtotime($sDate))."'";
        
        $depModel = DB::select($sqlDep); 
        
        $sqlWid = "SELECT SUM(`amount`) as widTot 
                            FROM `user_deposites` 
                            WHERE `balanceType` NOT IN('WITHDRAWAL','DEPOSIT') 
                            AND `withdrawal_user_id` = '".Auth::user()->id."' 
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
        $options = view("frontend.button-value.accountstatement-game-row",compact('betModel','optBal','optDate'))->render();
        return $options;
      }else{
        $where = '';
        if(isset($request['sDate']) && !empty($request['sDate'])){
          $where .= " AND ud.`created_at` >= '".date('Y-m-d',strtotime($request['sDate']))."'";
         }
         
         if(isset($request['eDate']) && !empty($request['eDate'])){
           $where .= " AND ud.`created_at` <= '".date('Y-m-d',strtotime($request['eDate']))." 23:59:59'";
         }
         $where .= 'AND '.Auth::user()->id.' IN(ud.`deposite_user_id`,ud.`withdrawal_user_id`)';
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
        if(isset($request['sDate']) && !empty($request['sDate'])){
         $sqlDep .= " AND `created_at` < '".date('Y-m-d',strtotime($request['sDate']))."'";
        }
        
        $sqlWid = "SELECT SUM(`amount`) as totWid FROM `user_deposites` WHERE balanceType = 'WITHDRAWAL' AND `withdrawal_user_id`='".$userID."'";
        if(isset($request['sDate']) && !empty($request['sDate'])){ 
          $sqlWid .= " AND `created_at` < '".date('Y-m-d',strtotime($request['sDate']))."'";
        } 
        $optDate = date('Y-m-d',strtotime($request['sDate']))." 00:00:00";
        $DepModel = DB::select($sqlDep);
        $widModel = DB::select($sqlWid);
        $depTot = $DepModel[0]->totDep;
        $widTot = $widModel[0]->totWid;
        $optBal = ($depTot-$widTot);
         
         $options = view("frontend.button-value.accountstatement-game-row",compact('betModel','optBal','optDate'))->render();
         return $options;
      }
     
    }

    public function profitloss(){
       return view('frontend.button-value.profitloss');
    }
    public function profitlossList(Request $request){
      $requestData = $request->all();
      $sdate = $requestData['sDate'];
      $edate = $requestData['eDate'];
      $userID = Auth::user()->id;
      $userModel = User::find($userID);
      $mainCal = array();
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
      $sql = 'SELECT ud.*, 
                      sum(ud.amount) as Tot
                      FROM `user_deposites` ud 
                      JOIN sports s ON(s.match_id = ud.match_id)
                      JOIN games g ON(g.id = s.game_id)
                      WHERE SUBSTRING_INDEX(ud.type,"-",1) = "'.$type.'" AND g.name = "'.$gameName.'" AND ud.`withdrawal_user_id` = "'.$userID.'"';
      if(!empty($sdate)){
        $sql .= ' AND ud.created_at >= "'.date('Y-m-d',strtotime($sdate)).'"';
      }
      if(!empty($edate)){
        $sql .= ' AND ud.created_at <= "'.date('Y-m-d',strtotime($edate)).'  23:59:59"';
      }
      $sql .= 'GROUP BY s.match_id';
      
      $betModel = DB::select($sql);
      $totDR = 0;
      if(isset($betModel[0]->Tot)){
        $totDR = $betModel[0]->Tot;
      }
//      echo "<br><br><br>".$sql;
      $sql = 'SELECT ud.*, 
                      sum(ud.amount) as Tot
                      FROM `user_deposites` ud 
                      JOIN sports s ON(s.match_id = ud.match_id)
                      JOIN games g ON(g.id = s.game_id)
                      WHERE SUBSTRING_INDEX(ud.type,"-",1) = "'.$type.'" AND g.name = "'.$gameName.'" AND ud.`deposite_user_id` = "'.$userID.'"';
      if(!empty($sdate)){
        $sql .= ' AND ud.created_at >= "'.date('Y-m-d',strtotime($sdate)).'"';
      }
      if(!empty($edate)){
        $sql .= ' AND ud.created_at <= "'.date('Y-m-d',strtotime($edate)).'  23:59:59"';
      }
      $sql .= 'GROUP BY s.match_id';
//      dd($sql);
//      echo "<br><br><br>".$sql;
      
      $betModel = DB::select($sql);
      $totCR = 0;
      
      if(isset($betModel[0]->Tot)){
        $totCR = $betModel[0]->Tot;
      }
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
      if(isset($betModel[0]->Tot)){
        $totDR = $betModel[0]->Tot;
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
      if(isset($betModel[0]->Tot)){
        $totCR = $betModel[0]->Tot;
      }
      $tot = $totCR-$totDR;
      return $tot;
    }
    public function bethistory(){
      $betModel = MyBets::where(['active'=>0,'user_id'=>Auth::user()->id,'active'=>0,'isDeleted'=>'0'])->orderBy('id', 'DESC')->get();
      
//      $sql = 'SELECT mb.*,u.first_name as userName,s.match_name as matchName
//                      FROM `my_bets` mb 
//                      LEFT JOIN sports s ON(s.id = mb.sportID)
//                      LEFT JOIN users u ON(u.id = mb.user_id)
//                      JOIN game g ON(g.id = s.game_id)
//                      WHERE g.name="Cricket"';
//      if(){
//        $sql .= ' AND `created_at` > '' AND '' <= `created_at`;
//                      ';
      
      return view('frontend.button-value.bethistory', compact('betModel'));
    }
    public function bethistoryList(Request $request){
      $requestData = $request->all();
      
      $sql = 'SELECT mb.*,u.first_name as userName,s.match_name as matchName,s.winner
                      FROM `my_bets` mb 
                      JOIN sports s ON(s.id = mb.sportID)
                      JOIN users u ON(u.id = mb.user_id)
                      JOIN games g ON(g.id = s.game_id)
                      WHERE  mb.active=0 AND mb.isDeleted=0 AND g.name="'.$requestData['reportType'].'" AND ( mb.bet_type="ODDS" OR mb.bet_type = "BOOKMAKER")';
      $sql .= ' AND u.id="'.Auth::user()->id.'"';
      if(isset($requestData['sDate']) && !empty($requestData['sDate'])){
        $sql .= ' AND mb.`created_at` >="'.date('Y-m-d',strtotime($requestData['sDate'])).'"';
      }
      
      if(isset($requestData['eDate']) && !empty($requestData['eDate'])){
        $sql .= ' AND mb.`created_at` <= "'.date('Y-m-d',strtotime($requestData['eDate'])).' 23:59:59"';
      }
      $sql .= ' UNION ';
        
       $sql .= 'SELECT mb.*,u.first_name as userName,s.match_name as matchName,mf.result as winner
                      FROM `my_bets` mb 
                      JOIN sports s ON(s.id = mb.sportID)
                      JOIN match_fancies mf ON(mf.fancyName = mb.team_name)
                      JOIN users u ON(u.id = mb.user_id)
                      JOIN games g ON(g.id = s.game_id)
                      WHERE mb.active=0 AND mb.isDeleted=0 AND g.name="'.$requestData['reportType'].'" AND mb.bet_type LIKE "%SESSION"';
      $sql .= ' AND u.id="'.Auth::user()->id.'"';
      if(isset($requestData['sDate']) && !empty($requestData['sDate'])){
        $sql .= ' AND mb.`created_at` >="'.date('Y-m-d',strtotime($requestData['sDate'])).'"';
      }
      
      if(isset($requestData['eDate']) && !empty($requestData['eDate'])){
        $sql .= ' AND mb.`created_at` <= "'.date('Y-m-d 23:59:59',strtotime($requestData['eDate'])).'"';
      }
//      $sql .= "  ORDER BY mb.created_at DESC";
      
      $sql = 'SELECT mb.*,u.first_name as userName,s.match_name as matchName,mf.result as winner,g.name as gameName
                      FROM `my_bets` mb 
                      JOIN sports s ON(s.id = mb.sportID)
                      LEFT JOIN match_fancies mf ON(mf.fancyName = SUBSTRING_INDEX(mb.bet_type,"-",-1)  AND mf.match_id = mb.match_id)
                      JOIN users u ON(u.id = mb.user_id)
                      JOIN games g ON(g.id = s.game_id)
                      WHERE mb.active=0 AND mb.isDeleted=0 AND g.name="'.$requestData['reportType'].'" ';
      $sql .= ' AND u.id="'.Auth::user()->id.'"';
      if(isset($requestData['sDate']) && !empty($requestData['sDate'])){
        $sql .= ' AND mb.`created_at` >="'.date('Y-m-d',strtotime($requestData['sDate'])).'"';
      }
      
      if(isset($requestData['eDate']) && !empty($requestData['eDate'])){
        $sql .= ' AND mb.`created_at` <= "'.date('Y-m-d',strtotime($requestData['eDate'])).' 23:59:59"';
      }
      $sql .= "  ORDER BY mb.created_at DESC";
      $betModel = DB::select($sql);
//      die($sql);
//      dd($betModel);
      $options = view("frontend.button-value.bethistory-row",compact('betModel'))->render();
      return $options;
    }
    
    public function unsetteledbet(){
//      $sql = 'SELECT mb.*,u.first_name as userName,g.name as eventType,s.match_name as matchName
//                      FROM `my_bets` mb 
//                      JOIN sports s ON(s.id = mb.sportID)
//                      JOIN users u ON(u.id = mb.user_id)
//                      JOIN games g ON(g.id = s.game_id)
//                      WHERE mb.active=1 AND ( mb.bet_type="ODDS" OR mb.bet_type = "BOOKMAKER")';
//      $sql .= ' AND u.id="'.Auth::user()->id.'"';
//      $sql .= ' UNION ';
//        
//      $sql .= 'SELECT mb.*,u.first_name as userName,g.name as eventType,s.match_name as matchName
//                      FROM `my_bets` mb 
//                      JOIN sports s ON(s.id = mb.sportID)
//                      JOIN match_fancies mf ON(mf.fancyName = mb.team_name)
//                      JOIN users u ON(u.id = mb.user_id)
//                      JOIN games g ON(g.id = s.game_id)
//                      WHERE mb.active=1 AND mb.bet_type LIKE "%SESSION"';
//      $sql .= ' AND u.id="'.Auth::user()->id.'"';
      $sql = 'SELECT mb.*,u.first_name as userName,g.name as eventType,s.match_name as matchName
                      FROM `my_bets` mb 
                      JOIN sports s ON(s.id = mb.sportID)
                      JOIN users u ON(u.id = mb.user_id)
                      JOIN games g ON(g.id = s.game_id)
                      WHERE mb.active=1 AND mb.isDeleted = 0 AND s.match_id = mb.match_id';
      $sql .= ' AND u.id="'.Auth::user()->id.'"';
      $betModel = DB::select($sql);
      
      return view('frontend.button-value.unsetteledbet', compact('betModel'));
    }
    
    public function unsetteledbetList(Request $request){
      $requestData = $request->all();
      if($requestData['reportType'] !=1){
        $html = "<tr><td colspan='9'>Record Not Available</td></tr>";
        return $html;
      }else{
//      $sql = 'SELECT mb.*,u.first_name as userName,g.name as eventType,s.match_name as matchName
//                      FROM `my_bets` mb 
//                      JOIN sports s ON(s.id = mb.sportID)
//                      JOIN users u ON(u.id = mb.user_id)
//                      JOIN games g ON(g.id = s.game_id)
//                      WHERE mb.active=1 AND ( mb.bet_type="ODDS" OR mb.bet_type = "BOOKMAKER")';
//        $sql .= ' AND u.id="'.Auth::user()->id.'"';
//        $sql .= ' UNION ';
//        
//        $sql .= 'SELECT mb.*,u.first_name as userName,g.name as eventType,s.match_name as matchName
//                      FROM `my_bets` mb 
//                      JOIN sports s ON(s.id = mb.sportID)
//                      JOIN users u ON(u.id = mb.user_id)
//                      JOIN games g ON(g.id = s.game_id)
//                      WHERE mb.active=1 AND mb.bet_type LIKE "%SESSION"';
//      $sql .= ' AND u.id="'.Auth::user()->id.'"';
      
      $sql = 'SELECT mb.*,u.first_name as userName,g.name as eventType,s.match_name as matchName
                      FROM `my_bets` mb 
                      JOIN sports s ON(s.id = mb.sportID)
                      JOIN users u ON(u.id = mb.user_id)
                      JOIN games g ON(g.id = s.game_id)
                      WHERE mb.active=1 AND mb.isDeleted = 0 AND s.match_id = mb.match_id';
      $sql .= ' AND u.id="'.Auth::user()->id.'"';
      $betModel = DB::select($sql);
      $options = view("frontend.button-value.unserreldbet-row",compact('betModel'))->render();
      return $options;
      }
    }
    
    public function casinoresultreport(){
    $gameModel = Games::where(['name'=>'CASINO'])->first();
    $sportModel = Sports::where(['active'=>1,'game_id'=>$gameModel->id])->get();
    return view('frontend.button-value.casinoresultreport', compact('sportModel'));
  }
  
  public function casinoresultreportList(Request $request){
    $requestData = $request->all();
    $sql = "SELECT * 
        FROM `casinos` 
        WHERE `sportID`='".$request['sportID']."' 
        AND `result`!='' ";
    if(isset($requestData['sDate']) && !empty($requestData['sDate'])){
        $sql .= ' AND DATE_FORMAT(created_at, "%Y-%m-%d")="'.date('Y-m-d',strtotime($requestData['sDate'])).'"';
    }
    $sql .= " ORDER BY `id` DESC";
//    die($sql);
    $casinoModel = DB::select($sql);
    return view('frontend.button-value.casinoresultreport-row', compact('casinoModel'));
  }

    
}
