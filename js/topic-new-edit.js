$(document).ready(function() {
	$("#topic").validate(
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
					required: "Please enter a topic subject."
				},
				body: {
					required: "Please enter a topic body."
				}
			},

			submitHandler: function(form) {
				$(form).ajaxSubmit(
					{
						type   : "POST",
						url    : "../php/form/topic-new-edit.php",
						success: function(ajaxOutput) {
							// redirect user to a new page
							// TODO: change the below to tie over to an actual topic as received via ajaxOutput
							location.replace('topicsRecent.html')
						}
					});
			}
		});
});