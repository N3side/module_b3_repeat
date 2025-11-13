<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <form action="{{route("admin.login")}}" method="POST">
        @csrf
        <div class="item">
            <input type="email" name="email" id="" placeholder="email">
            @error("email")
            <span>{{$message}}</span>
            @enderror
        </div>
        <div class="item">
            <input type="password" name="password" id="" placeholder="password">
            @error("password")
            <span>{{$message}}</span>
            @enderror
        </div>
        <input type="submit" value="Войти">
    </form>
</body>
</html>
