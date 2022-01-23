<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('images')->group(function(){
    Route::post('upload',[ImageController::class,'upload']);
});

Route::prefix('categories')->group(function(){
    Route::get('/',[CategoryController::class,'index']);
    Route::get('{category}',[CategoryController::class,'single']);
    Route::post('create',[CategoryController::class,'create']);
    Route::post('update/{category}',[CategoryController::class,'update']);
    Route::post('delete/{category}',[CategoryController::class,'delete']);
});

Route::prefix('products')->group(function(){
    Route::get('/',[ProductController::class,'index']);
    Route::post('create',[ProductController::class,'create']);
    Route::post('delete/{product}',[ProductController::class,'delete']);
});
