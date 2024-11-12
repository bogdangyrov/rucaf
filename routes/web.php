<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\ProductController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/{page:slug}', [PageController::class, 'index'])->name('page');
Route::get('/catalog/{productType:slug}', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{productType:slug}/{product:slug}', [ProductController::class, 'show'])->name('products.show');
