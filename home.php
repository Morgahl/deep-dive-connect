<?php
session_start();

//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the classes you need
require_once("php/lib/csrf.php");
require_once("php/class/profile.php");
require_once("php/class/topic.php");

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
					try {
						$mysqli = MysqliConfiguration::getMysqli();

						// grab topic from database
						$topics = Topic::getRecentTopics($mysqli, 100000);

						// make sure it exists
						if ($topics !== null) {
							// iterate down array and prep html
							foreach($topics as $index => $element) {
								echo	"<p><a href=\"topic.php?t=" . $element->getTopicId() . "\">" . $element->getTopicSubject() . "</a></p>" .
									"<p>" . substr($element->getTopicBody(), 0, 140) . "...</p>";
							}
						} else {
							echo "<h4>No topics currently exist.</h4>";
						}

					} catch(Exception $exception) {
						echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to load recent topics: " . $exception->getMessage() . "</div>";
					}
					?>
				</article>
			</section><!-- row -->
		</main>
	</body>
</html>