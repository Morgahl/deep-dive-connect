<?php
/**
 * Created in collaboration by:
 *
 * Gerardo Medrano <GMedranoCode@gmail.com>
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez <schavez256@yahoo.com>
 * Joseph Bottone <hi@oofolio.com>
 * Form processor for admin-stub.php
 *
 * Form processor for change-password-stub.php
 *
 * Acquires values from form and ensures that password matches old one
 * from database and that the new password matches the password confirm
 * before moving on to setting the newly hashed password into database.
 *
 */

session_start();

//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the classes you need
require_once("../class/user.php");
require_once("../class/profile.php");
require_once("../lib/csrf.php");

try{
	// verify csrf tokens are set
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	// verify CSRF tokens
	if(verifyCsrf($csrfName, $csrfToken) === false){
		throw (new RuntimeException("External call made."));
	}

	// connect to mySQL
	$mysqli = MysqliConfiguration::getMysqli();

	//obtain profileId from $_SESSION
	$profileId = isset($_SESSION["profile"]["profileId"]) ? $_SESSION["profile"]["profileId"] : false;

	//acquire passwords from POST
	$currentPassword = filter_input(INPUT_POST,"currentPassword",FILTER_SANITIZE_STRING);
	$newPassword = filter_input(INPUT_POST,"newPassword",FILTER_SANITIZE_STRING);
	$confirmPassword = filter_input(INPUT_POST,"confirmPassword",FILTER_SANITIZE_STRING);

	//obtain profile by userId
	$profile = Profile::getProfileByProfileId($mysqli, $profileId);
	$userId = $profile->getUserId();

	//obtain user by userId
	$user = User::getUserByUserId($mysqli, $userId);

	//get password from user
	$oldPassword = $user->getPasswordHash();

	//hash the current password
	$salt		= $user->getSalt();
	$hash 	= hash_pbkdf2("sha512", $currentPassword, $salt, 2048, 128);

	//make sure that all fields are filled
	if(empty($currentPassword) === true || empty($newPassword) === true || empty($confirmPassword) === true){
		echo "<div class=\"alert alert-danger\" role=\"alert\"><p>All fields must be filled</p></div>";
	}
	//confirm that current password matches old password
	elseif($hash !== $oldPassword){
		echo "<div class=\"alert alert-danger\" role=\"alert\"><p>incorrect Password</p></div>";
	}
	//make sure that the new and confirmed password match
	elseif($newPassword !== $confirmPassword){
		echo "<div class=\"alert alert-danger\" role=\"alert\"><p>Passwords must match</p></div>";
	}
	else{
		//Now that you made it this far set new password
		$salt		= $user->getSalt();
		$newHash 	= hash_pbkdf2("sha512", $newPassword, $salt, 2048, 128);

		$user->setPasswordHash($newHash);
		$user->update($mysqli);

		echo "<div class=\"alert alert-success\" role=\"alert\"><p>Password Changed</p></div>";
	}
}
catch (Exception $exception){
	$_SESSION[$csrfName] = $csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to change permissions: " . $exception->getMessage() . "</div>";
}