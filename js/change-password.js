/**
 * Created in collaboration by:
 *
 * Gerardo Medrano GMedranoCode@gmail.com
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez <schavez256@yahoo.com>
 * Joseph Bottone hi@oofolio.com
 *
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