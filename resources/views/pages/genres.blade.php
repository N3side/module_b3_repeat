@extends("pages/index")
@section("content")

    <h2>Жанры</h2>

    <form action="{{route("admin.genres.create")}}" method="POST">
        @csrf

        <div class="item">
            <input type="text" name="genre" id="" placeholder="genre">
            @error("genre")
            <span>{{$message}}</span>
            @enderror
        </div>

        <input type="submit" value="Создать">
    </form>

    @foreach($genres as $genre)
        <a href="{{route("admin.genres", $genre)}}">{{ $genre->genre }}</a>
    @endforeach

@endsection
