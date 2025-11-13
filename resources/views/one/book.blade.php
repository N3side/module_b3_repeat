@extends("pages/index")

@section("content")

    <img src="{{url($book->preview)}}" alt="" style="width:200px; aspect-ratio: 1/1; object-fit: cover">

    <form action="{{route("admin.books.update", $book)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("PATCH")

        <div class="item">
            <input type="text" name="title" id="" placeholder="title" value="{{$book->title}}">
            @error("title")
            <span>{{$message}}</span>
            @enderror
        </div>

        @php
            function includes($child, $arr) {
                foreach ($arr as $item) {
                    if ($child->id === $item->id) {
                        return true;
                    }
                }
            }
        @endphp

        <div class="item">
            genre_ids
            <select name="genres_ids[]" id="" multiple>
                @foreach($genres as $genre)
                    <option value="{{$genre->id}}"
                        {{includes($genre, $book->genres) ? "selected" : "" }}
                    >
                        {{$genre->genre}}</option>
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
                    <option value="{{$author->id}}"
                        {{includes($author, $book->authors) ? "selected" : "" }}
                    >{{$author->author}}</option>
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
            <input type="text" name="price" id="" placeholder="price" value="{{$book->price}}">
            @error("price")
            <span>{{$message}}</span>
            @enderror
        </div>

        <div class="item">
            <textarea name="text">{{$book->text}}</textarea>
            @error("text")
            <span>{{$message}}</span>
            @enderror
        </div>

        <input type="submit" value="Изменить">
    </form>

@endsection
