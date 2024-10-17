<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/catalog/{productType:slug}', [ProductController::class, 'index'])->name('products');
Route::get('/products/{productType:slug}/{product:slug}', [ProductController::class, 'show'])->name('product');
