<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/topic.php");

$mysqli = MysqliConfiguration::getMysqli();

if(@isset($_SESSION["profileId"]) === false) {
	$profileId = null;
	$canEditOther= null;
} else {
	$profileId = $_SESSION["profileId"];
	$canEditOther= $_SESSION["security"]["canEditOther"];
}
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
	$html =	"<div class=\"row\">" .
				"<h2><strong>" . $topic->getTopicSubject() . "</strong></h2><br>" .
				"<p>" . nl2br($topic->getTopicBody()) . "</p>";
	if ($profileId === $topic->getProfileId() || $canEditOther === 1) {
		$html = $html . "<a id=\"edit\" href=\"../html/topic-newedit.php?t=$topicId\">Edit Topic</a>";
	}
	$html =	$html . "</div>";

	echo $html;
} else {
	echo "<h1>Topic does not exist.</h1>";
}

