<?php
try {
	require_once("/etc/apache2/capstone-mysql/ddconnect.php");
	require_once("php/class/topic.php");

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

	echo	"<form action=\"topic-newedit.php\">" .
		"<input type=\"submit\" value=\"Create a Topic\">" .
		"</form>";

} catch(Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to load recent topics: " . $exception->getMessage() . "</div>";}
?>