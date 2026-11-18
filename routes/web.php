<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('adatbazis', [DatabaseController::class, 'index'])->name('database');

Route::get('kapcsolat', [ContactController::class, 'show'])->name('contact');
Route::post('kapcsolat', [ContactController::class, 'store'])->name('contact.store');

require __DIR__.'/auth.php';
