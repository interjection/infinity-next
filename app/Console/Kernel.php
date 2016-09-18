<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use File;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Autoprune::class,
        \App\Console\Commands\Captchaprune::class,
        \App\Console\Commands\Import::class,
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\RecordStats::class,
        \App\Console\Commands\RecordStatsAll::class,
        \App\Console\Commands\TorCheck::class,
        \App\Console\Commands\TorPull::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $now = Carbon::now();

        $this->runRecordStats($schedule, $now);
        $this->runAutoprune($schedule, $now);
        $this->runCaptchaprune($schedule, $now);
        $this->runTorPull($schedule, $now);
    }


    private function runTorPull(Schedule $schedule, Carbon $now)
    {
        $logdir = storage_path('logs/torpull');

        if (!File::exists($logdir)) {
            File::makeDirectory($logdir);
        }

        $schedule->command('tor:pull')
            ->twiceDaily()
            ->sendOutputTo("{$logdir}/{$now->format('Y-m-d_H')}.txt");
    }

    private function runAutoprune(Schedule $schedule, Carbon $now)
    {
        $logdir = storage_path('logs/autoprune');

        if (!File::exists($logdir)) {
            File::makeDirectory($logdir);
        }

        $schedule->command('autoprune')
            ->hourly()
            ->sendOutputTo("{$logdir}/{$now->format('Y-m-d_H')}.txt");
    }

    private function runCaptchaprune(Schedule $schedule, Carbon $now)
    {
        $logdir = storage_path('logs/captchaprune');

        if (!File::exists($logdir)) {
            File::makeDirectory($logdir);
        }

        $schedule->command('captcha')
            ->hourly()
            ->sendOutputTo("{$logdir}/{$now->format('Y-m-d_H')}.txt");
    }

    private function runInspire(Schedule $schedule, Carbon $now)
    {
        $logdir = storage_path('logs/inspire');

        if (!File::exists($logdir)) {
            File::makeDirectory($logdir);
        }

        $schedule->command('inspire')
            ->sendOutputTo("{$logdir}/{$now->format('Y-m-d_H:m')}.txt");
    }


    private function runRecordStats(Schedule $schedule, Carbon $now)
    {
        $logdir = storage_path('logs/recordstats');

        if (!File::exists($logdir)) {
            File::makeDirectory($logdir);
        }

        $schedule->command('recordstats')
            ->hourly()
            ->sendOutputTo("{$logdir}/{$now->format('Y-m-d_H')}.txt.txt");
    }
}
