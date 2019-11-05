<?php
require_once('header/db.php');
$nrSongs = ($_GET['s']) ? $_GET['s'] : 5;
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
            <div class="track-wrapper">
                <h1 class="title text-center">New Songs</h1>
                <nav aria-label="Songs per track">
                  <ul class="pagination justify-content-center">
                    <li class="page-item <?php($nrSongs == 5) ? 'disabled active' : '' ?>">
                        <a class="page-link" href="track?s=5" <?php ($nrSongs == 5) ? 'tabindex="-1"' : '' ?>>5</a>
                    </li>
                    <li class="page-item <?php($nrSongs == 10) ? 'disabled active' : '' ?>">
                        <a class="page-link" href="track?s=10" <?php ($nrSongs == 10) ? 'tabindex="-1"' : '' ?>>10</a>
                    </li>
                    <li class="page-item <?php($nrSongs == 15) ? 'disabled active' : '' ?>">
                        <a class="page-link" href="track?s=15" <?php ($nrSongs == 15) ? 'tabindex="-1"' : '' ?>>15</a>
                    </li>
                  </ul>
                </nav>
                @for($i = 0 ; $i < $nrSongs ; $i++)
                <div class="ice-panel d-flex mb-3">
                    <div class="song-img-wrapper d-flex" title="Song Name or Album Here">
                        <img class="song-img" src="images/blank.png" alt="">
                    </div>
                    <div class="song-info-wrapper d-flex">
                        <h2><b>Song's Name</b></h2>
                        <h5>Album's Name</h5>
                        <h4>Name of the Artist</h4>
                    </div>
                </div>
                @endfor
            </div>
        </section>
    </main>
    <footer>
        <div class="container">
            <p class="float-left">Created by Software Engineering Group 5.</p>
            <p class="float-right">© <?php date('Y')?> Headline Music App.</p>
        </div>
    </footer>
</body>
</html>