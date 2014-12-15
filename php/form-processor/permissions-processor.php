<?php
session_start();

// path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

// require files needed
require_once("../lib/csrf.php");
require_once("../class/security.php");
require_once("../class/user.php");
require_once("../class/profile.php");

$securityId = $_POST["securityOption"];
$userId = $_POST["userId"];
$profileId = $_POST["profileId"];

// connect to mysqli
$mysqli = MysqliConfiguration::getMysqli();

$user = User::getUserByUserId($mysqli, $userId);

$user->setSecurityId($securityId);
$user->update($mysqli);



header("Location: ../../permissions.php?profile=" . urlencode($profileId));

