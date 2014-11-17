<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 11/11/2014
 * Time: 1:14 PM
 */
require_once("/etc/apache2/capstone-mysql/ddconnect.php");


//Init secured mySQLi object
$mysqli = MysqliConfiguration::getMysqli();

// confirm mysqli object was created
var_dump($mysqli);