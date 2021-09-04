<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{productId}', [ProductController::class, 'show']);
Route::post('products', [ProductController::class, 'store']);
Route::put('products/{productId}', [ProductController::class, 'update']);
Route::delete('products/{productId}', [ProductController::class, 'destroy']);
});
