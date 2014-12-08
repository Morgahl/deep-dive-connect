<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/topic.php");
require_once("../lib/csrf.php");

try {
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	// verify CSRF tokens
	if(verifyCsrf($_POST["csrfName"], $_POST["csrfToken"]) === false){
		throw (new RuntimeException("External call made."));
	}

	$mysqli = MysqliConfiguration::getMysqli();

	// Grab and sanitize all the super globals
	$profileId = isset($_SESSION["profile"]["profileId"]) ? $_SESSION["profile"]["profileId"] : false;
	$createTopic = isset($_SESSION["security"]["createTopic"]) ? $_SESSION["security"]["createTopic"] : false;
	$canEditOther = isset($_SESSION["security"]["canEditOther"]) ? $_SESSION["security"]["canEditOther"] : false;
	$subject = filter_input(INPUT_POST,"topicSubject",FILTER_SANITIZE_STRING);
	$body = filter_input(INPUT_POST,"topicBody",FILTER_SANITIZE_STRING);
	$topicId = filter_input(INPUT_POST,"topic",FILTER_VALIDATE_INT);

	// verify that the form-processor was properly filled out
	if ($subject === false || $body === false || $profileId === false) {
		throw(new RuntimeException("Form variables incomplete or missing."));
	}

	// verify user is authorized to create topics
	if($createTopic === 1) {
		// check if this is a new topic or if user is editing an existing one
		if($topicId === false || $topicId === null) {
			// user creating a topic
			$topic = new Topic(null, $profileId, null, $subject, $body);
			$topic->insert($mysqli);
			$topicId = $topic->getTopicId();
		} else {
			// user editing a topic

			if ($topicId < 1) {
				throw (new UnexpectedValueException("Not a valid Topic Id"));
			}

			// grab from the database
			$topic = Topic::getTopicByTopicId($mysqli, $topicId);

			// if edit: verify that user is owner of topic or can editOther: then update.
			if($topic->getProfileId() === $profileId || $canEditOther === 1) {
				// make sure we got something
				if ($topic === null) {
					throw (new UnexpectedValueException("Not a valid Topic"));
				}

				// set values and update
				$topic->setTopicSubject($subject);
				$topic->setTopicBody($body);
				$topic->update($mysqli);
			}
		}
		// return created topicId to calling JS
		header("Location: ../../topic.php?topic=" . $topicId);
	}
} catch(Exception $exception) {
	$_SESSION[$csrfName] = $csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to create or edit topic: " . $exception->getMessage() . "</div>";
}