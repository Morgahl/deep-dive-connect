<?php
/**
 Associationby PhpStorm.
 * User: Steven
 * Date: 12/8/2014
 * Time: 11:53 AM
 */
require_once("php/class/cohort.php");
require_once("php/class/profileCohort.php");

$profileId = isset($_SESSION["profile"]["profileId"]) ? $_SESSION["profile"]["profileId"] : false;

$cohorts[] = Cohort::getCohorts($mysqli);

echo "<h3>Cohort Association</h3>";

//obtain cohorts associated with profile
$proCohort = Cohort::getCohortsByProfileId($mysqli, $profileId);

foreach($proCohort as $i => $firstDem){
	echo "<row class=\"row\">";
	foreach($firstDem as $j => $secondDem){
		echo "<section class=\"col-md-3\">";
		echo "<strong>". $i . "</strong><br>";
		echo $secondDem["cohort"]->getDescription(). "<br>";
		echo $secondDem["cohort"]->getStartDate()->format("M Y") . " - " . $secondDem["cohort"]->getEndDate()->format("M Y")."<br>";
		echo $secondDem["cohort"]->getLocation(). "<br>";
		echo "</section>";
	}
	echo "</row>";
}




// drop down of Cohorts
$total = count($cohorts[0]);

echo "<row class=\"row\">
		<h3>Cohort Edit</h3>
		<form id=\"cohortEditForm\" action=\"php/form-processor/cohort-edit-processor.php\" method=\"POST\">
			<select id=\"cohortOption\" name=\"cohortOption\">";

for($i = 0; $i < $total; $i++) {
	$startDate = $cohorts[0][$i]->getStartDate();
	$endDate = $cohorts[0][$i]->getEndDate();

	echo "<option value=\"" . $cohorts[0][$i]->getCohortId() . "\">";
	echo $startDate->format("M Y") . " - " . $endDate->format("M Y");
	echo "</option>";
}

echo "	</select>
	<button id=\"cohortSubmit\" class=\"btn btn-primary btn-xs\" type=\"submit\" name=\"submit\">Submit</button>
</form>
<p id=\"cohortEditOutput\"></p>
</row";
