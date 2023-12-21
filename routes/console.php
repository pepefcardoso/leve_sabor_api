<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('project:init', function () {
    Artisan::call('migrate:reset');
    Artisan::call('migrate:fresh');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    Artisan::call('db:seed --class=CategorySeeder');
    Artisan::call('db:seed --class=DietSeeder');
    Artisan::call('db:seed --class=RoleSeeder');
    Artisan::call('optimize');
})->describe('Initialize the project');
