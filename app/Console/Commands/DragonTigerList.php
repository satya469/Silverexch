<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Sports;

class DragonTigerList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dragontiger:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert Dragon Tiger List';

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
        //Dragon Tiger List
        $result = '';
        $result = Self::CallAPI('GET', 'http://52.66.42.244/api/codds?id=2595');

        if(!empty($result)){
            $result = json_decode($result,true);
            $match_id = $result[0]['mid'];
            if(!empty($match_id)){
                $res = Sports::where(['roundID' =>$match_id])->get();
                if($res == '[]'){
                    $sportsModel = new Sports();
                    $sportsModel->match_name = 'Dragon Tiger';
                    $sportsModel->match_date_time = '';
                    $sportsModel->roundID = $match_id;
                    $sportsModel->inplay_status = '';
                    $sportsModel->game_id = 4;
                    $sportsModel->active = '1';
                    $sportsModel->save();
                }
            }
            // dd($match_id);
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
