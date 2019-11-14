<?php
require_once 'php/db.php';

//includes
include_once 'pageelements/header.php';

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
// if(!isset($_SESSION["spotifytoken"]) || empty($_SESSION["spotifytoken"])){
//     header("https://accounts.spotify.com/authorize?client_id=".$clientid."&response_type=code&redirect_uri=https%3A%2F%2Fheadlinemusicapp.co.uk%2Ftracks&scope=user-read-private%20playlist-modify-private&state=".$session_id);
// }
// else {
// }
$nrSongs = (isset($_GET['s'])) ? $_GET['s'] : 5;
?>
<div class="track-wrapper">
    <h1 class="title text-center">New Songs</h1>
    <a href="logout.php" class="btn login-btn">Sign Out of Your Account</a>
    <nav aria-label="Songs per track">
      <ul class="pagination justify-content-center">
        <li class="page-item <?php ($nrSongs == 5) ? 'disabled active' : '' ?>">
            <a class="page-link" href="track.php?s=5" <?php ($nrSongs == 5) ? 'tabindex="-1"' : '' ?> >5</a>
        </li>
        <li class="page-item <?php ($nrSongs == 10) ? 'disabled active' : '' ?>">
            <a class="page-link" href="track.php?s=10" <?php ($nrSongs == 10) ? 'tabindex="-1"' : '' ?> >10</a>
        </li>
        <li class="page-item <?php ($nrSongs == 15) ? 'disabled active' : '' ?>">
            <a class="page-link" href="track.php?s=15" <?php ($nrSongs == 15) ? 'tabindex="-1"' : '' ?> >15</a>
        </li>
      </ul>
    </nav>
    <?php for($i = 0 ; $i < $nrSongs ; $i++): ?>
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
    <?php endfor; ?>
</div>
<?php
include_once 'pageelements/footer.php';
?>
