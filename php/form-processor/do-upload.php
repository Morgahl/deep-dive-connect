<?php
/**
 * Created in collaboration by:
 *
 * Gerardo Medrano <GMedranoCode@gmail.com>
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez <schavez256@yahoo.com>
 * Joseph Bottone <hi@oofolio.com>
 *
 * Form processor for image upload
 *
 * Acquires file from form and inserts it into the profile
 * class and if successfully sanitized filename is set and
 * image for profile moved to image directory
 */

session_start();

//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the classes you need
require_once("../class/profile.php");
require_once("../lib/csrf.php");
require_once("../lib/status-message.php");

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
	$fileSize = isset($_FILES["imgUpload"]["size"]) ? $_FILES["imgUpload"]["size"] : false;

	//does not all images over 3mb
	if($fileSize > 3000000){
		setStatusMessage("do-upload", "fail", "file to large");
		header("Location: ../../profile-edit.php");
	}
	elseif ($fileSize <= 0) {
		setStatusMessage("do-upload", "fail", "no file selected");
		header("Location: ../../profile-edit.php");
	}
	else{
		// obtain profile by userId which acquires file to sanitize from $_FILES
		$profile = Profile::getProfileByProfileId($mysqli, $profileId);


		// move image
		$profile->uploadNewProfilePic();

		// acquire file name form profile object to place into session
		$filename = $profile->getProfilePicFileName();
		$_SESSION["profile"]["profilePicFilename"] = $filename;

		// echo success alert
		setStatusMessage("do-upload", "success", "upload complete");
		$profile->update($mysqli);
		header("Location: ../../profile-edit.php");

	}
} catch(Exception $exception) {
	$_SESSION[$csrfName] = $csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to create or edit profile pic: " . $exception->getMessage() . "</div>";
}