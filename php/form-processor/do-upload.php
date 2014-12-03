<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 11/24/2014
 * Time: 1:39 PM
 */

session_start();

//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the classes you need
require_once("../class/profile.php");

// connect to mySQL
$mysqli = MysqliConfiguration::getMysqli();

//obtain profileId from $_SESSION
$profileId = $_SESSION["profileId"];

//obtain profile by userId
$profile = Profile::getProfileByProfileId($mysqli, $profileId);

$img = "nothing";

$profile->setProfilePicFileName($img);

$filename = $profile->getProfilePicFileName();

if($profile->getProfilePicFileName() !== null){
	echo "<div class=\"alert alert-success\" role=\"alert\"><p>Upload Successful</p></div>";
}

