<?php
/**
 * signup and login form processor
 *
 * @author Joseph Bottone <bottone.joseph@gmail.com>
 */


// connect to mySQL
$mysqli = MysqliConfiguration::getMysqli();

//obtain email from $_SESSION
$email = $_POST["email"];
$password = $_POST["password"];

//obtain user by userId
$user = User::getUserByEmail($mysqli, $email);

if(isset($user) === false){
	//use bootstrap div alert to echo to user
	echo "<div class=\"alert alert-danger\" role=\"alert\"><p>No User Found/p></div>";
}
else{
	//No that you made it this far set new password
	$salt		= $user->getSalt();
	$newHash 	= hash_pbkdf2("sha512", $password, $salt, 2048, 128);

	$oldPassword		= $user->getPasswordHash();

	if($oldPassword === $newHash){
		// comparing oldPassword with newHash

		require_once("../class/security.php");

		$security = Security::getSecurityBySecurityId($mysqli, $user->getSecurityId());

		$_SESSION["userId"] = $user->getUserId();
		$_SESSION["profile"]["profileId"] = $profile->getProfileId();
		$_SESSION["profile"]["firstName"] = $profile->getFirstName();
		$_SESSION["profile"]["lastName"] = $profile->getLastName();
		$_SESSION["profile"]["profilePicFilename"] = $profile->getProfilePicFileName();
		$_SESSION["profile"]["location"] = $profile->getLocation();
		$_SESSION["profile"]["description"] = $profile->getDescription();
		$_SESSION["security"]["description"] = $security->getDescription();
		$_SESSION["security"]["createTopic"] = $security->getCreateTopic();
		$_SESSION["security"]["canEditOther"] = $security->getCanEditOther();
		$_SESSION["security"]["canPromote"] = $security->getCanPromote();
		$_SESSION["security"]["siteAdmin"] = $security->getSiteAdmin();

	}
	else {
		echo "<div class=\"alert alert-danger\" role=\"alert\"><p>Wrong Password/p></div>";
	}

}