<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);

Route::get('product', [ProductController::class, 'get']);
Route::post('product', [ProductController::class, 'post']);
Route::put('product', [ProductController::class, 'put']);
Route::delete('product', [ProductController::class, 'delete']);

Route::get('category', [CategoryController::class, 'get']);
Route::post('category', [CategoryController::class, 'post']);
Route::put('category', [CategoryController::class, 'put']);
Route::delete('category', [CategoryController::class, 'delete']);

Route::middleware("auth:sanctum")
    ->get("/user", fn(Request $request) => $request->user());
