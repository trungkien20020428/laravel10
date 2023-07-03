<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalculateController;
use App\Http\Controllers\exampleAPI;
use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});
Route::get('redis', function (Request $request) {
    Redis::set('1', 'Taylor');
});
Route::controller(ProductsController::class)->group(function () {
    Route::get('products', 'index');
    Route::delete('product/{id}', 'destroy');
});

Route::get('/example', [exampleAPI::class, 'success']);

Route::middleware(\App\Http\Middleware\Role::class)->group(function () {
    Route::controller(CalculateController::class)->group(function () {
        Route::get('calculate', 'execute');
    });
});

Route::get('test', function () {
    return 'this is test';
})->middleware('auth:api')->middleware(\App\Http\Middleware\Role::class);
