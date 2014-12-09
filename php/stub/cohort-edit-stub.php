<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 12/8/2014
 * Time: 11:53 AM
 */
require_once("php/class/cohort-main.php");

//declare variables
//$cohort[] = array();
$cohortBool = true;
$id = 1;

//catch all the cohort objects in $cohort array
while($cohortBool){
if(($cohort[] = Cohort::getCohortByCohortId($mysqli, $id)) !== null){
		$id++;
	}
	else{
		$cohortBool = false;
	}
}

//get total number of elements in array
$total = count($cohort);



echo "<h3>Cohort Edit</h3>
		<form id=\"cohortEditForm\" action=\"php/form-processor/cohort-edit-processor.php\" method=\"POST\">
			<select id=\"cohortOption\" name=\"cohortOption\">
				<option value=\"null\">pick your cohort...</option>";

for($i = 0; $i < $total-1; $i++) {
	$startDate = $cohort[$i][0]->getStartDate();
	$endDate = $cohort[$i][0]->getEndDate();

	echo "<option value=\"" . $id . "\">";
	echo $startDate->format("M Y") . " - " . $endDate->format("M Y") . "<br>";
	echo "</option>";
}

echo "	</select>
	<button id=\"profileSubmit\" type=\"submit\" name=\"submit\">Submit</button>
</form>
<p id=\"CohortEditOutput\"></p>";