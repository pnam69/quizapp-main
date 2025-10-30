<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/debug-auth', function () {
    return response()->json([
        'auth_user' => auth()->user(),
        'auth_id' => auth()->id(),
        'session_id' => session()->getId(),
        'cookies' => request()->cookies->all(),
        'headers' => [
            'host' => request()->header('host'),
            'referer' => request()->header('referer'),
        ],
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

