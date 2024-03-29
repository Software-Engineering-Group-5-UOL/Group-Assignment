<?php
// Include db and header files
include 'pageelements/header.php';
require_once "php/db.php";

//verifying email
//checking there is a link on the email
if( $_GET["verify"]) {
    $verifylink = $_GET["verify"];
    $sql = "SELECT temptype, tempuse, id FROM users WHERE tempuse = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = trim($_GET["verify"]);
        
        /* execute query */
        if(mysqli_stmt_execute($stmt)) {    

            /* store result */
            $result = mysqli_stmt_store_result($stmt);

            if(mysqli_stmt_num_rows($stmt) == 1) {   

                // Bind result variables
                mysqli_stmt_bind_result($stmt, $temptype, $tempuse, $id);
                
                if(mysqli_stmt_fetch($stmt)) {

                    if ($verified == 0 && $temptype == 1) {
                        
                        $sql1 = "UPDATE users SET verified = '1', tempuse = NULL, temptype = NULL WHERE id = $id ";
                        
                        if (mysqli_query($link, $sql1)) {
                            echo '<div class"ice-panel">';
                            echo '<h1>Thank you for verifying you email address.</h1>';
                            echo '<p>Please link your spotify account to complete registration.</p>';
                            include 'spotifyapp/authorization_code/public/index.html';
                            echo '</div>';
                        } else {
                            echo "Error updating record: " . mysqli_error($link);
                        }

                    } elseif ($verified == 1) {
                        echo '<h1>Your account is already verified.</h1>';
                        echo '<p>You may now close this page</p>';
                    } else {
                        echo '<h1>There is a problem with your link.</h1>';
                        echo '<p>Please try again later</p>';
                    }
                }
                
                /* free result */
                mysqli_stmt_free_result($stmt);
            }
        }
    }

    /* close statement */
    mysqli_stmt_close($stmt);
}

else {
    echo '<h1>There is a problem with your link.</h1>';
    echo '<p>Please try again later</p>';
}

include 'pageelements/footer.php';

?>
