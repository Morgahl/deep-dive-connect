<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 12/11/2014
 * Time: 9:04 AM
 */
$inputTags = generateInputTags();

echo "<script type=\"text/javascript\" src=\"js/change-password.js\"></script>
		<h3>Change Password</h3>
			<form id=\"changePasswordForm\" action=\"/php/form-processor/change-password-form-processor.php\" method=\"post\">"
				.$inputTags.
				"<p>
					<label for=\"currentPassword\">Current Password:</label><br>
					<input type=\"password\" id=\"currentPassword\" name=\"currentPassword\">
				</p>
				<p>
					<label for=\"newPassword\">New Password:</label><br>
					<input type=\"password\" id=\"newPassword\" name=\"newPassword\">
				</p>
				<p>
					<label for=\"confirmPassword\">Confirm Password:</label><br>
					<input type=\"password\" id=\"confirmPassword\" name=\"confirmPassword\">
				</p>
				<button type=\"submit\" name=\"confirm\">Confirm</button>
			</form>
			<p id=\"outputArea\"></p>";