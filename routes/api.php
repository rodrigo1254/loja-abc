<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


Route::apiResource('sales','App\Http\Controllers\Api\V1\SalesController');

Route::put('sales/{id}/cancel', ['App\Http\Controllers\Api\V1\SalesController', 'cancel']);
Route::post('sales/{id}', ['App\Http\Controllers\Api\V1\SalesController', 'addProductsToSale']);

Route::get('products',['App\Http\Controllers\Api\V1\ProductsController','index']);
Route::get('products/{product}',['App\Http\Controllers\Api\V1\ProductsController','show']);

Route::post('login',[AuthController::class,'login']);
Route::get('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

Route::get('users',[UserController::class,'index']);