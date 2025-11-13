@extends("pages/index")

@section("content")

    <form action="{{route("admin.authors.update", $author)}}" method="POST">
        @csrf
        @method("PATCH")
        <input type="text" name="author" value="{{$author->author}}">
        <input type="submit" value="Изменить">
    </form>

@endsection
