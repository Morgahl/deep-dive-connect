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
//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the classes you need
require_once("../class/profile.php");
require_once("../class/user.php");

// connect to mySQL
$this->mysqli = MysqliConfiguration::getMysqli();

//obtain email from $_SESSION
$email = $_SESSION["email"];

//obtain user by email
$user = User::getUserByEmail($mysqli, $email);
$userId = $user->getUserId();

//obtain profile by userId
$profile = Profile::getProfileByUserId($mysqli, $userId);

// obtain info from the form and set the values into the
// object if it has a value
$firstName = $_POST["firstName"];
if($firstName !== null){
	$profile->setFirstName($firstName);
}

$lastName = $_POST["lastName"];
if($lastName !== null){
	$profile->setLastName($lastName);
}

$middleName = $_POST["middleName"];
if($middleName !== null){
	$profile->setMiddleName($middleName);
}

$location = $_POST["location"];
if($location !== null){
	$profile->setLocation($location);
}

$description = $_POST["description"];
if($description !== null){
	$description->setDescription($description);
}

//now insert into database
$profile->insert();
