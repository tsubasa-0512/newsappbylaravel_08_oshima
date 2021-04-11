<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticlesController;

Route::get('/', [ArticlesController::class, 'index']);
Route::get('/show', [ArticlesController::class, 'show']);
Route::get('/{tag}', [ArticlesController::class, 'sortByTag']);
Route::post('/save', [ArticlesController::class, 'save']);
Route::post('/update', [ArticlesController::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
