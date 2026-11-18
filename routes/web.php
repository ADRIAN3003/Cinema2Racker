<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\FilmController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('adatbazis', [DatabaseController::class, 'index'])->name('database');

Route::get('kapcsolat', [ContactController::class, 'show'])->name('contact');
Route::post('kapcsolat', [ContactController::class, 'store'])->name('contact.store');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('filmek', FilmController::class)
        ->parameters(['filmek' => 'film'])
        ->names('films')
        ->except('show');
});

require __DIR__.'/auth.php';
