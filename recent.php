<?php
session_start();
require_once("php/lib/csrf.php");
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("php/class/topic.php");
?>
<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Topics</title>
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<!--		<script type="text/javascript" src="js/recent-topics.js"></script>-->
	</head>
	<body>
		<article class="container">
			<section class="row">
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
								"<p>" . substr($element->getTopicBody(), 0, 100) . "...</p>";
						}
					} else {
						echo "<h4>No topics currently exist.</h4>";
					}

				} catch(Exception $exception) {
					echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to load recent topics: " . $exception->getMessage() . "</div>";
				}
				?>
			</section>
			<section class="row">
				<form action="topic-newedit.php">
					<input type="submit" value="Create a Topic">
				</form>
			</section>
		</article>
	</body>
</html>