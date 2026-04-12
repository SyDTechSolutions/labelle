<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\ResendDocuments::class,
        \App\Console\Commands\ResendMensajesReceptor::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('02:00');
        // Cada dos semanas (1ro y 15 de cada mes a las 3:00 AM)
        $schedule->command('telescope:prune-custom --hours=336')->twiceMonthly(1, 15, '03:00');
        
        $schedule->command(\App\Console\Commands\ResendDocuments::class)
            ->everyFifteenMinutes();

        $schedule->command(\App\Console\Commands\ResendMensajesReceptor::class)
            ->everyThirtyMinutes();
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
