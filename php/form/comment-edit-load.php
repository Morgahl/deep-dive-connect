<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/comment.php");

try {
	$mysqli = MysqliConfiguration::getMysqli();

	// verify that the form was properly filled out
	if (@isset($_SESSION["profileId"]) === false) {
		throw(new RuntimeException("User not logged in."));
	}

	$profileId = $_SESSION["profileId"];
	$createTopic = $_SESSION["security"]["createTopic"];
	$canEditOther = $_SESSION["security"]["canEditOther"];

	// verify CSRF tokens
	// todo: add CSRF token validation

	// verify user is authorized to create topics
	$form = array();
	// check if this is a new topic or if user is editing an existing one
	if(@isset($_GET["c"]) === false || $_GET["c"] === "undefined") {
		// user creating a new topic
		$form["subject"] = "";
		$form["body"] = "";
	} else {
		// user editing a comment
		$commentId = $_GET["c"];

		if (($commentId = filter_var($commentId, FILTER_VALIDATE_INT)) === false) {
			throw (new UnexpectedValueException("Not a valid Comment Id"));
		}

		if ($commentId < 1) {
			throw (new UnexpectedValueException("Not a valid Comment Id"));
		}
		// if edit: verify that user is owner of comment or can editOther: then update.
		$comment = Comment::getCommentByCommentId($mysqli, $commentId);

		if ($comment === null) {
			throw (new UnexpectedValueException("Not a valid Comment Id"));
		}

		if($comment->getProfileId() === $profileId || $canEditOther === 1) {
			$form["subject"] = $comment->getCommentSubject();
			$form["body"] = $comment->getCommentBody();
		}
	}

	// return json for comment text areas
	echo json_encode($form);

} catch(Exception $exception) {
	// todo: add catch
}