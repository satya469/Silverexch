<?php

namespace App\Http\Controllers\Frontend;

use App\AdminSetting;
use App\ButtonValue;
use App\Casino;
use App\Games;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\MyBets;
use App\UpperLevelDownLevel;
use App\UserDeposite;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SportsController extends Controller
{
    public function cricket()
    {

        $gameModel = Games::where(["name" => "CRICKET", 'status' => 1])->first();
        if (!isset($gameModel->id) || empty($gameModel->id)) {
            $sports = array();
        } else {
            $sports = DB::select("SELECT  * FROM `sports` WHERE game_id='" . $gameModel->id . "' AND active='1' AND (winner ='' OR winner IS NULL)");
        }

        return view('frontend.game-list.cricket', compact('sports'));

    }

    public function tennis()
    {
        $gameModel = Games::where(['name' => "TENNIS", 'status' => 1])->first();
        if (!isset($gameModel->id) || empty($gameModel->id)) {
            $sports = array();
        } else {
            $sports = DB::select("SELECT  * FROM `sports` WHERE game_id='" . $gameModel->id . "' AND active='1' AND (winner ='' OR winner IS NULL)");
        }
//      $sports = Sports::where(['game_id'=>$gameModel->id])->get();
        return view('frontend.game-list.tennis', compact('sports'));
    }

    public function footboll()
    {

        $gameModel = Games::where(['name' => "SOCCER", 'status' => 1])->first();
        if (!isset($gameModel->id) || empty($gameModel->id)) {
            $sports = array();
        } else {
            $sports = DB::select("SELECT  * FROM `sports` WHERE game_id='" . $gameModel->id . "' AND active='1' AND (winner ='' OR winner IS NULL)");
        }
        return view('frontend.game-list.footboll', compact('sports'));
    }

    public static function teenpatiresult($sportID, $details, $callType)
    {

        if($callType == 'DragOnTiger'){
            $details['result'] = $details['details'];
        }

        if (!isset($details['result'])) {
            return false;
        }
        foreach ($details['result'] as $key => $result) {

            $sportModel = Casino::where(['sportID' => $sportID, 'roundID' => $result['mid'], 'status' => 1])->first();

            if (isset($sportModel->status) && $sportModel->status == 1) {

                $betModel = MyBets::where(['sportID' => $sportID, 'match_id' => $result['mid']])->get();
                $userBetList = array();
                // dd($betModel);
                foreach ($betModel as $key => $data) {

                    if (isset($userBetList[$data->user_id])) {
                        $myBetResultModel = MyBets::find($data->id);
                        $myBetResultModel->active = 0;
                        $myBetResultModel->save();
                        unset($myBetResultModel);
                        continue;
                    }
                    $winnerTeam = '';
                    switch ($callType) {
                        case 'LiveTeenPati':{
                                $winnerTeam = 'Player ' . $result['result'];
                                break;
                            }
                        case 'AndarBahar':{
                                $winnerTeam = ($result['result'] == 'A' ? 'Andar' : 'Bahar');
                                break;
                            }
                        case 'Poker':{
                                $winnerTeam = 'Player ' . $result['result'];
                                break;
                            }
                        case 'UpDown7':{
                                $result['result'] = preg_replace('/[^0-9\-]/', '', $result['result']);
                                if ($result['result'] > 7) {
                                    $winnerTeam = '7Up';
                                } else if ($result['result'] == 7) {
                                    $winnerTeam = '7';
                                } else if ($result['result'] < 7) {
                                    $winnerTeam = '7Down';
                                }
                                break;
                            }
                        case 'CardScasin032':{
                                $winnerTeam = 'Player ' . $result['result'];
                                break;
                            }
                        case 'TeenPati20':{
                                $winnerTeam = 'Player ' . $result['result'];
                                break;
                            }
                        case 'AmarAkbarAnthony':{
                                $result['result'] = preg_replace('/[^0-9\-]/', '', $result['result']);
                                if ($result['result'] >= 1 && $result['result'] <= 6) {
                                    $winnerTeam = 'Amar';
                                } else if (($result['result'] >= 7 && $result['result'] <= 10)) {
                                    $winnerTeam = 'Akbar';
                                } else if (($result['result'] >= 11 && $result['result'] <= 13)) {
                                    $winnerTeam = 'Anthony';
                                }
                                break;
                            }
                        case 'DragOnTiger':{
                                if (strtoupper($result['result']) == 'D') {
                                    $winnerTeam = 'Dragon';
                                } else if (strtoupper($result['result']) == 'T') {
                                    $winnerTeam = 'Tiger';
                                } else if (strtoupper($result['result']) == 'TIE') {
                                    $winnerTeam = 'Tie (Rank Only)';
                                } else if (strtoupper($result['result']) == 'ST') {
                                    $winnerTeam = 'Suited Tie';
                                }
                                break;
                            }
                    }

                    $sport = Casino::find($sportModel->id);
                    $sport->status = 0;
                    $sport->result = $result['result'];
                    $sport->save();
                    unset($sport);

                    $exTot = MyBetsController::getExAmountByMatchWithDetail($sportID, $data->user_id, $result['mid'], $winnerTeam);
                    $amount = $exTot;
                    $userModel = User::find($data->user_id);
                    if ($exTot == 0) {
                        $model = new UserDeposite();
                        $model->balanceType = 'MATCH-P-L';
                        $model->deposite_user_id = $userModel->id;
                        $model->withdrawal_user_id = $userModel->parent_id;
                        $model->amount = '0';
                        $model->match_id = $result['mid'];
                        $model->type = "ODDS_BOOKMEKER";
                        $model->note = $result['result'] . " is Winner to get P/L";
                        $model->callType = $callType;
                        $model->save();
                    } else if ($exTot > 0) {
                        $model = new UserDeposite();
                        $model->balanceType = 'MATCH-P-L';
                        $model->deposite_user_id = $userModel->id;
                        $model->withdrawal_user_id = $userModel->parent_id;
                        $model->amount = abs($exTot);
                        $model->match_id = $result['mid'];
                        $model->type = "ODDS_BOOKMEKER";
                        $model->note = $result['result'] . " is Winner to get P/L";
                        $model->callType = $callType;
                        $model->save();

                        /** USER PARENT CAL **/
                        $perentArr = self::getUserParentPer($userModel->parent_id);
                        foreach ($perentArr as $userID => $per) {
                            $userModelPer = User::find($userID);
                            $userModelIsAdmin = User::find($userModelPer->parent_id);
                            if (isset($perentArr[$userModelPer->parent_id]) && strtoupper($userModelIsAdmin->roles->first()->name) == 'ADMINISTRATOR') {
                                $parentPER = $perentArr[$userModelPer->parent_id];
                                $downLevel = (($amount * $per) / 100);
                                $perupleval = (100 - $userModelPer->partnership);
                                $upperLevel = (($amount * $perupleval) / 100);
                            } else {
                                $downLevel = (($amount * $per) / 100);
                                $perupleval = (100 - $userModelPer->partnership);
                                $upperLevel = (($amount * $perupleval) / 100);
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
                        unset($model);
                    } else {
                        $model = new UserDeposite();
                        $model->balanceType = 'MATCH-P-L';
                        $model->deposite_user_id = $userModel->parent_id;
                        $model->withdrawal_user_id = $userModel->id;
                        $model->amount = abs($exTot);
                        $model->match_id = $data->match_id;
                        $model->type = "ODDS_BOOKMEKER";
                        $model->note = $result['result'] . " is Winner to get P/L";
                        $model->callType = $callType;
                        $model->save();

                        /** USER PARENT CAL **/

                        $perentArr = self::getUserParentPer($userModel->parent_id);
                        foreach ($perentArr as $userID => $per) {
                            $userModelPer = User::find($userID);
                            $userModelIsAdmin = User::find($userModelPer->parent_id);
                            if (isset($perentArr[$userModelPer->parent_id]) && strtoupper($userModelIsAdmin->roles->first()->name) == 'ADMINISTRATOR') {
                                $parentPER = $perentArr[$userModelPer->parent_id];
                                $downLevel = (($amount * $per) / 100);
                                $perupleval = (100 - $userModelPer->partnership);
                                $upperLevel = (($amount * $perupleval) / 100);
                            } else {
                                $downLevel = (($amount * $per) / 100);
                                $perupleval = (100 - $userModelPer->partnership);
                                $upperLevel = (($amount * $perupleval) / 100);
                            }

                            $upDownModel = new UpperLevelDownLevel();
                            $upDownModel->user_id = $userID;
                            $upDownModel->deposit_id = $model->id;
                            $upDownModel->sportID = $data->sportID;
                            $upDownModel->matchID = $data->match_id;
                            $upDownModel->bet_user_id = $data->user_id;
                            $upDownModel->per = $per;
                            $upDownModel->upperLevel = ($upperLevel);
                            $upDownModel->downLevel = ($downLevel);

//                $upDownModel->upperLevel = ($upperLevel*(-1));
                            //                $upDownModel->downLevel = ($downLevel*(-1));
                            $upDownModel->save();
                            unset($upDownModel);
                        }
                        unset($model);
                    }
                    unset($userModel);
                    $userBetList[$data->user_id] = $data->id;
                    $myBetResultModel = MyBets::find($data->id);
                    $myBetResultModel->active = 0;
                    $myBetResultModel->save();
                    unset($myBetResultModel);
                }
                $sport = Casino::find($sportModel->id);
                $sport->status = 0;
                $sport->result = $result['result'];
                $sport->save();
                unset($sport);
            }
            unset($sportModel);
        }
    }

    public static function getUserParentPer($userID)
    {
        $userModel = User::find($userID);
        $userData = array();
        /** get parent **/
        $parentID = $userModel->parent_id;
        $userData[$userID] = $userModel->partnership;
        $childPartnership = $userModel->partnership;
        $childID = $userID;
        while ($parentID > 0) {
            $userModelParent = User::find($parentID);
            $userModelChilds = User::find($childID);
            $userData[$parentID] = ($userModelParent->partnership - $userModelChilds->partnership);
            $childPartnership = $userData[$parentID];
            $childID = $userModelParent->id;
            $parentID = $userModelParent->parent_id;
        }
        return $userData;
    }

    public function getcasinoData(Request $request)
    {
        $requestData = $request->all();
        $url = '';
//      die($requestData['gameName']);
        switch ($requestData['gameName']) {
            case 'LiveTeenPati':{
                    $url = 'http://172.105.49.149/json/teenpatti_live.json';
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $arr = json_decode($result, true);
                    self::teenpatiresult($requestData['sportID'], $arr, 'LiveTeenPati');
                    $sportModel = Casino::where(['sportID' => $requestData['sportID'], 'roundID' => $arr['detail']['roundId']])->first();
                    if (isset($sportModel->id) && $sportModel->id > 0) {
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['detail']['roundId'];
                        $sportModel->card1 = $arr['match_ods'][0]['c1'] . "," . $arr['match_ods'][0]['c2'] . "," . $arr['match_ods'][0]['c3'];
                        $sportModel->card2 = $arr['match_ods'][1]['c1'] . "," . $arr['match_ods'][1]['c2'] . "," . $arr['match_ods'][1]['c3'];
                        $sportModel->save();
                    } else {
                        $sportModel = new Casino();
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['detail']['roundId'];
                        $sportModel->card1 = $arr['match_ods'][0]['c1'] . "," . $arr['match_ods'][0]['c2'] . "," . $arr['match_ods'][0]['c3'];
                        $sportModel->card2 = $arr['match_ods'][1]['c1'] . "," . $arr['match_ods'][1]['c2'] . "," . $arr['match_ods'][1]['c3'];
                        $sportModel->save();
                    }
                    break;
                }
            case 'AndarBahar':{
                    $url = 'http://172.105.49.149/json/andar_bahar.json';
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $arr = json_decode($result, true);
                    self::teenpatiresult($requestData['sportID'], $arr, 'AndarBahar');
                    $sportModel = Casino::where(['sportID' => $requestData['sportID'], 'roundID' => $arr['detail']['roundId']])->first();
                    if (isset($sportModel->id) && $sportModel->id > 0) {
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['detail']['roundId'];
                        $sportModel->save();
                    } else {
                        $sportModel = new Casino();
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['detail']['roundId'];
                        $sportModel->save();
                    }
                    break;
                }
            case 'Poker':{
                    $url = 'http://172.105.49.149/json/poker.json';
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $arr = json_decode($result, true);
                    self::teenpatiresult($requestData['sportID'], $arr, 'Poker');
                    $sportModel = Casino::where(['sportID' => $requestData['sportID'], 'roundID' => $arr['detail']['roundId']])->first();
                    if (isset($sportModel->id) && $sportModel->id > 0) {
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['detail']['roundId'];
                        $sportModel->save();
                    } else {
                        $sportModel = new Casino();
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['detail']['roundId'];
                        $sportModel->save();
                    }
                    break;
                }
            case 'UpDown7':{
                    $url = 'http://172.105.49.149/json/7updown.json';
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $arr = json_decode($result, true);
                    self::teenpatiresult($requestData['sportID'], $arr, 'UpDown7');
                    $sportModel = Casino::where(['sportID' => $requestData['sportID'], 'roundID' => $arr['detail']['roundId']])->first();
                    if (isset($sportModel->id) && $sportModel->id > 0) {
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['detail']['roundId'];
                        $sportModel->save();
                    } else {
                        $sportModel = new Casino();
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['detail']['roundId'];
                        $sportModel->save();
                    }
                    break;
                }
            case 'CardScasin032':{
                    $url = 'http://172.105.49.149/json/32cardcas.json';
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $arr = json_decode($result, true);
                    self::teenpatiresult($requestData['sportID'], $arr, 'CardScasin032');
                    $sportModel = Casino::where(['sportID' => $requestData['sportID'], 'roundID' => $arr['detail']['roundId']])->first();
                    if (isset($sportModel->id) && $sportModel->id > 0) {
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['detail']['roundId'];
                        $sportModel->save();
                    } else {
                        $sportModel = new Casino();
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['detail']['roundId'];
                        $sportModel->save();
                    }
                    break;
                }
            case 'TeenPati20':{
                    $url = 'http://172.105.49.149/json/teenpatti_t20.json';
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $arr = json_decode($result, true);
                    self::teenpatiresult($requestData['sportID'], $arr, 'TeenPati20');
                    $sportModel = Casino::where(['sportID' => $requestData['sportID'], 'roundID' => $arr['detail']['roundId']])->first();
                    if (isset($sportModel->id) && $sportModel->id > 0) {
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['detail']['roundId'];
                        $sportModel->save();
                    } else {
                        $sportModel = new Casino();
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['detail']['roundId'];
                        $sportModel->save();
                    }
                    break;
                }
            case 'AmarAkbarAnthony':{
                    $url = 'http://172.105.49.149/json/amarakbar.json';
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $arr = json_decode($result, true);
                    self::teenpatiresult($requestData['sportID'], $arr, 'AmarAkbarAnthony');
                    $sportModel = Casino::where(['sportID' => $requestData['sportID'], 'roundID' => $arr['detail']['roundId']])->first();
                    if (isset($sportModel->id) && $sportModel->id > 0) {
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['detail']['roundId'];
                        $sportModel->status = 1;
                        $sportModel->save();
                    } else {
                        $sportModel = new Casino();
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['detail']['roundId'];
                        $sportModel->status = 1;
                        $sportModel->save();
                    }
                    break;
                }
            case 'DragOnTiger':{

                    $url = 'http://52.66.42.244/api/lastresults?Id=2595';
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $arr['details'] = json_decode($result, true);

                    $url = 'http://52.66.42.244/api/codds?id=2595';
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $arr['odds'] = json_decode($result, true);

                    self::teenpatiresult($requestData['sportID'], $arr, 'DragOnTiger');
                    // dd($arr[0]['mid']);
                    $sportModel = Casino::where(['sportID' => $requestData['sportID'], 'roundID' => $arr['details'][0]['mid']])->first();
                // dd($arr['details'][0]);
                    if (isset($sportModel->id) && $sportModel->id > 0) {
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['details'][0]['mid'];
                        $sportModel->save();
                    } else {
                        $sportModel = new Casino();
                        $sportModel->sportID = $requestData['sportID'];
                        $sportModel->roundID = $arr['details'][0]['mid'];
                        $sportModel->save();
                    }
                    break;


                }
        }
        return $arr;
    }

    public function liveteenpati()
    {
        $gameModel = self::getCasinoGameObj();

        if (!isset($gameModel->id) || empty($gameModel->id)) {
            return redirect('/');
        }
        $adminSetting = AdminSetting::first();
        $buttonValueModel = ButtonValue::where(['user_id' => Auth::user()->id])->first();
//      dd($buttonValueModel);
        $buttonValueArr = json_decode($buttonValueModel->btnSetting, true);
        $buttonValue = $buttonValueArr;
        $sports = DB::select("SELECT  * FROM `sports` WHERE game_id='" . $gameModel->id . "' AND match_name='Live Teenpatti' AND active='1'");
        if (isset($sports[0])) {
            $sports = $sports[0];
        }
        if (!isset($sports->id) || empty($sports->id)) {
            return redirect('/');
        }

        return view('frontend.game-list.liveteenpati', compact('sports', 'adminSetting', 'buttonValue'));
    }

    public function andarbahar()
    {
        $gameModel = self::getCasinoGameObj();
        if (!isset($gameModel->id) || empty($gameModel->id)) {
            return redirect('/');
        }
        $adminSetting = AdminSetting::first();
        $buttonValueModel = ButtonValue::where(['user_id' => Auth::user()->id])->first();
        $buttonValueArr = json_decode($buttonValueModel->btnSetting, true);
        $buttonValue = $buttonValueArr;
        $sports = DB::select("SELECT  * FROM `sports` WHERE game_id='" . $gameModel->id . "' AND match_name='Andar Bahar' AND active='1'");
        if (isset($sports[0])) {
            $sports = $sports[0];
        }
        if (!isset($sports->id) || empty($sports->id)) {
            return redirect('/');
        }
        return view('frontend.game-list.andarbahar', compact('sports', 'adminSetting', 'buttonValue'));
    }

    public function poker()
    {
        $gameModel = self::getCasinoGameObj();
        if (!isset($gameModel->id) || empty($gameModel->id)) {
            return redirect('/');
        }
        $adminSetting = AdminSetting::first();
        $buttonValueModel = ButtonValue::where(['user_id' => Auth::user()->id])->first();
        $buttonValueArr = json_decode($buttonValueModel->btnSetting, true);
        $buttonValue = $buttonValueArr;
        $sports = DB::select("SELECT  * FROM `sports` WHERE game_id='" . $gameModel->id . "' AND match_name='Poker' AND active='1'");
        if (isset($sports[0])) {
            $sports = $sports[0];
        }
        if (!isset($sports->id) || empty($sports->id)) {
            return redirect('/');
        }
        return view('frontend.game-list.poker', compact('sports', 'adminSetting', 'buttonValue'));
    }

    public function updown7()
    {
        $gameModel = self::getCasinoGameObj();
        if (!isset($gameModel->id) || empty($gameModel->id)) {
            return redirect('/');
        }
        $adminSetting = AdminSetting::first();
        $buttonValueModel = ButtonValue::where(['user_id' => Auth::user()->id])->first();
        $buttonValueArr = json_decode($buttonValueModel->btnSetting, true);
        $buttonValue = $buttonValueArr;
        $sports = DB::select("SELECT  * FROM `sports` WHERE game_id='" . $gameModel->id . "' AND match_name='7 up & Down' AND active='1'");
        if (isset($sports[0])) {
            $sports = $sports[0];
        }
        if (!isset($sports->id) || empty($sports->id)) {
            return redirect('/');
        }
        return view('frontend.game-list.updown7', compact('sports', 'adminSetting', 'buttonValue'));
    }

    public function cardscasino32()
    {
        $gameModel = self::getCasinoGameObj();
        if (!isset($gameModel->id) || empty($gameModel->id)) {
            return redirect('/');
        }
        $adminSetting = AdminSetting::first();
        $buttonValueModel = ButtonValue::where(['user_id' => Auth::user()->id])->first();
        $buttonValueArr = json_decode($buttonValueModel->btnSetting, true);
        $buttonValue = $buttonValueArr;
        $sports = DB::select("SELECT  * FROM `sports` WHERE game_id='" . $gameModel->id . "' AND match_name='32 cards Casino' AND active='1'");
        if (isset($sports[0])) {
            $sports = $sports[0];
        }
        if (!isset($sports->id) || empty($sports->id)) {
            return redirect('/');
        }
        return view('frontend.game-list.cardscasino32', compact('sports', 'adminSetting', 'buttonValue'));
    }

    public function teenpatit20()
    {
        $gameModel = self::getCasinoGameObj();
        if (!isset($gameModel->id) || empty($gameModel->id)) {
            return redirect('/');
        }
        $adminSetting = AdminSetting::first();
        $buttonValueModel = ButtonValue::where(['user_id' => Auth::user()->id])->first();
        $buttonValueArr = json_decode($buttonValueModel->btnSetting, true);
        $buttonValue = $buttonValueArr;
        $sports = DB::select("SELECT  * FROM `sports` WHERE game_id='" . $gameModel->id . "' AND match_name='TeenPatti T20' AND active='1'");
        if (isset($sports[0])) {
            $sports = $sports[0];
        }
        if (!isset($sports->id) || empty($sports->id)) {
            return redirect('/');
        }
        return view('frontend.game-list.teenpatit20', compact('sports', 'adminSetting', 'buttonValue'));
    }

    public function amarakhbaranthony()
    {
        $gameModel = self::getCasinoGameObj();
        if (!isset($gameModel->id) || empty($gameModel->id)) {
            return redirect('/');
        }
        $adminSetting = AdminSetting::first();
        $buttonValueModel = ButtonValue::where(['user_id' => Auth::user()->id])->first();
        $buttonValueArr = json_decode($buttonValueModel->btnSetting, true);
        $buttonValue = $buttonValueArr;
        $sports = DB::select("SELECT  * FROM `sports` WHERE game_id='" . $gameModel->id . "' AND match_name='Amar Akbar Anthony' AND active='1'");
        if (isset($sports[0])) {
            $sports = $sports[0];
        }
        if (!isset($sports->id) || empty($sports->id)) {
            return redirect('/');
        }
        return view('frontend.game-list.amarakhbaranthony', compact('sports', 'adminSetting', 'buttonValue'));
    }

    public function dragontiger()
    {
        $gameModel = self::getCasinoGameObj();
        // dd($gameModel->id);
        if (!isset($gameModel->id) || empty($gameModel->id)) {
            return redirect('/');
        }
        $adminSetting = AdminSetting::first();
        $buttonValueModel = ButtonValue::where(['user_id' => Auth::user()->id])->first();
        $buttonValueArr = json_decode($buttonValueModel->btnSetting, true);
        $buttonValue = $buttonValueArr;
        $sports = DB::select("SELECT  * FROM `sports` WHERE game_id='" . $gameModel->id . "' AND match_name='Dragon Tiger' AND active='1'");
        // dd($sports);
        if (isset($sports[0])) {
            $sports = $sports[0];
        }
        if (!isset($sports->id) || empty($sports->id)) {
            return redirect('/');
        }

        return view('frontend.game-list.dragontiger', compact('sports', 'adminSetting', 'buttonValue'));
    }

    public static function getCasinoGameObj()
    {
        $gameModel = Games::where(['name' => "CASINO", 'status' => 1])->first();
        return $gameModel;
    }

    public function singles($token)
    {

        $userId = Auth::user()->id;
        $user = User::find($userId);
        $delay = 0;
        $sports = DB::select("SELECT sp.* FROM `sports` sp JOIN games g ON(g.id= sp.game_id and status=1) WHERE sp.match_id='" . $token . "' AND sp.active='1' AND (sp.winner ='' OR sp.winner IS NULL) LIMIT 1");


        if (!isset($sports[0])) {
            return redirect('/');
        }
        $sports = $sports[0];
        if (empty($sports->game_id)) {
            return redirect('/');
        }

        $gameModel = Games::where(['id' => $sports->game_id])->first();
        $adminSetting = AdminSetting::first();
        $buttonValueModel = ButtonValue::where(['user_id' => Auth::user()->id])->first();
        if (!isset($buttonValueModel->btnSetting)) {
            $buttonValueModel = new ButtonValue();
            $buttonValueModel->user_id = Auth::user()->id;
            $buttonValueModel->btnSetting = '{"label":["1000","2000","3000","4000","5000","6000","7000","8000","9000","10000"],"price":["1000","2000","3000","4000","5000","6000","7000","8000","9000","10000"]}';
            $buttonValueModel->save();
        } else if (empty($buttonValueModel->btnSetting)) {
            $buttonValueModel->btnSetting = '{"label":["1000","2000","3000","4000","5000","6000","7000","8000","9000","10000"],"price":["1000","2000","3000","4000","5000","6000","7000","8000","9000","10000"]}';
            $buttonValueModel->save();
        }
        $buttonValueArr = json_decode($buttonValueModel->btnSetting, true);
        $buttonValue = $buttonValueArr;
        $gameName = strtoupper($gameModel->name);

        switch ($gameName) {
            case 'CRICKET':{
                    if ($user->delay_cricket > 0) {
                        $delay = ($user->delay_cricket * 1000);
                    }
                    $url = 'http://139.177.188.73:3000/getBM?eventId=' . $token;
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);

                    $arr = json_decode($result, true);
                    $dataArr = array();
                    // dd($arr);
                    $data = array();
                    if (isset($arr['t1'][0])) {
                        $data['odd'] = $arr['t1'][0];
                    }


                    if (isset($arr['t2'][0])) {
                        $data['bookmaker'] = $arr['t2'][0]['bm1'];
                    }

                    // dd($arr['t2']);

                    if (isset($arr['t3'][0])) {
                        $data['session'] = $arr['t3'];
                    }

                    if (isset($data['session'])) {
                        foreach ($data['session'] as $key => $val) {
                            // dd($val);
                            if (isset($val['nat']) && !empty($val['nat'])) {
                                $dataArr['session'][] = array(
                                    'RunnerName' => $val['nat'],
                                    'LayPrice1' => $val['l1'],
                                    'LaySize1' => $val['ls1'],
                                    'BackPrice1' => $val['b1'],
                                    'BackSize1' => $val['bs1'],
                                );
                            }
                        }
                    }
                    //   dd($data);
                    return view('frontend.game-list.singles', compact('sports', 'adminSetting', 'data', 'buttonValue', 'dataArr', 'delay'));
                    break;
                }
            case 'TENNIS':{
                    if ($user->delay_tennic > 0) {
                        $delay = ($user->delay_tennic * 1000);
                    }
                    //          die($user->id."====".$user->delay_tennic);
                    return view('frontend.game-list.tennisSingles', compact('sports', 'adminSetting', 'buttonValue', 'delay'));
                    break;
                }
            case 'SOCCER':{
                    if ($user->delay_football > 0) {
                        $delay = ($user->delay_football * 1000);
                    }
                    $url = 'http://65.1.65.188:3000/getdata/' . $token;
                    //          $result = file_get_contents($url);
                    //          $result = '{"market": [{"marketId": "1.30042557", "inplay": false, "totalMatched": null, "totalAvailable": null, "priceStatus": null, "events": [{"SelectionId": "", "RunnerName": "Kolkata Knight Riders", "LayPrice1": "2.08", "LaySize1": "215.83", "LayPrice2": "2.1", "LaySize2": "219.43", "LayPrice3": "2.12", "LaySize3": "3.2", "BackPrice1": "2.04", "BackSize1": "210.07", "BackPrice2": "2.02", "BackSize2": "550", "BackPrice3": "1.96", "BackSize3": "83.2"}, {"SelectionId": "", "RunnerName": "Chennai Super Kings", "LayPrice1": "1.95", "LaySize1": "8.99", "LayPrice2": "1.96", "LaySize2": "195.13", "LayPrice3": "1.97", "LaySize3": "14.5", "BackPrice1": "1.94", "BackSize1": "9.78", "BackPrice2": "1.93", "BackSize2": "213.31", "BackPrice3": "1.92", "BackSize3": "249.51"}]}], "bookmake": [{"runners": [{"SelectionId": "", "RunnerName": "Kolkata Knight Riders", "LayPrice1": "0", "LaySize1": "0", "LayPrice2": "0", "LaySize2": "0", "LayPrice3": "0", "LaySize3": "0", "BackPrice1": "0", "BackSize1": "0", "BackPrice2": "0", "BackSize2": "0", "BackPrice3": "0", "BackSize3": "0"}, {"SelectionId": "", "RunnerName": "Chennai Super Kings", "LayPrice1": "96", "LaySize1": "100", "LayPrice2": "0", "LaySize2": "0", "LayPrice3": "0", "LaySize3": "0", "BackPrice1": "92", "BackSize1": "100", "BackPrice2": "0", "BackSize2": "0", "BackPrice3": "0", "BackSize3": "0"}]}], "session": [{"SelectionId": "", "RunnerName": "Match 1st over run(KKR vs CSK)adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "6 over runs KKR(KKR vs CSK)adv", "LayPrice1": "46", "LaySize1": "100", "BackPrice1": "48", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "6 over runs CSK(KKR vs CSK)adv", "LayPrice1": "46", "LaySize1": "100", "BackPrice1": "48", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "20 over runs KKR(KKR vs CSK)adv", "LayPrice1": "165", "LaySize1": "100", "BackPrice1": "167", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "20 over runs CSK(KKR vs CSK)adv", "LayPrice1": "167", "LaySize1": "100", "BackPrice1": "169", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Fall of 1st wkt KKR(KKR vs CSK)adv", "LayPrice1": "23", "LaySize1": "110", "BackPrice1": "23", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Fall of 1st wkt CSK(KKR vs CSK)adv", "LayPrice1": "23", "LaySize1": "110", "BackPrice1": "23", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Gill run(KKR vs CSK)adv", "LayPrice1": "26", "LaySize1": "110", "BackPrice1": "26", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine run(KKR vs CSK)adv", "LayPrice1": "16", "LaySize1": "110", "BackPrice1": "16", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "F du Plessis run(KKR vs CSK)adv", "LayPrice1": "25", "LaySize1": "110", "BackPrice1": "25", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Watson run(KKR vs CSK)adv", "LayPrice1": "20", "LaySize1": "110", "BackPrice1": "20", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Gill Boundaries(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine Boundaries(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "115", "BackPrice1": "3", "BackSize1": "85", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "F du Plessis Boundaries(KKR vs CSK)adv", "LayPrice1": "4", "LaySize1": "115", "BackPrice1": "4", "BackSize1": "85", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Watson Boundaries(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "How many balls for 50 runs KKR(KKR vs CSK)adv", "LayPrice1": "38", "LaySize1": "100", "BackPrice1": "40", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "How many balls for 50 runs CSK(KKR vs CSK)adv", "LayPrice1": "38", "LaySize1": "100", "BackPrice1": "40", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Fours(KKR vs CSK)adv", "LayPrice1": "25", "LaySize1": "100", "BackPrice1": "27", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Sixes(KKR vs CSK)adv", "LayPrice1": "11", "LaySize1": "100", "BackPrice1": "12", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Boundaries(KKR vs CSK)adv", "LayPrice1": "36", "LaySize1": "100", "BackPrice1": "38", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Wkts(KKR vs CSK)adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "13", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Wides(KKR vs CSK)adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Extras(KKR vs CSK)adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Caught Outs(KKR vs CSK)adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Bowled(KKR vs CSK)adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match LBW(KKR vs CSK)adv", "LayPrice1": "1", "LaySize1": "100", "BackPrice1": "2", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Fifties(KKR vs CSK)adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Highest Scoring over in match(KKR vs CSK)adv", "LayPrice1": "20", "LaySize1": "100", "BackPrice1": "21", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Top batsman runs in match(KKR vs CSK)adv", "LayPrice1": "66", "LaySize1": "100", "BackPrice1": "68", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "3 wkt or more by bowler in match(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Fours KKR and CSK adv", "LayPrice1": "150", "LaySize1": "100", "BackPrice1": "157", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Sixes KKR and CSK adv", "LayPrice1": "28", "LaySize1": "100", "BackPrice1": "31", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Wkts KKR and CSK adv", "LayPrice1": "32", "LaySize1": "100", "BackPrice1": "37", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Wides KKR and CSK adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Extras KKR and CSK adv", "LayPrice1": "50", "LaySize1": "100", "BackPrice1": "57", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "P Cummins 2 over Runs Session adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "15", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "P Cummins 4 over Runs Session adv", "LayPrice1": "30", "LaySize1": "100", "BackPrice1": "32", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Mavi 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Mavi 4 over Runs Session adv", "LayPrice1": "33", "LaySize1": "100", "BackPrice1": "35", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "V Chakravarthy 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "V Chakravarthy 4 over Runs Session adv", "LayPrice1": "33", "LaySize1": "100", "BackPrice1": "35", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine 2 over Runs Session adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine 4 over Runs Session adv", "LayPrice1": "28", "LaySize1": "100", "BackPrice1": "30", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "A Russell 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "A Russell 4 over Runs Session adv", "LayPrice1": "32", "LaySize1": "100", "BackPrice1": "34", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "D Chahar 2 over Runs Session adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "15", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "D Chahar 4 over Runs Session adv", "LayPrice1": "30", "LaySize1": "100", "BackPrice1": "32", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Curran 2 over Runs Session adv", "LayPrice1": "14", "LaySize1": "100", "BackPrice1": "16", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Curran 4 over Runs Session adv", "LayPrice1": "32", "LaySize1": "100", "BackPrice1": "34", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Thakur 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Thakur 4 over Runs Session adv", "LayPrice1": "33", "LaySize1": "100", "BackPrice1": "35", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Dwayne Bravo 2 over Runs Session adv", "LayPrice1": "14", "LaySize1": "100", "BackPrice1": "16", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Dwayne Bravo 4 over Runs Session adv", "LayPrice1": "31", "LaySize1": "100", "BackPrice1": "33", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "R Jadeja 2 over Runs Session adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "15", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "R Jadeja 4 over Runs Session adv", "LayPrice1": "30", "LaySize1": "100", "BackPrice1": "32", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Wkts KKR adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Extras KKR adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Dot balls KKR adv", "LayPrice1": "22", "LaySize1": "100", "BackPrice1": "24", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 1 runs KKR adv", "LayPrice1": "22", "LaySize1": "100", "BackPrice1": "24", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 2 runs KKR adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Fours KKR adv", "LayPrice1": "7", "LaySize1": "100", "BackPrice1": "8", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Sixes KKR adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Wkts KKR adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Extras KKR adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Dot balls KKR adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 1 runs KKR adv", "LayPrice1": "26", "LaySize1": "100", "BackPrice1": "28", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 2 runs KKR adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Fours KKR adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Sixes KKR adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Wkts KKR adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Extras KKR adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Dot balls KKR adv", "LayPrice1": "34", "LaySize1": "100", "BackPrice1": "36", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 1 runs KKR adv", "LayPrice1": "48", "LaySize1": "100", "BackPrice1": "50", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 2 runs KKR adv", "LayPrice1": "9", "LaySize1": "100", "BackPrice1": "10", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Fours KKR adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Sixes KKR adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Wkts CSK adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Extras CSK adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Dot balls CSK adv", "LayPrice1": "21", "LaySize1": "100", "BackPrice1": "23", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 1 runs CSK adv", "LayPrice1": "23", "LaySize1": "100", "BackPrice1": "25", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 2 runs CSK adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Fours CSK adv", "LayPrice1": "7", "LaySize1": "100", "BackPrice1": "8", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Sixes CSK adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Wkts CSK adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Extras CSK adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Dot balls CSK adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 1 runs CSK adv", "LayPrice1": "27", "LaySize1": "100", "BackPrice1": "29", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 2 runs CSK adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Fours CSK adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Sixes CSK adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Wkts CSK adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Extras CSK adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Dot balls CSK adv", "LayPrice1": "34", "LaySize1": "100", "BackPrice1": "36", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 1 runs CSK adv", "LayPrice1": "50", "LaySize1": "100", "BackPrice1": "52", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 2 runs CSK adv", "LayPrice1": "9", "LaySize1": "100", "BackPrice1": "10", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Fours CSK adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Sixes CSK adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}]}';

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);

                    $arr = json_decode($result, true);
                    // dd($arr);
                    $data['odd'] = $arr['t1'][0][1];
                    $data['bookmaker'] = $arr['bookmake'][0]['runners'] ?? '';
                    $data['session'] = $arr['session'] ?? '';
                    $dataArr = array();
                    //          dd($data['odd']);
                    if (!empty($data['odd'])) {
                        foreach ($data['odd'] as $bkey => $bval) {
                            $dataArr['odd'][] = (!empty($bval['RunnerName']) ? $bval['RunnerName'] : '');
                        }
                    }
                    if (!empty($data['session'])) {
                        foreach ($data['session'] as $key => $val) {
                            if (isset($val['RunnerName']) && !empty($val['RunnerName'])) {
                                $arr = explode(' ', $val['RunnerName']);
                                $session = str_replace('.', '', $arr[1]);
                                $dataArr['session'][$session]['TITLE'] = 'OVER_UNDER_' . $session;
                                $dataArr['session'][$session]['TEAMNAME'][] = $val['RunnerName'];
                            }
                        }
                    }
                    if (!isset($dataArr['session'])) {
                        $dataArr['session'] = array();
                    }
                    if (!isset($dataArr['odd'])) {
                        $dataArr['odd'] = array();

                    }
                    return view('frontend.game-list.footbollSingles', compact('sports', 'adminSetting', 'buttonValue', 'delay','dataArr'));
                    break;
                }
        }
    }
}
