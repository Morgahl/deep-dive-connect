$(document).ready(function()
{
	$("#profileEditForm").validate(
	{
		debug: true,

		rules:
		{
		},
		messages:
		{
		},
		submitHandler: function(form)
		{
			$(form).ajaxSubmit(
				{
					type: "POST",
					url: "php/form-processor/profile-edit-form-processor.php",
					success: function(ajaxOutput)
					{
						$("#outputProfileEdit").html(ajaxOutput);
						// if the ajax was a success...
							// hehe - just assume the user input is what's there
							// take each field's value and write it to the profile area
					}
				});
		}
	});
});