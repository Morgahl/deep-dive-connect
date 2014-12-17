<?php
/**
 * Created in collaboration by:
 *
 * Gerardo Medrano GMedranoCode@gmail.com
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez <schavez256@yahoo.com>
 * Joseph Bottone hi@oofolio.com
 *
 */
session_start();

// path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

// require files needed
require_once("../lib/csrf.php");
require_once("../class/security.php");
require_once("../class/user.php");
require_once("../class/profile.php");
require_once("../lib/status-message.php");

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

	$security = Security::getSecurityBySecurityId($mysqli, $securityId);
	$profile = Profile::getProfileByProfileId($mysqli, $profileId);

	setStatusMessage("permissions", "success", $profile->getFirstName() . " is now a ". $security->getDescription() );

	header("Location: ../../permissions.php?profile=" . urlencode($profileId));
}
catch (Exception $exception){
	$_SESSION[$csrfName] = $csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to edit Permissions: " . $exception->getMessage() . "</div>";
}
