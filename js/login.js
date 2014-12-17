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
	$("#login-form").validate(
		{
			rules: {
				email: {
					email: true,
					required: true
				},
				password: {
					required: true
				}
			},

			messages: {
				email: {
					email: "Please enter a lawful email.",
					required: "Please enter your email."
				},
				password: {
					required: "Please enter your password."
				}
			}
		});
});