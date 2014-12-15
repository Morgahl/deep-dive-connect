<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 12/9/2014
 * Time: 9:07 AM
 */

session_start();

//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the classes you need
require_once("../class/cohort.php");
require_once("../class/profile.php");
require_once("../class/profileCohort.php");

// connect to mySQL
$mysqli = MysqliConfiguration::getMysqli();

//obtain profileId from $_SESSION
$profileId = $_SESSION["profile"]["profileId"];

//get the value of the selection they made
$cohortId = $_POST["cohortOption"];
$radio = $_POST["cohortEditOptions"];

if($radio === "add"){
	$profileCohort = new profileCohort(null, $profileId, $cohortId, "Student");
	$profileCohort->insert($mysqli);

	$cohort = Cohort::getCohortByCohortId($mysqli, $cohortId);

//$_SESSION["cohort"] = Cohort::getCohortByProfileId($mysqli, $profileId);

	$_SESSION["cohort"]["cohortId"] = $cohort[0]->getCohortId();
	$_SESSION["cohort"]["startDate"] = $cohort[0]->getStartDate()->format("M Y");
	$_SESSION["cohort"]["endDate"] = $cohort[0]->getEndDate()->format("M Y");
	$_SESSION["cohort"]["location"] = $cohort[0]->getlocation();
	$_SESSION["cohort"]["description"] = $cohort[0]->getDescription();

	if(isset($profileCohort) === false){
		echo "<div class=\"alert alert-danger\" role=\"alert\"><p>Unable to connect you to your Cohort.</p></div>";
	}
	else{
		echo "<div class=\"alert alert-success\" role=\"alert\"><p>Connection Made</p></div>";
	}
	header("Location: ../../cohort-edit.php");
}
else{
	$cohortDelete = profileCohort::getCohortByProfileId($mysqli, $profileId);

	if($cohortDelete === null){
		echo "<div class=\"alert alert-danger\" role=\"alert\"><p>Cohort Doesn't Exist.</p></div>";
	}
	else{

		foreach($cohortDelete as $i => $element){
			if($element->getCohortId() == $cohortId){
				$delete = $cohortDelete[$i];
				$delete->delete($mysqli);
			}
		}
		$_SESSION["cohort"] = null;
	}
	header("Location: ../../cohort-edit.php");
}

