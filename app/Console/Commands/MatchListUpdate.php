<?php

namespace App\Console\Commands;

use App\Sports;
use Illuminate\Console\Command;

class MatchListUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matchlist:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update match list of cricket, soccer,tennis';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Cricket
        $result = '';
        $result = Self::CallAPI('GET', 'http://139.177.188.73:3000/getcricketmatches');
        Self::process_task($result, 1);
   
        // Soccer
        $result = '';
        $result = Self::CallAPI('GET', 'http://139.177.188.73:3000/getsoccermatches');
        Self::process_task($result, 2);

        // Tennis
        $result = '';
        $result = Self::CallAPI('GET', 'http://139.177.188.73:3000/gettennismatches');
        Self::process_task($result, 3);
    }

    public static function process_task($result, $game_id)
    {
        $result = json_decode($result);

        foreach ($result as $key => $value) {

            // $sql = "SELECT * FROM sports WHERE match_id=$value->gameId";
            $res = Sports::where(['match_id' =>$value->gameId])->get();

            if ($res != '[]') {
                // var_dump($res == '[]');die;
                switch ($game_id) {
                    case '1':
                        $result1 = Self::CallAPI('GET', "http://139.177.188.73:3000/getBM?eventId=$value->gameId");
                        // dd($result1);
                        if ($result1 == '[]') {

                            Sports::where('match_id', $value->gameId)->update(['active' => '2']);

                        } else {

                            Sports::where('match_id', $value->gameId)->update(['inplay_status' => $value->inPlay, 'fancy_status' => $value->f]);
                        }

                        break;
                    case '2':
                        $result1 = Self::CallAPI('GET', "http://65.1.65.188:3000/getdata/$value->gameId");
                        if ($result1 == '[]') {

                            Sports::where('match_id', $value->gameId)->update(['active' => '2']);

                        } else {

                            Sports::where('match_id', $value->gameId)->update(['inplay_status' => $value->inPlay, 'fancy_status' => $value->f]);
                        }
                        break;
                    case '3':
                        $result1 = Self::CallAPI('GET', "http://65.1.65.188:3000/getdata/$value->gameId");
                        if ($result1 == '[]') {

                            Sports::where('match_id', $value->gameId)->update(['active' => '2']);

                        } else {

                            Sports::where('match_id', $value->gameId)->update(['inplay_status' => $value->inPlay, 'fancy_status' => $value->f]);
                        }

                        break;

                    default:
                        # code...
                        break;
                }

            } else {

                if(!empty($value->eventName)){
                    $name_date = explode('/', $value->eventName);
                }
                $sportsModel = new Sports();
                $sportsModel->match_name = $name_date[0] ?? '';
                $sportsModel->match_date_time = $name_date[1] ?? '';
                $sportsModel->match_id = $value->gameId;
                $sportsModel->inplay_status = $value->inPlay;
                $sportsModel->game_id = $game_id;
                $sportsModel->active = '1';

                $sportsModel->save();


            }

        }
    }

    public static function CallAPI($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }

                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }

        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

}
