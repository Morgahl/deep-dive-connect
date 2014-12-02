<?php
/**
 * Form processor for profile-edit.php
 *
 * Takes the information from the form and sends it to the profile class
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

// connect to mySQL
$mysqli = MysqliConfiguration::getMysqli();

//obtain profileId from $_SESSION
$profileId = $_SESSION["profileId"];

//obtain profile by userId
$profile = Profile::getProfileByProfileId($mysqli, $profileId);

$boolField = false;
// obtain info from the form and set the values into the
// object if it has a value
$firstName = $_POST["firstName"];
if(empty($firstName) === false){
	$profile->setFirstName($firstName);
	$boolField = true;
}

$lastName = $_POST["lastName"];
if(empty($lastName) === false){
	$profile->setLastName($lastName);
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
	$boolField = true;
}

$description = $_POST["description"];
if(empty($description) === false){
	$profile->setDescription($description);
	$boolField = true;
}

if($boolField === true){
	$profile->update($mysqli);
	echo "<p>Updated Successful</p>";
	echo $profile->getFirstName()."<br>";
	echo $profile->getLastName()."<br>";
	echo $profile->getMiddleName()."<br>";
	echo $profile->getLocation()."<br>";
	echo $profile->getDescription()."<br>";
}
else{
	echo "<p>There was no entries</p>";
}
