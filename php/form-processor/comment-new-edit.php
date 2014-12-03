<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/comment.php");

try {
	$mysqli = MysqliConfiguration::getMysqli();

	// Grab and sanitize all the super globals
	$profileId = isset($_SESSION["profileId"]) ? $_SESSION["profileId"] : false;
	$canEditOther = isset($_SESSION["security"]["canEditOther"]) ? $_SESSION["security"]["canEditOther"] : false;
	$subject = filter_input(INPUT_POST,"subject",FILTER_SANITIZE_STRING);
	$body = filter_input(INPUT_POST,"body",FILTER_SANITIZE_STRING);
	$topicId = filter_input(INPUT_GET,"t",FILTER_VALIDATE_INT);
	$commentId = filter_input(INPUT_GET,"c",FILTER_VALIDATE_INT);


	// verify CSRF tokens
	// todo: add CSRF token validation

	// verify that the form-processor was properly filled out
	if ($subject === false || $body === false || $profileId === false || $topicId === false) {
		throw(new RuntimeException("Form variables incomplete or missing."));
	}

	// check if this is a new comment or if user is editing an existing
	if($commentId === false) {
		// user creating a comment
		$comment = new Comment(null, $topicId, $profileId, null, $subject, $body);
		$comment->insert($mysqli);
	} else {
		// user editing a comment
		if($commentId < 1) {
			throw (new UnexpectedValueException("Not a valid Comment Id"));
		}

		// grab comment from database
		$comment = Comment::getCommentByCommentId($mysqli, $commentId);

		// if edit: verify that user is owner of comment or can editOther: then update.
		if($comment->getProfileId() === $profileId || $canEditOther === 1) {
			// make sure we got it
			if($comment === null) {
				throw (new UnexpectedValueException("Not a valid Comment Id"));
			}
			// set values and update
			$comment->setCommentSubject($subject);
			$comment->setCommentBody($body);
			$comment->update($mysqli);
		}
	}

	// return created topicId to calling JS
	echo $comment->getTopicId();

} catch(Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to create or edit comment: " . $exception->getMessage() . "</div>";
}