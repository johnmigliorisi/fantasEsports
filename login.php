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
    // Process the form
	$username = $_POST["username"];
	$password = $_POST["password"];
    //attempt login
    $login = attempt_login($dbh, $username, $password);
    if($login === true){
        echo "<p>Welcome " . $_SESSION["username"] . "</p>";
    } else {
        // Tell them to try again
        echo "<p class='warning'>User Name / Password not recognized. Please try again.</p>";
    }
}  // end: if (isset($_POST['submit']))

?>
<!DOCTYPE html>
<html>
<head>
 <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css"  href="bootstrap/css/bootstrap.css">
 <!--<link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">
	<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	 <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	 <script type="text/javascript" src="js/bootstrap_validator_master/js/validator.js"></script>-->

     <!-- custom styles -->
     <link rel="stylesheet" type="text/css" href="css/custom_styles.css">
<title>create account or login</title>
</head>

<body>
    <div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="col-md-4 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <form method="post" id="loginform" class="form-horizontal" data-toggle="validator" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label>User Name</label>           
                <input id="login-username" type="text" class="form-control" name="username" value="<?php echo htmlentities($username) ?>" placeholder="make it cool" required>  
                 <label>Password</label>                                         
                <input id="login-password" type="password" class="form-control" name="password" placeholder="password"  required>
                <button type="submit" class="btn btn-success" name="submit" value="login">Login</button> 
            </form>     
        </div>
    </div>
</body>

</html>