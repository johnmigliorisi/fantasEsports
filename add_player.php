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


if (isset($_POST['submit'])) {
    // Process the form
	$playerName = $_POST["playerName"];
    $playerTag = $_POST["playerTag"];
    $bio = $_POST["bio"];
    $ranking = $_POST["rank"];


    //upload the image file
    //first you have to set where you want to store files
    //in this image upload script we keep file in folder upload
    //$_FILES['ufile']['name']; = upload file name
    //for example upload file name click4knowledge.gif . $path will be upload/click4knowledge.gif
     
    $path = "Player_pictures/".$_FILES['playerPic']['name'];
    if($_FILES['playerPic']['name'] != "")
    {
    if(copy($_FILES['playerPic']['tmp_name'], $path))
    {
    echo "Successful<BR/>";
    // print uploaded data after successful upload
    echo "File Name :".$_FILES['playerPic']['name']."<BR/>";
    echo "File Size :".$_FILES['playerPic']['size']."<BR/>";
    echo "File Type :".$_FILES['playerPic']['type']."<BR/>";
    echo "<img src=\"$path\" width=\"150\" height=\"150\">";
    }
    else
    {
    echo "Error";
    }
    }

    //attempt to add the player
    $addPlayer = insert_player($dbh, $playerName, $playerTag, $bio, $path, $ranking);
    if(!$addPlayer){
        echo "failed to add Player...";
    } else {
        echo $playerName . " created!<br />";
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

<title>add player</title>
</head>

<body>
    <div class="container">  
    <h2>Use this form to add a player</h2>  
        <div id="loginbox" style="margin-top:50px;" class="col-md-4 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <form method="post" id="addplayer" class="form-horizontal" data-toggle="validator" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <!--this max file size check is for user convenience only-->
            <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
            
                <label for="playerName">Player Name</label>           
                    <input type="text" class="form-control" name="playerName" value="" placeholder="" required>  
            
                <label for="playerTag">Player Tag</label>           
                    <input type="text" class="form-control" name="playerTag" value="" placeholder="" required>  

                <label for="bio">Bio</label>
                    <textarea name="bio" class="form-control" value="" placeholder=""></textarea>

                <label for="rank">Player Rank</label>           
                    <input type="text" class="form-control" name="rank" value="" placeholder="" required> 

                <label for="playerPic">Player Picture</label>   
                    <input type="file" class="form-control" name="playerPic" />
                    
                                     
                <button type="submit" class="btn btn-success" name="submit" value="addplayer">Add Player</button>
            </form>     
        </div>
    </div>
</body>

</html>