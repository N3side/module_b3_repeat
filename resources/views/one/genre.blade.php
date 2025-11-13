@extends("pages/index")

@section("content")

    <form action="{{route("admin.genres.update", $genre)}}" method="POST">
        @csrf
        @method("PATCH")
        <input type="text" name="genre" value="{{$genre->genre}}">
        <input type="submit" value="Изменить">

    </form>

@endsection
