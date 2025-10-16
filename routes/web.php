<?php

use App\Helpers\Filter;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductType;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\Web\ProductController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');

Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/comparison', [ComparisonController::class, 'index'])->name('comparison');
Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites');

Route::get('/catalog', [HomeController::class, 'catalog'])->name('catalog');
Route::get('/catalog/{productType:slug}', [ProductTypeController::class, 'index'])->name('product-types.index');
Route::get('/catalog/{productType:slug}/{category:slug}', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/catalog/{productType:slug}/{category:slug}/{subcategory:slug}', [ProductController::class, 'index'])->name('products.index');
Route::get('/catalog/{productType:slug}/{category:slug}/{subcategory:slug}/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/filters/{id}/counts', function (Request $request, $id) {
    $attribute = Attribute::findOrFail($id);
    $filter = new Filter(
        ProductType::findOrFail($request->input('product_type_id')),
        $request->input('category_id') ? Category::find($request->input('category_id')) : null,
        $request->input('subcategory_id') ? Subcategory::find($request->input('subcategory_id')) : null,
        $request->query()
    );

    $attribute->load('values');
    $attribute->loadProductsCount($filter);

    return response()->json([
        'values' => $attribute->values->map(fn($v) => [
            'slug' => $v->slug,
            'count' => $v->products_count,
        ]),
    ]);
})
    ->name('filters.load-products-count');


Route::get('/{page:slug}', [PageController::class, 'index'])->name('page');
