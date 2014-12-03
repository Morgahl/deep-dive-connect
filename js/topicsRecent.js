$(document).ready(function() {
	$.ajax({
		url    : '../php/form-processor/topics-recent-load.php',
		success: function(ajaxOutput) {
			$("#recent").html(ajaxOutput);
		}
	});
});