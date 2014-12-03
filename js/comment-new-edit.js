$(document).ready(function() {
	var topicId = getUrlParameter('t');
	var commentId = getUrlParameter('c');
	var urlGlue= "";

	if (topicId != "") {
		urlGlue = "?t=" + topicId;
		if(commentId !== "undefined") {
			urlGlue = urlGlue + "&c=" + commentId;
		}
	}

	$.ajax({
		url    : '../php/form-processor/comment-edit-load.php' + urlGlue,
		success: function(ajaxOutput) {
			$.each(JSON.parse(ajaxOutput), function(idx, obj) {
				var id = "#" + idx;
				$(id).val(obj);
			});
		}
	});

	$.ajax({
		url    : '../php/form-processor/comment-edit-load.php' + urlGlue,
		success: function(ajaxOutput) {
			$.each(JSON.parse(ajaxOutput), function(idx, obj) {
				var id = "#" + idx;
				$(id).val(obj);
			});
		}
	});

	$("#comment").validate(
		{
			rules:
			{
				subject:
				{
					required: true
				},
				body:
				{
					required: true
				}
			},

			messages:
			{
				subject:
				{
					required: "Please enter a comment subject."
				},
				body: { required: "Please enter a comment body."
				}
			},

			submitHandler: function(form) {
				$(form).ajaxSubmit(
					{
						type   : "POST",
						url    : "../php/form-processor/comment-new-edit.php" + urlGlue,
						success: function(ajaxOutput) {
							// redirect user to a new page
							location.replace('topicMain.form?t=' + ajaxOutput)
						}
					});
			}
		});
});


function getUrlParameter(sParam)
{
	var sPageURL = window.location.search.substring(1);
	var sURLVariables = sPageURL.split('&');
	for (var i = 0; i < sURLVariables.length; i++)
	{
		var sParameterName = sURLVariables[i].split('=');
		if (sParameterName[0] == sParam)
		{
			return sParameterName[1];
		}
	}
}