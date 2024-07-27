<?php

use App\Events\TestEVent;
use App\Jobs\ImportCSVJob;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    ImportCSVJob::dispatch('customers_2.csv');
    broadcast(new TestEVent('Hello World!'));
    return 'Job dispatched!';
});
