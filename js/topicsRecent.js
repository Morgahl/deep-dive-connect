$(document).ready(function() {
	$.ajax({
		url    : '../php/form/topicsRecent.php',
		success: function(ajaxOutput) {
			$("#recent").html(ajaxOutput);
		}
	});
});