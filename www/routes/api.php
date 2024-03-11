<?php

use App\Http\Controllers\UserController;
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

Route::post("register", [UserController::class, "register"]);
Route::post("login", [UserController::class, "login"]);
Route::post("logout", [UserController::class, "logout"]);

Route::group(["prefix" => "product"], function () {
    Route::get("/", [\App\Http\Controllers\ProductController::class, "index"]);
    Route::get("/{product}/detail", [\App\Http\Controllers\ProductController::class, "show"]);
});

Route::post("basket/sync", [\App\Http\Controllers\BasketController::class, "sync"]);

Route::group(["middleware" => "auth.token"], function () {
    Route::get("/order/make", [\App\Http\Controllers\OrderController::class, "make"]);
    Route::get("/orders", [\App\Http\Controllers\OrderController::class, "show"]);
});
