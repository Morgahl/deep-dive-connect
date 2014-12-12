<?php
/**
 * Signup HTML form
 *
 * Author Joseph Bottone  bottone.joseph@gmail.com
 */
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../lib/csrf.php");
require_once("../class/profile.php");
require_once("../class/user.php");

try {

		$mysqli = MysqliConfiguration::getMysqli();
		echo "<p>Authenticating your account</p>";
	$authToken = $_GET['authToken'];
	$newUser = User::getUserByAuthToken($mysqli, $authToken);
	$newProfile = Profile::getProfileByProfileId($mysqli, $profileId);

	if ($newUser !== null || $newProfile !== null){
		$newUser->insert($mysqli);
	}

	$_SESSION['userId'] = $newUser->getUserId();
	$_SESSION['profileId'] = $newProfile;

	echo "<div class='alert alert-success' role='alert'> <a href='#' class='alert-link'>Your account has been authenticated. You are now signed in</a></div>
			<p><a href='../../index.php'>Home</a></p>";
}catch(Exception $e){
		echo "<div class='alert alert-danger' role='alert'><a href='#' class='alert-link'>".$e->getMessage()."</a></div>";
}
?>
?>