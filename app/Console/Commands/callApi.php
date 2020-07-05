<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;
use Psr\Http\Message\ResponseInterface;


class callApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:callapi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        DB::table('stats')->delete();
        $client = new Client();
        $promise = $client->requestAsync('GET','http://api.rtbravo.com/api/statsv2?token=4eyrn7z923f75admnazufvucvskm3vpyqn4422zc&from=2020-04-21&to=2020-04-25&groupby=day:paid:sid&format=json');
        $promise->then(
            function (ResponseInterface $res) {
                $data = json_decode($res->getBody()->getContents(),true);       
                $time_now = date("Y-m-d");

            foreach (array_chunk($data, 1000) as $responseChunk)
            {
                $insertableArray = [];
                foreach($responseChunk as $value) {
                    $insertableArray[] = [
                        'day'      => $value["day"],
                        'paid'     => $value["paid"],
                        'sid'      => $value["sid"],
                        'requests' => $value["requests"],
                        'bids'     => $value["bids"],
                        'wins'     => $value["wins"],
                        'cost'     => $value["cost"],
                        'created_at' => date($time_now),
                        'updated_at' => date($time_now),
                    ];
                }
                DB::table('stats')->insert($insertableArray);
            }
            },
            function (RequestException $e) {
            }
        )->wait();
        echo "update done";
    }
}
