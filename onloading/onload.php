<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../php/class/security.php");
require_once("../php/class/user.php");
require_once("../php/class/profile.php");

echo "<form id=\"back\" action=\"loading.html\">
			<button type=\"submit\">Back</button>
		</form>";

$mysqli = MysqliConfiguration::getMysqli();

$user = new User(null,"marc.hayes.tech@gmail.com", null, null, null, 4, 4);
$user->insert($mysqli);

$profile = new Profile(null, $user->getUserId(), "Marc", "Hayes", "D", "Albuquerque, NM", "Deep Dive Connect Student, Information Technology Guru, and Gaming fanatic!", null, null);
$profile->insert($mysqli);

$security = Security::getSecurityBySecurityId($mysqli, $user->getSecurityId());

$_SESSION["userId"] = $user->getUserId();
$_SESSION["profile"]["profileId"] = $profile->getProfileId();
$_SESSION["profile"]["firstName"] = $profile->getFirstName();
$_SESSION["profile"]["lastName"] = $profile->getLastName();
$_SESSION["profile"]["profilePicFilename"] = $profile->getProfilePicFileName();
$_SESSION["profile"]["location"] = $profile->getLocation();
$_SESSION["profile"]["description"] = $profile->getDescription();
$_SESSION["security"]["description"] = $security->getDescription();
$_SESSION["security"]["createTopic"] = $security->getCreateTopic();
$_SESSION["security"]["canEditOther"] = $security->getCanEditOther();
$_SESSION["security"]["canPromote"] = $security->getCanPromote();
$_SESSION["security"]["siteAdmin"] = $security->getSiteAdmin();


