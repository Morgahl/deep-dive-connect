<?php
/**
 * Created in collaboration by:
 *
 * Gerardo Medrano GMedranoCode@gmail.com
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez @schavez256
 * Joseph Bottone hi@oofolio.com
 *
 */
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../php/class/security.php");
require_once("../php/class/user.php");
require_once("../php/class/profile.php");

echo "<form id=\"back\" action=\"loading.html\">
			<button type=\"submit\">Back</button>
		</form>";

$mysqli = MysqliConfiguration::getMysqli();

$password = "abc123";
$salt		= bin2hex(openssl_random_pseudo_bytes(32));
$authKey = bin2hex(openssl_random_pseudo_bytes(16));
$hash 	= hash_pbkdf2("sha512", $password, $salt, 2048, 128);


$user = new User(null,"marc.hayes.tech@gmail.com", $hash, $salt, $authKey, 4, null);
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


