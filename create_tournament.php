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
	$tournamentname = $_POST["tournamentname"];
    $startdate = date('Y-m-d H:i:s', strtotime($_POST["startdate"]));
	$enddate = date('Y-m-d H:i:s', strtotime($_POST["enddate"]));
    $format = $_POST["format"];
    $tournamentadmin = $_POST["tournamentadmin"];
    $tournamentadminemail = $_POST["tournamentadminemail"];

    //attempt to add the tournament
    $addTournament = insert_tournament($dbh, $tournamentname, $startdate, $enddate, $format, $tournamentadmin, $tournamentadminemail);
    if(!$addTournament){
        echo "failed to create tournament...";
    } else {
        echo $tournamentname . " created!<br />";
    }
    
}  // end: if (isset($_POST['submit']))

?>
<!DOCTYPE html>
<html>
<head>
 <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css"  href="bootstrap/css/bootstrap.css">


    <!-- custom styles -->
    <link rel="stylesheet" type="text/css" href="css/custom_styles.css">

    <script type="text/javascript" src="js/jquery-3.1.0.js"></script>
    <script type="text/javascript" src="js/pickadate.js-master/lib/picker.js"></script>
    <script type="text/javascript" src="js/pickadate.js-master/lib/picker.date.js"></script>
    <link rel="stylesheet" href="js/pickadate.js-master/lib/themes/default.css" id="theme_base">
    <link rel="stylesheet" href="js/pickadate.js-master/lib/themes/default.date.css" id="theme_date">
    <link rel="stylesheet" href="js/pickadate.js-master/lib/themes/default.time.css" id="theme_time">
     <script type="text/javascript">
    $(document).ready(function() {
        $('.datepicker').pickadate();
    });
        
     </script>
<title>create tournament</title>
</head>

<body>
    <div class="container">  
    <h2>Use this form to create a Tournament</h2>  
        <div id="loginbox" style="margin-top:50px;" class="col-md-4 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <form method="post" id="loginform" class="form-horizontal" data-toggle="validator" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            
                <label for="tournamentname">Tournament Name</label>           
                    <input type="text" class="form-control" name="tournamentname" value="" placeholder="" required>  
                
                <label for="startdate">Start Date</label>           
                    <input type="text" class="form-control datepicker" name="startdate" id="startdate" value="" placeholder="" required>  
                
                <label for="enddate">End Date</label>
                    <input type="password" class="form-control datepicker" name="enddate" id="enddate" placeholder="" required>
            
                <label for="format">Format</label>
                    <select class="form-control" name="format" required>
                        <option value="round robin" selected>round robin</option>
                        <option value="single elimination">single elimination</option>
                        <option value="double elimination">double elimination</option>
                    </select>

                <label for="tournamentadmin">Tournament Admin</label>           
                    <input type="text" class="form-control" name="tournamentadmin" value="" placeholder="" required>

                <label for="tournamentadminemail">Tournament Admin Email</label>           
                    <input type="text" class="form-control" name="tournamentadminemail" value="" placeholder="" required> 
                    
                                     
                <button type="submit" class="btn btn-success" name="submit" value="createtournament">Create Tournament</button>
            </form>     
        </div>
    </div>
</body>

</html>