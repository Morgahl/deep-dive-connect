<?php
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("php/class/profile.php");

$mysqli = MysqliConfiguration::getMysqli();



$cohorts = Cohort::getCohorts($mysqli);

echo "<div class=\"row\">";

foreach($cohorts as $index => $element) {
	echo "<a href=\"php/stub/cohort.php?cohort=" . $element->getCohortId() . "\" class=\"col-xs-4\">" . $element->getDescription() . "</p>";
}

echo "</div>";