<?php

// getStatusMessage("profile-edit");
function getStatusMessage($form) {
	$message = null;
	$postArray = isset($_SESSION[$form]) ? $_SESSION[$form] : false;
	if (is_array($postArray) !== false) {
		if (array_key_exists('fail', $postArray)) {
			$message = filter_var($postArray['fail'], FILTER_SANITIZE_STRING);
			$message = "<div class=\"alert alert-danger\" role=\"alert\"><p><strong>WARNING!</strong> $message</p></div>";
		} elseif (array_key_exists('success', $postArray)) {
			$message = filter_var($postArray['success'], FILTER_SANITIZE_STRING);
			$message = "<div class=\"alert alert-success\" role=\"alert\"><p>$message</p></div>";
		}
	}
	unset($_SESSION[$form]);
	return($message);
}

// setStatusMessage("profile-edit","fail","MESSAGE GOES HERE");
function setStatusMessage($form, $status, $message){
	$_SESSION[$form][$status] = $message;
}