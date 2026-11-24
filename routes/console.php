<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
use App\Jobs\HapusCatatanLama;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new HapusCatatanLama)->daily();