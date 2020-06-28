<?php

namespace App\Http\Controllers;

use App\Nova\Stats;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use function GuzzleHttp\json_decode;

class StatsController extends Controller
{

    public function getStatsData()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'http://api.rtbravo.com/api/statsv2?token=4eyrn7z923f75admnazufvucvskm3vpyqn4422zc&from=2020-04-21&to=2020-04-25&groupby=day:paid:sid&format=json');
        $data = json_decode($response->getBody()->getContents(),true);       
        $time_now = date("Y-m-d");
        foreach($data as $item)
            {
                DB::table('stats')->insert([
                                            'day'      => $item["day"],
                                            'paid'     => $item["paid"],
                                            'sid'      => $item["sid"],
                                            'requests' => $item["requests"],
                                            'bids'     => $item["bids"],
                                            'wins'     => $item["wins"],
                                            'cost'     => $item["cost"],
                                            'created_at' => date($time_now),
                                            'updated_at' => date($time_now),
                                        ]);
            }
        
    }

}


