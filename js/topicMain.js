$(document).ready(function() {
	$.ajax({
		// FIXME: fix the hard coded values below
		url    : '../php/form/topicMainTopic.php?t=2',
		success: function(ajaxOutput) {
			$("#topic").html(ajaxOutput);
		}
	});
	$.ajax({
		// FIXME: fix the hard coded values below
		url    : '../php/form/topicMainComments.php?t=2',
		success: function(ajaxOutput) {
			$("#comments").html(ajaxOutput);
		}
	});
});