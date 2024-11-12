<?php

// use App\Jobs\CheckAppExpiredNotPayment;
use App\Console\Commands\RejectPendingApplications;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule::job(new CheckAppExpiredNotPayment())->dailyAt('10:00');
Schedule::command('app:reject-applicaction-without-payment')->everyMinute();
