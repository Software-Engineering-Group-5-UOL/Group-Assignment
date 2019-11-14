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
if((!isset($_GET["token"]) || empty($_GET["token"])) || (!isset($_GET["code"]) || empty($_GET["code"]))){
    header("location: https://accounts.spotify.com/authorize?client_id=".$clientid."&response_type=code&redirect_uri=https%3A%2F%2Fheadlinemusicapp.co.uk%2Ftracks.php&scope=user-read-private%20playlist-modify-private&state=".$session_id);
} else {
    if(isset($_GET["code"] && !empty($_GET["code"])) {
       $url = 'https://accounts.spotify.com/api/token';
       $code = $_GET["code"];
       $data = array('grant_type' => 'authorization_code', 'code' => $code, 'redirect_uri' => 'https://headlinemusicapp.co.uk/tracks.php');

       // use key 'http' even if you send the request to https://...
       $options = array(
           'http' => array(
               'header'  => "Content-type: application/x-www-form-urlencoded\r\n"
                ."Authorization: Basic ".$clientid.":".$clientsecret."\r\n",
               'method'  => 'POST',
               'content' => http_build_query($data)
           )
       );
       $context  = stream_context_create($options);
       $result = file_get_contents($url, false, $context);
       if ($result === FALSE) { /* Handle error */ }
    } elseif(isset($_GET["token"] && !empty($_GET["token"])) {
       
    }

}
$nrSongs = (isset($_GET['s'])) ? (int)$_GET['s'] : 5;
?>
<div class="track-wrapper">
    <h1 class="title text-center">New Songs</h1>
    <a href="logout.php" class="btn login-btn">Sign Out of Your Account</a>
    <h2></h2>
    <nav aria-label="Songs per track">
      <ul class="pagination justify-content-center mt-3">
        <li class="page-item <?php echo ($nrSongs == 5) ? 'disabled active' : ''; ?>" >
            <a class="page-link" href="tracks.php?s=5" <?php echo ($nrSongs == 5) ? 'tabindex="-1"' : ''; ?> >5</a>
        </li>
        <li class="page-item <?php echo ($nrSongs == 10) ? 'disabled active' : ''; ?>" >
            <a class="page-link" href="tracks.php?s=10" <?php echo ($nrSongs == 10) ? 'tabindex="-1"' : ''; ?> >10</a>
        </li>
        <li class="page-item <?php echo ($nrSongs == 15) ? 'disabled active' : ''; ?>" >
            <a class="page-link" href="tracks.php?s=15" <?php echo ($nrSongs == 15) ? 'tabindex="-1"' : ''; ?> >15</a>
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
