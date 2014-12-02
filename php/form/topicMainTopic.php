<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/topic.php");

$mysqli = MysqliConfiguration::getMysqli();

$topicId = $_GET["t"];

if (($topicId = filter_var($topicId, FILTER_VALIDATE_INT)) === false) {
	throw (new UnexpectedValueException("Not a valid Topic Id"));
}

if ($topicId < 1) {
	throw (new UnexpectedValueException("Not a valid Topic Id"));
}
// if edit: verify that user is owner of topic or can editOther: then update.
$topic = Topic::getTopicByTopicId($mysqli, $topicId);

if ($topic !== null) {
	echo 	"<div class=\"row\">" .
		"<h1><strong>" . $topic->getTopicSubject() . "</strong></h1><br>" .
			"<p>" . $topic->getTopicSubject() . "</p>" .
			"</div>";
} else {
	echo "<h1>Topic does not exist.</h1>";
}

