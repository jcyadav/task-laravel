<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ProfileController::class, 'index'])->name('home');
Route::resource('profiles', ProfileController::class);
Route::post('profiles/import', [ProfileController::class, 'import'])->name('profiles.import');
