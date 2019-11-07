<?php
// Include config file
include "pageelements/header.php";
require_once "php/db.php";

// Define variables and initialize with empty values
$usr_email = $usr_password = $confirm_password = $verifycode = "";
$usr_email_err = $usr_password_err = $confirm_password_err = $verifycode_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
// Validate usr_email
    if(empty(trim($_POST["usr_email"]))){
        $usr_email_err = "Please enter an email address.";
    } 
    else{
        // Prepare a select statement
        $sql = "SELECT id, usr_fname FROM users WHERE usr_email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_usr_email);
            
            // Set parameters
            $param_usr_email = trim($_POST["usr_email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $usr_email = trim($_POST["usr_email"]);
                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $usr_fname);
                    mysqli_stmt_fetch($stmt);
                }
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
        
        $sql = "UPDATE users SET temptype = 2, tempuse = ? WHERE usr_email = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_tempuse, $param_usr_email);
            
            // Set parameters
            $random = random_int(1000000000, 9999999999);
            $verifykey = password_hash($random, PASSWORD_DEFAULT);
            $param_tempuse = $verifykey;
            $param_usr_email = $usr_email;
            
            if(mysqli_stmt_execute($stmt)){
                //send account verificaion email to user
                $to = $usr_email;
                $subject = "Reset Your Password";
                $message = "<html>
                            <head>
                            <title>Reset Your Password</title>
                            </head>
                            <body>
                            <h2>Hello $usr_fname</h2>
                            <p>A password reset has been requested on your account.</p>
                            <a href=https://software.ryangrange.co.uk/forgotten.php?key=$verifykey>Click here to reset your password</a>
                            <p>If this was not requested by you, please disregard this email.</p>                            
                            </body>
                            </html>
                            ";
                $headers = "From: Headline Music <accounts@headlinemusicapp.co.uk>" . "\r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                
                mail($to,$subject,$message,$headers);
                
                echo 'Please follow the instructions sent to your email to finish resetting your password';
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
}
    // Close connection
    mysqli_close($link);

 
?>
<div class="ice-panel">
 <h1 class="title text-center">Reset Password</h2>
 <p class="text-center">Please enter your email address to recieve a reset</p>
 <!--Get users email address-->
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
     <div class="form-group <?php echo (!empty($usr_email_err)) ? 'has-error' : ''; ?>">
         <input type="text" name="usr_email" class="form-control" value="<?php echo $usr_email; ?>" placeholder="Email Adress">
         <span class="help-block"><?php echo $usr_email_err; ?></span>
     </div>    
     <div class="form-group">
         <input type="submit" class="btn sign-up-btn" value="Send Code">
     </div>
 </form>
 <p class="text-center">Already know your password? <a href="index.php" class="text-white">Login here</a>.</p>
 <p class="text-center">Don't have an account? <a href="signup.php" class="text-white">Sign up now</a>.</p>
</div>
<?php
include "pageelements/footer.php";
?>
