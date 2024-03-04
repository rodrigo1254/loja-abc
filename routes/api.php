<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('sales',['App\Http\Controllers\Api\V1\SalesController','index']);
Route::get('sales/{sale}',['App\Http\Controllers\Api\V1\SalesController','show']);

Route::post('sales',['App\Http\Controllers\Api\V1\SalesController','store']);

Route::put('sales/{sale}',['App\Http\Controllers\Api\V1\SalesController','update']);
Route::put('sales/{id}/cancel', ['App\Http\Controllers\Api\V1\SalesController', 'cancel']);

Route::get('products',['App\Http\Controllers\Api\V1\ProductsController','index']);
Route::get('products/{product}',['App\Http\Controllers\Api\V1\ProductsController','show']);