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

// connect to mySQL
$mysqli = MysqliConfiguration::getMysqli();

//does not all images over 3mb
if($_FILES["imgUpload"]["size"] > 3000000){
	echo"<div class=\"alert alert-danger\" role=\"alert\"><p>File to large</p></div>";
}
else{
	// obtain profileId from $_SESSION
	$profileId = $_SESSION["profile"]["profileId"];

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
