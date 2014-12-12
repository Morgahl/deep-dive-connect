<?php

/**
 * Deep Dive Connect Navigation Stub by
 * @GMedrano, adapted from model by Marc Hayes
 */


//Added ternary

$Admin = isset($_SESSION["security"]["siteAdmin"]) ? $_SESSION["security"]["siteAdmin"] : false;
$profileId = isset($_SESSION["profile"]["profileId"]) ? $_SESSION["profile"]["profileId"] : false;



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

