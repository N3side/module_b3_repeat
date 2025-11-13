<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ADMIN\AdminController;
use App\Http\Middleware\CheckIsUser;
use App\Http\Controllers\ADMIN\GenresController;
use App\Http\Controllers\ADMIN\AuthorController;
use App\Http\Controllers\ADMIN\BookController;


Route::get('/', function () {
    return view('welcome');
});


Route::view("login", "login");
Route::post("login", [AdminController::class, "login"])->name("admin.login");
Route::middleware(CheckIsUser::class)->group(function () {
    Route::post("logout", [AdminController::class, "logout"])->name("admin.logout");
});

Route::middleware(CheckIsUser::class)->group(function () {
    Route::middleware(\App\Http\Middleware\CheckIsAdmin::class)->group(function () {
        Route::get("admin", [AdminController::class, "index"])->name("admin.index");

        Route::get("admin/books", [BookController::class, "index"])->name("admin.books");
        Route::get("admin/books/{book}", [BookController::class, "show"])->name("admin.books.show");
        Route::post("admin/books", [BookController::class, "store"])->name("admin.books.create");
        Route::patch("admin/books/{book}", [BookController::class, "update"])->name("admin.books.update");
        Route::delete("admin/books/{book}", [BookController::class, "destroy"])->name("admin.books.destroy");

        Route::get("admin/genres", [GenresController::class, "index"])->name("admin.genres");
        Route::get("admin/genres/{genre}", [GenresController::class, "show"])->name("admin.genres.show");
        Route::post("admin/genres", [GenresController::class, "store"])->name("admin.genres.create");
        Route::patch("admin/genres/{genre}", [GenresController::class, "update"])->name("admin.genres.update");
        Route::delete("admin/genres/{genre}", [GenresController::class, "destroy"])->name("admin.genres.destroy");

        Route::get("admin/authors", [AuthorController::class, "index"])->name("admin.authors");
        Route::get("admin/authors/{author}", [AuthorController::class, "show"])->name("admin.authors.show");
        Route::post("admin/authors", [AuthorController::class, "store"])->name("admin.authors.create");
        Route::patch("admin/authors/{author}", [AuthorController::class, "update"])->name("admin.authors.update");
        Route::delete("admin/authors/{author}", [AuthorController::class, "destroy"])->name("admin.authors.destroy");
    });
});
