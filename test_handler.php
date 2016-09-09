 <?php
// Require needed classes
require_once('includes/class_dbhandler.php');
require_once('includes/fantasy_utils.php');

// Create needed objects
$dbh = new DBHandler();

// Check if database connection established successfully
if ($dbh->getInstance() === null) {
    die("No database connection");
}

$datetime = date("Y-m-d H:i:s");


$email = "atestemail@example.com";
$owner_name = "total_injection";
$password = "secret";
//insert_owner($dbh,$email, $owner_name, $password);
?>
<!DOCTYPE html>
<html>
<head>
<title>PDO testing</title>
 <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css"  href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">
</head>

<body>

<h3>List of Owners</h3>
<?php
$result = find_all_owners($dbh);

?>
<h3>List of Owners</h3>
<table class="table table-striped">
	<tr>
		<th>name</th>
		<th>created</th>
		<th>modified</th>
		<th>email</th>
		<th>action</th>
	</tr>
	<?php foreach ($result as $row) { ?>
	<tr>
		<td><?php echo $row['owner_name']; ?></td>
		<td><?php echo $row['created']; ?></td>
		<td><?php echo $row['modified']; ?></td>
		<td><?php echo $row['email']; ?></td>
		<td><a href="manage_owners.php<?php echo "?owner_name=" . $row['owner_name']?>">edit</a></td>
	</tr>
	<?php } ?>
	</table>
</body>

</html>