<?php

use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('adatbazis', [DatabaseController::class, 'index'])->name('database');

require __DIR__.'/auth.php';
