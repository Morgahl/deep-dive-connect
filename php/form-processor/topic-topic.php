<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/topic.php");

try {
	$mysqli = MysqliConfiguration::getMysqli();

	// Grab and sanitize all the super globals
	$profileId = isset($_SESSION["profileId"]) ? $_SESSION["profileId"] : false;
	$canEditOther = isset($_SESSION["security"]["canEditOther"]) ? $_SESSION["security"]["canEditOther"] : false;
	$topicId = filter_input(INPUT_GET,"t",FILTER_VALIDATE_INT);

	// verify CSRF tokens
	// todo: add CSRF token validation

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

