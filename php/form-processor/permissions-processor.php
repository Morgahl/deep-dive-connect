<?php
session_start();

// path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

// require files needed
require_once("../lib/csrf.php");
require_once("../class/security.php");
require_once("../class/user.php");

try{
	// verify csrf tokens are set
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	// verify CSRF tokens
	if(verifyCsrf($csrfName, $csrfToken) === false){
		throw (new RuntimeException("External call made."));
	}

	$securityId = filter_input(INPUT_POST,"securityOption",FILTER_VALIDATE_INT);
	$userId = filter_input(INPUT_POST,"userId",FILTER_VALIDATE_INT);
	$profileId = filter_input(INPUT_POST,"profileId",FILTER_VALIDATE_INT);

	// connect to mysqli
	$mysqli = MysqliConfiguration::getMysqli();

	$user = User::getUserByUserId($mysqli, $userId);

	$user->setSecurityId($securityId);
	$user->update($mysqli);

	header("Location: ../../permissions.php?profile=" . urlencode($profileId));
}
catch (Exception $exception){
	$_SESSION[$csrfName] = $csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to edit Permissions: " . $exception->getMessage() . "</div>";
}
