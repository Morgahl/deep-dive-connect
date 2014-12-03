<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/comment.php");

try {
	$mysqli = MysqliConfiguration::getMysqli();

	// verify that the form-processor was properly filled out
	if (@isset($_POST["subject"]) === false || @isset($_POST["body"]) === false || @isset($_SESSION["profileId"]) === false || @isset($_GET["t"]) === false) {
		throw(new RuntimeException("Form variables incomplete or missing."));
	}

	$profileId = $_SESSION["profileId"];
	$subject = $_POST["subject"];
	$body = $_POST["body"];
	$topicId = $_GET["t"];
	$createTopic = $_SESSION["security"]["createTopic"];
	$canEditOther = $_SESSION["security"]["canEditOther"];

	// verify CSRF tokens
	// todo: add CSRF token validation

	// check if this is a new comment or if user is editing an existing
	if(@isset($_GET["c"]) === false || $_GET["c"] === "undefined") {
		// user creating a comment
		$comment = new Comment(null, $topicId, $profileId, null, $subject, $body);
		$comment->insert($mysqli);
	} else {
		// user editing a comment
		$commentId = $_GET["c"];

		if(($commentId = filter_var($commentId, FILTER_VALIDATE_INT)) === false) {
			throw (new UnexpectedValueException("Not a valid Comment Id"));
		}

		if($commentId < 1) {
			throw (new UnexpectedValueException("Not a valid Comment Id"));
		}
		// if edit: verify that user is owner of comment or can editOther: then update.
		$comment = Comment::getCommentByCommentId($mysqli, $commentId);

		if($comment === null) {
			throw (new UnexpectedValueException("Not a valid Comment Id"));
		}

		if($comment->getProfileId() === $profileId || $canEditOther === 1) {
			$comment->setCommentSubject($subject);
			$comment->setCommentBody($body);
			$comment->update($mysqli);
		}
	}



	// return created topicId to calling JS
	echo $comment->getTopicId();

} catch(Exception $exception) {
	// todo: add catch
}