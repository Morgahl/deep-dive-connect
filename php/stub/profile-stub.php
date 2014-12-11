<?php
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("php/class/cohort.php");
require_once("php/class/profile.php");
require_once("php/class/topic.php");
require_once("php/class/comment.php");

$sessionProfileId = isset($_SESSION["profile"]["profileId"]) ? $_SESSION["profile"]["profileId"] : false;
$profileId = filter_input(INPUT_GET,"profile", FILTER_VALIDATE_INT);

$mysqli = MysqliConfiguration::getMysqli();

if ($profileId !== null) {
	// do nothing
} elseif ($sessionProfileId !== false) {
	$profileId = $sessionProfileId;
} else {
	header("Location: ../../index.php");
}


$profile = Profile::getProfileByProfileId($mysqli, $profileId);

if ($profile !== null) {
	echo "<div class=\"row\">";
	if (($fileName = $profile->getProfilePicFileName()) !== null) {
		echo "<p><div class=\"col-xs-offset-4 col-xs-4\"><img id=\"profilePic\" class=\"img-responsive\" src=\"/ddconnect/avatars/" . $fileName . "\" /></div></p></div>";
	} else {
		echo "<p><div class=\"col-xs-offset-4 col-xs-4\"><img id=\"profilePic\" class=\"img-responsive\" src=\"resources/avatar-default.png\" /></div></p></div>";
	}
	echo "<div class=\"row\">";
	echo "<h3><strong>" . $profile->getFirstName() . " " . $profile->getLastName() . "</strong></h3>";
	echo $profile->getLocation() . "<br>";
	echo $profile->getDescription() . "</p>";
//echo $profile->getLocation() . "</p>";
	echo "</div>";

	$cohorts = Cohort::getCohortsByProfileId($mysqli, $profileId);

	if ($cohorts !== null) {
		echo "<div class=\"row\">";
		echo "<h4><strong>Cohorts:</strong></h4>";
		foreach($cohorts as $index => $element){
			echo "<h5><strong>As " . $index . ":</strong></h5>";
			echo "<div class=\"row\">";
			foreach ($element as $innerIndex => $innerElement) {
				echo "<div class=\"col-xs-4\">";
				echo "<a href=\"cohort.php?cohort=" . $innerElement["cohort"]->getCohortId() . "\"><p><strong>" . $innerElement["cohort"]->getDescription() . "</strong><br>";
				echo "" . $innerElement["cohort"]->getStartDate()->format("M Y") . " - " . $innerElement["cohort"]->getEndDate()->format("M Y") . "<br>";
				echo $innerElement["cohort"]->getLocation() . "</p></a></div>";
//				var_dump($innerElement);
			}
			echo "</div>";
		}
		echo "</div></div>";
	}

	$comments = Comment::getCommentsByProfileId($mysqli, $profileId, 5, 1);

	if ($comments !== null) {
		echo "<div class=\"row\">";
		echo "<h4><strong>Recent Comments:</strong></h4>";
		foreach ($comments as $index => $element) {
			echo	"<p><a href=\"topic.php?topic=" . $element->getTopicId() . "#comment" . $element->getCommentId() . "\"><strong>" . substr($element->getCommentSubject(), 0, 100) . "...</strong></a><br>" .
				substr($element->getCommentBody(), 0, 100) . "...</p>";
		}
		echo "</div>";
	}

	$topics = Topic::getTopicsByProfileId($mysqli, $profileId, 5);

	if ($topics !== null) {
		echo "<div class=\"row\">";
		echo "<h4><strong>Recent Topics:</strong></h4>";
		foreach ($topics as $index => $element) {
			echo	"<p><a href=\"topic.php?topic=" . $element->getTopicId() . "\"><strong>" . substr($element->getTopicSubject(), 0, 100) . "...</strong></a><br>" .
				substr($element->getTopicBody(), 0, 100) . "...</p>";
		}
		echo "</div>";
	}


} else {
	echo "<h2>No Valid Profile can be loaded.</h2>";
}





//echo "<div class=\"row\">";
//if ($profileId === false || $profileId === null){
//	echo "<p>" . count($profiles) . " user(s) signed up for this cohort<br>";
//	echo "<a href=\"signupForm.php\">Sign up or log in now!</a></p>";
//} else {
//	if ($profiles !== null){
//		foreach ($profiles as $index => $element) {
//			echo "<h4>" . $index . "</h4>";
//			echo "<div class=\"row\">";
//			foreach ($element as $innerIndex => $innerElement){
//				echo "<div class=\"col-xs-2\">";
////				var_dump($innerElement);
//				if (($fileName = $innerElement["profile"]->getProfilePicFileName()) !== null) {
//					echo "<div class=\"row\"><img id=\"profilePic\" class=\"img-responsive\" src=\"/ddconnect/avatars/" . $fileName . "\" /></div>";
//				} else {
//					echo "<div class=\"row\"><img id=\"profilePic\" class=\"img-responsive\" src=\"resources/avatar-default.png\" /></div><br>";
//				}
//				echo "<p><a href=\"profile.php?profile=" . $innerElement["profile"]->getProfileId() . "\">" . $innerElement["profile"]->getFirstName() . " " . $innerElement["profile"]->getLastName() . "</a>";
//				echo "</div>";
//			}
//			echo "</div>";
//		}
//	} else {
//		echo "<p>0 user(s) signed up for this cohort</p>";
//	}
//}
//echo "</div>";