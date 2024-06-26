<?php

use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Route::get('test', [HomeController::class, 'index'])->name('test');

Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('products', [ProductController::class, 'searchProducts'])->name('search-products');
Route::get('product-detail/{id}', [ProductController::class, 'getDetails'])->name('product-detail');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
