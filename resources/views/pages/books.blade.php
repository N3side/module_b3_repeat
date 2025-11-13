@extends("pages/index")
@section("content")

    <h2>Книги</h2>

    <form action="{{route("admin.books.create")}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="item">
            <input type="text" name="title" id="" placeholder="title">
            @error("title")
            <span>{{$message}}</span>
            @enderror
        </div>

        <div class="item">
            genre_ids
            <select name="genres_ids[]" id="" multiple>
                @foreach($genres as $genre)
                    <option value="{{$genre->id}}">{{$genre->genre}}</option>
                @endforeach
            </select>
            @error("genres_ids")
            <span>{{$message}}</span>
            @enderror
        </div>

        <div class="item">
            author_ids
            <select name="authors_ids[]" id="" multiple>
                @foreach($authors as $author)
                    <option value="{{$author->id}}">{{$author->author}}</option>
                @endforeach
            </select>
            @error("authors_ids")
            <span>{{$message}}</span>
            @enderror
        </div>

        <div class="item">
            <input type="file" name="preview" id="" placeholder="preview">
            @error("preview")
            <span>{{$message}}</span>
            @enderror
        </div>

        <div class="item">
            <input type="text" name="price" id="" placeholder="price">
            @error("price")
            <span>{{$message}}</span>
            @enderror
        </div>

        <div class="item">
            <textarea name="text"></textarea>
            @error("text")
            <span>{{$message}}</span>
            @enderror
        </div>

        <input type="submit" value="Создать">
    </form>

    @foreach($books as $book)
        <a href="{{route("admin.books.show", $book)}}">{{ $book->title }}</a>
    @endforeach

@endsection
