<?php
/**
 * form processor for AdminCohort-stub
 *
 * Allows admin to add new cohorts for every class and
 * delete cohorts if user errors occur while adding a cohort
 *
 * @author Steven Chavez <schavez256@yahoo.com>
 */
session_start();

// require the files needed
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../lib/status-message.php");
require_once("../class/cohort.php");
require_once("../lib/csrf.php");

try{

	// verify csrf tokens are set
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	// verify CSRF tokens
	if(verifyCsrf($csrfName, $csrfToken) === false){
		throw (new RuntimeException("External call made."));
	}

	// connect to mysqli
	$mysqli = MysqliConfiguration::getMysqli();

 	//get variables from Add cohort Form and check if set
	$description = filter_input(INPUT_POST, "cohortDesc",FILTER_SANITIZE_STRING);
	$location = filter_input(INPUT_POST, "cohortLoc", FILTER_SANITIZE_STRING);
	$startDate = filter_input(INPUT_POST, "startDate", FILTER_SANITIZE_STRING);
	$endDate = filter_input(INPUT_POST, "endDate", FILTER_SANITIZE_STRING);



	//get variable from Delete cohorts and check if set
	$deleteId = filter_input(INPUT_POST, "deleteSelect", FILTER_SANITIZE_STRING);

	// if delete is not set delete form will not be visible
	if(isset($deleteId) !== true){

		// ensure all fields are required
		if(empty($description) !== false || empty($location) !== false || empty($startDate) !== false || empty($endDate) !== false){

			// set error message
			$msg = "All fields required";
			setStatusMessage("cohortAdmin", "fail", $msg);
			header("Location: ../../adminCohort.php");
		}
		else{
			//create DateTime object and format startDate and endDate
			$startDate = new DateTime($startDate);
			$startDate = $startDate->format("Y-m-d H:i:s");

			$endDate = new DateTime($endDate);
			$endDate = $endDate->format("Y-m-d H:i:s");

			// insert into database and set success message
			$newCohort = new Cohort(null, $startDate, $endDate, $location, $description);
			$newCohort->insert($mysqli);
			$msg = "Cohort Added";
			setStatusMessage("cohortAdmin", "success", $msg);
			header("Location: ../../adminCohort.php");
		}
	}
	else{

		//delete cohort from database with id associated with selection
		$cohort = Cohort::getCohortByCohortId($mysqli, $deleteId);
		$cohort[0]->delete($mysqli);

		// set success message
		$msg = "Cohort Deleted";
		setStatusMessage("cohortAdmin", "success", $msg);
		header("Location: ../../adminCohort.php");
	}

}
catch(Exception $exception) {
		$_SESSION[$csrfName] = $csrfToken;
		echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to add or delete cohort: " . $exception->getMessage() . "</div>";
}


