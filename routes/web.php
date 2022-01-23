<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $products = Product::get();
    return view('welcome',compact('products'));
});

Route::middleware(['auth'])->group(function(){

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('categories',[CategoryController::class,'index'])->name('categories.index');
    Route::get('products',[ProductController::class,'index'])->name('products.index');
    // Route::resource('products', ProductController::class);

});


require __DIR__.'/auth.php';
