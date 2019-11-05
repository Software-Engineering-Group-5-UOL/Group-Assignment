<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'ryanwslr_softwaresuer');
define('DB_PASSWORD', 'jKHGBku65eOIJ0itrd5432wOK9juESD');
define('DB_NAME', 'ryanwslr_software');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


       
?>