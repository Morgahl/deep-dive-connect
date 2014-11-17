<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 11/11/2014
 * Time: 1:14 PM
 */
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

$mysqli = MysqliConfiguration::getMysqli();

var_dump($mysqli);