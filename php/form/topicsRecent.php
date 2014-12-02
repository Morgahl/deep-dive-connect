<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../php/class/topic.php");

$mysqli = MysqliConfiguration::getMysqli();

$topics = Topic::getRecentTopics($mysqli, 10);

if ($topics !== null) {
	foreach($topics as $index => $element) {
		echo "<p><a href=\"../html/topic?t=" . $element["topicId"] . "\">" . $element["subject"] . "</a></p>";
	}
} else {
	echo "No topics currently exist.";
}

