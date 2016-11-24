<?php

require('controllers/UserController.php');
require('controllers/TournamentController.php');

$userObj = new UserController();
$users = $userObj->find();
$tournamentObj = new TournamentController();
$tournaments = $tournamentObj->find();
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
<h2>What's the Haps?</h2>
	<p>Sooo, during the 2016 HOC Winter Tournament a group of us were hanging out spectating a match, discussing all manner of important and adult topics, when Hockeyplaya and Nolja hit upon the idea of running a fantasy league based on our UT tournaments. How cool would that be right? We would often have around 20 people spectating matches so why not take it up a notch?</p>
	<p>Here we will be able to run fantasy leagues across all of our UT communities. We are able to set up tournaments, define the list of participating players and set up leagues based on them. Team owners will be able to draft and manage their teams and play against each other in typical fantasy sports style.</p>
	<p>For the moment scoring is going to be pretty manual until I figure out how to automate it. Maybe one of the awesome coders out there will help me get that part in place.</p>
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
		<?php if ($tournaments): ?>
			<ul>
			<?php foreach ($tournaments as $tournament): ?>
				<li><?= $tournament['tournament_name'] ?></li>
			<?php endforeach; ?>
			</ul>
		<?php else: ?>
        	<p>No tournaments yet!!</p>
    	<?php endif; ?>
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