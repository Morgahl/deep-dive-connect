<?php

// getStatusMessage("profile-edit");
function getStatusMessage($form) {
	$message = null;
	$postArray = filter_input(INPUT_POST, $form, FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
	if (is_array($postArray) !== false) {
		if (array_key_exists('fail', $postArray)) {
			$message = filter_var($postArray['fail'], FILTER_SANITIZE_STRING);
			$message = "<div class=\"alert alert-danger\" role=\"alert\"><p><strong>WARNING!</strong> $message</p></div>";
		} elseif (array_key_exists('success', $postArray)) {
			$message = filter_var($postArray['success'], FILTER_SANITIZE_STRING);
			$message = "<div class=\"alert alert-success\" role=\"alert\"><p>$message</p></div>";
		}
	}
	return($message);
}

// setStatusMessage("profile-edit","fail","MESSAGE GOES HERE");
function setStatusMessage($form, $status, $message){
	$_POST[$form][$status] = $message;
}