<?php
/**
 * signup and login form processor
 *
 * @author Joseph Bottone <bottone.joseph@gmail.com>
 */

session_start();

//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the classes you need
require_once("../class/user.php");
require_once("../class/profile.php");

// connect to mySQL
$mysqli = MysqliConfiguration::getMysqli();

//obtain profileId from $_SESSION
$email = $_SESSION["email"];

