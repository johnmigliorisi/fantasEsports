<?php
require_once('includes/session.php');
require_once('includes/class_dbhandler.php');
require_once('includes/fantasy_utils.php');
if ($_SERVER['PHP_SELF'] != "/fantasy/login.php"){ 
require_once('includes/verify_login.php');
}
// Create needed objects
$dbh = new DBHandler();

// Check if database connection established successfully
if ($dbh->getInstance() === null) {
    die("No database connection");
}
?>