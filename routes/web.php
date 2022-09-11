<?php

use App\Jobs\NormalExample;
use App\Jobs\StepBatchExample;
use App\Jobs\StepChainExample;
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

Route::get('/normalQueue', function () {
    // dispatch immediately
    NormalExample::dispatch();
    // dispatch after 5 seconds
    NormalExample::dispatch()->delay(5);
    return "DONE";
});

Route::get('/chain', function () {
    $chain = [
        new StepChainExample('step1'),
        new StepChainExample('step2'),
        new StepChainExample('step3'),
    ];
    Bus::chain($chain)->dispatch();
    return "DONE";
});

Route::get('/batch', function () {
    // before using batch you should run
    // php artisan queue:batches-table
    // and then migrate

    $batch = [
        new StepBatchExample('step1'),
        new StepBatchExample('step2'),
        new StepBatchExample('step3'),
    ];
    Bus::batch($batch)
        ->catch(function ($batch, $e) {
            // handle exception
        })
        ->then(function ($batch) {
            // this is called when ALL jobs are successful
        })
        ->finally(function ($batch) {
            // this is called anyway
        })
        ->dispatch();
    return "DONE";
});

Route::get('/timeout', function () {
    TimeoutExample::dispatch();
    return "DONE";
});

Route::get('/', function () {
    echo "HOME";
})->name('home');

