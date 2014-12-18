/**
 * Created in collaboration by:
 *
 * @author Gerardo Medrano <GMedranoCode@gmail.com>
 * @author Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * @author Steven Chavez <schavez256@yahoo.com>
 * @author Joseph Bottone <hi@oofolio.com>
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