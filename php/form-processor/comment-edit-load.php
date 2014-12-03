<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/comment.php");

try {
	$mysqli = MysqliConfiguration::getMysqli();

	// Grab and sanitize all the super globals
	$profileId = isset($_SESSION["profileId"]) ? $_SESSION["profileId"] : false;
	$canEditOther = isset($_SESSION["security"]["canEditOther"]) ? $_SESSION["security"]["canEditOther"] : false;
	$commentId = filter_input(INPUT_GET,"c",FILTER_VALIDATE_INT);

	// verify CSRF tokens
	// todo: add CSRF token validation

	// verify that the user is logged in
	if ($profileId === false) {
		throw(new RuntimeException("User not logged in."));
	}

	$form = array();
	// check if this is a new topic or if user is editing an existing one
	if($commentId === false) {
		// user creating a new topic
		$form["subject"] = "";
		$form["body"] = "";
	} else {
		// user editing a comment
		if ($commentId < 1) {
			throw (new UnexpectedValueException("Not a valid Comment Id"));
		}

		// get comment from database
		$comment = Comment::getCommentByCommentId($mysqli, $commentId);

		// if edit: verify that user is owner of comment or can editOther: then update.
		if($comment->getProfileId() === $profileId || $canEditOther === 1) {
			if ($comment === null) {
				throw (new UnexpectedValueException("Not a valid Comment Id"));
			}

			$form["subject"] = $comment->getCommentSubject();
			$form["body"] = $comment->getCommentBody();
		}
	}

	// return json for comment text areas
	echo json_encode($form);

} catch(Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to load comment to edit: " . $exception->getMessage() . "</div>";
}