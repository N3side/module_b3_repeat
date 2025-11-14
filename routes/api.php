<?php

use App\Http\Controllers\API\UserController;
use App\Http\Middleware\CheckIsAdmin;
use App\Http\Middleware\CheckIsUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BookController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::get("books", [BookController::class, "index"]);
Route::get("books/{book}", [BookController::class, "show"]);


Route::middleware(CheckIsUser::class)->group(function () {

    Route::prefix("books")->group(function () {
        Route::get("{book}/reviews", [\App\Http\Controllers\API\ReviewController::class, "index"]);
        Route::post("{book}/reviews", [\App\Http\Controllers\API\ReviewController::class, "store"]);
        Route::patch("{book}/reviews", [\App\Http\Controllers\API\ReviewController::class, "update"]);
        Route::delete("{book}/reviews", [\App\Http\Controllers\API\ReviewController::class, "destroy"]);
        Route::get("{book}/read", [\App\Http\Controllers\API\BookController::class, "read"]);
        Route::get("{book}/download", [\App\Http\Controllers\API\BookController::class, "download"]);
    });

    Route::get("cart", [\App\Http\Controllers\API\CartController::class, "index"]);
    Route::post("cart/{book}", [\App\Http\Controllers\API\CartController::class, "store"]);
    Route::delete("cart/{book}", [\App\Http\Controllers\API\CartController::class, "destroy"]);

    Route::get("user/me", [UserController::class, "show"]);

    Route::middleware(CheckIsAdmin::class)->group(function () {

    });
});

Route::prefix("auth")->group(function () {
    Route::post("register", [UserController::class, "register"]);
    Route::post("login", [UserController::class, "login"]);
    Route::middleware(CheckIsUser::class)->group(function () {
        Route::post("logout", [UserController::class, "logout"]);
    });
});


