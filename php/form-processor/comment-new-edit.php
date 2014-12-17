<?php
/**
 * Created in collaboration by:
 *
 * Gerardo Medrano <GMedranoCode@gmail.com>
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez <schavez256@yahoo.com>
 * Joseph Bottone <hi@oofolio.com>
 *
 */
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/comment.php");
require_once("../lib/csrf.php");

try {
	// verify csrf tokens are set
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	// verify CSRF tokens
	if(verifyCsrf($csrfName, $csrfToken) === false){
		throw (new RuntimeException("External call made."));
	}

	$mysqli = MysqliConfiguration::getMysqli();

	// Grab and sanitize all the super globals
	$profileId = isset($_SESSION["profile"]["profileId"]) ? $_SESSION["profile"]["profileId"] : false;
	$canEditOther = isset($_SESSION["security"]["canEditOther"]) ? $_SESSION["security"]["canEditOther"] : false;
	$subject = filter_input(INPUT_POST,"commentSubject",FILTER_SANITIZE_STRING);
	$body = filter_input(INPUT_POST,"commentBody",FILTER_SANITIZE_STRING);
	$topicId = filter_input(INPUT_POST,"commentTopicId",FILTER_VALIDATE_INT);
	$commentId = filter_input(INPUT_POST,"commentCommentId",FILTER_VALIDATE_INT);

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
	header("Location: ../../topic.php?topic=" . $topicId);

} catch(Exception $exception) {
	$_SESSION[$csrfName] = $csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to create or edit comment: " . $exception->getMessage() . "</div>";
}