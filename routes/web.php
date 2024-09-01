<?php

use App\Jobs\ImportCSVJob;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    ImportCSVJob::dispatch('customers_2.csv');
    return 'Job dispatched!';
});
