<?php
require_once('includes/loader.php');
echo "<p>Welcome " . $_SESSION["username"] . "</p>";
?>

<?php
//grab the list of current tournaments for the tourney id select field
$results = find_all_tournaments($dbh);


if (isset($_POST['submit'])) {
    // Process the form
	$leaguename = $_POST["leaguename"];
    $num_teams = $_POST["num_teams"];
    $tournamentid = $_POST["tournamentid"];

    //attempt to add the tournament
    $addLeague = insert_league($dbh, $leaguename, $num_teams, $tournamentid);
    if(!$addLeague){
        echo "failed to create league...";
    } else {
        echo $leaguename . " created!<br />";
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


<title>create league</title>
</head>

<body>
    <div class="container">  
    <h2>Use this form to create a league</h2>  
        <div id="loginbox" style="margin-top:50px;" class="col-md-4 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <form method="post" id="leagueform" class="form-horizontal" data-toggle="validator" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            
                <label for="leaguename">League Name</label>           
                    <input type="text" class="form-control" name="leaguename" value="" placeholder="" required>  
            
                <label for="num_teams">Number of Teams</label>           
                    <input type="text" class="form-control" name="num_teams" value="" placeholder="" required>  

                <label for="tournamentid">Select a Tournament</label>
                    <select class="form-control" name="tournamentid" required>
                    <option value="" selected>Choose a tournament</option>
                    <?php foreach ($results as $row) { ?>

                        <option value="<?php echo $row['id']; ?>"><?php echo $row['tournament_name']; ?></option>"
                    <?php } ?>
                    </select>
                    
                                     
                <button type="submit" class="btn btn-success" name="submit" value="createleague">Create League</button>
            </form>     
        </div>
    </div>
</body>

</html>