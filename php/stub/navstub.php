<?php

/**
 * Deep Dive Connect Navigation Stub by
 * @GMedrano, adapted from model by Marc Hayes
 */


//Added ternary

$Admin = isset($_SESSION["security"]["siteAdmin"]) ? $_SESSION["security"]["siteAdmin"] : false;
$profileId = isset($_SESSION["profile"]["profileId"]) ? $_SESSION["profile"]["profileId"] : false;

//echo "<div class=\"col-sm-9 col-xs-12\">";
//echo "	<ul class=\"nav nav-tabs nav-justified footer\">";
//echo "	  <li role=\"presentation\"><a href=\"index.php\"><strong>Home</strong></a></li>";
//if($profileId !== false) {
//	echo "	  <li role=\"presentation\"><a href=\"profile.php\"><strong>Profile</strong></a></li>";
//}
//echo "	  <li role=\"presentation\"><a href=\"cohort-main.php\"><strong>Cohort</strong></a></li>";
//if ($Admin === 1){
//	echo "	  <li role=\"presentation\"><a href=\"admin.php\"><strong>Admin</strong></a></li>";
//}
//echo "	</ul>";
//echo "</div>";

//Code for Onloader - Navigation Bar

echo "<div class=\"col-sm-9 col-xs-12\">
	<div class= \"btn-group btn-group-justified\">
      <a href=\"index.php\" class=\"btn btn-default\"><h4><strong>Home</strong></h4></a>";

if($profileId !== false) {
	echo "<a href=\"profile.php\" class=\"btn btn-default\"><h4><strong>Profile</strong></h4></a>";
}

echo "<a href=\"cohort-main.php\" class=\"btn btn-default\"><h4><strong>Cohort</strong></h4></a>";

if ($Admin === 1){
	echo "<a href=\"admin.php\" class=\"btn btn-default\"><h4><strong>Admin</strong></h4></a>";
}

echo "</div>
	</div>";

