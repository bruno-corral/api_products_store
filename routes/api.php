<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

// User

Route::get('user/all', [UsersController::class, 'index']);
Route::get('user/{id}', [UsersController::class, 'findOne']);
Route::post('user/signup', [UsersController::class, 'signup']);
Route::post('user/signin', [UsersController::class, 'signIn']);
Route::put('user/{id}', [UsersController::class, 'update']);
Route::delete('user/{id}', [UsersController::class, 'delete']);

// Products

Route::get('product/all', [ProductsController::class, 'index']);
Route::get('product/{id}', [ProductsController::class, 'findOne']);
Route::post('product/create', [ProductsController::class, 'create']);
Route::put('product/{id}', [ProductsController::class, 'update']);
Route::delete('product/{id}', [ProductsController::class, 'delete']);
