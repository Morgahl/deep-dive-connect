<?php
session_start();
require_once("php/lib/csrf.php");
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/topic.php");
?>
<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Topic</title>
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/topic.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="topic-nav row">
				<form action="recent.php">
					<button onclick="submit">Recent Topics</button>
				</form>
			</div>
			<div class="addComment"></div>
			<?php
			try {
				$mysqli = MysqliConfiguration::getMysqli();

				// Grab and sanitize all the super globals
				$profileId = isset($_SESSION["profileId"]) ? $_SESSION["profileId"] : false;
				$canEditOther = isset($_SESSION["security"]["canEditOther"]) ? $_SESSION["security"]["canEditOther"] : false;
				$topicId = filter_input(INPUT_GET,"t",FILTER_VALIDATE_INT);

				if ($topicId < 1) {
					throw (new UnexpectedValueException("Not a valid Topic Id"));
				}

				// get topic from database
				$topic = Topic::getTopicByTopicId($mysqli, $topicId);

				if ($topic !== null) {
					// prep topic
					$html =	"<div class=\"row\">" .
						"<h2><strong>" . $topic->getTopicSubject() . "</strong></h2><br>" .
						"<p>" . nl2br($topic->getTopicBody()) . "</p>";

					// if topic is owner by user or is viewed by someone with edit other
					if ($profileId === $topic->getProfileId() || $canEditOther === 1) {
						$html = $html . "<a id=\"edit\" href=\"topic-newedit.php?t=$topicId\">Edit Topic</a>";
					}

					$html =	$html . "</div>";
					// send this back to calling JS
					echo $html;
				} else {
					echo "<h1>Topic does not exist.</h1>";
				}
			} catch(Exception $exception) {
				echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to load topic: " . $exception->getMessage() . "</div>";
			}

			?>
			<div id="comments"></div>
			<div class="addComment"></div>
		</div>
	</body>
</html>