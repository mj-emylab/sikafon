<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;


Route::get('/clear', function() {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');
    Artisan::call('storage:link');
    // Artisan::call('migrate');
    
 
    return "Cleared!";
 
});
Route::get('/test', function () {
    return view('index');
});

// Route::get('{any}', [PageController::class, 'index'])->where('any','.*');
