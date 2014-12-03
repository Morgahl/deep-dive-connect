$(document).ready(function() {
	$.ajax({
		url    : '../php/form-processor/recent-topics.php',
		success: function(ajaxOutput) {
			$("#recent").html(ajaxOutput);
		}
	});
});