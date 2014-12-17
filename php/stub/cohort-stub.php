<?php
/**
 * Created in collaboration by:
 *
 * Gerardo Medrano GMedranoCode@gmail.com
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez <schavez256@yahoo.com>
 * Joseph Bottone hi@oofolio.com
 *
 */
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("php/class/cohort.php");
require_once("php/class/profile.php");

$profileId = isset($_SESSION["profile"]["profileId"]) ? $_SESSION["profile"]["profileId"] : false;
$cohortId = filter_input(INPUT_GET,"cohort", FILTER_VALIDATE_INT);

if ($cohortId <=0 || $cohortId === false) {
	throw (new UnexpectedValueException("Not a valid Cohort ID."));
}

$mysqli = MysqliConfiguration::getMysqli();

$cohort = Cohort::getCohortByCohortId($mysqli, $cohortId);
$profiles = Profile::getProfilesByCohortId($mysqli, $cohortId);

echo "<div class=\"col-xs-12\">";
echo "<h3><strong>" . $cohort[0]->getDescription() . "</strong></h3>";
echo "<p>" . $cohort[0]->getStartDate()->format("M Y") . " - " . $cohort[0]->getEndDate()->format("M Y") . "<br>";
echo $cohort[0]->getLocation() . "</p>";
echo "</div>";


if ($profileId === false || $profileId === null){
	echo "<div class=\"col-xs-12\">";
	// get count of instructors
	if (array_key_exists("Instructor", $profiles)) {
		$instructors = count($profiles["Instructor"]);
	} else {
		$instructors = 0;
	}

	// get count of students
	if (array_key_exists("Student", $profiles)) {
		$students = count($profiles["Student"]);
	} else {
		$students = 0;
	}

	echo "<p>$instructors instructor(s) signed up for this cohort<br>";
	echo "<p>$students student(s) signed up for this cohort<br>";
	echo "<a class=\"btn btn-primary btn-xs\" href=\"signupForm.php\">Sign up or log in now!</a></p>";
} else {
	if ($profiles !== null){
		foreach ($profiles as $index => $element) {
			echo "<div class=\"col-xs-12\">";
			echo "<h4>" . $index . ":</h4>";
			foreach ($element as $innerIndex => $innerElement){
				echo "<div class=\"col-xs-2\">";
//				var_dump($innerElement);
				if (($fileName = $innerElement["profile"]->getProfilePicFileName()) !== null) {
					echo "<div class=\"row\"><img id=\"profilePic\" class=\"img-responsive\" src=\"/ddconnect/avatars/" . $fileName . "\" /></div>";
				} else {
					echo "<div class=\"row\"><img id=\"profilePic\" class=\"img-responsive\" src=\"resources/avatar-default.png\" /></div><br>";
				}
				echo "<p><a href=\"profile.php?profile=" . $innerElement["profile"]->getProfileId() . "\">" . $innerElement["profile"]->getFirstName() . " " . $innerElement["profile"]->getLastName() . "</a>";
				echo "</div>";
			}
			echo "</div>";
		}
	} else {
		echo "<p>0 user(s) signed up for this cohort</p>";
	}
}
echo "</div>";