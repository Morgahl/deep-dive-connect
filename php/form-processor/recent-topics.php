<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/topic.php");

try {
	$mysqli = MysqliConfiguration::getMysqli();

	// verify CSRF tokens
	// todo: add CSRF token validation

	// grab topic from database
	$topics = Topic::getRecentTopics($mysqli, 100000);

	// make sure it exists
	if ($topics !== null) {
		// iterate down array and prep html
		foreach($topics as $index => $element) {
			echo "<p><a href=\"topic.php?t=" . $element->getTopicId() . "\">" . $element->getTopicSubject() . "</a></p>";
		}
	} else {
		echo "<h4>No topics currently exist.</h4>";
	}

} catch(Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to load recent topics: " . $exception->getMessage() . "</div>";
}