<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('adatbazis', [DatabaseController::class, 'index'])->name('database');

Route::get('kapcsolat', [ContactController::class, 'show'])->name('contact');
Route::post('kapcsolat', [ContactController::class, 'store'])->name('contact.store');

Route::get('uzenetek', [MessageController::class, 'index'])
    ->middleware('auth')
    ->name('messages');

Route::get('diagram', [ChartController::class, 'index'])->name('chart');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('filmek', FilmController::class)
        ->parameters(['filmek' => 'film'])
        ->names('films')
        ->except('show');
});

require __DIR__.'/auth.php';
