<?php
/**
 * Login form processor
 *
 * @author Joseph Bottone <bottone.joseph@gmail.com>
 */
session_start();

//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the classes you need
require_once("../lib/csrf.php");
require_once("../class/user.php");
require_once("../class/profile.php");
require_once("../class/cohort.php");
require_once("../class/security.php");

try {
	// store CSRF tokens
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	// verify CSRF tokens
	if(verifyCsrf($csrfName, $csrfToken) === false){
		throw (new RuntimeException("External call made."));
	}

	// connect to mySQL
	$mysqli = MysqliConfiguration::getMysqli();

	// obtain form info from $_POST
	$email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
	$password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING);

	// obtain user by userId
	$user = User::getUserByEmail($mysqli, $email);

	if(isset($user) === false) {
		//use bootstrap div alert to echo to user
		echo "<div class=\"alert alert-danger\" role=\"alert\"><p>No User Found</p></div>";
	} elseif ($user->getAuthKey() !== null) {
		//use bootstrap div alert to echo to user
		echo "<div class=\"alert alert-danger\" role=\"alert\"><p>Please check your email to verify your email address.</p></div>";
	} else {
		//No that you made it this far set new password
		$salt				= $user->getSalt();
		$newHash			= hash_pbkdf2("sha512", $password, $salt, 2048, 128);
		$oldPassword	= $user->getPasswordHash();

		if($oldPassword === $newHash){
			// comparing oldPassword with newHash

			$userId = $user->getUserId();
			$profile = Profile::getProfileByUserId($mysqli, $userId);
			$security = Security::getSecurityBySecurityId($mysqli, $user->getSecurityId());
			$cohort = Cohort::getRecentCohortByProfileId($mysqli, $profile->getProfileId());

			//set userId into the session
			$_SESSION["userId"] = $user->getUserId();

			//set $profile info into session
			$_SESSION["profile"]["profileId"] = $profile->getProfileId();
			$_SESSION["profile"]["firstName"] = $profile->getFirstName();
			$_SESSION["profile"]["lastName"] = $profile->getLastName();
			$_SESSION["profile"]["profilePicFilename"] = $profile->getProfilePicFileName();
			$_SESSION["profile"]["location"] = $profile->getLocation();
			$_SESSION["profile"]["description"] = $profile->getDescription();

			//set security info into session
			$_SESSION["security"]["description"] = $security->getDescription();
			$_SESSION["security"]["createTopic"] = $security->getCreateTopic();
			$_SESSION["security"]["canEditOther"] = $security->getCanEditOther();
			$_SESSION["security"]["canPromote"] = $security->getCanPromote();
			$_SESSION["security"]["siteAdmin"] = $security->getSiteAdmin();

			if ($cohort !== null) {
				//set cohort info into session
				$_SESSION["cohort"]["cohortId"] = $cohort->getCohortId();
				$_SESSION["cohort"]["startDate"] = $cohort->getStartDate()->format("M Y");
				$_SESSION["cohort"]["endDate"] = $cohort->getEndDate()->format("M Y");
				$_SESSION["cohort"]["location"] = $cohort->getlocation();
				$_SESSION["cohort"]["description"] = $cohort->getDescription();
			}

			header("Location: ../../index.php");
		}
		else {
			echo "<div class=\"alert alert-danger\" role=\"alert\"><p>Wrong Password</p></div>";
		}
	}
} catch(Exception $exception) {
	$_SESSION[$csrfName] = $csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to login: " . $exception->getMessage() . "</div>";
}