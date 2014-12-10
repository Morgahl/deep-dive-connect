<?php
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

echo "<div class=\"row\">";
echo "<h3><strong>" . $cohort[0]->getDescription() . "</strong></h3>";
echo "<p>" . $cohort[0]->getStartDate()->format("M Y") . " - " . $cohort[0]->getEndDate()->format("M Y") . "<br>";
echo $cohort[0]->getLocation() . "</p>";
echo "</div>";

echo "<div class=\"row\">";
if ($profileId === false || $profileId === null){
	echo "<p>" . count($profiles) . " user(s) signed up for this cohort<br>";
	// FIXME NEED ACTUAL LINK HERE
	echo "<a href=\"\">Sign up or log in now!</a></p>";
} else {
	if ($profiles !== null){
		foreach ($profiles as $index => $element) {
			echo "<div class=\"row\"><p>";
			echo "";
			var_dump($element);
			echo "</p></div>";
		}
	} else {
		echo "<p>0 user(s) signed up for this cohort</p>";
	}
}
echo "</div>";