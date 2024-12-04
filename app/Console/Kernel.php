<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:update-manuscript-mappings')
            ->daily('2:30');

        $schedule->command('zotero:download')
            ->daily('3:00');

        $schedule->command('umwelttext:load')
            ->daily('3:30');

        $schedule->call(function () {
            DB::table('ms_image_tmp_link')
                ->whereRaw('created_at >= now() - interval 2 hour')
                ->delete();
        })->everyThirtyMinutes();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
