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
					}
				});
		}
	});
});