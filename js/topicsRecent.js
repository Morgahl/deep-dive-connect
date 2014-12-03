$(document).ready(function() {
	$.ajax({
		url    : '../php/form-processor/topicsRecent.php',
		success: function(ajaxOutput) {
			$("#recent").html(ajaxOutput);
		}
	});
});