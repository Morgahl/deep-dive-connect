<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/comment.php");

$mysqli = MysqliConfiguration::getMysqli();

$topicId = $_GET["t"];

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
		echo 	"<div class=\"row\">" .
			"<h1><strong>" . $element->getCommentSubject() . "</strong></h1><br>" .
			"<p>" . $element->getCommentSubject() . "</p>" .
			"</div>";
	}
} else {
	echo "<h4>Be the first to comment on this topic!</h4>";
}

