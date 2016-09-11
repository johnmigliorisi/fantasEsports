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
//grab the list of current tournaments for the tourney id select field
$results = find_all_leagues($dbh);


if (isset($_POST['submit'])) {
    // Process the form
	$teamname = $_POST["teamname"];
    $leagueid = $_POST["leagueid"];

    //attempt to add the team
    $addTeam = insert_fantasy_team($dbh, $teamname, $_SESSION["user_id"], $leagueid);
    if(!$addTeam){
        echo "failed to create league...";
    } else {
        echo $teamname . " created!<br />";
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


<title>create fantasy team</title>
</head>

<body>
    <div class="container">  
    <h2>Use this form to create a Fantasy team and add it to a league</h2>  
        <div id="loginbox" style="margin-top:50px;" class="col-md-4 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <form method="post" id="leagueform" class="form-horizontal" data-toggle="validator" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            
                <label for="teamname">Name Your Team</label>           
                    <input type="text" class="form-control" name="teamname" value="" placeholder="" required>  
            

                <label for="leagueid">Select a League</label>
                    <select class="form-control" name="leagueid" required>
                    <option value="" selected>Choose a league</option>
                    <?php foreach ($results as $row) { ?>

                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>"
                    <?php } ?>
                    </select>
                    
                                     
                <button type="submit" class="btn btn-success" name="submit" value="createteam">Create Team</button>
            </form>     
        </div>
    </div>
</body>

</html>