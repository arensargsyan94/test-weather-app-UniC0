<?php

use App\Http\Controllers\WeatherController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Handle login request
Route::post('/login', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [WeatherController::class, 'showHome'])->name('home');
Route::post('/search', [WeatherController::class, 'search'])->name('weather.search');

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [WeatherController::class, 'userDashboard'])->name('dashboard');
});

Route::post('/search', [WeatherController::class, 'search'])->name('weather.search');
Route::get('/history', [WeatherController::class, 'getHistory'])->name('weather.history');

Route::post('/save-search', [WeatherController::class, 'saveSearch']);
