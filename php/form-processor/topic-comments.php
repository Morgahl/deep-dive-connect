<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/comment.php");

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

	// get topic's comments from database
	$comments = Comment::getCommentsByTopicId($mysqli, $topicId, 100000, 1);

	// make sure we got them
	if ($comments !== null) {
		// iterate across array of received objects
		foreach($comments as $index => $element) {
			// prep comments
			$html =	"<div class=\"row\">" .
				"<h2><strong>" . $element->getCommentSubject() . "</strong></h2><br>" .
				"<p>" . nl2br($element->getCommentBody()) . "</p>";

			// if user is owner of comment or can edit other give them a link to modify
			if ($profileId === $element->getProfileId() || $canEditOther === 1) {
				$html = $html . "<a id=\"edit\" href=\"comment-newedit.php?t=" . $element->getTopicId() . "&c=" . $element->getCommentId() . "\">Edit Comment</a>";
			}

			$html =	$html . "</div>";

			// send it back to calling JS
			echo $html;
		}
	} else {
		echo "<div class=\"row\"><h4>Be the first to comment on this topic!</h4></div>";
	}
} catch(Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to load comments: " . $exception->getMessage() . "</div>";
}