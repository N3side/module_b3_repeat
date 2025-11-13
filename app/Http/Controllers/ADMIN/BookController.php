<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Support\Str;


class BookController extends Controller
{
    public function index() {
        $books = Book::all();
        $genres = Genre::all();
        $authors = Author::all();

        return view("pages/books", compact("books", "genres", "authors"));
    }

    public function show(Book $book) {
        $genres = Genre::all();
        $authors = Author::all();
        return view("one/book", compact("book", "genres", "authors"));
    }

    public function store() {
        $validator = validator(request()->all(), [
            "title" => "required|string",
            "authors_ids" => "required|array",
            "authors_ids*" => "exists:authors,id",
            "genres_ids" => "required|array",
            "genres_ids*" => "exists:genres,id",
            "text" => 'required|string|min:10',
            "price" => "required|integer|min:0",
            "preview" => "required|image|mimes:jpg,jpeg,png"
        ]);

        if ($validator->fails()) return back()->withInput()->withErrors($validator->errors());

        $data = $validator->validated();

        $preview = $data["preview"] ?? null;

        if ($preview) {
            $path = Str::uuid() . "." . $preview->getClientOriginalExtension();

            $preview->move(public_path("previews"), $path);
            $data["preview"] = "/previews/". $path;
        }

        unset($data["authors_ids"]);
        unset($data["genres_ids"]);

        Book::create($data);

        return back()->with(["toast" => "Книга успешно создана"]);
    }

    public function update(Book $book)
    {
        $validator = validator(request()->all(), [
            "title" => "nullable|string",
            "author_ids" => "nullable|array",
            "author_ids.*" => "exists:authors,id",
            "genre_ids" => "nullable|array",
            "genre_ids.*" => "exists:genres,id",
            "text" => "nullable|string|min:10",
            "price" => "nullable|integer|min:0",
            "preview" => "nullable|image|mimes:jpg,jpeg,png"
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        $data = $validator->validated();

        $preview = $data["preview"] ?? null;

        if ($preview) {

            $oldPath = $book->preview;

            if ($oldPath && file_exists(public_path($oldPath))) {
                unlink(public_path($oldPath));
            }

            $path = Str::uuid() . "." . $preview->getClientOriginalExtension();

            $preview->move(public_path("previews"), $path);
            $data["preview"] = "/previews/". $path;
        }

        $authorIds = $data['author_ids'] ?? null;
        $genreIds = $data['genre_ids'] ?? null;

        unset($data['author_ids'], $data['genre_ids']);

        $book->update($data);

        if ($authorIds !== null) {
            $book->authors()->sync($authorIds);
        }

        if ($genreIds !== null) {
            $book->genres()->sync($genreIds);
        }

        return back()->with(['toast' => 'Книга успешно обновлена']);
    }

    public function delete() {

    }
}
