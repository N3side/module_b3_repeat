<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = request()->input('query');
        $min_price = request()->input('min_price');
        $max_price = request()->input('max_price');
        $sort = request()->input("sort");

        if ($sort !== "desc") {
            $sort = "asc";
        }

        $genre_ids = request()->input("genre_ids");

        $books = Book::query()
            ->with("genres:id,genre")
            ->with("authors:id,author")
            ->when($min_price, function ($q) use ($min_price) {
                $q->where("price", ">=", $min_price);
            })
            ->when($max_price, function ($q) use ($max_price) {
                $q->where("price", "<=", $max_price);
            })
            ->when($genre_ids, function ($q) use ($genre_ids) {
                $q->whereHas("genres", function ($sub) use ($genre_ids) {
                    $sub->whereIn("genre_id", $genre_ids);
                });
            })
            ->orderBy("created_at", $sort)
            ->paginate(12);

        return response()->json([
            "data" => BookResource::collection(
                $books,
            ),
            "current_page" => $books->currentPage(),
            "per_page" => $books->perPage(),
            "last_page" => $books->lastPage()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function read(Book $book) {
        return response()->json([
            "message" => $book->text
        ]);
    }

    public function download(Book $book) {

        $filename = $book->title . "txt";

        return response()->make($book->text, 200, [
            "Content-Type" => "text/plain",
            "Content-Dispositions" => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function store(Request $request)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
