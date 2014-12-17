/**
 * Created in collaboration by:
 *
 * Gerardo Medrano <GMedranoCode@gmail.com>
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez <schavez256@yahoo.com>
 * Joseph Bottone <hi@oofolio.com>
 *
 */

$(document).ready(function()
{
	$("#signUp").validate(
		{
			rules: {
				email: {
					required: true,
					email: true
				},
				password: {
					required: true
				},
				confPassword: {
					required: true,
					equalTo: "#password"
				},
				firstName: {
					required: true
				},
				lastName: {
					required: true
				}
			},

			messages: {
				email : {
					required: "Please enter your email"
				},
				password: {
					required: "Please enter your password"
				},
				confPassword: {
					// confirmPassword was empty
					required: "Please confirm the password",
					// passwords did not match
					equalTo: "Passwords do not match"
				},
				firstName : {
					required: "Please enter your First Name"
				},
				lastName : {
					required: "Please enter your Last Name"
				}
			}
		})
});
