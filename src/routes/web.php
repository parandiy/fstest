<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\FileController;

Route::get('/', [FileController::class, 'index'])->name('files.index');

Route::post('/', [FileUploadController::class, 'store'])
    ->name('files.store');

Route::delete('/{file}', [FileController::class, 'destroy'])
    ->name('files.destroy');
