<?php
// Include config file
require_once "php/db.php";
include 'pageelements/header.php';
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Confirming the users link is valid
if( $_GET["key"]) {
    $verifylink = $_GET["key"];
    $sql = "SELECT usr_email, temptype, tempuse, id FROM users WHERE tempuse = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_tempuse);
        $param_tempuse = trim($_GET["key"]);
        
        /* execute query */
        if(mysqli_stmt_execute($stmt)){    
            
            /* store result */
            $result = mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){                    
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $usr_email, $temptype, $tempuse, $id);
            }
            
            mysqli_stmt_fetch($stmt);
            
        if ($temptype == 2 && $tempuse == trim($_GET["key"])) {
            echo'
                <div align="ice-panel">
                <h2>Reset Password</h2>
                <p>Please fill out this form to reset your password.</p>
                <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?key='.$verifylink.'" method="post">
                    <div>
                        <label>New Password</label>
                        <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                        <span class="help-block"><?php echo $new_password_err; ?></span>
                    </div>
                    <div>
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control">
                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn sign-up-btn" value="Submit">
                    </div>
                </form>
                </div>';
            } else{
                    echo '<h1>Your link is invalid</h1>
                    <p>Please return home <a href=login.php>here</a>.';
                }
     
                // Processing form data when form is submitted
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                 
                    // Validate new password
                    if(empty(trim($_POST["new_password"]))){
                        $new_password_err = "Please enter the new password.";     
                    } elseif(strlen(trim($_POST["new_password"])) < 6){
                        $new_password_err = "Password must have atleast 6 characters.";
                    } else{
                        $new_password = trim($_POST["new_password"]);
                    }
                    
                    // Validate confirm password
                    if(empty(trim($_POST["confirm_password"]))){
                        $confirm_password_err = "Please confirm the password.";
                    } else{
                        $confirm_password = trim($_POST["confirm_password"]);
                        if(empty($new_password_err) && ($new_password != $confirm_password)){
                            $confirm_password_err = "Password did not match.";
                        }
                    }
                        
                    // Check input errors before updating the database
                    if(empty($new_password_err) && empty($confirm_password_err)){
                        // Prepare an update statement
                        $sql = "UPDATE users SET usr_password = ? WHERE id = ?";
                        
                        if($stmt = mysqli_prepare($link, $sql)){
                            // Bind variables to the prepared statement as parameters
                            mysqli_stmt_bind_param($stmt, "si", $param_usr_password, $param_id);
                            
                            // Set parameters
                            $param_usr_password = password_hash($new_password, PASSWORD_DEFAULT);
                            $param_id = $_SESSION["id"];
                
                            //execute statement
                            if(mysqli_stmt_execute($stmt)){
                                // Clear the database fields that are for tempoary use
                                $sql1 = "UPDATE users SET tempuse = NULL, temptype = NULL WHERE id = $id";
                                
                                if (mysqli_query($link, $sql1)) {
                                    header("location: index.php");
                                } else {
                                    echo "Error updating record: " . mysqli_error($link);
                                }

                            } else{
                                echo "Oops! Something went wrong. Please try again later.";
                            }
                        }
                        
                        // Close statement
                        mysqli_stmt_close($stmt);
                    }
                    
                    // Close connection
                    mysqli_close($link);
                }
            }
        }
    } else{
        echo '<h1>Your link is invalid</h1>
            <p>Please return home <a href=index.php>here</a>.';
    }

?>

<?php
include "pageelements/footer.php";
?>
