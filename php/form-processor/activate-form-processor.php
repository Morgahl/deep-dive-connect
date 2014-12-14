<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 12/14/2014
 * Time: 3:44 AM
 */

session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/profile.php");
require_once("../class/user.php");

try {
	$mysqli = MysqliConfiguration::getMysqli();

	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	// verify CSRF tokens
	if(verifyCsrf($csrfName, $csrfToken) === false){
		throw (new RuntimeException("External call made."));
	}

	$authToken = filter_input(INPUT_POST, "authToken", FILTER_SANITIZE_STRING);

	if ($csrfName === null || $csrfToken === null || $authToken === null) {
		throw(new RuntimeException("Form variables incomplete or missing."));
	}

	if ($csrfName === false || $csrfToken === false || $authToken === false) {
		throw(new RuntimeException("Form variables are malformed."));
	}

	$newUser = User::getUserByAuthToken($mysqli, $authToken);
	$newProfile = Profile::getProfileByUserId($mysqli, $newUser->getUserId());

	if ($newUser !== null || $newProfile !== null) {
		$newUser->setAuthKey(null);
		$newUser->update($mysqli);
	}

	echo "<div class='alert alert-success' role='alert'> <a href='#' class='alert-link'>Your account has been authenticated. </a></div>
			<p><a href='../../index.php'>Home</a></p>";

	header("Location: ../../index.php");

} catch(Exception $e) {
	echo "<div class='alert alert-danger' role='alert'><a href='#' class='alert-link'>".$e->getMessage()."</a></div>";
}
?>