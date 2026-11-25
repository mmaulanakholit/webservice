<?php

use App\Http\Controllers\BiodataController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BiodataController::class, 'index'])->name('biodata.index');
Route::resource('biodata', BiodataController::class)->except(['index', 'create', 'show', 'edit']);

Route::get('/tentang', function () {
    return view('tentang');
});