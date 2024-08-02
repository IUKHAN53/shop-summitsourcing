<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\WishlistController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Livewire::setScriptRoute(function ($handle) {
    return Route::get('/livewire/livewire.js', $handle);
});

//Route::get('test', [HomeController::class, 'index'])->name('test');
Route::get('/buser', function () {
    $user = \App\Models\User::first();
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('welcome');
})->name('test');

Route::get('/initialize', function (){
    Artisan::call('migrate:fresh --seed');
    echo 'Fresh Migrated';
    echo '<br>';

    Artisan::call('exchange:update');
    echo 'Exchange Rates Updated';
    echo '<br>';

    Artisan::call('app:sync-categories');
    echo 'Categories Synced';
})->name('initialize');



Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('products', [ProductController::class, 'searchProducts'])->name('search-products');
Route::get('dropshipping', [ProductController::class, 'searchDropshippingProducts'])->name('dropshipping');
Route::get('palletProducts', [ProductController::class, 'getPalletProducts'])->name('pallet-products');
Route::get('product-detail/{id}', [ProductController::class, 'getDetails'])->name('product-detail');
Route::post('/set-currency', [CurrencyController::class, 'setCurrency'])->name('setCurrency');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::get('/wishlist/remove/{id}', [WishlistController::class, 'removeItem'])->name('wishlist.remove');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    Route::group(['prefix' => 'admin'], function () {
    });

});




require __DIR__.'/auth.php';
Route::get('/{slug}', [HomeController::class, 'staticPages'])->name('static-page');
