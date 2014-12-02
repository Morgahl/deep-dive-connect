<?php
session_start();
require_once("../class/topic.php");

try {
	// verify that the form was properly filled out
	if (@isset($_POST["subject"]) === false || @isset($_POST["body"]) === false || @isset($_SESSION["profileId"]) === false) {
		throw(new RuntimeException("Form variables incomplete or missing."));
	}

	// verify CSRF tokens
	// todo: add CSRF token validation

	// verify user is authorized to create topics
	// todo: add user auth for topic creation

	// check if this is a new topic or if user is editing an existing one
	// if new: insert into database
	// if edit: verify that user is owner of topic or can editOther: then update.
	// todo: add in topic check to determine if new or editing

	// return created topicId to calling JS

} catch(Exception $exception) {
	// todo: add catch
}