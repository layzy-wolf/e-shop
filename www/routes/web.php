<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view("auth", "admin.auth")->name("admin.auth");
Route::post("auth", function (\Illuminate\Http\Request $request) {
    if (\Illuminate\Support\Facades\Auth::attempt([
        "email" => $request->email,
        "password" => $request->password
    ], true)) {
        return redirect()->route("admin.users");
    } else {
        return redirect()->back();
    }
});

Route::get("logout", function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect("/");
});


Route::group(["prefix" => "adminPanel", "middleware" => "auth.admin"], function () {
    Route::get("/", [UserController::class, "view"])->name("admin.users");
    Route::get("categories", [CategoryController::class, "view"])->name("admin.categories");

    Route::group(["prefix" => "categories"], function () {
        Route::post("create", [CategoryController::class, "create"])->name("admin.categories.create");
        Route::patch("{category}/patch", [CategoryController::class, "update"])->name("admin.categories.update");
        Route::get("{category}/delete", [CategoryController::class, "delete"])->name("admin.categories.delete");
    });

    Route::get("products", [ProductController::class, "view"])->name("admin.products");

    Route::group(["prefix" => "products"], function () {
        Route::post("create", [ProductController::class, "create"])->name("admin.products.create");
        Route::patch("{product}/patch", [ProductController::class, "update"])->name("admin.products.update");
        Route::get("{product}/delete", [ProductController::class, "delete"])->name("admin.products.delete");
    });

    Route::view("orders", "admin.orders")->name("admin.orders");
});

Route::get('/{any}', function ($any = null) {
    return view("app");

})->where('any', '.*');
