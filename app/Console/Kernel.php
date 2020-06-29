<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;

use function GuzzleHttp\json_decode;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\callApi::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('command:callapi')->everyMinute();
        // $schedule->call(function () {
          
        //     DB::disableQueryLog();
        //     DB::table('stats')->delete();
        //     $client = new Client();
        //     $promise = $client->requestAsync('GET','http://api.rtbravo.com/api/statsv2?token=4eyrn7z923f75admnazufvucvskm3vpyqn4422zc&from=2020-04-21&to=2020-04-25&groupby=day:paid:sid&format=json');
        //     $promise->then(
        //         function (ResponseInterface $res) {
        //             $data = json_decode($res->getBody()->getContents(),true);       
        //             $time_now = date("Y-m-d");
    
        //         foreach (array_chunk($data, 1000) as $responseChunk)
        //         {
        //             $insertableArray = [];
        //             foreach($responseChunk as $value) {
        //                 $insertableArray[] = [
        //                     'day'      => $value["day"],
        //                     'paid'     => $value["paid"],
        //                     'sid'      => $value["sid"],
        //                     'requests' => $value["requests"],
        //                     'bids'     => $value["bids"],
        //                     'wins'     => $value["wins"],
        //                     'cost'     => $value["cost"],
        //                     'created_at' => date($time_now),
        //                     'updated_at' => date($time_now),
        //                 ];
        //             }
        //             DB::table('stats')->insert($insertableArray);
        //         }
        //         return view('welcome');
        //         },
        //         function (RequestException $e) {
        //             return view('welcome');
        //         }
        //     )->wait();

        // })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
