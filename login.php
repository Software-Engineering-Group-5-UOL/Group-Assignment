<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

//check if the user has been redirected from account creation and present greeting message
$redirected = htmlspecialchars($_GET["account"]);
if ($redirected == 1) {
    echo 'Your account has been created, please verify with the email sent to you before logging in.';
}
 
// Include config file
include 'pageelements/header.php';
require_once "php/db.php";
 
// Define variables and initialize with empty values
$usr_email = $usr_password = "";
$usr_email_err = $usr_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if usr_email is empty
    if(empty(trim($_POST["usr_email"]))){
        $usr_email_err = "Please enter a valid email.";
    } else{
        $usr_email = trim($_POST["usr_email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["usr_password"]))){
        $usr_password_err = "Please enter your password.";
    } else{
        $usr_password = trim($_POST["usr_password"]);
    }
    
    // Validate credentials
    if(empty($usr_email_err) && empty($usr_password_err)){
        // Prepare a select statement
        $sql = "SELECT id, usr_email, usr_fname, usr_lname, usr_password, verified FROM users WHERE usr_email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_usr_email);
            
            // Set parameters
            $param_usr_email = $usr_email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if usr_email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $usr_email, $usr_fname, $usr_lname, $hashed_password, $verified);
                    if(mysqli_stmt_fetch($stmt)){
                        //check if the 
                        if($verified == 1){
                            if(password_verify($usr_password, $hashed_password)){
                                
                                // Password is correct, so start a new session
                                session_start();
                                
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["usr_email"] = $usr_email;
                                $_SESSION["usr_fname"] = $usr_fname;
                                $_SESSION["usr_lname"] = $usr_lname;
                                
                                // Redirect user to welcome page
                                header("location: welcome.php");
                            } else{
                                // Display an error message if password is not valid
                                $usr_password_err = "The password you entered was not valid.";
                            }

                        } elseif($verified == 0){
                            echo '<h1>Your account has not been verified. Please verify your account from the email sent to you</h1>';
                        
                            
                        } elseif($verified == 2){
                            echo '<h1>Your account has been banned for misuse of the site</h1>';
                        }
                    }
                } else{
                    // Display an error message if usr_email doesn't exist
                    $usr_email_err = "No account found with that email.";
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
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In</title>
</head>
</head>
<body>
    <div align="center">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($usr_email_err)) ? 'has-error' : ''; ?>">
                <label>Email Address</label>
                <input type="text" name="usr_email" class="form-control" value="<?php echo $usr_email; ?>">
                <span class="help-block"><?php echo $usr_email_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($usr_password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="usr_password" class="form-control">
                <span class="help-block"><?php echo $usr_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Forgotten your password? <a href="forgotten-password.php">Reset it here</a>.</p>
            <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>

        </form>
    </div>    
</body>
</html>
<?php
include 'pageelements/footer.php';
?>