<?php
session_start();

//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the classes you need
require_once("php/lib/csrf.php");
require_once("php/class/profile.php");

// connect to mySQL
$mysqli = MysqliConfiguration::getMysqli();

//obtain profileId from $_SESSION
$profileId = $_SESSION["profileId"];

//obtain profile by userId
$profile = Profile::getProfileByProfileId($mysqli, $profileId);

//set values into the session so that html can access profile info for user
$_SESSION["firstName"] = $profile->getFirstName();
$_SESSION["lastName"] = $profile->getLastname();
$_SESSION["location"] = $profile->getLocation();
$_SESSION["description"] = $profile->getDescription();
$_SESSION["picFileName"] = $profile->getProfilePicFileName();



?>
<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<title>Home</title>
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	</head>
	<body>
		<main class="container">
			<nav class="row">
				<?php

				?>
			</nav>
			<section class="row">
				<aside class="col-md-4">
					<?php

					?>
				</aside>
				<article id="content" class="col-md-8 col-xs-12">
					<?php
					require_once("php/stub/recent.php");
					?>
				</article>
			</section><!-- row -->
		</main>
	</body>
</html>