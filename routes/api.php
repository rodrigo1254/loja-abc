<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\V1\SalesController;
use App\Http\Controllers\Api\V1\ProductsController;


Route::apiResource('sales',SalesController::class);
Route::put('sales/{id}/cancel', [SalesController::class, 'cancel']);
Route::post('sales/{id}', [SalesController::class, 'addProductsToSale']);

Route::get('products',[ProductsController::class,'index']);
Route::get('products/{product}',[ProductsController::class,'show']);

Route::post('login',[AuthController::class,'login']);
Route::get('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

Route::get('users',[UserController::class,'index']);