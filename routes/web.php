<?php

use App\Models\Product;
use App\Mail\RequestPrice;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\Web\ProductController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/comparison', [ComparisonController::class, 'index'])->name('comparison');
Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites');

Route::get('/mailable', function () {
    $product = Product::first();
    return (new RequestPrice('Богдан', '79789999999', 'Бла Бла Бла Бла Бла БлаБла Бла БлаБла Бла БлаБла Бла БлаБла Бла Бла', 100500, $product))->render();
});

Route::get('/catalog', [HomeController::class, 'catalog'])->name('catalog');
Route::get('/catalog/{productType:slug}', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{productType:slug}/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/{page:slug}', [PageController::class, 'index'])->name('page');
