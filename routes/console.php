<?php

use App\Models\Note;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    Note::where('expirable', true)
        ->whereDate('for_date', '<', now()->subDay()->toDateString())
        ->delete();
})->daily();

Schedule::command('telescope:prune')->daily();
