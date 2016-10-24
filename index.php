<?php
require_once('includes/loader.php');

$tourneyList = find_all_tournaments($dbh);
$leagueList = find_all_leagues($dbh);

?>
<!DOCTYPE html>
<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Lato|Merriweather" rel="stylesheet">
<link rel="stylesheet" href="css/base.css" />

</head>
<body>
<header class="super-header">
<p>Welcome <?php echo $_SESSION["username"]; ?> </p>
</header>
<header class="flex-header">
	<div class="flex-name"><h1>The HOC/SOL/MHK Fantasy E-Sports spot</h1></div>
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
</article>
<aside class="flex-main-aside">
	<div class="aside-card">
		<h3>Current Tournaments</h3>
		<ul>
		<?php foreach ($tourneyList as $row) { ?>
			<li><?php echo $row['tournament_name']; ?></li>
		<?php } ?>
		</ul>
	</div>
	<div class="aside-card">
		<h3>Current Leagues</h3>
	</div>
</aside>
</main>
<footer>
<h3>The HOC/SOL/MHK Fantasy E-Sports spot</h3>
</footer>
</body>
</html>