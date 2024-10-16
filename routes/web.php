<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/catalog', [ProductController::class, 'index']);
Route::get('/catalog/{productType}', [ProductController::class, 'type']);
