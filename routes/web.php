<?php

use App\Jobs\NormalExample;
use App\Jobs\StepExample;
use App\Jobs\TimeoutExample;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// EXAMPLE ROUTES FOR QUEUES

Route::get('/normalQueue', function() {
    // dispatch immediately
    NormalExample::dispatch();
    // dispatch after 5 seconds
    NormalExample::dispatch()->delay(5);
    return "DONE";
});

Route::get('/chain', function() {
    $chain = [
      new StepExample('step1'),
      new StepExample('step2'),
      new StepExample('step3'),
    ];
    Bus::chain($chain)->dispatch();
    return "DONE";
});

Route::get('/timeout', function() {
    TimeoutExample::dispatch();
    return "DONE";
});

Route::get('/', function () {
    echo "HOME";
})->name('home');

