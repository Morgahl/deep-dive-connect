/**
 * Created by Steven on 12/2/2014.
 */
$(document).ready(function()
{
	$("#changePasswordForm").validate(
		{
			debug: true,

			rules:
			{
				currentPassword:
				{
					required: true
				},

				newPassword:
				{
					required: true
				},

				confirmPassword:
				{
					required: true,
					equalTo: "#newPassword"
				}
			},
			messages:
			{
				currentPassword:
				{
					required: "*"
				},

				newPassword:
				{
					required: "*"
				},

				confirmPassword:
				{
					required: "*",
					equalTo: "Don't Match"
				}
			},
			submitHandler: function(form)
			{
				$(form).ajaxSubmit(
					{
						type: "POST",
						url: "php/form-processor/change-password-form-processor.php",
						success: function(ajaxOutput)
						{
							$("#outputArea").html(ajaxOutput);
						}
					});
			}
		});
});