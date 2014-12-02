<?php
/**
 * change password form processor
 *
 * @author Steven Chavez <schavez256@yahoo.com>
 */
session_start();

//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the classes you need
require_once("../class/user.php");
require_once("../class/profile.php");

// connect to mySQL
$mysqli = MysqliConfiguration::getMysqli();

//obtain profileId from $_SESSION
$profileId = $_SESSION["profileId"];

//obtain profile by userId
$profile = Profile::getProfileByProfileId($mysqli, $profileId);
$userId = $profile->getUserId();

//obtain user by userId
$user = User::getUserByUserId($mysqli, $userId);

//get password from user
$oldPassword = $user->getPasswordHash();

$currentPassword = null;
$newPassword = null;
$confirmPassword = null;
//acquire passwords from POST
$currentPassword = $_POST["currentPassword"];
$newPassword = $_POST["newPassword"];
$confirmPassword = $_POST["confirmPassword"];

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
	//No that you made it this far set new password
	$salt		= $user->getSalt();
	$newHash 	= hash_pbkdf2("sha512", $newPassword, $salt, 2048, 128);

	$user->setPasswordHash($newHash);
	$user->update($mysqli);

	echo "<div class=\"alert alert-success\" role=\"alert\"><p>Password Changed</p></div>";
}