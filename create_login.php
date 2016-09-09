<?php
require_once('includes/session.php');
require_once('includes/class_dbhandler.php');
require_once('includes/fantasy_utils.php');
?>

<?php
$username = "";

if (isset($_POST['submit'])) {
  // Process the form
  echo $_POST["submit"];
  echo "<br />";
  echo "<hr />";
  // validations
  // $required_fields = array("username", "password");
  // validate_presences($required_fields);
  
  if (empty($errors)) {
    // Attempt Login

		$username = $_POST["username"];
		$password = $_POST["password"];
		
	// $found_admin = attempt_login($username, $password);

    if ($found_admin) {
      // Success
			// Mark user as logged in
			$_SESSION["admin_id"] = $found_admin["id"];
			$_SESSION["username"] = $found_admin["username"];
      redirect_to("admin.php");
    } else {
      // Failure
      $_SESSION["message"] = "Username/password not found.";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>
<!DOCTYPE html>
<html>
<head>
 <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css"  href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">
	<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	 <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	 <script type="text/javascript" src="js/bootstrap_validator_master/js/validator.js"></script>
<title>create account or login</title>
</head>

<body>
<?php
$password = "secret";
$hash = password_hash($password, PASSWORD_BCRYPT);


echo $hash;
echo "<br />";
$password2 = "secret";
$verified = password_verify($password2, $hash);
if (!$verified) {
	echo "denied";
} else {
	echo "welcome!";
}


?>
 <div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Sign In</div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form method="post" id="loginform" class="form-horizontal" data-toggle="validator" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                            <label>User Name</label>
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="use your email address" required>                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="password" placeholder="password"  required>
                                    </div>
                                    

                                
                            <div class="input-group">
                                      <div class="checkbox">
                                        <label>
                                          <input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
                                        </label>
                                      </div>
                                    </div>


                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
                                      <button type="submit" class="btn btn-success" name="submit" value="login">Login</button>

                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                            Don't have an account! 
                                        <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                            Sign Up Here
                                        </a>
                                        </div>
                                    </div>
                                </div>    
                            </form>     



                        </div>                     
                    </div>  
        </div>
        <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Sign Up</div>
                            <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign In</a></div>
                        </div>  
                        <div class="panel-body" >
                            <form method="post" id="signupform" class="form-horizontal" data-toggle="validator" role="form" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control" name="email" placeholder="Email Address" data-error="Bruh, that email address is invalid" required>
										<div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="username" class="col-md-3 control-label">User Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="username" placeholder="User Name" required>
									</div>
                                </div>
                        
                                <div class="form-group">
                                    <label for="password" class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" data-minlength="6" class="form-control" id="passwd" name="passwd" placeholder="Password" required>
										<span class="help-block">Minimum of 6 characters</span>
                                    </div>
                                </div>
								<div class="form-group">
                                    <label for="confpassword" class="col-md-3 control-label">Confirm Password</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="confpasswd" data-match="#passwd" data-match-error="Whoops, these don't match" placeholder="Confirm Password" required>
										<div class="help-block with-errors"></div>
                                    </div>
                                </div>
						

                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn btn-success" name="submit" value="signup">Sign Up</button>
                                         
                                    </div>
                                </div>
							</form>
						</div>
                         </div>
                    </div>

               
               
                
         </div> 
    </div>
</body>

</html>