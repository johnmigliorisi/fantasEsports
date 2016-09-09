<?php

try {
	require_once("includes/db_pdo.php");
	$sql = 'SELECT * FROM owner
			ORDER BY id';
} catch (Exception $e){
	$error = $e->getMessage();
}
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
The content of the document......<br />
<?php if ($db_conn) {
	echo "<p>connection successful</p>";
} elseif (isset($error)) {
	echo "<p>$error</p>";
}
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
	<?php foreach ($db_conn->query($sql) as $row) { ?>
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