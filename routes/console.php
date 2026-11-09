<?php

use App\Models\Note;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    Note::where('expirable', true)
        ->whereDate('for_date', '<', now()->subDay()->toDateString())
        ->delete();
})->daily();
