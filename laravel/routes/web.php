<?php

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
Route::middleware('auth')->group(function () {
    Route::get('/develop', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashhboard');
});

//Route::get('/develop/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
