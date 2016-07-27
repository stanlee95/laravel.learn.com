<?php

namespace App\Console;

use DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use \Core\Connection\CronInit;
use \Core\Connection\CronLib;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(
            function () {
                $connect = new CronInit(new CronLib);
                $connect->connectToDump();
            }
        )->everyMinute();

//        $schedule->call(
//            function () {
//                $connect = new CronInit(new CronLib);
//                $connect->clearDump();
//            }
//        )->weekly();
    }
}
