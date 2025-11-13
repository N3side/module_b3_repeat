<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
</head>
<body>
    <header>
        <li>
            <a href="{{route("admin.index")}}">Главная</a>
        </li>
        <li>
            <a href="{{route("admin.books")}}">Книги</a>
        </li>
        <li>
            <a href="{{route("admin.genres")}}">Жанры</a>
        </li>
        <li>
            <a href="{{route("admin.authors")}}">Авторы</a>
        </li>
        {{session("toast")}}
    </header>

    @yield("content")
</body>
</html>
