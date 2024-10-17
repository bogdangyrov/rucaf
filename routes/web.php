<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/catalog', [ProductController::class, 'index']);
Route::get('/catalog/{productType:slug}', [ProductController::class, 'type'])->name('products');
