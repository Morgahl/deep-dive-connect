<?php
try {
	require_once("/etc/apache2/capstone-mysql/ddconnect.php");
	require_once("php/class/topic.php");
	require_once("php/lib/csrf.php");

	$createTopic = isset($_SESSION["security"]["createTopic"]) ? $_SESSION["security"]["createTopic"] : false;

	echo "<script src=\"js/topic-modal.js\"></script>
	<div class=\"modal\" id=\"topicModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modal\" aria-hidden=\"true\">
		<div class=\"modal-dialog\">
			<div class=\"modal-content\">
				<div class=\"modal-header\">
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\" onclick=\"dePopulateTopicModal();\">&times;</button>
					<h4 class=\"modal-title\" id=\"topicModalLabel\">Topic:</h4>
				</div>
				<form id=\"topicModalForm\" method=\"POST\" action=\"php/form-processor/topic-new-edit.php\">
					<div class=\"modal-body\">";
	echo generateInputTags();
	echo "<label for=\"topicSubject\">Subject: </label><br />
						<textarea id=\"topicSubject\" name=\"topicSubject\" class=\"form-control\" rows=\"2\" maxlength=\"256\"></textarea><br />
						<label for=\"topicBody\">Body: </label><br />
						<textarea id=\"topicBody\" name=\"topicBody\" class=\"form-control\" rows=\"5\" maxlength=\"4096\"></textarea><br />
					</div>
					<div class=\"modal-footer\">
						<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\" onclick=\"dePopulateTopicModal();\">Close</button>
						<button type=\"submit\" id=\"modTopicSubmit\" class=\"btn btn-primary\">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>";


	echo "<h1><strong>Welcome to Deep Dive Connect!</strong></h1>";

	$mysqli = MysqliConfiguration::getMysqli();

	// grab topic from database
	$topics = Topic::getRecentTopics($mysqli, 100000);

	// make sure it exists
	if ($topics !== null) {
		// iterate down array and prep html
		foreach($topics as $index => $element) {
			echo	"<p><a href=\"topic.php?topic=" . $element->getTopicId() . "\"><strong>" . substr($element->getTopicSubject(), 0, 100) . "...</strong></a><br>" .
				substr($element->getTopicBody(), 0, 100) . "...</p>";
		}
	} else {
		echo "<h4>No topics currently exist.</h4>";
	}

	if($createTopic === 1){
	echo	"<button type=\"submit\" id=\"topicCreate\" class=\"btn btn-primary btn-xs\" data-toggle=\"modal\" data-target=\"#topicModal\" onclick=\"populateTopicModal();\">Create a Topic</button>";
	}

} catch(Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to load recent topics: " . $exception->getMessage() . "</div>";}
?>