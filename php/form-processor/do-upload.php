<?php
/**
 * Form processor for image upload
 *
 * Acquires file from form and inserts it into the profile
 * class and if successfully sanitized filename is set and
 * image for profile moved to image directory
 *
 * @author Steven Chavez <schavez256@yahoo.com>
 */

session_start();

//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the classes you need
require_once("../class/profile.php");
require_once("../lib/csrf.php");

try {
	// verify csrf tokens are set
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	// verify CSRF tokens
	if(verifyCsrf($csrfName, $csrfToken) === false){
		throw (new RuntimeException("External call made."));
	}

	// connect to mySQL
	$mysqli = MysqliConfiguration::getMysqli();

	// obtain profileId from $_SESSION
	$profileId = isset($_SESSION["profile"]["profileId"]) ? $_SESSION["profile"]["profileId"] : false;

	//does not all images over 3mb
	if($_FILES["imgUpload"]["size"] > 3145728){
		echo"<div class=\"alert alert-danger\" role=\"alert\"><p>File to large</p></div>";
	}
	else{
		// obtain profile by userId which acquires file to sanitize from $_FILES
		$profile = Profile::getProfileByProfileId($mysqli, $profileId);

		// ensure object exists
		if($profile->getProfilePicFileName() !== null){
			// move image
			$profile->uploadNewProfilePic();

			// acquire file name form profile object to place into session
			$filename = $profile->getProfilePicFileName();
			$_SESSION["profile"]["profilePicFilename"] = $filename;

			// echo success alert
			echo "<div class=\"alert alert-success\" role=\"alert\"><p>Upload Successful</p></div>";
			$profile->update($mysqli);
		}
	}
} catch(Exception $exception) {
	$_SESSION[$csrfName] = $csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to create or edit profile pic: " . $exception->getMessage() . "</div>";
}