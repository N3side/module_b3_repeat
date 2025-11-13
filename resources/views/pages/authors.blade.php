@extends("pages/index")
@section("content")

    <h2>Авторы</h2>

    <form action="{{route("admin.authors.create")}}" method="POST">
        @csrf

        <div class="item">
            <input type="text" name="author" id="" placeholder="author">
            @error("author")
            <span>{{$message}}</span>
            @enderror
        </div>

        <input type="submit" value="Создать">
    </form>

    @foreach($authors as $author)
        <a href="{{route("admin.authors.show", $author)}}">{{ $author->author }}</a>
    @endforeach

@endsection
