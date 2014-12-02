<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/comment.php");

$mysqli = MysqliConfiguration::getMysqli();

$topicId = $_GET["t"];
if(@isset($_SESSION["profileId"]) === false) {
	$profileId = null;
	$canEditOther= null;
} else {
	$profileId = $_SESSION["profileId"];
	$canEditOther= $_SESSION["security"]["canEditOther"];
}

if (($topicId = filter_var($topicId, FILTER_VALIDATE_INT)) === false) {
	throw (new UnexpectedValueException("Not a valid Topic Id"));
}

if ($topicId < 1) {
	throw (new UnexpectedValueException("Not a valid Topic Id"));
}
// if edit: verify that user is owner of topic or can editOther: then update.
$comments = Comment::getCommentsByTopicId($mysqli, $topicId, 100000, 1);

if ($comments !== null) {
	foreach($comments as $index => $element) {
		$html =	"<div class=\"row\">" .
			"<h2><strong>" . $element->getCommentSubject() . "</strong></h2><br>" .
			"<p>" . nl2br($element->getCommentBody()) . "</p>";
		if ($profileId === $element->getProfileId() || $canEditOther === 1) {
			$html = $html . "<a id=\"edit\" href=\"../html/comment-new-edit.html?t=$topicId&c=" . $element->getCommentId() . "\">Edit Comment</a>";
		}
		$html =	$html . "</div>";

		echo $html;
	}
} else {
	echo "<h4>Be the first to comment on this topic!</h4>";
}

