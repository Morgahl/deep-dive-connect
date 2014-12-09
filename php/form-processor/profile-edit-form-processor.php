<?php
/**
 * Form processor for profile-edit.php
 *
 * Takes the information from the form-processor and sends it to the profile class
 * for filtering and if the information is sanitized inserted into the
 * database.
 *
 *  @author Steven Chavez <schavez256@yahoo.com>
 * @see Profile
 */
session_start();
//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the classes you need
require_once("../class/profile.php");
require_once("../lib/csrf.php");

try{
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	// verify CSRF tokens
	if(verifyCsrf($_POST["csrfName"] ,$_POST["csrfToken"]) === false){
		throw (new RuntimeException("External call made."));
	}

	// connect to mySQL
	$mysqli = MysqliConfiguration::getMysqli();

//obtain profileId from $_SESSION
	$profileId = $_SESSION["profile"]["profileId"];

//obtain profile by userId
	$profile = Profile::getProfileByProfileId($mysqli, $profileId);

	$boolField = false;
// obtain info from the form-processor and set the values into the
// object if it has a value
	$firstName = $_POST["firstName"];
	if(empty($firstName) === false){
		$profile->setFirstName($firstName);
		$_SESSION["profile"]["firstName"] = $profile->getFirstName();
		$boolField = true;
	}

	$lastName = $_POST["lastName"];
	if(empty($lastName) === false){
		$profile->setLastName($lastName);
		$_SESSION["profile"]["lastName"] = $profile->getLastName();
		$boolField = true;
	}

	$middleName = $_POST["middleName"];
	if(empty($middleName) === false){
		$profile->setMiddleName($middleName);
		$boolField = true;
	}

	$location = $_POST["location"];
	if(empty($location) === false){
		$profile->setLocation($location);
		$_SESSION["profile"]["location"]= $profile->getLocation();
		$boolField = true;
	}

	$description = $_POST["description"];
	if(empty($description) === false){
		$profile->setDescription($description);
		$_SESSION["profile"]["description"]= $profile->getDescription();
		$boolField = true;
	}

	if($boolField === true){
		$profile->update($mysqli);
		echo "<div class=\"alert alert-success\" role=\"alert\"><p>Updated Successful</p></div>";

	}
	else{
		echo "<div class=\"alert alert-danger\" role=\"alert\"><p><strong>WARNING!</strong> no entries</p></div>";
	}
}
catch (Exception $exception){
	$_SESSION[$csrfName] = $csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to edit Profile: " . $exception->getMessage() . "</div>";
}
