<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/topic.php");

try {
	$mysqli = MysqliConfiguration::getMysqli();

	// Grab and sanitize all the super globals
	$profileId = isset($_SESSION["profileId"]) ? $_SESSION["profileId"] : false;
	$createTopic = isset($_SESSION["security"]["createTopic"]) ? $_SESSION["security"]["createTopic"] : false;
	$canEditOther = isset($_SESSION["security"]["canEditOther"]) ? $_SESSION["security"]["canEditOther"] : false;
	$topicId = filter_input(INPUT_GET,"t",FILTER_VALIDATE_INT);


	// verify CSRF tokens
	// todo: add CSRF token validation

	// verify that the form-processor was properly filled out
	if ($profileId === false) {
		throw(new RuntimeException("User not logged in."));
	}

	// verify user is authorized to create topics
	if($createTopic === 1) {
		$form = array();
		// check if this is a new topic or if user is editing an existing one
		if($topicId === false) {
			// user creating a new topic
			$form["subject"] = "";
			$form["body"] = "";
		} else {

			if ($topicId < 1) {
				throw (new UnexpectedValueException("Not a valid Topic Id"));
			}

			$topic = Topic::getTopicByTopicId($mysqli, $topicId);

			// if edit: verify that user is owner of topic or can editOther: then update.
			if($topic->getProfileId() === $profileId || $canEditOther === 1) {

				if ($topic === null) {
					throw (new UnexpectedValueException("Not a valid Topic Id"));
				}

				$form["subject"] = $topic->getTopicSubject();
				$form["body"] = $topic->getTopicBody();
			}
		}
		// return json for topic text areas
		echo json_encode($form);
	}
} catch(Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to load topic to edit: " . $exception->getMessage() . "</div>";
}