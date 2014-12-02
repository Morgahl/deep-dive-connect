<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/topic.php");

try {
	$mysqli = MysqliConfiguration::getMysqli();

	// verify that the form was properly filled out
	if (@isset($_POST["subject"]) === false || @isset($_POST["body"]) === false || @isset($_SESSION["profileId"]) === false) {
		throw(new RuntimeException("Form variables incomplete or missing."));
	}

	$profileId = $_SESSION["profileId"];
	$subject = $_POST["subject"];
	$body = $_POST["body"];

	// verify CSRF tokens
	// todo: add CSRF token validation

	// verify user is authorized to create topics
	if($_SESSION["secCreateTopic"] === 1) {
		// check if this is a new topic or if user is editing an existing one
		if(empty($_POST["topic"]) === false) {
			// user creating a topic
			// if new: insert into database
			$topic = new Topic(null, $profileId, null, $subject, $body);
			$topic->insert($mysqli);
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

			if($topic->getProfileId() === $profileId || $_SESSION["secCanEditOther"] === 1) {
				$topic->setTopicSubject($subject);
				$topic->setTopicBody($body);
				$topic->update($mysqli);
			}
		}

		// return created topicId to calling JS
		echo $topic->getTopicId();
	}
} catch(Exception $exception) {
	// todo: add catch
}