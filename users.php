<?php

require('controllers/UserController.php');

$userObj = new UserController();
$users = $userObj->find();
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Lato|Merriweather" rel="stylesheet">
<link rel="stylesheet" href="css/base.css" />

</head>
<body>
<header class="flex-header">
	<div class="flex-name"><h1>For Teh Win!</h1></div>
	<div class="flex-nav">
		<div class=""><a href="">Leagues</a></div>
		<div class=""><a href="">My Teams</a></div>
		<div class=""><a href="">Profile</a></div> 
	</div>
</header>
<main class="flex-main">
<article class="flex-main-article">
	<?php if ($users): ?>
        <ul>
            <?php foreach ($users as $user): ?>
            <li><a class="edit" href="edit.php?id=<?= $user['id'] ?>">Edit</a> <a class="delete" href="list_users.php?id=<?= $user['id'] ?>">Delete</a> <span><?= $user['owner_name'] ?> </span></li>
            <?php endforeach; ?>
            <li><a class="add" href="add.php">Add a user</a></li>
        </ul>
    <?php else: ?>
        <p>No users yet!!</p>
    <?php endif; ?>
</article>
<aside class="flex-main-aside">
	<div class="aside-card">
		<h3>Tournaments</h3>
		<ul>
		<?php foreach ($tourneyList as $row) { ?>
			<li><?php echo $row['tournament_name']; ?></li>
		<?php } ?>
		</ul>
	</div>
	<div class="aside-card">
		<h3>Leagues</h3>
		<ul>
		<?php foreach ($leagueList as $row) { ?>
			<li><?php echo $row['name']; ?></li>
		<?php } ?>
		</ul>
	</div>
</aside>
</main>
<footer>
<h3>For Teh Win! - An HOC/SOL/MHK Fantasy E-Sports spot</h3>
</footer>
</body>
</html>