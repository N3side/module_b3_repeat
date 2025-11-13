<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Genre;

class AuthorController extends Controller
{
    public function index() {
        $authors = Author::all();

        return view("pages/authors", compact("authors"));
    }

    public function store() {
        $validator = validator(request()->all(), [
            "author" => "required|string"
        ]);

        if ($validator->fails()) return back()->withInput()->withErrors($validator->errors());

        $data = $validator->validated();

        $genre = Author::create($data);

        return back()->with(["toast" => "Автор успешно создана"]);
    }

    public function show(Author $author) {
        return view("/one/author", compact("author"));
    }

    public function update(Author $author) {

        $validator = validator(request()->all(), [
            "author" => "string|required|unique:authors,author"
        ]);

        if ($validator->fails()) return back()->withInput()->withErrors($validator->errors());

        $data = $validator->validated();

        $author->update($data);

        return back()->with(["toast" => "Успешно обновлен автор"]);
    }

    public function delete() {

    }
}
