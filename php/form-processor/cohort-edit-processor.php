<?php
/**
 * Form processor for cohort-edit-stub.php
 *
 * Acquires
 *
 * @author Steven Chavez <schavez256@yahoo.com>
 */
session_start();

//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the classes you need
require_once("../class/cohort.php");
require_once("../class/profile.php");
require_once("../class/profileCohort.php");
require_once("../lib/csrf.php");

try {
	// verify csrf tokens are set
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	// verify CSRF tokens
	if(verifyCsrf($csrfName, $csrfToken) === false){
		throw (new RuntimeException("External call made."));
	}

	// connect to mySQL
	$mysqli = MysqliConfiguration::getMysqli();

	//obtain profileId from $_SESSION
	$profileId = isset($_SESSION["profile"]["profileId"]) ? $_SESSION["profile"]["profileId"] : false;
	$canPromote = isset($_SESSION["security"]["canPromote"]) ? $_SESSION["security"]["canPromote"] : false;

	//get the value of the selection they made
	$cohortId = filter_input(INPUT_POST,"cohortOption",FILTER_VALIDATE_INT);
	$cohortRole = filter_input(INPUT_POST,"cohortRole",FILTER_SANITIZE_STRING);
	$radio = filter_input(INPUT_POST,"cohortEditOptions",FILTER_SANITIZE_STRING);

	if ($cohortRole !== "Student" && $cohortRole !== "Instructor" && $cohortRole !== "Admin"){
		throw (new RuntimeException("Not a valid role for you."));
	}

	if (($canPromote === 0 && $cohortRole === "Instructor") || ($canPromote === 0 && $cohortRole === "Admin")){
		throw (new RuntimeException("Not a valid role for your permission level."));
	}

	if($radio === "add"){
		$profileCohort = new profileCohort(null, $profileId, $cohortId, $cohortRole);
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
	elseif ($radio === "delete"){
		$cohortDelete = profileCohort::getCohortByProfileId($mysqli, $profileId);

		if($cohortDelete === null){
			echo "<div class=\"alert alert-danger\" role=\"alert\"><p>Cohort Doesn't Exist.</p></div>";
		}
		else{
			foreach($cohortDelete as $i => $element){
				if($element->getCohortId() === $cohortId && $element->getRole() === $cohortRole){
					$delete = $cohortDelete[$i];
					$delete->delete($mysqli);
				}
			}
			$_SESSION["cohort"] = null;
		}
		header("Location: ../../cohort-edit.php");
	}

} catch(Exception $exception) {
	$_SESSION[$csrfName] = $csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to add or delete cohort: " . $exception->getMessage() . "</div>";
}
