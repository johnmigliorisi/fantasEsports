<?php
require_once('includes/session.php');
require_once('includes/class_dbhandler.php');
require_once('includes/fantasy_utils.php');
// Create needed objects
$dbh = new DBHandler();

// Check if database connection established successfully
if ($dbh->getInstance() === null) {
    die("No database connection");
}
?>

<?php
$username = "";


if (isset($_POST['submit'])) {
    var_dump($_POST['submit']);
    echo "<br/>";
    // Process the form
	$username = $_POST["username"];
    $email = $_POST["email"];
	$password = $_POST["password"];

    //attempt to create the account
    $creationMessage = create_account($dbh, $username, $email, $password);
    echo $creationMessage . "<br/>";
    
}  // end: if (isset($_POST['submit']))

?>
<!DOCTYPE html>
<html>
<head>
 <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css"  href="bootstrap/css/bootstrap.css">


     <!-- custom styles -->
     <link rel="stylesheet" type="text/css" href="css/custom_styles.css">
<title>create account</title>
</head>

<body>
    <div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="col-md-4 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <form method="post" id="createaccount" class="form-horizontal" data-toggle="validator" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="username">User Name</label>           
                    <input type="text" data-minlength="2" class="form-control" name="username" value="<?php echo htmlentities($username) ?>" placeholder="Minimum of 2 characters" required>  
                
                <label for="email">Email</label>           
                    <input type="text" class="form-control" name="email" value="<?php echo htmlentities($email) ?>" placeholder="email" required>  
                
                <label for="password">Password</label>
                    <input type="password" data-minlength="6" class="form-control" id="passwd" name="password" placeholder="Minimum of 6 characters" required>
                    <span class="help-block"></span>
            
                <label for="confpassword">Confirm Password</label>
                    <input type="password" class="form-control" name="confpasswd" data-match="#passwd" data-match-error="Whoops, these don't match" placeholder="Confirm Password" required>
                    <div class="help-block with-errors"></div>
                                     
                <button type="submit" class="btn btn-success" name="submit" value="signup">Sign Up</button>
            </form>     
        </div>
    </div>
</body>

</html>