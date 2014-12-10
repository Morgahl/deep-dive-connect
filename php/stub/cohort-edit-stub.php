<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 12/8/2014
 * Time: 11:53 AM
 */
require_once("php/class/cohort.php");



$cohorts[] = Cohort::getCohorts($mysqli);


$total = count($cohorts[0]);


echo "<h3>Cohort Edit</h3>
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
	<button id=\"cohortSubmit\" type=\"submit\" name=\"submit\">Submit</button>
</form>
<p id=\"cohortEditOutput\"></p>";
