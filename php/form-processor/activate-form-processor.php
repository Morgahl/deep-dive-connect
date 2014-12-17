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
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/profile.php");
require_once("../class/user.php");
require_once("../lib/csrf.php");

try {
	// verify csrf tokens are set
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	// verify CSRF tokens
	if(verifyCsrf($csrfName, $csrfToken) === false){
		throw (new RuntimeException("External call made."));
	}

	$mysqli = MysqliConfiguration::getMysqli();

	$authToken = filter_input(INPUT_POST, "authToken", FILTER_SANITIZE_STRING);


	if ($authToken === null) {
		throw(new RuntimeException("Form variables incomplete or missing."));
	}

	if ($authToken === false) {
		throw(new RuntimeException("Form variables are malformed."));
	}

	$newUser = User::getUserByAuthKey( $mysqli, $authToken);
	$newProfile = Profile::getProfileByUserId($mysqli, $newUser->getUserId());

	if ($newUser !== null || $newProfile !== null) {
		$newUser->setAuthKey(null);
		$newUser->update($mysqli);
	}

	echo "<div class='alert alert-success' role='alert'>Your account has been authenticated.</div>";

	header("Location: ../../index.php");

} catch(Exception $e) {
	echo "<div class='alert alert-danger' role='alert'>".$e->getMessage()."</div>";
}
?>