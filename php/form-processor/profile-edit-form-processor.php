<?php
/**
 * Created in collaboration by:
 *
 * Gerardo Medrano GMedranoCode@gmail.com
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez <schavez256@yahoo.com>
 * Joseph Bottone hi@oofolio.com
 *
 * Form processor for profile-edit.php
 *
 * Takes the information from the form and sends it to the profile class
 * for filtering and if the information is sanitized inserted into the
 * database.
 *
 */

session_start();
//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the classes you need
require_once("../class/profile.php");
require_once("../lib/csrf.php");
require_once("../lib/status-message.php");

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

	//obtain form data from $_SESSION
	$profileId = isset($_SESSION["profile"]["profileId"]) ? $_SESSION["profile"]["profileId"] : false;
	$firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_STRING);
	$lastName = filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_STRING);
	$middleName = filter_input(INPUT_POST, "middleName", FILTER_SANITIZE_STRING);
	$location = filter_input(INPUT_POST, "location", FILTER_SANITIZE_STRING);
	$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);

	//obtain profile by userId
	$profile = Profile::getProfileByProfileId($mysqli, $profileId);

	//if boolField stays false then no entries were filled when submitted
	$boolField = false;

	// obtain info from post
	//set first name if not empty
	if(empty($firstName) === false){
		$profile->setFirstName($firstName);
		$_SESSION["profile"]["firstName"] = $profile->getFirstName();
		$boolField = true;
	}

	//set last name if not empty
	if(empty($lastName) === false){
		$profile->setLastName($lastName);
		$_SESSION["profile"]["lastName"] = $profile->getLastName();
		$boolField = true;
	}

	// set middle name if not empty
	if(empty($middleName) === false){
		$profile->setMiddleName($middleName);
		$boolField = true;
	}

	// set location if not empty
	if(empty($location) === false){
		$profile->setLocation($location);
		$_SESSION["profile"]["location"]= $profile->getLocation();
		$boolField = true;
	}

	// set description if not empty
	if(empty($description) === false){
		$profile->setDescription($description);
		$_SESSION["profile"]["description"]= $profile->getDescription();
		$boolField = true;
	}

	// if boolField equals true update profile with new information if not alert user
	if($boolField === true){
		$profile->update($mysqli);

		setStatusMessage("profile-edit", "success", "update complete");
		header("Location: ../../profile-edit.php");
	}
	else{
		setStatusMessage("profile-edit", "fail", "no entries");
		header("Location: ../../profile-edit.php");
	}
}
catch (Exception $exception){
	$_SESSION[$csrfName] = $csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to edit Profile: " . $exception->getMessage() . "</div>";
}
