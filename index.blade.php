<?php
require_once('header/db.php');
require_once('header/login.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Spotify Tracks – Headline Music App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1 minimum-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header role="banner">
        <nav class="navbar container">
            <div class="navbar-brand" href="#">Headline Music App</div>
        </nav>
    </header>
    <main class="container">
        <section class="wrapper">
            <div class="ice-panel">
                <h1 class="title text-center">Log in</h1>
                <form action="/track" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Username or Email address">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn login-btn"></input>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <footer>
        <div class="container">
            <p class="float-left">Created by Software Engineering Group 5.</p>
            <p class="float-right">© <?php date('Y') ?> Headline Music App.</p>
        </div>
    </footer>
</body>
</html>