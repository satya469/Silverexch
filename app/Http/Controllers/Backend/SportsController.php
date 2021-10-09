<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\MyBetsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Sports;
use App\Games;
use App\MyBets;
use App\UserDeposite;
use App\MatchFancy;
use App\UpperLevelDownLevel;
use App\Models\Auth\User;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\AdminSetting;
use App\ButtonValue;
use App\Privilege;
use App\LockUnlockBet;
use Auth;
class SportsController extends Controller
{
    public function create($id){
      $gameModel = Games::where(["id" => $id])->first();
      return view('backend.sports.addSport', compact('id','gameModel'));
    }

    public function index($id)
    {
      $gameModel = Games::where(["id" => $id])->first();
      if(!empty($id)){
        $sports = DB::select( "SELECT * FROM `sports` WHERE game_id = '".$id."' AND (winner='' OR winner IS NULL)");
     }else{
        $sports = DB::select( "SELECT * FROM `sports` WHERE (winner='' OR winner IS NULL)");
      }
      return view('backend.sports.index', compact('sports','id','gameModel'));
    }



    public static function getAjaxLoad($sportID){
      $sportsOne = Sports::where(['id'=>$sportID])->first();
      $gameModel = Games::where(["id" => $sportsOne->game_id])->first();
      $sports = DB::select( "SELECT * FROM `sports` WHERE game_id = '".$gameModel->id."' AND (winner='' OR winner IS NULL)");
      $id = $sportsOne->gane_id;
      $options = view('backend.sports.matchListBody', compact('sports','id','gameModel'))->render();
      return $options;
    }

    public function matchhistory(){
      $sports = DB::select( "SELECT s.*,g.name as game_name FROM `sports` s
                             LEFT JOIN games g ON s.game_id = g.id
                             WHERE s.winner !='' ORDER BY s.created_at DESC");
      return view('backend.sports.matchhistory', compact('sports'));
    }

    public function managefancycricket(){
      $gameModel = Games::where(['name'=>'cricket'])->first();
//      $sports = Sports::where(['game_id'=>$gameModel->id,'winner'=>''])->get();
      $sports = DB::select( "SELECT  * FROM `sports` WHERE game_id='".$gameModel->id."' AND active='1' AND (winner ='' OR winner IS NULL)");
      return view('backend.sports.managefancycricket', compact('sports'));
    }

    public function managefancysoccer(){
      $gameModel = Games::where(['name'=>'SOCCER'])->first();
//      $sports = Sports::where(['game_id'=>$gameModel->id,'winner'=>''])->get();
      $sports = DB::select( "SELECT  * FROM `sports` WHERE game_id='".$gameModel->id."' AND active='1' AND (winner ='' OR winner IS NULL)");
      return view('backend.sports.managefancysoccer', compact('sports'));
    }

    public function managefancycricketsingle($matchID){

      $sports = DB::table('my_bets')
                 ->select('team_name', DB::raw('count(*) as total'))
                 ->where(['match_id'=>$matchID,'bet_type'=>'SESSION','active'=>1,'isDeleted'=>0])
                 ->groupBy('team_name')
                 ->get();
      return view('backend.sports.managefancycricketsingle', compact('sports','matchID'));
    }

    public function managefancysoccersingle($matchID){

      $sports = DB::table('my_bets')
                 ->where(['match_id'=>$matchID,'active'=>1,'isDeleted'=>0])
                 ->groupBy('bet_type')
                 ->get();

      $dataArr = array();
      foreach($sports as $key=>$fancy){

        if(isset($fancy->team_name) && !empty($fancy->team_name)){
          $arr = explode('-', $fancy->bet_type);
          if(isset($arr[1])){
            $dataArr['session'][$key]['TITLE'] = $arr[1];
          }else{
            continue;
          }
          $extra = json_decode($fancy->extra,true);
          if(isset($extra['teamname2'])){
            $dataArr['session'][$key]['TEAMNAME'][] = $fancy->team_name;
            $dataArr['session'][$key]['TEAMNAME'][] = $extra['teamname2'];
          }else{

            $dataArr['session'][$key]['TEAMNAME'][] = $extra['teamname1'];
            $dataArr['session'][$key]['TEAMNAME'][] =  $fancy->team_name;
          }
        }
      }
      $sql = "";
      $sports = DB::select( "SELECT * FROM `sports` WHERE match_id='".$matchID."' AND active='1' AND (winner ='' OR winner IS NULL) LIMIT 1");
      return view('backend.sports.managefancysoccersingle', compact('dataArr','sports'));
    }

    public function fancyhistorycricket(){
      $gameModel = Games::where(['name'=>'cricket'])->first();
      $sports = DB::select( "SELECT s.*,g.name as game_name FROM `sports` s
                             LEFT JOIN games g ON s.game_id = g.id
                             WHERE g.name='Cricket'");

      return view('backend.sports.fancyhistorycricket', compact('sports'));
    }
    public function managefancyhistorycricketsingle($matchID){
      $fancyHistory = MatchFancy::where(['match_id'=>$matchID,'fancyType'=>'CRICKET','status'=>'FINISH'])->get();
      return view('backend.sports.fancyHistoryCricketSingle', compact('fancyHistory','matchID'));
    }
    public function fancyhistorysoccer(){
      $gameModel = Games::where(['name'=>'SOCCER'])->first();
      $sports = DB::select( "SELECT s.*,g.name as game_name FROM `sports` s
                             LEFT JOIN games g ON s.game_id = g.id
                             WHERE g.name='SOCCER'");

      return view('backend.sports.fancyhistorysoccer', compact('sports'));
    }

    public function managefancyhistorysoccersingle($matchID){
      $fancyHistory = MatchFancy::where(['match_id'=>$matchID,'fancyType'=>'SOCCER'])->get();
      return view('backend.sports.fancyHistorySoccerSingle', compact('fancyHistory','matchID'));
    }

    public function resultrollbackcricketsession(Request $request){
      $requestData = $request->all();
      $modelFancy = MatchFancy::find($requestData['fancyID']);
      $matchID = $modelFancy->match_id;
      $teamName = $modelFancy->fancyName;

      $userDepModel = UserDeposite::where(['fancy_id'=>$requestData['fancyID']])->get();

      if(is_object($userDepModel) && count($userDepModel) > 0){
        $betIDs = $userDepModel[0]->extra;
        foreach($userDepModel as $key=>$dep){
          $betIDs = explode(',',$dep->extra);
          $model = UserDeposite::find($dep->id);
          $model->delete();
          UpperLevelDownLevel::where(['deposit_id'=>$dep->id])->delete();
          foreach($betIDs as $key=>$betid){
              $mb = MyBets::find($betid);
              $mb->active = 1;
              $mb->save();
          }
//          $myBetModel = DB::select("UPDATE `my_bets` SET `active` = '1' WHERE `id` IN(".$betIDs.")");
        }

      }else{
          DB::table('my_bets')
                ->where(['match_id'=>$matchID,'team_name'=>$teamName,'bet_type'=>'SESSION'])
                ->update(['active' => 1]);
        //$myBetModel = DB::select("UPDATE `my_bets` SET `active` = '1' WHERE match_id='".$matchID."' AND team_name='".$teamName."' AND bet_type='SESSION'");
      }
      $modelFancy->delete();
      return json_encode(array('status'=>true,'message'=>'RollBack Successfully'));
    }

    public function resultrollbackSoccersession(Request $request){
      $requestData = $request->all();
      $modelFancy = MatchFancy::find($requestData['fancyID']);
      $matchID = $modelFancy->match_id;
      $teamName = $modelFancy->fancyName;

      $userDepModel = UserDeposite::where(['fancy_id'=>$requestData['fancyID']])->get();

//      dd($userDepModel);
      if(is_object($userDepModel) && count($userDepModel) > 0){

        foreach($userDepModel as $key=>$dep){
          $betIDs = explode(',',$dep->extra);
          $model = UserDeposite::find($dep->id);
          $model->delete();
          UpperLevelDownLevel::where(['deposit_id'=>$dep->id])->delete();
          foreach($betIDs as $key=>$betid){
              $mb = MyBets::find($betid);
              $mb->active = 1;
              $mb->save();
          }
//          $myBetModel = DB::select("UPDATE `my_bets` SET `active` = '1' WHERE `id` IN(".$betIDs.")");
        }
      }else{
          DB::table('my_bets')
                ->where(['match_id'=>$matchID,'team_name'=>$teamName])
                ->update(['active' => 1]);
        //$myBetModel = DB::select("UPDATE `my_bets` SET `active` = '1' WHERE match_id='".$matchID."' AND team_name='".$teamName."'");
      }
      $modelFancy->delete();
      return json_encode(array('status'=>true,'message'=>'<div class="alert alert-success"> RollBack Successfully</div>'));
    }

    public function resultcancelcricketsession(Request $request){
      $requestData = $request->all();
      $matchID = $requestData['matchID'];
      $teamname = $requestData['teamsname'];

      /** FANCY ADDED IN DATABASE WITH RESULT STATUS PROCESSING **/
      $matchFancyModel = new MatchFancy();
      $matchFancyModel->result = 'Canceled';
      $matchFancyModel->match_id = $matchID;
      $matchFancyModel->fancyType = 'CRICKET';
      $matchFancyModel->fancyName = $teamname;
      $matchFancyModel->status = 'PROCESSING';
      $matchFancyModel->save();
      $fancyID = $matchFancyModel->id;

      $betModel = MyBets::where(['match_id'=>$matchID,'bet_type'=>'SESSION','team_name'=>$teamname,'isDeleted'=>0])->get();
      $dataArr = array();
      foreach($betModel as $key=>$data){
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

      return json_encode(array('status'=>true,'message'=>"<div class='alert alert-success'>Result Canceled Successfully</div>"));
    }

    public function store(Request $request){
      $requestData = $request->all();
      $userId = Auth::user()->id;
      $m_pwd =  $requestData['m_pwd'];
      $user = User::find($userId);
      if (!Hash::check($m_pwd, $user->password)) {
        return redirect()->route('admin.addSports',$request->input('gameID'))->withFlashSuccess('Master Password Wrong');
      }
      $model = Sports::where(['match_id'=>$request->input('match_id')])->first();
      if(isset($model->id)){
        return redirect()->route('admin.addSports',$request->input('gameID'))->withFlashSuccess('Match ID Already Exist');
      }
      $gameModel = Games::find($request->input('gameID'));
      $extra = '';
      if(isset($gameModel) && is_object($gameModel)){
        $arr = self::getTeamName(strtoupper($gameModel->name), $request->input('match_id'));
        if((isset($arr['teamname'][1]) && empty($arr['teamname'][1])) || !isset($arr['teamname'][1])){
            return Redirect::back()->withErrors(['Api Data Not Found']);
            return redirect()->route('admin.addSports',$request->input('gameID'))->withFlashErrors('Api Data Not Found');
        }
        $extra = json_encode($arr['teamname']);
      }
      $model = new Sports();
      $model->game_id = $request->input('gameID');
      $model->match_name = $request->input('match_name');
      $model->match_date_time = $request->input('match_date_time');
      $model->match_id = $request->input('match_id');
//      $model->tv_url = $request->input('tv_url');
      $model->sb_url = $request->input('sb_url');

      if(!empty($request->input('tv_status'))){
        $model->tv_status = $request->input('tv_status');
      }
      if(!empty($request->input('bookmaker_status'))){
        $model->bookmaker_status = $request->input('bookmaker_status');
      }
      if(!empty($request->input('fancy_status'))){
        $model->fancy_status = $request->input('fancy_status');
      }
      if(!empty($request->input('inplay_status'))){
        $model->inplay_status = $request->input('inplay_status');
      }
      $model->extra = $extra;
      $model->save();

      return redirect()->route('admin.listSports',$model->game_id)->withFlashSuccess('Sport added successfully');
    }

    public function resultrollback(Request $request){
      $requestData = $request->all();
      $sports = Sports::find($requestData['id']);
      $matchID = $sports->match_id;
      $type = "ODDS_BOOKMEKER";

      $userDepModel = UserDeposite::where(['match_id'=>$matchID,'type'=>$type])->get();
      foreach($userDepModel as $key=>$dep){
        $model = UserDeposite::find($dep->id);
        $model->delete();

        UpperLevelDownLevel::where(['deposit_id'=>$dep->id])->delete();
      }

      $myBetModel = DB::select( "SELECT * FROM `my_bets` WHERE (bet_type='ODDS' OR bet_type='BOOKMAKER') AND match_id = '".$matchID."'");
      foreach($myBetModel as $key=>$bets){
        $model = MyBets::find($bets->id);
        $model->active = 1;
        $model->save();
      }
      $sports->winner = '';
      $sports->save();

      return json_encode(array('status'=>true,'message'=>'<div class="alert alert-success"> RollBack Successfully</div>'));

    }

    public function winnerselect(Request $request){
      $requestData = $request->all();

      $sports = Sports::find($requestData['id']);
      $gameModel = Games::where(['id'=>$sports->game_id])->first();
      $gameName = strtoupper($gameModel->name);
      $arrTeam = array();
      $selectOptin = '';
      switch ($gameName){
        case 'CRICKET':{
//          $url = 'http://172.105.60.132/json/1.'.$sports->match_id.'.json';
//          $ch = curl_init( $url );
//          curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
//          curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
//          $result = curl_exec($ch);
//          curl_close($ch);
//          $sql = "SELECT * FROM `my_bets` WHERE match_id = '".$sports->match_id."' AND bet_type IN('ODDS','BOOKMAKER') LIMIT 1";
//          $model = DB::select($sql);
////           dd($model);

          $teams = json_decode($sports->extra,true);
          foreach($teams as $key=>$name){
            $selectOptin .= '<option value="'.$name.'">'.$name.'</option>';
          }
//          $selectOptin .= '<option value="Draw">Draw</option>';

//          $result = '{"market": [{"marketId": "1.30042557", "inplay": false, "totalMatched": null, "totalAvailable": null, "priceStatus": null, "events": [{"SelectionId": "", "RunnerName": "Kolkata Knight Riders", "LayPrice1": "2.08", "LaySize1": "215.83", "LayPrice2": "2.1", "LaySize2": "219.43", "LayPrice3": "2.12", "LaySize3": "3.2", "BackPrice1": "2.04", "BackSize1": "210.07", "BackPrice2": "2.02", "BackSize2": "550", "BackPrice3": "1.96", "BackSize3": "83.2"}, {"SelectionId": "", "RunnerName": "Chennai Super Kings", "LayPrice1": "1.95", "LaySize1": "8.99", "LayPrice2": "1.96", "LaySize2": "195.13", "LayPrice3": "1.97", "LaySize3": "14.5", "BackPrice1": "1.94", "BackSize1": "9.78", "BackPrice2": "1.93", "BackSize2": "213.31", "BackPrice3": "1.92", "BackSize3": "249.51"}]}], "bookmake": [{"runners": [{"SelectionId": "", "RunnerName": "Kolkata Knight Riders", "LayPrice1": "0", "LaySize1": "0", "LayPrice2": "0", "LaySize2": "0", "LayPrice3": "0", "LaySize3": "0", "BackPrice1": "0", "BackSize1": "0", "BackPrice2": "0", "BackSize2": "0", "BackPrice3": "0", "BackSize3": "0"}, {"SelectionId": "", "RunnerName": "Chennai Super Kings", "LayPrice1": "96", "LaySize1": "100", "LayPrice2": "0", "LaySize2": "0", "LayPrice3": "0", "LaySize3": "0", "BackPrice1": "92", "BackSize1": "100", "BackPrice2": "0", "BackSize2": "0", "BackPrice3": "0", "BackSize3": "0"}]}], "session": [{"SelectionId": "", "RunnerName": "Match 1st over run(KKR vs CSK)adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "6 over runs KKR(KKR vs CSK)adv", "LayPrice1": "46", "LaySize1": "100", "BackPrice1": "48", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "6 over runs CSK(KKR vs CSK)adv", "LayPrice1": "46", "LaySize1": "100", "BackPrice1": "48", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "20 over runs KKR(KKR vs CSK)adv", "LayPrice1": "165", "LaySize1": "100", "BackPrice1": "167", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "20 over runs CSK(KKR vs CSK)adv", "LayPrice1": "167", "LaySize1": "100", "BackPrice1": "169", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Fall of 1st wkt KKR(KKR vs CSK)adv", "LayPrice1": "23", "LaySize1": "110", "BackPrice1": "23", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Fall of 1st wkt CSK(KKR vs CSK)adv", "LayPrice1": "23", "LaySize1": "110", "BackPrice1": "23", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Gill run(KKR vs CSK)adv", "LayPrice1": "26", "LaySize1": "110", "BackPrice1": "26", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine run(KKR vs CSK)adv", "LayPrice1": "16", "LaySize1": "110", "BackPrice1": "16", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "F du Plessis run(KKR vs CSK)adv", "LayPrice1": "25", "LaySize1": "110", "BackPrice1": "25", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Watson run(KKR vs CSK)adv", "LayPrice1": "20", "LaySize1": "110", "BackPrice1": "20", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Gill Boundaries(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine Boundaries(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "115", "BackPrice1": "3", "BackSize1": "85", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "F du Plessis Boundaries(KKR vs CSK)adv", "LayPrice1": "4", "LaySize1": "115", "BackPrice1": "4", "BackSize1": "85", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Watson Boundaries(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "How many balls for 50 runs KKR(KKR vs CSK)adv", "LayPrice1": "38", "LaySize1": "100", "BackPrice1": "40", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "How many balls for 50 runs CSK(KKR vs CSK)adv", "LayPrice1": "38", "LaySize1": "100", "BackPrice1": "40", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Fours(KKR vs CSK)adv", "LayPrice1": "25", "LaySize1": "100", "BackPrice1": "27", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Sixes(KKR vs CSK)adv", "LayPrice1": "11", "LaySize1": "100", "BackPrice1": "12", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Boundaries(KKR vs CSK)adv", "LayPrice1": "36", "LaySize1": "100", "BackPrice1": "38", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Wkts(KKR vs CSK)adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "13", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Wides(KKR vs CSK)adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Extras(KKR vs CSK)adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Caught Outs(KKR vs CSK)adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Bowled(KKR vs CSK)adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match LBW(KKR vs CSK)adv", "LayPrice1": "1", "LaySize1": "100", "BackPrice1": "2", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Fifties(KKR vs CSK)adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Highest Scoring over in match(KKR vs CSK)adv", "LayPrice1": "20", "LaySize1": "100", "BackPrice1": "21", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Top batsman runs in match(KKR vs CSK)adv", "LayPrice1": "66", "LaySize1": "100", "BackPrice1": "68", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "3 wkt or more by bowler in match(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Fours KKR and CSK adv", "LayPrice1": "150", "LaySize1": "100", "BackPrice1": "157", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Sixes KKR and CSK adv", "LayPrice1": "28", "LaySize1": "100", "BackPrice1": "31", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Wkts KKR and CSK adv", "LayPrice1": "32", "LaySize1": "100", "BackPrice1": "37", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Wides KKR and CSK adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Extras KKR and CSK adv", "LayPrice1": "50", "LaySize1": "100", "BackPrice1": "57", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "P Cummins 2 over Runs Session adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "15", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "P Cummins 4 over Runs Session adv", "LayPrice1": "30", "LaySize1": "100", "BackPrice1": "32", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Mavi 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Mavi 4 over Runs Session adv", "LayPrice1": "33", "LaySize1": "100", "BackPrice1": "35", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "V Chakravarthy 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "V Chakravarthy 4 over Runs Session adv", "LayPrice1": "33", "LaySize1": "100", "BackPrice1": "35", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine 2 over Runs Session adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine 4 over Runs Session adv", "LayPrice1": "28", "LaySize1": "100", "BackPrice1": "30", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "A Russell 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "A Russell 4 over Runs Session adv", "LayPrice1": "32", "LaySize1": "100", "BackPrice1": "34", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "D Chahar 2 over Runs Session adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "15", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "D Chahar 4 over Runs Session adv", "LayPrice1": "30", "LaySize1": "100", "BackPrice1": "32", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Curran 2 over Runs Session adv", "LayPrice1": "14", "LaySize1": "100", "BackPrice1": "16", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Curran 4 over Runs Session adv", "LayPrice1": "32", "LaySize1": "100", "BackPrice1": "34", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Thakur 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Thakur 4 over Runs Session adv", "LayPrice1": "33", "LaySize1": "100", "BackPrice1": "35", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Dwayne Bravo 2 over Runs Session adv", "LayPrice1": "14", "LaySize1": "100", "BackPrice1": "16", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Dwayne Bravo 4 over Runs Session adv", "LayPrice1": "31", "LaySize1": "100", "BackPrice1": "33", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "R Jadeja 2 over Runs Session adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "15", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "R Jadeja 4 over Runs Session adv", "LayPrice1": "30", "LaySize1": "100", "BackPrice1": "32", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Wkts KKR adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Extras KKR adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Dot balls KKR adv", "LayPrice1": "22", "LaySize1": "100", "BackPrice1": "24", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 1 runs KKR adv", "LayPrice1": "22", "LaySize1": "100", "BackPrice1": "24", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 2 runs KKR adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Fours KKR adv", "LayPrice1": "7", "LaySize1": "100", "BackPrice1": "8", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Sixes KKR adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Wkts KKR adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Extras KKR adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Dot balls KKR adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 1 runs KKR adv", "LayPrice1": "26", "LaySize1": "100", "BackPrice1": "28", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 2 runs KKR adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Fours KKR adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Sixes KKR adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Wkts KKR adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Extras KKR adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Dot balls KKR adv", "LayPrice1": "34", "LaySize1": "100", "BackPrice1": "36", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 1 runs KKR adv", "LayPrice1": "48", "LaySize1": "100", "BackPrice1": "50", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 2 runs KKR adv", "LayPrice1": "9", "LaySize1": "100", "BackPrice1": "10", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Fours KKR adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Sixes KKR adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Wkts CSK adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Extras CSK adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Dot balls CSK adv", "LayPrice1": "21", "LaySize1": "100", "BackPrice1": "23", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 1 runs CSK adv", "LayPrice1": "23", "LaySize1": "100", "BackPrice1": "25", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 2 runs CSK adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Fours CSK adv", "LayPrice1": "7", "LaySize1": "100", "BackPrice1": "8", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Sixes CSK adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Wkts CSK adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Extras CSK adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Dot balls CSK adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 1 runs CSK adv", "LayPrice1": "27", "LaySize1": "100", "BackPrice1": "29", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 2 runs CSK adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Fours CSK adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Sixes CSK adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Wkts CSK adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Extras CSK adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Dot balls CSK adv", "LayPrice1": "34", "LaySize1": "100", "BackPrice1": "36", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 1 runs CSK adv", "LayPrice1": "50", "LaySize1": "100", "BackPrice1": "52", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 2 runs CSK adv", "LayPrice1": "9", "LaySize1": "100", "BackPrice1": "10", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Fours CSK adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Sixes CSK adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}]}';
//          $arr = json_decode($result,true);
//          foreach($arr['market'][0]['events'] as $key=>$name){
//            $selectOptin .= '<option value="'.$name['RunnerName'].'">'.$name['RunnerName'].'</option>';
//
//          }
//          $selectOptin .= '<option value="Draw">Draw</option>';
          break;
        }
        case 'TENNIS':{
//          $url = 'http://194.195.113.212/json/1.'.$sports->match_id.'.json';
//          $ch = curl_init( $url );
//          curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
//          curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
//          $result = curl_exec($ch);
//          curl_close($ch);
//          $selectOptin = '';
//          $arr = json_decode($result,true);
//          $sql = "SELECT * FROM `my_bets` WHERE match_id = '".$sports->match_id."' AND bet_type IN('ODDS','BOOKMAKER') LIMIT 1";
//           $model = DB::select($sql);
//           dd($model);
          $teams = json_decode($sports->extra,true);
          foreach($teams as $key=>$name){
            $selectOptin .= '<option value="'.$name.'">'.$name.'</option>';
          }
//          $selectOptin .= '<option value="Draw">Draw</option>';
          break;
        }
        case 'SOCCER':{
//          $url = 'http://194.195.114.164/json/1.'.$sports->match_id.'.json';
//          $ch = curl_init( $url );
//          curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
//          curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
//          $result = curl_exec($ch);
//          curl_close($ch);
//          $selectOptin = '';
//          $arr = json_decode($result,true);
//           $sql = "SELECT * FROM `my_bets` WHERE match_id = '".$sports->match_id."' AND bet_type IN('ODDS','BOOKMAKER') LIMIT 1";
//           $model = DB::select($sql);
//           dd($model);
          $teams = json_decode($sports->extra,true);
          foreach($teams as $key=>$name){
            $selectOptin .= '<option value="'.$name.'">'.$name.'</option>';
          }

          break;
        }
      }

      $html = '<div class="row">';

        $html .= '<div class="col-sm-12">';
          $html .= '<div class="from-group">';
            $html .= '<select id="winnerTeam" class="form-control">';
              $html .= '<option value="">Select Winner</option>';
              $html .= $selectOptin;
              $html .= '<option value="Tie">Tie</option>';

            $html .= '</select>';
          $html .= '</div>';
        $html .= '</div>';
      $html .= '</div>';

      return $html;
    }

    /*** CRICKET WINNER DECLEARS ***/

    public function winnerselectstore(Request $request){
      $requestData = $request->all();
      $sports = Sports::where(['id'=>$requestData['id']])->first();
      $gameModel = Games::find($sports->game_id);
      $sports->winner = $requestData['winnerTeam'];
//      $sports->winner = '';
      if($sports->save()){
        $myBetModel = DB::select( "SELECT  DISTINCT(user_id) as user_id,sportID,match_id FROM `my_bets` WHERE bet_type !='SESSION' AND isDeleted=0 AND match_id = '".$sports->match_id."'");
        if(strtoupper($requestData['winnerTeam']) != 'TIE'){
          foreach($myBetModel as $key=> $client){
            $exTot = MyBetsController::getExAmountByMatchWithDetail($sports->id,$client->user_id,$sports->match_id,$requestData['winnerTeam']);
            $userModel = User::find($client->user_id);
            $amount = $exTot;
            if($exTot == 0){
              $model = new UserDeposite();
              $model->balanceType = 'MATCH-P-L';
              $model->deposite_user_id = $userModel->id;
              $model->withdrawal_user_id = $userModel->parent_id;
              $model->amount = '0';
              $model->match_id = $sports->match_id;
              $model->type = "ODDS_BOOKMEKER";
              $model->note = $requestData['winnerTeam']." is Winner to get P/L";
              $model->callType = $gameModel->name;
              $model->save();
            }else if($exTot > 0){
              $model = new UserDeposite();
              $model->balanceType = 'MATCH-P-L';
              $model->deposite_user_id = $userModel->id;
              $model->withdrawal_user_id = $userModel->parent_id;
              $model->amount = abs($exTot);
              $model->match_id = $sports->match_id;
              $model->type = "ODDS_BOOKMEKER";
              $model->note = $requestData['winnerTeam']." is Winner to get P/L";
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
//                  $upperLevel = (($amount*$parentPER)/100);
                }else{
                  $downLevel = (($amount*$per)/100);
                  $perupleval = (100-$userModelPer->partnership);
                  $upperLevel = (($amount*$perupleval)/100);
                }

                $upDownModel = new UpperLevelDownLevel();
                $upDownModel->deposit_id = $model->id;
                $upDownModel->user_id = $userID;
                $upDownModel->sportID = $client->sportID;
                $upDownModel->matchID = $client->match_id;
                $upDownModel->bet_user_id = $client->user_id;
                $upDownModel->per = $per;
                $upDownModel->upperLevel = $upperLevel;
                $upDownModel->downLevel = $downLevel;
                $upDownModel->save();
                unset($upDownModel);
              }
            }else{
              $model = new UserDeposite();
              $model->balanceType = 'MATCH-P-L';
              $model->deposite_user_id = $userModel->parent_id;
              $model->withdrawal_user_id = $userModel->id;
              $model->amount = abs($exTot);
              $model->match_id = $sports->match_id;
              $model->type = "ODDS_BOOKMEKER";
              $model->note = $requestData['winnerTeam']." is Winner to get P/L";
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
                $upDownModel->sportID = $client->sportID;
                $upDownModel->matchID = $client->match_id;
                $upDownModel->bet_user_id = $client->user_id;
                $upDownModel->per = $per;
                $upDownModel->upperLevel = $upperLevel;
                $upDownModel->downLevel = $downLevel;

//                $upDownModel->upperLevel = ($upperLevel*(-1));
//                $upDownModel->downLevel = ($downLevel*(-1));
                $upDownModel->save();
                unset($upDownModel);
              }
            }
          }
        }

        $myBetModel = DB::select( "SELECT * FROM `my_bets` WHERE (bet_type='ODDS' OR bet_type='BOOKMAKER') AND match_id = '".$sports->match_id."'");
        foreach($myBetModel as $key=>$bets){
          $model = MyBets::find($bets->id);
          $model->active = 0;
          $model->save();
        }
        $bodyHtml = self::getAjaxLoad($requestData['id']);
        return json_encode(array('status'=>true,'bodyHtml'=>$bodyHtml,'message'=>$requestData['winnerTeam'].' Team are Winner'));
      }else{
        return json_encode(array('status'=>false,'message'=>'match winner not decleard,try agian!'));
      }
    }

    /** SOCCER WINNER SESSION **/

    public function soccersessionwinner(Request $request){
      $requestData = $request->all();
      $matchid = $requestData['matchID'];

      $sports = Sports::where(['match_id'=>$matchid])->first();
      $gameModel = Games::find($sports->game_id);

      $betSite = 'SESSION-'.$requestData['betSide'];
      /** FANCY ADDED IN DATABASE WITH RESULT STATUS PROCESSING **/
      $matchFancyModel = new MatchFancy();
      $matchFancyModel->result = $requestData['winnerTeam'];
      $matchFancyModel->match_id = $matchid;
      $matchFancyModel->fancyType = 'SOCCER';
      $matchFancyModel->fancyName = $requestData['betSide'];
      $matchFancyModel->status = 'PROCESSING';
      $matchFancyModel->save();
      $fancyID = $matchFancyModel->id;

      $myBetModel = DB::select( "SELECT  DISTINCT(user_id) as user_id,sportID,match_id FROM `my_bets` WHERE bet_type='".$betSite."' AND match_id = '".$matchid."' AND isDeleted=0");
      $sql = "SELECT CONCAT(id) as ids FROM `my_bets` WHERE `match_id`= '".$matchid."' AND isDeleted=0 AND `bet_type` = '".$betSite."'";
      $idsArr = DB::select($sql);
      $ids = $idsArr[0]->ids;


        if(strtoupper($requestData['winnerTeam']) != 'TIE'){
          foreach($myBetModel as $key=> $client){

            $dataArrSession = MyBetsController::getExAmountSoccer($sports->id,$client->user_id);
//            dd($dataArrSession);
            $exTot = $dataArrSession['SESSION'][$requestData['betSide']][$requestData['winnerTeam']]['SESSION_profitLost'];

            $userModel = User::find($client->user_id);
            if($exTot == 0){
                $model = new UserDeposite();
                $model->balanceType = 'MATCH-P-L';
                $model->deposite_user_id = $userModel->id;
                $model->withdrawal_user_id = $userModel->parent_id;
                $model->amount = '0';
                $model->match_id = $matchid;
                $model->type = $betSite;
                $model->fancy_id = $fancyID;
                $model->extra = $ids;
                $model->note = $requestData['winnerTeam']." is Winner to get P/L";
                $model->callType = $gameModel->name;
                $model->save();
            }else if($exTot > 0){
              $model = new UserDeposite();
              $model->balanceType = 'MATCH-P-L';
              $model->deposite_user_id = $userModel->id;
              $model->withdrawal_user_id = $userModel->parent_id;
              $model->amount = abs($exTot);
              $model->match_id = $matchid;
              $model->type = $betSite;
              $model->fancy_id = $fancyID;
              $model->extra = $ids;
              $model->note = $requestData['winnerTeam']." is Winner to get P/L";
              $model->callType = $gameModel->name;
              $model->save();
              $amount = abs($exTot);
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
                $upDownModel->deposit_id = $model->id;
//                $upDownModel->user_id = $userModel->parent_id;
                $upDownModel->user_id = $userID;
                $upDownModel->sportID = $client->sportID;
                $upDownModel->matchID = $client->match_id;
                $upDownModel->bet_user_id = $client->user_id;
                $upDownModel->per = $per;
                $upDownModel->upperLevel = $upperLevel;
                $upDownModel->downLevel = $downLevel;
                $upDownModel->save();
                unset($upDownModel);
              }

            }else{
//                dd($exTot);
              $model = new UserDeposite();
              $model->balanceType = 'MATCH-P-L';
              $model->deposite_user_id = $userModel->parent_id;
              $model->withdrawal_user_id = $userModel->id;
              $model->amount = abs($exTot);
              $model->match_id = $matchid;
              $model->type = $betSite;
              $model->fancy_id = $fancyID;
              $model->extra = $ids;
              $model->note = $requestData['winnerTeam']." is Winner to get P/L";
              $model->callType = $gameModel->name;
              $model->save();

              /** USER PARENT CAL **/
              $amount = $exTot;
              $perentArr = ListClientController::getUserParentPer($userModel->parent_id);
//              dd($perentArr);
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
                $upDownModel->user_id = $userID;
                $upDownModel->sportID = $client->sportID;
                $upDownModel->matchID = $client->match_id;
                $upDownModel->bet_user_id = $client->user_id;
                $upDownModel->per = $per;
//                $upDownModel->upperLevel = ($upperLevel*(-1));
//                $upDownModel->downLevel = ($downLevel*(-1));
                $upDownModel->upperLevel = $upperLevel;
                $upDownModel->downLevel = $downLevel;
                $upDownModel->save();
                unset($upDownModel);
              }
            }
          }
        }

        $myBetModel = DB::select( "SELECT * FROM `my_bets` WHERE bet_type='".$betSite."' AND match_id = '".$matchid."'");
        foreach($myBetModel as $key=>$bets){
          $model = MyBets::find($bets->id);
          $model->active = 0;
          $model->save();
        }

      $matchFancyModelNew = MatchFancy::find($fancyID);
      $matchFancyModelNew->status = "FINISH";
      $matchFancyModelNew->save();

      return json_encode(array('status'=>true,'message'=>$requestData['winnerTeam'].' Team are Winner'));

    }

    public function marketanalysis(){

      $userChildArr = \App\Http\Controllers\Backend\AccountsController::getChildUserListArr(Auth::user()->id);

      $where = '';
      if(is_array($userChildArr) && count($userChildArr) > 0){
        $txt = implode(',', $userChildArr);
        $where = ' AND mb.user_id IN ('.$txt.')';
      }else{
        $where = ' AND mb.user_id = '.Auth::user()->id;
      }
      $sportsCricket = DB::select( "SELECT  s.*,
                                            g.name as game_name
                                            FROM `sports` s
                                            LEFT JOIN games g ON s.game_id = g.id
                                            WHERE UPPER(g.name)='CRICKET' AND (s.winner ='' OR s.winner IS NULL)");

      $sportsSoccer = DB::select( "SELECT s.*,
                                          g.name as game_name
                                          FROM `sports` s
                                          LEFT JOIN games g ON s.game_id = g.id
                                          WHERE UPPER(g.name)='SOCCER'  AND (s.winner ='' OR s.winner IS NULL)");

      $sportsTennis = DB::select( "SELECT
                                          s.*, g.name AS game_name
                                          FROM `sports` s
                                          LEFT JOIN games g ON s.game_id = g.id
                                          WHERE UPPER(g.name) = 'TENNIS'  AND (s.winner ='' OR s.winner IS NULL)");

    //   dd($sportsCricket);

      if(Auth::user()->roles->first()->name == 'administrator'){
        $userPrivilegeCheckModel = Privilege::where(['user_id'=>Auth::user()->id])->first();
      }
      if(Auth::user()->roles->first()->name == 'administrator' && isset($userPrivilegeCheckModel->id)){
        return view('backend.market.marketAnalysisEmpty', compact('sportsCricket','sportsSoccer','sportsTennis'));
      }else{
        return view('backend.market.marketAnalysis', compact('sportsCricket','sportsSoccer','sportsTennis'));
      }
    }

    public static function getBetCount($matchID){
      $userChildArr = \App\Http\Controllers\Backend\AccountsController::getChildUserListArr(Auth::user()->id);
      $txt = implode(',', $userChildArr);
    //  $count = MyBets::where(['match_id'=>$matchID,'active'=>'1','isDeleted'=>0])->count();
      $count = 0;
    //   dd($txt);
      if(!empty($txt)){
      $sportss = DB::select( "SELECT count(id) as tot FROM `my_bets` WHERE match_id='".$matchID."' AND active='1' AND isDeleted='0' AND user_id IN (".$txt.") LIMIT 1");
      $count = $sportss[0]->tot;
      }
      return $count;
    }

    public static function getTeamName($gameName,$MatchID){
      $dataArr = array();
      switch ($gameName){
        case 'CRICKET':{
          $url = 'http://139.177.188.73:3000/getBM?eventId='.$MatchID;
          $ch = curl_init( $url );
          curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
          curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
          $result = curl_exec($ch);
          curl_close($ch);

          $arr = json_decode($result,true);
            // dd($arr);
          $dataArr['ODDS'] = isset($arr['t1'][0]) ? $arr['t1'][0] : '';
          $dataArr['BOOKMEKER'] = isset($arr['t2'][0]['bm1']) ? $arr['t2'][0]['bm1'] : '';
          $dataArr['SESSION'] =   isset($arr['t3']) ?$arr['t3'] : '';
          $dataArr['teamname'][1] = isset($arr['t1'][0][0]['nat']) ? $arr['t1'][0][0]['nat'] : '';
          $dataArr['teamname'][2] = isset($arr['t1'][0][1]['nat']) ? $arr['t1'][0][1]['nat'] : '';
          $team3 = isset($arr['t1'][0][2]['nat']) ? $arr['t1'][0][2]['nat'] : '';
          if(!empty($team3)){
            $dataArr['teamname'][3] = $team3;
          }
          break;
        }
        case 'TENNIS':{
        //    $url = 'http://194.195.113.212/json/1.'.$MatchID.'.json';
        //   $ch = curl_init( $url );
        //   curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        //   curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        //   $result = curl_exec($ch);
        //   curl_close($ch);
        //   $arr = json_decode($result,true);
        //   $dataArr['ODDS'] = isset($arr['market'][0]['events']) ? $arr['market'][0]['events'] : '';
        //   $dataArr['teamname'][1] = isset($arr['market'][0]['events'][0]['RunnerName']) ? $arr['market'][0]['events'][0]['RunnerName'] : '';
        //   $dataArr['teamname'][2] = isset($arr['market'][0]['events'][1]['RunnerName']) ? $arr['market'][0]['events'][1]['RunnerName'] : '';

        //   break;
        }
        case 'SOCCER':{
    //       $url = 'http://194.195.114.164/json/1.'.$MatchID.'.json';
    //       $ch = curl_init( $url );
    //       curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    //       curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    //       $result = curl_exec($ch);
    //       curl_close($ch);
    //       $arr = json_decode($result,true);
    //       $dataArr['odd'] = isset($arr['market'][0]['events']) ? $arr['market'][0]['events'] : '';
    //       $dataArr['session'] =  isset( $arr['session']) ?  $arr['session'] : '';
    //       $dataArr['teamname'][] = isset($arr['market'][0]['events'][0]['RunnerName']) ? $arr['market'][0]['events'][0]['RunnerName'] : '';
    //       $dataArr['teamname'][] = isset($arr['market'][0]['events'][1]['RunnerName']) ? $arr['market'][0]['events'][1]['RunnerName'] : '';
    //       $dataArr['teamname'][] = isset($arr['market'][0]['events'][2]['RunnerName']) ? $arr['market'][0]['events'][2]['RunnerName'] : '';
    //       if(isset($arr['odd'])){
    //         foreach ($arr['odd'] as $bkey=>$bval){
    //           $dataArr['odd'][] = (!empty($bval['RunnerName']) ? $bval['RunnerName'] : '') ;
    //         }
    //       }
    //       if(isset($arr['session'])){
    //         foreach ($arr['session'] as $key=>$val){
    //           if(isset($val['RunnerName']) && !empty($val['RunnerName'])){
    //             $arr = explode(' ', $val['RunnerName']);
    //             $session = str_replace('.','', $arr[1]);
    //             $dataArr['sessionType'][$session]['TITLE'] = 'OVER_UNDER_'.$session;
    //             $dataArr['sessionType'][$session]['TEAMNAME'][] = $val['RunnerName'];
    //           }
    //         }
    //       }
    //       if(!isset($dataArr['soccer']['session'])){
    //          $dataArr['session'] = array();
    //       }
    //       if(!isset($dataArr['soccer']['odd'])){
    //          $dataArr['odd'] = array();
    //       }
          break;
        }
      }
      return $dataArr;
    }

    public function MADCricket($token){
//      $sportss = DB::select( "SELECT * FROM `sports` WHERE match_id='".$token."' AND active='1' AND (winner ='' OR winner IS NULL) LIMIT 1");
      $sportss = DB::select( "SELECT s.*,g.name as gameName
                                    FROM `sports` s
                                    LEFT JOIN games g ON s.game_id = g.id
                                    WHERE s.match_id='".$token."' AND s.active='1' AND (s.winner ='' OR s.winner IS NULL) LIMIT 1");
      if(!isset($sportss[0])){
          return Redirect::back();
        }
      $sports = $sportss[0];
      if(!isset($sports->id)){
          return Redirect::back();
      }
      $adminSetting = AdminSetting::first();
      $url = 'http://172.105.60.132/json/1.'.$token.'.json';
          $ch = curl_init( $url );
          curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
          curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
          $result = curl_exec($ch);
          curl_close($ch);

          $arr = json_decode($result,true);
          if(!isset($arr['market'][0]['events'])){
              return Redirect::back();
          }
          $dataArr = array();
          $data['odd'] = $arr['market'][0]['events'];
          $data['bookmaker'] = $arr['bookmake'][0]['runners'];
          $data['session'] = $arr['session'];
          if(isset($data['session'])){
            foreach ($data['session'] as $key=>$val){
              if(isset($val['RunnerName']) && !empty($val['RunnerName'])){
                $dataArr['session'][] = array(
                                              'RunnerName'=>$val['RunnerName'],
                                              'LayPrice1'=>$val['LayPrice1'],
                                              'LaySize1'=>$val['LaySize1'],
                                              'BackPrice1'=>$val['BackPrice1'],
                                              'BackSize1'=>$val['BackSize1'],
                                        );
              }
            }
          }
      return view('backend.market.market-detail-cricket', compact('adminSetting','sports','data'));
    }

    public function MADSoccer($token){
      $sportss = DB::select( "SELECT s.*,g.name as gameName
                                    FROM `sports` s
                                    LEFT JOIN games g ON s.game_id = g.id
                                    WHERE s.match_id='".$token."' AND s.active='1' AND (s.winner ='' OR s.winner IS NULL) LIMIT 1");
     if(!isset($sportss[0])){
          return Redirect::back();
        }
      $sports = $sportss[0];
      if(!isset($sports->id)){
          return Redirect::back();
      }
      $adminSetting = AdminSetting::first();
      return view('backend.market.market-detail-soccer', compact('adminSetting','sports'));
    }

    public function MADTennis($token){
//      $sportss = DB::select( "SELECT *
//          FROM `sports`
//          WHERE match_id='".$token."' AND active='1' AND (winner ='' OR winner IS NULL) LIMIT 1");
      $sportss = DB::select( "SELECT s.*,g.name as gameName
                                    FROM `sports` s
                                    LEFT JOIN games g ON s.game_id = g.id
                                    WHERE s.match_id='".$token."' AND s.active='1' AND (s.winner ='' OR s.winner IS NULL) LIMIT 1");
      if(!isset($sportss[0])){
          return Redirect::back();
        }
      $sports = $sportss[0];
      if(!isset($sports->id)){
          return Redirect::back();
      }
      $adminSetting = AdminSetting::first();
      return view('backend.market.market-detail-tennis', compact('adminSetting','sports'));
    }

    public static function getMyAllBets($matchID = '',$isViewMoreBets = false){
      if(Auth::user()->roles->first()->name == 'administrator'){
        if(empty($matchID)){
          $mybetsModel = MyBets::where(['active'=>'1'])->orderBy('id', 'DESC')->get();
        }else{
          $mybetsModel = MyBets::where(['match_id'=>$matchID,'active'=>'1'])->orderBy('id', 'DESC')->get();
        }
      }else{
        $userChildArr = \App\Http\Controllers\Backend\AccountsController::getChildUserListArr(Auth::user()->id);
        $txt = implode(',', $userChildArr);
        if(empty($txt)){
            $txt = Auth::user()->id;
        }
        $sql = "SELECT * FROM `my_bets` WHERE match_id = '".$matchID."' AND active = '1' AND `isDeleted`='0' AND user_id IN (".$txt.") Order By id DESC";
        $mybetsModel = DB::select($sql);

//        $mybetsModel = MyBets::where(['match_id'=>$matchID,'active'=>'1','isDeleted'=>0])->orderBy('id', 'DESC')->get();
      }
      $sportModel = Sports::where(['match_id'=>$matchID])->first();
      $isDeleteShow = false;
      if(isset($sportModel->id)){
        $isDeleteShow = true;
      }
      $options = view("backend.market.getMyBetsList",compact('mybetsModel','isDeleteShow','isViewMoreBets','sportModel'))->render();
      return $options;
    }

    public static function getMyAllBetsViewAll($matchID = '',$requestData){
        $isViewMoreBets = true;
        if(Auth::user()->roles->first()->name == 'administrator'){
            $sql = "SELECT * FROM `my_bets` WHERE match_id = '".$matchID."'";
            if(isset($requestData['userid']) && !empty($requestData['userid']) && $requestData['userid'] != 'ALL'){
                $sql .= " AND user_id IN (".$requestData['userid'].")";
            }
            if(isset($requestData['ipAddress']) && !empty($requestData['ipAddress'])){
                $sql .= " AND ip_address ='".$requestData['ipAddress']."'";
            }

            if(isset($requestData['type']) && !empty($requestData['type']) && $requestData['type'] != 'ALL'){
                $sql .= " AND bet_side ='".$requestData['type']."'";
            }
            if(isset($requestData['sAmount']) && !empty($requestData['sAmount'])){
                $sql .= " AND bet_amount >=".$requestData['sAmount']."";
            }
            if(isset($requestData['eAmount']) && !empty($requestData['eAmount'])){
                $sql .= " AND bet_amount <=".$requestData['eAmount'];
            }

            $sql .= " Order By id DESC";
            $mybetsModel = DB::select($sql);
        }else{
            $userChildArr = \App\Http\Controllers\Backend\AccountsController::getChildUserListArr(Auth::user()->id);
            $txt = implode(',', $userChildArr);
            if(empty($txt)){
                $txt = Auth::user()->id;
            }
            $sql = "SELECT * FROM `my_bets` WHERE match_id = '".$matchID."' AND `isDeleted`='0'";
            if(isset($requestData['userid']) && !empty($requestData['userid']) && $requestData['userid'] != 'ALL' && in_array($requestData['userid'],$userChildArr) ){
                $sql .= " AND user_id IN (".$requestData['userid'].")";
            }else{
                $sql .= " AND user_id IN (".$txt.")";
            }
            if(isset($requestData['ipAddress']) && !empty($requestData['ipAddress'])){
                $sql .= " AND ipAddress ='".$requestData['ipAddress']."'";
            }

            if(isset($requestData['type']) && !empty($requestData['type']) && $requestData['type'] != 'ALL'){
                $sql .= " AND bet_side ='".$requestData['type']."'";
            }
            if(isset($requestData['sAmount']) && !empty($requestData['sAmount'])){
                $sql .= " AND bet_amount =>'".$requestData['sAmount']."'";
            }
            if(isset($requestData['eAmount']) && !empty($requestData['eAmount'])){
                $sql .= " AND bet_amount <='".$requestData['eAmount']."'";
            }

            $sql .= " Order By id DESC";
            $mybetsModel = DB::select($sql);
        }
        $sportModel = Sports::where(['match_id'=>$matchID])->first();
        $isDeleteShow = false;
        if(isset($sportModel->id)){
            $isDeleteShow = true;
        }
        $options = view("backend.market.getMyBetsList",compact('mybetsModel','isDeleteShow','isViewMoreBets','sportModel'))->render();
        return $options;
    }

    public function marketanalysisdetails(){
      return view('backend.market.market-detail');
    }

    public function changestatus(Request $request){
      $res = array();
      $id = $request->input('id');
      $model = Sports::find($id);
      if($model->active == 1){
        $res['msg'] = 'Click To Active';
        $res['text'] = 'InActive';
        $model->active = 0;
      }else{
        $res['msg'] = 'Click To InActive';
        $res['text'] = 'Active';
        $model->active = 1;
      }
      $res['status'] = false;
      if($model->save()){
        $res['status'] = true;
      }
      return json_encode($res);
    }
    public function chnagestatusInplay(Request $request){
      $res = array();
      $id = $request->input('id');
      $model = Sports::find($id);
      if($model->inplay_status == 1){
        $res['msg'] = 'No';
        $model->inplay_status = 0;
      }else{
        $res['msg'] = 'Yes';
        $model->inplay_status = 1;
      }
      $res['status'] = false;
      if($model->save()){
        $res['status'] = true;
      }
      return json_encode($res);
    }

    public function chnagesuspened(Request $request){
      $res = array();
      $id = $request->input('id');
      $model = Sports::find($id);
      if($model->suspended == 1){
        $model->suspended = 0;
      }else{
        $model->suspended = 1;
      }
      $res['status'] = false;
      if($model->save()){
        $res['status'] = true;
      }
      return json_encode($res);
    }

    public function setlimit(Request $request){
      $res = array();
      $id = $request->input('id');
      $model = Sports::find($id);
      $model->odd_min_limit = $request->input('odd_min_limit');
      $model->odd_max_limit = $request->input('odd_max_limit');
      $model->bookmaker_min_limit = $request->input('bookmaker_min_limit');
      $model->bookmaker_max_limit = $request->input('bookmaker_max_limit');
      $model->fancy_min_limit = $request->input('fancy_min_limit');
      $model->fancy_max_limit = $request->input('fancy_max_limit');

      $res['msg'] = 'some thing wranng try again!';
      $res['status'] = false;

      if($model->save()){
        $res['msg'] = 'Limit added successfully';
        $res['status'] = true;
      }
      return json_encode($res);
    }

    public function getMAxMinLimit(Request $request){
      $res = array();
      $id = $request->input('id');
      $model = Sports::find($id);
      $res['odd_min_limit'] = $model->odd_min_limit;
      $res['odd_max_limit'] = $model->odd_max_limit;
      $res['bookmaker_min_limit'] =$model->bookmaker_min_limit;
      $res['bookmaker_max_limit'] =$model->bookmaker_max_limit;
      $res['fancy_min_limit'] = $model->fancy_min_limit;
      $res['fancy_max_limit'] =$model->fancy_max_limit;
      $res['status'] = true;
       return json_encode($res);
    }

    /************** GAMES ******************/

    public function getcasinoData(Request $request){
      $requestData = $request->all();
      $url = '';
      switch ($requestData['gameName']){
        case 'LiveTeenPati':{
          $url = 'http://172.105.49.149/json/teenpatti_live.json';
          break;
        }
        case 'AndarBahar':{
          $url = 'http://172.105.49.149/json/andar_bahar.json';
          break;
        }
        case 'Poker':{
          $url = 'http://172.105.49.149/json/poker.json';
          break;
        }
        case 'UpDown7':{
          $url = 'http://172.105.49.149/json/7updown.json';
          break;
        }
        case 'CardScasin032':{
          $url = 'http://172.105.49.149/json/32cardcas.json';
          break;
        }
        case 'TeenPati20':{
          $url = 'http://172.105.49.149/json/teenpatti_t20.json';
          break;
        }
        case 'AmarAkbarAnthony':{
          $url = 'http://172.105.49.149/json/amarakbar.json';
          break;
        }
        case 'DragOnTiger':{
          $url = 'http://172.105.49.149/json/dragont.json';
          break;
        }
      }

      $ch = curl_init( $url );
      curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
      $result = curl_exec($ch);
      curl_close($ch);
      $arr = json_decode($result,true);
      return $arr;
    }

    public function liveteenpati()
    {
      $gameModel = Games::where(['name'=>"CASINO",'status'=>1])->first();
      if(!isset($gameModel->id) || empty($gameModel->id)){
          return redirect('/');
      }
      $adminSetting = AdminSetting::first();
      $sports = DB::select( "SELECT  * FROM `sports` WHERE game_id='".$gameModel->id."' AND match_name='Live Teenpatti' AND active='1'");
      if(!isset($sports[0])){
          return Redirect::back();
      }
      $sports = $sports[0];
      if(!isset($sports->id)){
          return Redirect::back();
      }
      return view('backend.games.liveteenpati', compact('sports','adminSetting'));
    }

    public function andarbahar()
    {
      $gameModel = Games::where(['name'=>"CASINO",'status'=>1])->first();
      if(!isset($gameModel->id) || empty($gameModel->id)){
          return redirect('/');
      }
      $adminSetting = AdminSetting::first();

        $sports = DB::select( "SELECT  * FROM `sports` WHERE game_id='".$gameModel->id."' AND match_name='Andar Bahar' AND active='1'");
        if(!isset($sports[0])){
            return Redirect::back();
        }
        $sports = $sports[0];
        if(!isset($sports->id)){
            return Redirect::back();
        }
      return view('backend.games.andarbahar', compact('sports','adminSetting'));
    }

    public function poker()
    {
        $gameModel = Games::where(['name'=>"CASINO",'status'=>1])->first();
        if(!isset($gameModel->id) || empty($gameModel->id)){
            return redirect('/');
        }
        $adminSetting = AdminSetting::first();

        $sports = DB::select( "SELECT  * FROM `sports` WHERE game_id='".$gameModel->id."' AND match_name='Poker' AND active='1'");
        if(!isset($sports[0])){
            return Redirect::back();
        }
        $sports = $sports[0];
        if(!isset($sports->id)){
            return Redirect::back();
        }
        return view('backend.games.poker', compact('sports','adminSetting'));
    }


    public function updown7()
    {
        $gameModel = Games::where(['name'=>"CASINO",'status'=>1])->first();
        if(!isset($gameModel->id) || empty($gameModel->id)){
            return redirect('/');
        }
        $adminSetting = AdminSetting::first();
        $sports = DB::select( "SELECT  * FROM `sports` WHERE game_id='".$gameModel->id."' AND match_name='7 up & Down' AND active='1'");
        if(!isset($sports[0])){
            return Redirect::back();
        }
        $sports = $sports[0];
        if(!isset($sports->id)){
            return Redirect::back();
        }
        return view('backend.games.updown7', compact('sports','adminSetting'));
    }

    public function cardscasino32()
    {
        $gameModel = Games::where(['name'=>"CASINO",'status'=>1])->first();
        if(!isset($gameModel->id) || empty($gameModel->id)){
            return redirect('/');
        }
        $adminSetting = AdminSetting::first();
        $sports = DB::select( "SELECT  * FROM `sports` WHERE game_id='".$gameModel->id."' AND match_name='32 cards Casino' AND active='1'");
        if(!isset($sports[0])){
            return Redirect::back();
        }
        $sports = $sports[0];
        if(!isset($sports->id)){
            return Redirect::back();
        }
        return view('backend.games.cardscasino32', compact('sports','adminSetting'));
    }

    public function teenpatit20()
    {
        $gameModel = Games::where(['name'=>"CASINO",'status'=>1])->first();
        if(!isset($gameModel->id) || empty($gameModel->id)){
            return redirect('/');
        }
        $adminSetting = AdminSetting::first();
        $sports = DB::select( "SELECT  * FROM `sports` WHERE game_id='".$gameModel->id."' AND match_name='TeenPatti T20' AND active='1'");
        if(!isset($sports[0])){
            return Redirect::back();
        }
        $sports = $sports[0];
        if(!isset($sports->id)){
            return Redirect::back();
        }
        return view('backend.games.teenpatit20', compact('sports','adminSetting'));
    }

    public function amarakhbaranthony()
    {
        $gameModel = Games::where(['name'=>"CASINO",'status'=>1])->first();
        if(!isset($gameModel->id) || empty($gameModel->id)){
            return redirect('/');
        }
        $adminSetting = AdminSetting::first();
        $sports = DB::select( "SELECT  * FROM `sports` WHERE game_id='".$gameModel->id."' AND match_name='Amar Akbar Anthony' AND active='1'");
        if(!isset($sports[0])){
            return Redirect::back();
        }
        $sports = $sports[0];
        if(!isset($sports->id)){
            return Redirect::back();
        }
        return view('backend.games.amarakhbaranthony', compact('sports','adminSetting'));
    }

    public function dragontiger()
    {
        $gameModel = Games::where(['name'=>"CASINO",'status'=>1])->first();
        if(!isset($gameModel->id) || empty($gameModel->id)){
            return redirect('/');
        }
        $adminSetting = AdminSetting::first();
        $sports = DB::select( "SELECT  * FROM `sports` WHERE game_id='".$gameModel->id."' AND match_name='Dragon Tiger' AND active='1'");
        if(!isset($sports[0])){
            return Redirect::back();
        }
        $sports = $sports[0];
        if(!isset($sports->id)){
            return Redirect::back();
        }
        return view('backend.games.dragontiger', compact('sports','adminSetting'));
    }

    /**** BET LOCK UNLOCK ****/

    public function lockUnlock(Request $request){
      if(isset($request['lockType']) && !empty($request['lockType'])){
        switch($request['lockType']){
          case 'SUSPENDED':{
            $userLockModel = LockUnlockBet::where(['user_id'=>Auth::user()->id,'sportID'=>$request['sportID'],'lockType'=>'SUSPENDED'])->first();
            if(!isset($userLockModel->id)){
              $userLockModel = new LockUnlockBet();
            }
            $userLockModel->sportID = $request['sportID'];
            $userLockModel->lockType = 'SUSPENDED';
            $userLockModel->user_id = Auth::user()->id;
            if($request['type'] == 'SUSPEND'){
              $userLockModel->type = "SUSPEND";

            }elseif($request['type'] == 'UNSUSPEND'){
              $userLockModel->type = "UNSUSPEND";
            }
            if($userLockModel->save()){
              $message = 'Match '.$userLockModel->type." successfully";
            }else{
              $message = 'Match '.$userLockModel->type." Not successfully";
            }
            break;
          }
          case 'FULLMATCH':{
            $userLockModel = LockUnlockBet::where(['user_id'=>Auth::user()->id,'sportID'=>$request['sportID'],'lockType'=>'ODDS'])->first();
            if(!isset($userLockModel->id)){
              $userLockModel = new LockUnlockBet();
            }
            $userLockModel->sportID = $request['sportID'];
            $userLockModel->lockType = 'ODDS';
            $userLockModel->user_id = Auth::user()->id;
            if(isset($request['extra']) && !empty($request['extra'])){
              $userLockModel->extra = $request['extra'];
              $userLockModel->type = "LOCK";
            }else{
              $userLockModel->extra = '';
              $userLockModel->type = "";
            }
            if($request['type'] == 'LOCK'){
              $userLockModel->type = "LOCK";
            }elseif($request['type'] == 'UNLOCK'){
              $userLockModel->type = "UNLOCK";
            }
            if($userLockModel->save()){
              $message = 'Match '.$userLockModel->type." successfully";
            }else{
              $message = 'Match '.$userLockModel->type." Not successfully";
            }
            break;
          }
          case 'FANCY':{
            $userLockModel = LockUnlockBet::where(['user_id'=>Auth::user()->id,'sportID'=>$request['sportID'],'lockType'=>'SESSION'])->first();
            if(!isset($userLockModel->id)){
              $userLockModel = new LockUnlockBet();
            }
            $userLockModel->user_id = Auth::user()->id;
            $userLockModel->sportID = $request['sportID'];
            $userLockModel->lockType = 'SESSION';
            if(isset($request['extra']) && !empty($request['extra'])){
              $userLockModel->extra = $request['extra'];
              $userLockModel->type = "LOCK";
            }else{
              $userLockModel->extra = '';
              $userLockModel->type = "UNLOCK";
            }
            if($request['type'] == 'LOCK'){
              $userLockModel->type = "LOCK";

            }elseif($request['type'] == 'UNLOCK'){
              $userLockModel->type = "UNLOCK";
            }
            if($userLockModel->save()){
              $message = 'Fancy '.$userLockModel->type." successfully";
            }else{
              $message = 'Fancy '.$userLockModel->type." Not successfully";
            }
            break;
          }
          case 'BOOKMAKER':{
            $userLockModel = LockUnlockBet::where(['user_id'=>Auth::user()->id,'sportID'=>$request['sportID'],'lockType'=>'BOOKMAKER'])->first();
            if(!isset($userLockModel->id)){
              $userLockModel = new LockUnlockBet();
            }
            $userLockModel->user_id = Auth::user()->id;
            $userLockModel->sportID = $request['sportID'];
            $userLockModel->lockType = $request['lockType'];
            if(isset($request['extra'])){
              $userLockModel->extra = $request['extra'];
              $userLockModel->type = "LOCK";
            }else{
              $userLockModel->extra = '';
              $userLockModel->type = "";
            }
            if($request['type'] == 'LOCK'){
              $userLockModel->type = "LOCK";

            }elseif($request['type'] == 'UNLOCK'){
              $userLockModel->type = "UNLOCK";
            }elseif($request['type'] == 'SELECTEDUSER'){
              $userLockModel->type = "LOCK";
            }
            if($userLockModel->save()){
              $message = 'Bookmaker '.$userLockModel->type." successfully";
            }else{
              $message = 'Bookmaker '.$userLockModel->type." Not successfully";
            }
            break;
          }
        }
      }

      return json_encode(array('message'=>$message));
    }

    function getUserList(Request $request){
      $userId = Auth::user()->id;
//      if(Auth::user()->roles->first()->name == 'administrator'){
//        $UserData = User::where(['active'=>1])->get();
//      }else{

        $UserData = self::getChildUserList($userId);
//      }
      $type = '';
      switch($request['lockType']){
          case 'SUSPENDED':{
            $type = 'SUSPENDED';
            break;
          }
          case 'FULLMATCH':{
            $type = 'ODDS';
            break;
          }
          case 'FANCY':{
            $type = 'SESSION';
            break;
          }
          case 'BOOKMAKER':{
            $type = 'BOOKMAKER';
            break;
          }
      }
      $userLockModel = LockUnlockBet::where(['user_id'=>Auth::user()->id,'sportID'=>$request['sportID'],'lockType'=>$type])->first();
      $options = view('backend.sports.getUserList', compact('UserData','userLockModel'))->render();
      return $options;
    }

    public static function getChildUserList($userID){

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
}
