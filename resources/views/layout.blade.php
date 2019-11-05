<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>New Spotify Tracks – Headline Music App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1 minimum-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
</head>
<body>
    <header role="banner">
        <nav class="navbar container">
            <div class="navbar-brand" href="#">Headline Music App</div>
        </nav>
    </header>
    <main class="container">
        <section class="wrapper">
            @yield('content')
        </section>
    </main>
    <footer>
        <div class="container">
            <p class="float-left">Created by Software Engineering Group 5.</p>
            <p class="float-right">© {{date('Y')}} Headline Music App.</p>
        </div>
    </footer>
</body>
</html>