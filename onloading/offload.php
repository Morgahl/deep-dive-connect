<?php
/**
 * Created in collaboration by:
 *
 * Gerardo Medrano <GMedranoCode@gmail.com>
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez <schavez256@yahoo.com>
 * Joseph Bottone <hi@oofolio.com>
 *
 */
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../php/class/user.php");
require_once("../php/class/profile.php");
require_once("../php/class/topic.php");
require_once("../php/class/comment.php");
require_once("../php/class/profileCohort.php");

echo "<form id=\"back\" action=\"loading.html\">
			<button type=\"submit\">Back</button>
		</form>";

$mysqli = MysqliConfiguration::getMysqli();

$user = $_SESSION["userId"];
$profile = $_SESSION["profile"]["profileId"];

// get all topics owned by user
$topics = Topic::getTopicsByProfileId($mysqli, $profile);

if($topics !== null) {
// recursively delete all comment under each topic then the topic itself for the profileId
	foreach ($topics as $index => $element){
		// store topic id for later deletion
		$topicId = $topics[$index]->getTopicId();

		// grab all comments under the topic
		$topics[$index] = Comment::getCommentsByTopicId($mysqli, $topics[$index]->getTopicId(), 100000, 1);

		// delete all comments under a given topic
		if($topics[$index] !== null)
		foreach ($topics[$index] as $innerIndex => $innerElement) {
			// bye bye
			$topics[$index][$innerIndex]->delete($mysqli);
		}
		// rebuild in prep to delete
		$topics[$index] = Topic::getTopicByTopicId($mysqli,$topicId);
		//delete
		$topics[$index]->delete($mysqli);
	}
}

// get all comments made by user
$comments = Comment::getCommentsByProfileId($mysqli, $profile, 100000, 1);

if($comments !== null) {
// delete all comments made by the user
	foreach($comments as $index => $element) {
		$comments[$index]->delete($mysqli);
	}
}

// get profileCohort
$profileCohort = ProfileCohort::getCohortByProfileId($mysqli, $profile);

if ($profileCohort !== null) {
// nuke profile
	$profileCohort->delete($mysqli);
}

// get profile
$profile = Profile::getProfileByProfileId($mysqli, $profile);

if ($profile !== null) {
// nuke profile
	$profile->delete($mysqli);
}

// get user
$user = User::getUserByUserId($mysqli, $user);

// nuke user
$user->delete($mysqli);

if ($user !== null) {
// nuke left over session info
	session_destroy();
}


