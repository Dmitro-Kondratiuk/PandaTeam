<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Laravel</title>
    <link href="{{ "http://".$_SERVER['HTTP_HOST'] }}/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body>
<main>
    @yield('content')
</main>
<script type="text/javascript" src="{{ "http://".$_SERVER['HTTP_HOST'] }}/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
