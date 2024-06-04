<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublisherController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});
Route::group([
    'middleware' => 'auth',
    'prefix' =>'author'
], function ($router) {
    Route::get('/', [AuthorController::class, 'index']);
    Route::post('/', [AuthorController::class, 'store']);
    Route::get('/{id}', [AuthorController::class, 'show']);
    Route::put('/{id}', [AuthorController::class, 'update']);
    Route::delete('/{id}', [AuthorController::class, 'destroy']);
});
Route::group([
    'middleware' => 'auth',
    'prefix' =>'book'
], function ($router) {
    Route::get('/', [BookController::class, 'index']);
    Route::post('/', [BookController::class, 'store']);
    Route::get('/{id}', [BookController::class, 'show']);
    Route::put('/{id}', [BookController::class, 'update']);
    Route::delete('/{id}', [BookController::class, 'destroy']);
});
Route::group([
    'middleware' => 'auth',
    'prefix' =>'publisher'
], function ($router) {
    Route::get('/', [PublisherController::class, 'index']);
    Route::post('/', [PublisherController::class, 'store']);
    Route::get('/{id}', [PublisherController::class, 'show']);
    Route::put('/{id}', [PublisherController::class, 'update']);
    Route::delete('/{id}', [PublisherController::class, 'destroy']);
});
