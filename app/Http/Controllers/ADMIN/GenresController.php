<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Genre;

class GenresController extends Controller
{
    public function index() {
        $genres = Genre::all();

//        dd($genres);

        return view("pages/genres", compact("genres"));
    }

    public function store() {
        $validator = validator(request()->all(), [
            "genre" => "required|string"
        ]);

        if ($validator->fails()) return back()->withInput()->withErrors($validator->errors());

        $data = $validator->validated();

        $genre = Genre::create($data);

        return back()->with(["toast" => "Книга успешно создана"]);
    }

    public function show(Genre $genre) {
        return view("one/genre", compact("genre"));
    }

    public function update(Genre $genre) {

        $validator = validator(request()->all(), [
            "genre" => "string|required|unique:genres,genre"
        ]);

        if ($validator->fails()) return back()->withInput()->withErrors($validator->errors());

        $data = $validator->validated();

        $genre->update($data);

        return back()->with(["toast" => "Успешно обновлен жанр"]);
    }

    public function delete() {

    }
}
