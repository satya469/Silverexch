<?php

namespace App\Http\Controllers\Frontend;

use App\ButtonValue;
use App\Games;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Sports;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function gamesextra()
    {
        return view('frontend.norecordfound');
    }
    public function getdata($token)
    {

        $url = 'http://139.177.188.73:3000/getBM?eventId=' . $token;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        //      $result = file_get_contents($url);
        //      $result = '{"market": [{"marketId": "1.30042557", "inplay": false, "totalMatched": null, "totalAvailable": null, "priceStatus": null, "events": [{"SelectionId": "", "RunnerName": "Kolkata Knight Riders", "LayPrice1": "2.08", "LaySize1": "215.83", "LayPrice2": "2.1", "LaySize2": "219.43", "LayPrice3": "2.12", "LaySize3": "3.2", "BackPrice1": "2.04", "BackSize1": "210.07", "BackPrice2": "2.02", "BackSize2": "550", "BackPrice3": "1.96", "BackSize3": "83.2"}, {"SelectionId": "", "RunnerName": "Chennai Super Kings", "LayPrice1": "1.95", "LaySize1": "8.99", "LayPrice2": "1.96", "LaySize2": "195.13", "LayPrice3": "1.97", "LaySize3": "14.5", "BackPrice1": "1.94", "BackSize1": "9.78", "BackPrice2": "1.93", "BackSize2": "213.31", "BackPrice3": "1.92", "BackSize3": "249.51"}]}], "bookmake": [{"runners": [{"SelectionId": "", "RunnerName": "Kolkata Knight Riders", "LayPrice1": "0", "LaySize1": "0", "LayPrice2": "0", "LaySize2": "0", "LayPrice3": "0", "LaySize3": "0", "BackPrice1": "0", "BackSize1": "0", "BackPrice2": "0", "BackSize2": "0", "BackPrice3": "0", "BackSize3": "0"}, {"SelectionId": "", "RunnerName": "Chennai Super Kings", "LayPrice1": "96", "LaySize1": "100", "LayPrice2": "0", "LaySize2": "0", "LayPrice3": "0", "LaySize3": "0", "BackPrice1": "92", "BackSize1": "100", "BackPrice2": "0", "BackSize2": "0", "BackPrice3": "0", "BackSize3": "0"}]}], "session": [{"SelectionId": "", "RunnerName": "Match 1st over run(KKR vs CSK)adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "6 over runs KKR(KKR vs CSK)adv", "LayPrice1": "46", "LaySize1": "100", "BackPrice1": "48", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "6 over runs CSK(KKR vs CSK)adv", "LayPrice1": "46", "LaySize1": "100", "BackPrice1": "48", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "20 over runs KKR(KKR vs CSK)adv", "LayPrice1": "165", "LaySize1": "100", "BackPrice1": "167", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "20 over runs CSK(KKR vs CSK)adv", "LayPrice1": "167", "LaySize1": "100", "BackPrice1": "169", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Fall of 1st wkt KKR(KKR vs CSK)adv", "LayPrice1": "23", "LaySize1": "110", "BackPrice1": "23", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Fall of 1st wkt CSK(KKR vs CSK)adv", "LayPrice1": "23", "LaySize1": "110", "BackPrice1": "23", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Gill run(KKR vs CSK)adv", "LayPrice1": "26", "LaySize1": "110", "BackPrice1": "26", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine run(KKR vs CSK)adv", "LayPrice1": "16", "LaySize1": "110", "BackPrice1": "16", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "F du Plessis run(KKR vs CSK)adv", "LayPrice1": "25", "LaySize1": "110", "BackPrice1": "25", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Watson run(KKR vs CSK)adv", "LayPrice1": "20", "LaySize1": "110", "BackPrice1": "20", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Gill Boundaries(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine Boundaries(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "115", "BackPrice1": "3", "BackSize1": "85", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "F du Plessis Boundaries(KKR vs CSK)adv", "LayPrice1": "4", "LaySize1": "115", "BackPrice1": "4", "BackSize1": "85", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Watson Boundaries(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "How many balls for 50 runs KKR(KKR vs CSK)adv", "LayPrice1": "38", "LaySize1": "100", "BackPrice1": "40", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "How many balls for 50 runs CSK(KKR vs CSK)adv", "LayPrice1": "38", "LaySize1": "100", "BackPrice1": "40", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Fours(KKR vs CSK)adv", "LayPrice1": "25", "LaySize1": "100", "BackPrice1": "27", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Sixes(KKR vs CSK)adv", "LayPrice1": "11", "LaySize1": "100", "BackPrice1": "12", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Boundaries(KKR vs CSK)adv", "LayPrice1": "36", "LaySize1": "100", "BackPrice1": "38", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Wkts(KKR vs CSK)adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "13", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Wides(KKR vs CSK)adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Extras(KKR vs CSK)adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Caught Outs(KKR vs CSK)adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Bowled(KKR vs CSK)adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match LBW(KKR vs CSK)adv", "LayPrice1": "1", "LaySize1": "100", "BackPrice1": "2", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Fifties(KKR vs CSK)adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Highest Scoring over in match(KKR vs CSK)adv", "LayPrice1": "20", "LaySize1": "100", "BackPrice1": "21", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Top batsman runs in match(KKR vs CSK)adv", "LayPrice1": "66", "LaySize1": "100", "BackPrice1": "68", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "3 wkt or more by bowler in match(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Fours KKR and CSK adv", "LayPrice1": "150", "LaySize1": "100", "BackPrice1": "157", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Sixes KKR and CSK adv", "LayPrice1": "28", "LaySize1": "100", "BackPrice1": "31", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Wkts KKR and CSK adv", "LayPrice1": "32", "LaySize1": "100", "BackPrice1": "37", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Wides KKR and CSK adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Extras KKR and CSK adv", "LayPrice1": "50", "LaySize1": "100", "BackPrice1": "57", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "P Cummins 2 over Runs Session adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "15", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "P Cummins 4 over Runs Session adv", "LayPrice1": "30", "LaySize1": "100", "BackPrice1": "32", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Mavi 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Mavi 4 over Runs Session adv", "LayPrice1": "33", "LaySize1": "100", "BackPrice1": "35", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "V Chakravarthy 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "V Chakravarthy 4 over Runs Session adv", "LayPrice1": "33", "LaySize1": "100", "BackPrice1": "35", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine 2 over Runs Session adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine 4 over Runs Session adv", "LayPrice1": "28", "LaySize1": "100", "BackPrice1": "30", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "A Russell 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "A Russell 4 over Runs Session adv", "LayPrice1": "32", "LaySize1": "100", "BackPrice1": "34", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "D Chahar 2 over Runs Session adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "15", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "D Chahar 4 over Runs Session adv", "LayPrice1": "30", "LaySize1": "100", "BackPrice1": "32", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Curran 2 over Runs Session adv", "LayPrice1": "14", "LaySize1": "100", "BackPrice1": "16", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Curran 4 over Runs Session adv", "LayPrice1": "32", "LaySize1": "100", "BackPrice1": "34", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Thakur 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Thakur 4 over Runs Session adv", "LayPrice1": "33", "LaySize1": "100", "BackPrice1": "35", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Dwayne Bravo 2 over Runs Session adv", "LayPrice1": "14", "LaySize1": "100", "BackPrice1": "16", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Dwayne Bravo 4 over Runs Session adv", "LayPrice1": "31", "LaySize1": "100", "BackPrice1": "33", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "R Jadeja 2 over Runs Session adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "15", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "R Jadeja 4 over Runs Session adv", "LayPrice1": "30", "LaySize1": "100", "BackPrice1": "32", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Wkts KKR adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Extras KKR adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Dot balls KKR adv", "LayPrice1": "22", "LaySize1": "100", "BackPrice1": "24", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 1 runs KKR adv", "LayPrice1": "22", "LaySize1": "100", "BackPrice1": "24", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 2 runs KKR adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Fours KKR adv", "LayPrice1": "7", "LaySize1": "100", "BackPrice1": "8", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Sixes KKR adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Wkts KKR adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Extras KKR adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Dot balls KKR adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 1 runs KKR adv", "LayPrice1": "26", "LaySize1": "100", "BackPrice1": "28", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 2 runs KKR adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Fours KKR adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Sixes KKR adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Wkts KKR adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Extras KKR adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Dot balls KKR adv", "LayPrice1": "34", "LaySize1": "100", "BackPrice1": "36", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 1 runs KKR adv", "LayPrice1": "48", "LaySize1": "100", "BackPrice1": "50", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 2 runs KKR adv", "LayPrice1": "9", "LaySize1": "100", "BackPrice1": "10", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Fours KKR adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Sixes KKR adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Wkts CSK adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Extras CSK adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Dot balls CSK adv", "LayPrice1": "21", "LaySize1": "100", "BackPrice1": "23", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 1 runs CSK adv", "LayPrice1": "23", "LaySize1": "100", "BackPrice1": "25", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 2 runs CSK adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Fours CSK adv", "LayPrice1": "7", "LaySize1": "100", "BackPrice1": "8", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Sixes CSK adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Wkts CSK adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Extras CSK adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Dot balls CSK adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 1 runs CSK adv", "LayPrice1": "27", "LaySize1": "100", "BackPrice1": "29", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 2 runs CSK adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Fours CSK adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Sixes CSK adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Wkts CSK adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Extras CSK adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Dot balls CSK adv", "LayPrice1": "34", "LaySize1": "100", "BackPrice1": "36", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 1 runs CSK adv", "LayPrice1": "50", "LaySize1": "100", "BackPrice1": "52", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 2 runs CSK adv", "LayPrice1": "9", "LaySize1": "100", "BackPrice1": "10", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Fours CSK adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Sixes CSK adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}]}';
        $arr = array();
        if (!empty($result)) {
            $arr = json_decode($result, true);
        }
        // dd($arr);
        if (isset($arr['t1'][0])) {
            $aaa['odd'] = $arr['t1'][0];
        } else {
            $aaa['odd'] = array();
        }

        if (isset($arr['t2'][0])) {
            $aaa['bookmaker'] = $arr['t2'][0];
        } else {
            $aaa['bookmaker'] = array();
        }
        if (isset($arr['t3'])) {
            $aaa['session'] = $arr['t3'];
        }else{
            $aaa['session'] = array();
        }
        // dd($arr['t3']);
//        $aaa['session'] = $arr['session'];

        // $url = 'http://139.177.188.73:3000/getBM?eventId='.$token;
        // $ch = curl_init( $url );
        // curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        // curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        // $SBresult = curl_exec($ch);
        // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // curl_close($ch);
        // if(isset($SBresult) && !empty($SBresult) && $httpCode != 404){
        //     $aaa['SB'] = json_decode($SBresult,true);
        // }

        $sportModel = Sports::where(['match_id' => $token, 'active' => 1])->first();
        $aaa['matchDeclear'] = false;
        if (isset($sportModel->winner) && $sportModel->winner !== '') {
            $aaa['matchDeclear'] = true;
        } else {
            $aaa['matchDeclear'] = false;
        }
        // dd($sportModel->id);
        $aaa['matchSuspended'] = MyBetsController::getMatchSuspended($sportModel->id);

        // dd($data);
        return json_encode($aaa);
    }

    public function getdatatennis($token)
    {

        $url = 'http://65.1.65.188:3000/getdata/' . $token;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
//      $result = file_get_contents($url);
        //      $result = '{"market": [{"marketId": "1.30042557", "inplay": false, "totalMatched": null, "totalAvailable": null, "priceStatus": null, "events": [{"SelectionId": "", "RunnerName": "Kolkata Knight Riders", "LayPrice1": "2.08", "LaySize1": "215.83", "LayPrice2": "2.1", "LaySize2": "219.43", "LayPrice3": "2.12", "LaySize3": "3.2", "BackPrice1": "2.04", "BackSize1": "210.07", "BackPrice2": "2.02", "BackSize2": "550", "BackPrice3": "1.96", "BackSize3": "83.2"}, {"SelectionId": "", "RunnerName": "Chennai Super Kings", "LayPrice1": "1.95", "LaySize1": "8.99", "LayPrice2": "1.96", "LaySize2": "195.13", "LayPrice3": "1.97", "LaySize3": "14.5", "BackPrice1": "1.94", "BackSize1": "9.78", "BackPrice2": "1.93", "BackSize2": "213.31", "BackPrice3": "1.92", "BackSize3": "249.51"}]}], "bookmake": [{"runners": [{"SelectionId": "", "RunnerName": "Kolkata Knight Riders", "LayPrice1": "0", "LaySize1": "0", "LayPrice2": "0", "LaySize2": "0", "LayPrice3": "0", "LaySize3": "0", "BackPrice1": "0", "BackSize1": "0", "BackPrice2": "0", "BackSize2": "0", "BackPrice3": "0", "BackSize3": "0"}, {"SelectionId": "", "RunnerName": "Chennai Super Kings", "LayPrice1": "96", "LaySize1": "100", "LayPrice2": "0", "LaySize2": "0", "LayPrice3": "0", "LaySize3": "0", "BackPrice1": "92", "BackSize1": "100", "BackPrice2": "0", "BackSize2": "0", "BackPrice3": "0", "BackSize3": "0"}]}], "session": [{"SelectionId": "", "RunnerName": "Match 1st over run(KKR vs CSK)adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "6 over runs KKR(KKR vs CSK)adv", "LayPrice1": "46", "LaySize1": "100", "BackPrice1": "48", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "6 over runs CSK(KKR vs CSK)adv", "LayPrice1": "46", "LaySize1": "100", "BackPrice1": "48", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "20 over runs KKR(KKR vs CSK)adv", "LayPrice1": "165", "LaySize1": "100", "BackPrice1": "167", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "20 over runs CSK(KKR vs CSK)adv", "LayPrice1": "167", "LaySize1": "100", "BackPrice1": "169", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Fall of 1st wkt KKR(KKR vs CSK)adv", "LayPrice1": "23", "LaySize1": "110", "BackPrice1": "23", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Fall of 1st wkt CSK(KKR vs CSK)adv", "LayPrice1": "23", "LaySize1": "110", "BackPrice1": "23", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Gill run(KKR vs CSK)adv", "LayPrice1": "26", "LaySize1": "110", "BackPrice1": "26", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine run(KKR vs CSK)adv", "LayPrice1": "16", "LaySize1": "110", "BackPrice1": "16", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "F du Plessis run(KKR vs CSK)adv", "LayPrice1": "25", "LaySize1": "110", "BackPrice1": "25", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Watson run(KKR vs CSK)adv", "LayPrice1": "20", "LaySize1": "110", "BackPrice1": "20", "BackSize1": "90", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Gill Boundaries(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine Boundaries(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "115", "BackPrice1": "3", "BackSize1": "85", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "F du Plessis Boundaries(KKR vs CSK)adv", "LayPrice1": "4", "LaySize1": "115", "BackPrice1": "4", "BackSize1": "85", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Watson Boundaries(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "How many balls for 50 runs KKR(KKR vs CSK)adv", "LayPrice1": "38", "LaySize1": "100", "BackPrice1": "40", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "How many balls for 50 runs CSK(KKR vs CSK)adv", "LayPrice1": "38", "LaySize1": "100", "BackPrice1": "40", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Fours(KKR vs CSK)adv", "LayPrice1": "25", "LaySize1": "100", "BackPrice1": "27", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Sixes(KKR vs CSK)adv", "LayPrice1": "11", "LaySize1": "100", "BackPrice1": "12", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Boundaries(KKR vs CSK)adv", "LayPrice1": "36", "LaySize1": "100", "BackPrice1": "38", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Wkts(KKR vs CSK)adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "13", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Wides(KKR vs CSK)adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Extras(KKR vs CSK)adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Caught Outs(KKR vs CSK)adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Bowled(KKR vs CSK)adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match LBW(KKR vs CSK)adv", "LayPrice1": "1", "LaySize1": "100", "BackPrice1": "2", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Total match Fifties(KKR vs CSK)adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Highest Scoring over in match(KKR vs CSK)adv", "LayPrice1": "20", "LaySize1": "100", "BackPrice1": "21", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Top batsman runs in match(KKR vs CSK)adv", "LayPrice1": "66", "LaySize1": "100", "BackPrice1": "68", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "3 wkt or more by bowler in match(KKR vs CSK)adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Fours KKR and CSK adv", "LayPrice1": "150", "LaySize1": "100", "BackPrice1": "157", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Sixes KKR and CSK adv", "LayPrice1": "28", "LaySize1": "100", "BackPrice1": "31", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Wkts KKR and CSK adv", "LayPrice1": "32", "LaySize1": "100", "BackPrice1": "37", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Wides KKR and CSK adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Multiplication of Total Extras KKR and CSK adv", "LayPrice1": "50", "LaySize1": "100", "BackPrice1": "57", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "P Cummins 2 over Runs Session adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "15", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "P Cummins 4 over Runs Session adv", "LayPrice1": "30", "LaySize1": "100", "BackPrice1": "32", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Mavi 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Mavi 4 over Runs Session adv", "LayPrice1": "33", "LaySize1": "100", "BackPrice1": "35", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "V Chakravarthy 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "V Chakravarthy 4 over Runs Session adv", "LayPrice1": "33", "LaySize1": "100", "BackPrice1": "35", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine 2 over Runs Session adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Narine 4 over Runs Session adv", "LayPrice1": "28", "LaySize1": "100", "BackPrice1": "30", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "A Russell 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "A Russell 4 over Runs Session adv", "LayPrice1": "32", "LaySize1": "100", "BackPrice1": "34", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "D Chahar 2 over Runs Session adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "15", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "D Chahar 4 over Runs Session adv", "LayPrice1": "30", "LaySize1": "100", "BackPrice1": "32", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Curran 2 over Runs Session adv", "LayPrice1": "14", "LaySize1": "100", "BackPrice1": "16", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Curran 4 over Runs Session adv", "LayPrice1": "32", "LaySize1": "100", "BackPrice1": "34", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Thakur 2 over Runs Session adv", "LayPrice1": "15", "LaySize1": "100", "BackPrice1": "17", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "S Thakur 4 over Runs Session adv", "LayPrice1": "33", "LaySize1": "100", "BackPrice1": "35", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Dwayne Bravo 2 over Runs Session adv", "LayPrice1": "14", "LaySize1": "100", "BackPrice1": "16", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Dwayne Bravo 4 over Runs Session adv", "LayPrice1": "31", "LaySize1": "100", "BackPrice1": "33", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "R Jadeja 2 over Runs Session adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "15", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "R Jadeja 4 over Runs Session adv", "LayPrice1": "30", "LaySize1": "100", "BackPrice1": "32", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Wkts KKR adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Extras KKR adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Dot balls KKR adv", "LayPrice1": "22", "LaySize1": "100", "BackPrice1": "24", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 1 runs KKR adv", "LayPrice1": "22", "LaySize1": "100", "BackPrice1": "24", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 2 runs KKR adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Fours KKR adv", "LayPrice1": "7", "LaySize1": "100", "BackPrice1": "8", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Sixes KKR adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Wkts KKR adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Extras KKR adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Dot balls KKR adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 1 runs KKR adv", "LayPrice1": "26", "LaySize1": "100", "BackPrice1": "28", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 2 runs KKR adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Fours KKR adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Sixes KKR adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Wkts KKR adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Extras KKR adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Dot balls KKR adv", "LayPrice1": "34", "LaySize1": "100", "BackPrice1": "36", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 1 runs KKR adv", "LayPrice1": "48", "LaySize1": "100", "BackPrice1": "50", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 2 runs KKR adv", "LayPrice1": "9", "LaySize1": "100", "BackPrice1": "10", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Fours KKR adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Sixes KKR adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Wkts CSK adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Extras CSK adv", "LayPrice1": "3", "LaySize1": "100", "BackPrice1": "4", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Dot balls CSK adv", "LayPrice1": "21", "LaySize1": "100", "BackPrice1": "23", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 1 runs CSK adv", "LayPrice1": "23", "LaySize1": "100", "BackPrice1": "25", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total 2 runs CSK adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Fours CSK adv", "LayPrice1": "7", "LaySize1": "100", "BackPrice1": "8", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 10 overs Total Sixes CSK adv", "LayPrice1": "2", "LaySize1": "100", "BackPrice1": "3", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Wkts CSK adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Extras CSK adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Dot balls CSK adv", "LayPrice1": "12", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 1 runs CSK adv", "LayPrice1": "27", "LaySize1": "100", "BackPrice1": "29", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total 2 runs CSK adv", "LayPrice1": "5", "LaySize1": "100", "BackPrice1": "6", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Fours CSK adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 11 to 20 overs Total Sixes CSK adv", "LayPrice1": "4", "LaySize1": "100", "BackPrice1": "5", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Wkts CSK adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Extras CSK adv", "LayPrice1": "8", "LaySize1": "100", "BackPrice1": "9", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Dot balls CSK adv", "LayPrice1": "34", "LaySize1": "100", "BackPrice1": "36", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 1 runs CSK adv", "LayPrice1": "50", "LaySize1": "100", "BackPrice1": "52", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total 2 runs CSK adv", "LayPrice1": "9", "LaySize1": "100", "BackPrice1": "10", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Fours CSK adv", "LayPrice1": "13", "LaySize1": "100", "BackPrice1": "14", "BackSize1": "100", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "1st Inn 0 to 20 overs Total Sixes CSK adv", "LayPrice1": "6", "LaySize1": "100", "BackPrice1": "7", "BackSize1": "100", "GameStatus": ""}]}';

        //   dd($arr);
        $aaa=[];
        if (!empty($result)) {
            $arr = json_decode($result, true);

            $aaa['odd'] = $arr['t1'][0];

            $aaa['bookmaker'] = $arr['t2'][0]['bm1'] ?? '';
            $aaa['session'] = $arr['t3'] ?? '';
        }
            $sportModel = Sports::where(['match_id' => $token, 'active' => 1])->first();
            $aaa['matchDeclear'] = false;
            if (!empty($sportModel->winner)) {
                $aaa['matchDeclear'] = true;
            }
            $aaa['matchSuspended'] = MyBetsController::getMatchSuspended($sportModel->id);

        return json_encode($aaa);
    }
    public function getdatasoccer($token)
    {
        // $result = [];
        $url = "http://65.1.65.188:3000/getdata/$token";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

//      $result = '{"market": [{"marketId": "1.30165965", "inplay": false, "totalMatched": null, "totalAvailable": null, "priceStatus": null, "events": [{"SelectionId": "", "RunnerName": "Seattle Sounders", "LayPrice1": "1.72", "LaySize1": "68.99", "LayPrice2": "1.73", "LaySize2": "35.51", "LayPrice3": "1.74", "LaySize3": "11.25", "BackPrice1": "1.69", "BackSize1": "19", "BackPrice2": "1.68", "BackSize2": "11.87", "BackPrice3": "1.67", "BackSize3": "422.15"}, {"SelectionId": "", "RunnerName": "Minnesota Utd", "LayPrice1": "5.4", "LaySize1": "201.35", "LayPrice2": "5.5", "LaySize2": "6.62", "LayPrice3": "5.6", "LaySize3": "8.48", "BackPrice1": "5.1", "BackSize1": "10.97", "BackPrice2": "5", "BackSize2": "11.77", "BackPrice3": "4.9", "BackSize3": "72.98"}, {"SelectionId": "", "RunnerName": "The Draw", "LayPrice1": "4.6", "LaySize1": "10.23", "LayPrice2": "4.7", "LaySize2": "195.28", "LayPrice3": "4.8", "LaySize3": "22.31", "BackPrice1": "4.5", "BackSize1": "14.46", "BackPrice2": "4.4", "BackSize2": "36.29", "BackPrice3": "4.3", "BackSize3": "71.87"}]}], "bookmake": [{"runners": [{"SelectionId": "", "RunnerName": "", "LayPrice1": "0", "LaySize1": "0", "LayPrice2": "0", "LaySize2": "0", "LayPrice3": "0", "LaySize3": "0", "BackPrice1": "0", "BackSize1": "0", "BackPrice2": "0", "BackSize2": "0", "BackPrice3": "0", "BackSize3": "0"}, {"SelectionId": "", "RunnerName": "", "LayPrice1": "0", "LaySize1": "0", "LayPrice2": "0", "LaySize2": "0", "LayPrice3": "0", "LaySize3": "0", "BackPrice1": "0", "BackSize1": "0", "BackPrice2": "0", "BackSize2": "0", "BackPrice3": "0", "BackSize3": "0"}, {"SelectionId": "", "RunnerName": "", "LayPrice1": "0", "LaySize1": "0", "LayPrice2": "0", "LaySize2": "0", "LayPrice3": "0", "LaySize3": "0", "BackPrice1": "0", "BackSize1": "0", "BackPrice2": "0", "BackSize2": "0", "BackPrice3": "0", "BackSize3": "0"}]}], "session": [{"SelectionId": "", "RunnerName": "Under 1.5 Goals", "LayPrice1": "6.4", "LaySize1": "6.94", "LayPrice2": "6.6", "LaySize2": "6.67", "LayPrice3": "7", "LaySize3": "24.95", "BackPrice1": "5.1", "BackSize1": "1.99", "BackPrice2": "4.8", "BackSize2": "13.07", "BackPrice3": "3.5", "BackSize3": "1.15", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Over 1.5 Goals", "LayPrice1": "1.25", "LaySize1": "10.1", "LayPrice2": "1.27", "LaySize2": "47.51", "LayPrice3": "1.33", "LaySize3": "2.5", "BackPrice1": "1.19", "BackSize1": "37.32", "BackPrice2": "1.18", "BackSize2": "37.32", "BackPrice3": "1.17", "BackSize3": "149.28", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Under 0.5 Goals", "LayPrice1": "26", "LaySize1": "93.87", "LayPrice2": "36", "LaySize2": "78.21", "LayPrice3": "55", "LaySize3": "1.51", "BackPrice1": "21", "BackSize1": "3.78", "BackPrice2": "16.5", "BackSize2": "10", "BackPrice3": "3.4", "BackSize3": "2.7", "GameStatus": ""}, {"SelectionId": "", "RunnerName": "Over 0.5 Goals", "LayPrice1": "1.05", "LaySize1": "75.57", "LayPrice2": "1.07", "LaySize2": "155.68", "LayPrice3": "1.42", "LaySize3": "6.2", "BackPrice1": "1.04", "BackSize1": "2.3K", "BackPrice2": "1.03", "BackSize2": "2.7K", "BackPrice3": "1.02", "BackSize3": "81.43", "GameStatus": ""}]}';

        if (!empty($result)) {

            $arr = json_decode($result, true);
            $aaa['odd'] = $arr['t1'][0];
            $aaa['bookmaker'] = $arr['t2'];
            $aaa['session'] = $arr['t3'];
        }


        $sportModel = Sports::where(['match_id' => $token, 'active' => 1])->first();
        $aaa['matchDeclear'] = false;
        if (!empty($sportModel->winner)) {
            $aaa['matchDeclear'] = true;
        }
        $aaa['matchSuspended'] = MyBetsController::getMatchSuspended($sportModel->id);
        return json_encode($aaa);
    }
    public function userchangepassword()
    {
        return view('frontend.changepassword');
    }

    public function userchangepasswordstore(Request $request)
    {

        $requestData = $request->all();
        $userId = Auth::user()->id;

        $m_pwd = $requestData['old_password'];
        $user = User::find($userId);
        if (!Hash::check($m_pwd, $user->password)) {
            return redirect()->route('frontend.userchangepassword')->withFlashSuccess('old Password Wrong');
        }

        if ($requestData['new_password'] != $requestData['c_password']) {
            return redirect()->route('frontend.userchangepassword')->withFlashSuccess('Password Not Match');
        }
        $model = User::where(['id' => $userId])->first();
        $model->password = Hash::make($requestData['new_password']);
        $model->isChangePassParent = '0';
        if ($model->save()) {
            return redirect()->route('frontend.auth.logout')->withFlashSuccess('User Password Updated successfully');
        } else {
            return redirect()->route('frontend.userchangepassword')->withFlashSuccess('User Password Not Updated');
        }
    }

    public function showAdminLoginForm()
    {
        return view('frontend.auth.admin-login');
    }
    public function index()
    {

        $gameModel = Games::where(["name" => "CRICKET", 'status' => 1])->first();
        if (!isset($gameModel->id) || empty($gameModel->id)) {
            $sports = array();
        } else {
            $sports = DB::select("SELECT  * FROM `sports` WHERE game_id='" . $gameModel->id . "' AND active='1' AND (winner ='' OR winner IS NULL)");
        }
        self::setButtonVal(Auth::user()->id);
        return view('frontend.game-list.cricket', compact('sports'));
    }
    public static function setButtonVal($userID)
    {
        $buttonValueModel = ButtonValue::where(['user_id' => $userID])->first();
        if (!isset($buttonValueModel->btnSetting)) {
            $buttonValueModel = new ButtonValue();
            $buttonValueModel->user_id = $userID;
            $buttonValueModel->btnSetting = '{"label":["1000","2000","3000","4000","5000","6000","7000","8000","9000","10000"],"price":["1000","2000","3000","4000","5000","6000","7000","8000","9000","10000"]}';
            $buttonValueModel->save();
        } else if (empty($buttonValueModel->btnSetting)) {
            $buttonValueModel->btnSetting = '{"label":["1000","2000","3000","4000","5000","6000","7000","8000","9000","10000"],"price":["1000","2000","3000","4000","5000","6000","7000","8000","9000","10000"]}';
            $buttonValueModel->save();
        }
    }
    public function cricket()
    {
        return view('frontend.game-list.cricket');
    }
    public function singles($token)
    {
//      return view('frontend.game-list.singles');
        //      return view('frontend.game-list.tennisSingles');

        return view('frontend.game-list.footbollSingles');
    }
    public function changebtnvalue()
    {

        $model = ButtonValue::where('user_id', Auth::user()->id)->first();
        if (!$model) {
            $array = array(
                'label' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
                'price' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            );
            $model = new ButtonValue();
            $model->user_id = Auth::user()->id;

            $model->btnSetting = json_encode($array);
            $model->save();
        }

        $setting = json_decode($model->btnSetting, true);
//      ddd($setting);
        return view('frontend.button-value.create', compact('setting'));
    }

    public function btnvaluestore(Request $request)
    {
        $returnArr = array();
        $returnArr['status'] = false;
        $returnArr['message'] = 'Enter required values';

        $model = ButtonValue::where(['user_id' => Auth::user()->id])->first();
        if (!$model) {
            $model = new ButtonValue();
        }
        $model->user_id = Auth::user()->id;
        $model->btnSetting = json_encode($request->input('btnSetting'));
        if ($model->save()) {
            $returnArr['status'] = true;
            $returnArr['message'] = 'Successfully updated!';
        }
        die(json_encode($returnArr));
    }
    public function changepassword()
    {
        return view('frontend.button-value.change-password');
    }
    public function pwStore(Request $request)
    {
        $this->validate($request, [
            'oldpassword' => 'required',
            'newpassword' => 'required',
        ]);
        $resp = array();
        $hashedPassword = Auth::user()->password;

        if (\Hash::check($request->oldpassword, $hashedPassword)) {

            if (!\Hash::check($request->newpassword, $hashedPassword)) {

                $users = \App\Models\Auth\User::find(Auth::user()->id);
                $users->password = bcrypt($request->newpassword);
                \App\Models\Auth\User::where('id', Auth::user()->id)->update(array('password' => $users->password));
                $resp['status'] = true;
                $resp['message'] = 'password updated successfully';

            } else {
                $resp['status'] = false;
                $resp['message'] = 'new password can not be the old password!';
            }

        } else {
            $resp['status'] = false;
            $resp['message'] = 'old password doesnt matched';
        }
        die(json_encode($resp));
    }
    public static function getActiveStatus($userID)
    {
        $userModel = User::find($userID);
        if ($userModel->active == 0) {
            return true;
        }
        if ($userModel->parent_id != 0) {
            $data = self::getActiveStatus($userModel->parent_id);
            if ($data) {
                return true;
            }
        }
        return false;
    }

    public function getRules(Request $request)
    {
        $type = $request->input('type');
        switch ($type) {
            case 'ODDS':{
                    $html = '<div class="container-fluid">
                      <div data-typeid="" class="row rules-container">
                        <!---->
                        <div class="col nopading rules-description">
                          <div class="card">
                            <div class="card-header">
                              <h4 class="card-title">Match</h4>
                            </div>
                            <div class="card-body">
                              <table class="table table-bordered">
                                <tr class="norecordsfound">
                                  <td class="text-center">No records Found</td>
                                </tr>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>';
                    break;
                }
            case 'BOOKMAKER':{
                    $html = '<div class="container-fluid">
                    <div data-typeid="" class="row rules-container">
                      <!---->
                      <div class="col nopading rules-description">
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title">Bookmaker</h4>
                          </div>
                          <div class="card-body">
                            <table class="table table-bordered">
                              <tbody>
                                <tr>
                                  <td><span class="text-danger">Due to any reason any team will be getting advantage or disadvantage we are not concerned.</span></td>
                                </tr>
                                <tr>
                                  <td><span class="text-danger">We will simply compare both teams 25 overs score higher score team will be declared winner in ODI (25 over comparison)</span></td>
                                </tr>
                                <tr>
                                  <td><span class="text-danger">We will simply compare both teams 10 overs higher score team will be declared winner in T20 matches (10 over comparison)</span></td>
                                </tr>
                                <tr>
                                  <td><span class="text-danger">Any query about the result or rates should be contacted within 7 days of the specific event, the same will not be considered valid post 7 days from the event.</span></td>
                                </tr>
                                <tr>
                                  <td><span class="">Football-Spain LaLiga winner 2019-2020 without Barcelona &amp; Real Madrid</span></td>
                                </tr>
                                <tr>
                                  <td><span class="text-danger">Highest point scoring team in the league table excluding Barcelona &amp; Real Madrid will be considered as winner of this event</span></td>
                                </tr>
                                <tr>
                                  <td><span class="text-danger">If two team ends up with equal points, then result will be given based on the official point table</span></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>';
                    break;
                }
            case 'SESSION':{
                    $html = '<div class="container-fluid">
            <div data-typeid="" class="row rules-container">
              <!---->
              <div class="col nopading rules-description">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Fancy</h4>
                  </div>
                  <div class="card-body">
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <td><span class="text-danger">1. All fancy bets will be validated when match has been tied.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">2. All advance fancy will be suspended before toss or weather condition.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">3. In case technical error or any circumstances any fancy is suspended and does not resume result will be given all
                            previous bets will be valid (based on haar/jeet).</span>
                          </td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">4. If any case wrong rate has been given in fancy that particular bets will be cancelled.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">5. In any circumstances management decision will be final related to all exchange items. Our scorecard will be considered as valid if there is any mismatch in online portal</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">6. In case customer make bets in wrong fancy we are not liable to delete, no changes will be made and bets will be consider as confirm bet.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">7. Due to any technical error market is open and result has came all bets after result will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">8. Manual bets are not accepted in our exchange</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">9.Our exchange will provide 5 second delay in our tv.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">10. Company reserves the right to suspend/void any id/bets if the same is found to be illegitimate. For example incase of vpn/robot-use/multiple entry from same IP and others. Note : only winning bets will be voided</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">11. Once our exchange give username and password it is your responsibility to change a
                            password.</span>
                          </td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">12. Penalty runs will not be counted in any fancy.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">13. Warning:- live scores and other data on this site is sourced from third party feeds and may be subject to time delays and/or be inaccurate. If you rely on this data to place bets, you do so at your own risk. Our exchange does not accept responsibility for loss suffered as a result of reliance on this data.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">14. Our exchange is not responsible for misuse of client id.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Test</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">1 Session:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">1.1 Complete session valid in test.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">1.2 Session is not completed for ex:- India 60 over run session Ind is running in case India team declares or all-out at 55 over next 5 over session will be continue in England inning.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">1.3 1st day 1st session run minimum 25 over  will be played then result is given otherwise 1st day 1st session will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">1.4 1st day 2nd session run minimum 25 over  will be played then result is given otherwise 1st day 2nd session will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">1.5 1st day total run minimum 80 over  will be played then result is given otherwise 1st day total run will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">1.6 Test match both advance session is valid.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">2 Test lambi/ Inning run:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">2.1 Mandatory 70 over played in test lambi paari/ Innings run. If any team all-out or declaration lambi paari/ innings run is valid.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">2.2 In case due to weather situation match has been stopped all lambi trades will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">2.3 In test both lambi paari / inning run is valid in advance fancy.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">3 Test batsman:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">3.1 In case batsmen is injured he/she is made 34 runs the result will be given 34 runs.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">3.2 Batsman 50/100 run if batsman is injured or declaration the result will be given on particular run.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">3.3 In next men out fancy if player is injured particular fancy will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">3.4 In advance fancy opening batsmen is only valid if same batsmen came in opening the fancy will be valid in case one batsmen is changed that particular player fancy will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">3.5 Test match both advance fancy batsmen run is valid.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">4 Test partnership:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">4.1 In partnership one batsman is injured partnership is continued in next batsman.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">4.2 Partnership and player runs due to weather condition or match abandoned the result will be given as per score.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">4.3 Advance partnership is valid in case both players are different or same.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">4.4 Test match both advance fancy partnership is valid.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">5 Other fancy advance (test):-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">5.1 Four, sixes, wide, wicket,  extra run, total run, highest over and top batsmen is valid only if 300 overs has been played or the match has been won by any team otherwise all these fancy will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">2 Odi rule:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Session:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Match 1st over run advance fancy only 1st innings run will be counted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Complete session is valid in case due to rain or match abandoned particular session will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">For example:- 35 over run team a is playing any case team A  is all-out in 33 over team a has made 150 run the session result is validated on particular run.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Advance session is valid in only 1st innings.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">50 over runs:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">In case 50 over is not completed all bet will be deleted due to weather or any condition.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Advance 50 over runs is valid in only 1st innings.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Odi batsman runs:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">In case batsman is injured he/she is made 34 runs the result will be given 34 runs.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">In next men out fancy if player is injured particular fancy will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">In advance fancy opening batsmen is only valid if same batsmen came in opening the fancy will be valid in case one batsmen is changed that particular player fancy will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Odi partnership runs:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">In partnership one batsman is injured partnership is continued in next batsman.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Advance partnership is valid in case both players are different or same.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Both team advance partnerships are valid in particular match.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Other fancy:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Four, sixes, wide, wicket, extra run, total run, highest over ,top batsman,maiden over,caught-out,no-ball,run-out,fifty and century are valid only match has been completed in case due to rain over has been reduced all other fancy will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">T20:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Session:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Match 1st over run advance fancy only 1st innings run will be counted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Complete session is valid in case due to rain or match abandoned particular session will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">For example :- 15 over run team a is playing any case team a  is all-out in 13 over team A has made 100 run the session result is validated on particular run.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Advance session is valid in only 1st innings.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">20 over runs:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Advance 20 over run is valid only in 1st innings. 20 over run will not be considered as valid if 20 overs is not completed due to any situation</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">T20 batsman runs:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">In case batsman is injured he/she is made 34 runs the result will be given 34 runs.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">In next men out fancy if player is injured particular fancy will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">In advance fancy opening batsmen is only valid if same batsmen came in opening the fancy will be valid in case one batsmen is changed that particular player fancy will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">T20 partnership runs:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">In partnership one batsman is injured partnership is continued in next batsman.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Advance partnership is valid in case both players are different or same.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Both team advance partnerships are valid in particular match.
                            1st 3 wkt runs:-
                            Advance 1st 3 wkt runs is valid in only 1st Innings</span>
                          </td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Other fancy:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">T-20 ,one day and test match in case current innings player and partnership are running in between match has been called off or abandoned that situation all current player and partnership results are valid.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Four, sixes, wide, wicket, extra run, total run, highest over and top batsman,maiden over,caught-out,no-ball,run-out,fifty and century are valid only match has been completed in case due to rain over has been reduced all other fancy will be deleted.
                            1st 6 over dot ball and  20 over dot ball fancy only valid is 1st innings.</span>
                          </td>
                        </tr>
                        <tr>
                          <td><span class="">Lowest scoring over will be considered valid only if the over is completed fully (all six deliveries has to be bowled)</span></td>
                        </tr>
                        <tr>
                          <td><span class="">1st wicket lost to any team balls meaning that any team 1st wicket fall down in how many balls that particular fancy at least minimum one ball have to be played otherwise bets will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">1st wicket lost to any team fancy valid both innings.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">How many balls for 50 runs any team meaning that any team achieved 50 runs in how many balls that particular fancy at least one ball have to be played otherwise that fancy bets will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">How many balls for 50 runs fancy any team only first inning valid.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">1st 6 inning boundaries runs any team fancy will be counting only according to run scored fours and sixes at least 6 over must be played otherwise that fancy will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">1st inning 6 over boundaries runs any team run like wide ,no-ball ,leg-byes ,byes and over throw runs are not counted this fancy.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">How many balls face any batsman meaning that any batsman how many balls he/she played that particular fancy at least one ball have to be played otherwise that fancy bets will be deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">How many balls face by any batsman both innings valid.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Concussion in Test:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">All bets of one over session will be deleted in test scenario, in case session is incomplete. For example innings declared or match suspended to bad light or any other conditions.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">1. All bets will be considered as valid if a player has been replaced under concussion substitute, result will be given for the runs scored by the mentioned player. For example DM Bravo gets retired hurt at 23 runs, then result will be given for 23.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">2. Bets of both the player will be valid under concussion substitute.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Total Match- Events (test):-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Minimum of 300 overs to be bowled in the entire test match, otherwise all bets related to the particular event will get void. For example, Total match caught outs will be valid only if 300 overs been bowled in the particular test match</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Limited over events-Test:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">This event will be considered valid only if the number of overs defined on the particular event has been bowled, otherwise all bets related to this event will get void. For example 0-25 over events will be valid only if 25 overs has been bowled, else the same will not be considered as valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="">If the team gets all out prior to any of the defined overs, then balance overs will be counted in next innings. For example if the team gets all out in 23.1 over the same will be considered as 24 overs and the balance overs will be counted from next innings.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Bowler Wicket event`s- Test:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Minimum of one legal over (one complete over) has to be bowled by the bowler mentioned in the event, else the same will not be considered as valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Bowler over events- Test:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">The mentioned bowler has to complete the defined number of overs, else the bets related to that particular event will get void. For example if the mentioned bowler has bowled 8 overs, then 5 over run of that particular bowler will be considered as valid and the 10 over run will get void</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Player ball event`s- Test:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">This event will be considered valid only if the defined number of runs made by the mentioned player, else the result will be considered as 0 (zero) balls</span></td>
                        </tr>
                        <tr>
                          <td><span class="">For example if Root makes 20 runs in 60 balls and gets out on 22 runs, result for 20 runs will be 60 balls and the result for balls required for 25 run Root will be considered as 0 (Zero) and the same will be given as result</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Limited over events-ODI:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">This event will be considered valid only if the number of overs defined on the particular event has been bowled, otherwise all bets related to this event will get void. 0-50 over events will be valid only if 50 over completed, if the team batting first get all out prior to 50 over the balance over will be counted from second innings. For example if team batting first gets all out in 35 over balance 15 over will be counted from second innings, the same applies for all events if team gets all out before the defined number of overs</span></td>
                        </tr>
                        <tr>
                          <td><span class="">The events which remains incomplete will be voided if over gets reduced in the match due to any situation, for example if match interrupted in 15 overs due to rain/badlight and post this over gets reduced. Events for 0-10 will be valid, all other events related to this type will get deleted.</span></td>
                        </tr>
                        <tr>
                          <td><span class="">This events will be valid only if the defined number of over is completed. For example team batting first gets all out in 29.4 over then the same will be considered as 30 over, the team batting second must complete 20 overs only then 0-50 over events will be considered as valid. In case team batting second gets all out in 19.4 over then 0-50 over event will not be considered as valid, This same is valid for 1st Innings only.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Bowler event- ODI:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">The mentioned bowler has to complete the defined number of overs, else the bets related to that particular event will get void. For example if the mentioned bowler has bowled 8 overs, then 5 over run of that particular bowler will be considered as valid and the 10 over run will get void</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Both innings are valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Other event:- T20</span></td>
                        </tr>
                        <tr>
                          <td><span class="">The events for 1-10 over and 11-20 over will be considered valid only if the number of over mentioned has been played completely. However if the over got reduced before the particular event then the same will be voided,
                            if the team batting first get all out prior to 20 over the balance over will be counted from second innings. For example if team batting first gets all out in 17 over balance 3 over will be counted from second innings.
                            This same is valid for 1st Innings only.</span>
                          </td>
                        </tr>
                        <tr>
                          <td><span class="">If over got reduced in between any running event, then the same will be considered valid and the rest will be voided. For example.., match started and due to rain/bad light or any other situation match got interrupted at 4 over and later over got reduced. Then events for 1-10 is valid rest all will be voided</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Bowler Session: This event is valid only if the bowler has completed his maximum quota of overs, else the same will be voided. However if the match has resulted and the particular bowler has already started bowling his final over then result will be given even if he haven`t completed the over. For example B Kumar is bowling his final over and at 3.4 the match has resulted then result will be given for B Kumar over runs</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Incase of DLS, the over got reduced then the bowler who has already bowled his maximum quota of over that result will be considered as valid and the rest will be voided</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">12. Player and partnership are valid only 14 matches.</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Boundary on Match 1st Free hit</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Both innings are valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Boundary hit on Free hit only be considered as valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Bets will be deleted if there is no Free hit in the mentioned match</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Boundary by bat will be considered as valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Boundaries by Player</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Both Four and six are valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Any query regarding result or rate has to be contacted within 7 days from the event, query after 7 days from the event will not be considered as valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">CPL:-</span></td>
                        </tr>
                        <tr>
                          <td><span class="">If CPL fixture 0f 33 matches gets reduced due to any reason, then all the special fancies will be voided (Match abandoned due to rain/bad light will not be considered in this)</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Fancy based on all individual teams are valid only for league stage</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Total 1st over runs: Average 6 runs will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Total fours: Average 22 fours will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Total sixes: Average 13 sixes will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Total Wickets - Average will 13 Wickets be given in case match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Total Wides - Average 10 wides will be given in case match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Total Extras - Average 18 extras will be given in case match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Total No ball - Average 1 no ball will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Total Fifties - Average 1 fifties will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Total Caught outs: Average 9 caught out will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="">At any situation if result is given for any particular event based on the rates given for the same, then the particular result will be considered valid, similarly if the tournament gets canceled due to any reason the previously given result will be considered valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Management decision will be final</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Highest innings run - Only first innings is valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Lowest innings run - Only first innings is valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Highest over run: Both innings are valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Highest 1st over run in individual match: Both innings are valid, however for CPL we have created the fancy for 1st innings only</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Highest Fours in individual match: Both innings are valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Highest Sixes in individual match: Both innings are valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Highest Extras in individual match: Both innings are valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Highest Wicket in individual match: Both innings are valid</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Super over will not be included</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Barbados Tridents</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Opening partnership run: Average 24 runs will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="">First 6 over run: Average 45 run will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">St Kitts and Nevis Patriots</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Opening partnership run: Average 25 runs will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="">First 6 over run: Average 45 run will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Trinbago Knight Riders</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Opening partnership run: Average 22 runs will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="">First 6 over run: Average 46 run will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Guyana Amazon Warriors</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Opening partnership run: Average 23 runs will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="">First 6 over run: Average 44 run will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">St Lucia Zouks</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Opening partnership run: Average 22 runs will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="">First 6 over run: Average 43 run will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="text-danger">Jamaica Tallawahs</span></td>
                        </tr>
                        <tr>
                          <td><span class="">Opening partnership run: Average 24 runs will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                        <tr>
                          <td><span class="">First 6 over run: Average 46 run will be given in case  match abandoned or over reduced</span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>';
                    break;
                }
        }
        return $html;
    }

}
