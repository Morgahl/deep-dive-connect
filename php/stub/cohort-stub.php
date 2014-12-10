<?php
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("php/class/cohort.php");

$cohortId = filter_input(INPUT_GET,"cohort", FILTER_VALIDATE_INT);

if ($cohortId <=0 || $cohortId === false) {
	throw (new UnexpectedValueException("Not a valid Cohort ID."));
}

$mysqli = MysqliConfiguration::getMysqli();

$cohort = Cohort::getCohortByCohortId($mysqli, $cohortId);

echo "<div class=\"row\">";
echo "<h3><strong>" . $cohort[0]->getDescription() . "</strong></h3>";
echo "<p>" . $cohort[0]->getStartDate()->format("M Y") . " - " . $cohort[0]->getEndDate()->format("M Y") . "<br>";
echo $cohort[0]->getLocation() . "</p>";
echo "</div>";