$(document).load(function() {
	$.ajax({
		url    : '../php/form/topicsRecent.php',
		success: function(ajaxOutput) {
			$("#recent").html(ajaxOutput).trigger('create');
			$("#recent").listview('refresh');
		}
	});
});