<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Schedule::command('exchange:update')->everyFourHours();
Schedule::command('app:sync-pallet-products')->dailyAt('05:00');
Schedule::command('app:sync-categories')->dailyAt('05:00');


