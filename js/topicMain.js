$(document).ready(function() {
	$.ajax({
		url    : '../php/form/topicMainTopic.php?t=2',
		success: function(ajaxOutput) {
			$("#topic").html(ajaxOutput);
		}
	});
	$.ajax({
		url    : '../php/form/topicMainComments.php?t=2',
		success: function(ajaxOutput) {
			$("#comments").html(ajaxOutput);
		}
	});
});