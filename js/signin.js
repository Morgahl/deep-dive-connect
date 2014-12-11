/**
 * Signup Javascript form
 *
 * Author Joseph Bottone  bottone.joseph@gmail.com
 */
$(document).ready(function()
{
	$("#searchTeam").validate(
		{

			rules: {
				teamName: {
					required: true

				}
			},

			messages: {
				teamName : {
					required: "Please enter your teamName to search"
				}


			},

			submitHandler: function(form) {
				$(form).ajaxSubmit(
					{
						type   : "POST",
						url    : "../php/form/login-form-processor.php",
						success: function(ajaxOutput) {
							$("#outputArea").html(ajaxOutput);
						}
					});
			}
		})
});