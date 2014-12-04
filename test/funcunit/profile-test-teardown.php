<?php
//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
//require the classes you need
require_once("../../php/class/profile.php");
require_once("../../php/class/user.php");

// connect to mySQL
session_start();
$mysqli = MysqliConfiguration::getMysqli();
$profile = Profile::getProfileByProfileId($mysqli, $_SESSION["profileId"]);
$user    = User::getUserByUserId($mysqli, $_SESSION["userId"]);

// tear down temporary objects
$profile->delete($mysqli);
$user->delete($mysqli);

// destroy session
$_SESSION = array();
session_destroy();
echo "Tear down seems to have worked OK";
?>