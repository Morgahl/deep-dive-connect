<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 12/15/2014
 * Time: 8:11 PM
 */
session_start();

require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../lib/status-message.php");
require_once("../class/cohort.php");
require_once("../lib/csrf.php");

// verify csrf tokens are set
$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

// verify CSRF tokens
if(verifyCsrf($csrfName, $csrfToken) === false){
	throw (new RuntimeException("External call made."));
}

$mysqli = MysqliConfiguration::getMysqli();

//get variables from Add cohort Form and check if set
$description = filter_input(INPUT_POST, "cohortDesc",FILTER_SANITIZE_STRING);
$location = filter_input(INPUT_POST, "cohortLoc", FILTER_SANITIZE_STRING);
$startDate = filter_input(INPUT_POST, "startDate", FILTER_SANITIZE_STRING);
$endDate = filter_input(INPUT_POST, "endDate", FILTER_SANITIZE_STRING);



//get variable from Delete cohorts and check if set
$deleteId = filter_input(INPUT_POST, "deleteSelect", FILTER_SANITIZE_STRING);

if(isset($deleteId) !== true){

	if(isset($description) === false || isset($location) === false || isset($startDate) === false || isset($startDate) === false){
		$msg = "All fields required";
		setStatusMessage("cohortAdmin", "fail", $msg);
		header("Location: ../../adminCohort.php");
	}
	else{
		//create DateTime object and format
		$startDate = new DateTime($startDate);
		$startDate = $startDate->format("Y-m-d H:i:s");

		$endDate = new DateTime($endDate);
		$endDate = $endDate->format("Y-m-d H:i:s");

		$newCohort = new Cohort(null, $startDate, $endDate, $location, $description);
		$newCohort->insert($mysqli);
		header("Location: ../../adminCohort.php");
	}
}

