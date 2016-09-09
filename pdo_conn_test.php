<?php

try {
	require_once("includes/db_pdo.php");
	$sql = 'SELECT * FROM player
			ORDER BY ranking DESC';
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
<table class="table table-striped">
	<tr>
		<th>name</th>
		<th>created</th>
		<th>modified</th>
		<th>ranking</th>
	</tr>
	<?php foreach ($db_conn->query($sql) as $row) { ?>
	<tr>
		<td><?php echo $row['player_name']; ?></td>
		<td><?php echo $row['created']; ?></td>
		<td><?php echo $row['modified']; ?></td>
		<td><?php echo $row['ranking']; ?></td>
	</tr>
	<?php } ?>
	</table>
</body>

</html>