<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use App\Models\Book;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user("sanctum");

        $cart = $user->cart;

        if (!$cart) {
            return response()->json([
                "message" => "Корзина пуста"
            ]);
        }

        return response()->json([
            "data" => BookResource::collection($cart->books)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Book $book)
    {
        $user = request()->user("sanctum");

        if ($book->price <= 0) {
            return response()->json([
                "message" => "Книга бесплатная"
            ]);
        }

        $cart = $user->cart;

        if (!$cart) {
            $user->cart()->create();
        }

        function isBookInCart($book_inp, $cart) {
            foreach ($cart->books as $book) {
                if ($book_inp->id === $book->id) {
                    return true;
                }
            }
        }

        if (!isBookInCart($book, $cart)) {
            $cart->books()->attach($book->id);
        } else {
            $cart->books()->updateExistingPivot($book->id, [
                "count" => $book->pivot->count + 1
            ]);
        }


        return response()->json([
            "message" => "Книга успешно добавлена в корзину",
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {

        $user = \request()->user("sanctum");

        if (!$user->cart) {
            return response()->json([
                "message" => "Корзина пуста"
            ]);
        }

        $user->cart->books()->detach($book->id);

        return response()->json([
            "message" => "Книга успешно удалена из корзины",
        ]);
    }
}
