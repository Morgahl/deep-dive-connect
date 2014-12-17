<?php
/**
 * Created in collaboration by:
 *
 * Gerardo Medrano <GMedranoCode@gmail.com>
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez <schavez256@yahoo.com>
 * Joseph Bottone <hi@oofolio.com>
 *
 * Form for change-password-stub
 *
 * Allows users to change their password by entering their
 * current password, new password, and confirmation of new
 * password.
 */

require_once("php/lib/csrf.php");


// form that allows user to change password
echo "<script type=\"text/javascript\" src=\"js/change-password.js\"></script>
		<h3>Change Password</h3>
			<form id=\"changePasswordForm\" action=\"/php/form-processor/change-password-form-processor.php\" method=\"post\">";

// generates csrf token
echo generateInputTags();

echo			"<p>
					<label for=\"currentPassword\">Current Password:</label><br>
					<input type=\"password\" class=\"form-control\" id=\"currentPassword\" name=\"currentPassword\" autocomplete=\"off\">
				</p>
				<p>
					<label for=\"newPassword\">New Password:</label><br>
					<input type=\"password\" class=\"form-control\" id=\"newPassword\" name=\"newPassword\" autocomplete=\"off\">
				</p>
				<p>
					<label for=\"confirmPassword\">Confirm Password:</label><br>
					<input type=\"password\" class=\"form-control\" id=\"confirmPassword\" name=\"confirmPassword\" autocomplete=\"off\">
				</p>
				<button type=\"submit\" class=\"btn btn-primary btn-xs\" name=\"confirm\">Confirm</button>
			</form>
			<p id=\"outputArea\"></p>";