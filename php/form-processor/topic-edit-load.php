<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/topic.php");

try {
	$mysqli = MysqliConfiguration::getMysqli();

	// verify that the form-processor was properly filled out
	if (@isset($_SESSION["profileId"]) === false) {
		throw(new RuntimeException("User not logged in."));
	}

	$profileId = $_SESSION["profileId"];
	$createTopic = $_SESSION["security"]["createTopic"];
	$canEditOther = $_SESSION["security"]["canEditOther"];

	// verify CSRF tokens
	// todo: add CSRF token validation

	// verify user is authorized to create topics
	if($createTopic === 1) {
		$form = array();
		// check if this is a new topic or if user is editing an existing one
		if(@isset($_GET["t"]) === false || $_GET["t"] === "undefined") {
			// user creating a new topic
			$form["subject"] = "";
			$form["body"] = "";
		} else {
			// user editing a topic
			$topicId = $_GET["t"];
			if (($topicId = filter_var($topicId, FILTER_VALIDATE_INT)) === false) {
				throw (new UnexpectedValueException("Not a valid Topic Id"));
			}

			if ($topicId < 1) {
				throw (new UnexpectedValueException("Not a valid Topic Id"));
			}
			// if edit: verify that user is owner of topic or can editOther: then update.
			$topic = Topic::getTopicByTopicId($mysqli, $topicId);

			if ($topic === null) {
				throw (new UnexpectedValueException("Not a valid Topic Id"));
			}

			if($topic->getProfileId() === $profileId || $canEditOther === 1) {
				$form["subject"] = $topic->getTopicSubject();
				$form["body"] = $topic->getTopicBody();
			}
		}

		// return json for topic text areas
		echo json_encode($form);
	}
} catch(Exception $exception) {
	// todo: add catch
}