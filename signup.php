<?php
// Include config file
include 'pageelements/header.php';
require "php/db.php";

// Define variables and initialize with empty values
$usr_email = $usr_password = $confirm_password = $usr_fname = $usr_lname = "";
$usr_email_err = $usr_password_err = $confirm_password_err = $usr_fname_err = $usr_lname_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate usr_email
    if(empty(trim($_POST["usr_email"]))){
        $usr_email_err = "Please enter an email address.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE usr_email = ?";
        
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
                    $usr_email_err = "This usr_email is already taken.";
                } else{
                    $usr_email = trim($_POST["usr_email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["usr_password"]))){
        $usr_password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["usr_password"])) < 8){
        $usr_password_err = "Password must have atleast 8 characters.";
    } else{
        $usr_password = trim($_POST["usr_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($usr_password_err) && ($usr_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Validate first name 
        if(empty(trim($_POST["usr_fname"]))){
        $usr_fname_err = "Please enter first name";     
    } else{
        $usr_fname = trim($_POST["usr_fname"]);
    }
    
    
    // Validate last name 
        if(empty(trim($_POST["usr_lname"]))){
        $usr_lname_err = "Please enter last name";     
    } else{
        $usr_lname = trim($_POST["usr_lname"]);
    }
    
    
    // Check input errors before inserting in database
    if(empty($usr_email_err) && empty($usr_password_err) && empty($confirm_password_err) && empty($usr_fname_err) && empty($usr_lname_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (usr_email, usr_fname, usr_lname, usr_password, temptype, tempuse) VALUES (?, ?, ?, ?, 1, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_usr_email, $param_usr_fname, $param_usr_lname, $param_usr_password, $param_tempuse);
            
            // Set parameters
            $random = random_int(1000000000, 9999999999);
            $verifykey = password_hash($random, PASSWORD_DEFAULT);            
            $param_usr_email = $usr_email;
            $param_usr_fname = $usr_fname;
            $param_usr_lname = $usr_lname;
            $param_usr_password = password_hash($usr_password, PASSWORD_DEFAULT); // Creates a password hash
            $param_tempuse = $verifykey;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                //send account verificaion email to user
                $to = $usr_email;
                $subject = "Verify your account";
                $message = "<html>
                            <head>
                            <title>Verify Your Account</title>
                            </head>
                            <body>
                            <h2>Welcome $usr_fname</h2>
                            <p>To use your account you need to verify that this email belongs to you</p>
                            <a href=https://$domain/verify.php?verify=$verifykey>Click here to verify</a>
                            </body>
                            </html>
                            ";
                $headers = "From: 418d Accounts <accounts@2dev.xyz>" . "\r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                
                mail($to,$subject,$message,$headers);
                
                // Redirect to login page
                header("location: login.php?account=1");
            } else{
                echo "Something went wrong. Please try again later.";
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
    <title>Sign Up</title>
</head>
<body>
    <div align="center">
        <h2>Sign Up</h2>
        <p>Create Your Account</p>
        
        <table>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
            <tr>
            <div class="form-group <?php echo (!empty($usr_fname_err)) ? 'has-error' : ''; ?>">
                <label>First Name</label>
                <input type="text" name="usr_fname" class="form-control" value="<?php echo $usr_fname; ?>">
                <span class="help-block"><?php echo $usr_fname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($lanem_err)) ? 'has-error' : ''; ?>">
                <label>Last Name</label>
                <input type="text" name="usr_lname" class="form-control" value="<?php echo $usr_lname; ?>">
                <span class="help-block"><?php echo $usr_lname_err; ?></span>
            </div>
            </tr>
            
            <tr>
            <div class="form-group <?php echo (!empty($usr_email_err)) ? 'has-error' : ''; ?>">
                <label>Email Address</label>
                <input type="text" name="usr_email" class="form-control" value="<?php echo $usr_email; ?>">
                <span class="help-block"><?php echo $usr_email_err; ?></span>
            </div>
            </tr>
            
            <tr>
            <div class="form-group <?php echo (!empty($usr_password_err)) ? 'has-error' : ''; ?>">
                <label>Create Password</label>
                <input type="password" name="usr_password" class="form-control" value="<?php echo $usr_password; ?>">
                <span class="help-block"><?php echo $usr_password_err; ?></span>
            </div>
            </tr>
            
            <tr>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Verify Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </tr>
            
            <tr>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            </tr>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
        </table>
        
    </div>    
</body>
</html>

<?php
include 'pageelements/footer.php';
?>