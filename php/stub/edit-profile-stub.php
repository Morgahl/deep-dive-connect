<?php
 /**
 * Created by PhpStorm.
 * User: Steven
 * Date: 12/5/2014
 * Time: 11:07 AM
 */
require_once("php/lib/csrf.php");

$inputTagPic = generateInputTags();
$inputTagProfile = generateInputTags();

echo		"<h3>Change Profile Picture</h3>
			<script src=\"js/do-upload.js\"></script>
			<form id=\"imgUploadForm\" action=\"php/form-processor/do-upload.php\" enctype=\"multipart/form-data\" method=\"post\">". $inputTagPic .
				"<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"5000000\">
				<label for=\"file-upload\">photo location:</label>
				<p>Max-size: 3 mb</p>
				<input type=\"file\" id=\"imgUpload\" name=\"imgUpload\"><br>
				<button id=\"uploadSubmit\" type=\"submit\" name=\"submit\" value=\"send\">Change Image</button>
			</form>
			<p id=\"imgUploadOutput\"></p>
			<script src=\"js/profile-edit.js\"></script>
			<form id=\"profileEditForm\" action=\"php/form-processor/profile-edit-form-processor.php\" method=\"post\">". $inputTagProfile ."
				<!-- Change profile information -->
				<h3>Change Profile Information</h3>
				<p>
					<label for=\"firstName\">First Name:</label><br>
					<input type=\"text\" id=\"firstName\" name=\"firstName\">
				</p>
				<p>
					<label for=\"middleName\">Middle Name:</label><br>
					<input type=\"text\" id=\"middleName\" name=\"middleName\">
				</p>
				<p>
					<label for=\"lastName\">Last Name:</label><br>
					<input type=\"text\" id=\"lastName\" name=\"lastName\">
				</p>
				<p>
					<label for=\"location\">Location:</label><br>
					<input type=\"text\" id=\"location\" name=\"location\">
				</p>
				<p>
					<label for=\"description\">Description:</label><br>
					<input type=\"text\" id=\"description\" name=\"description\">
				</p>
				<button id=\"profileSubmit\" type=\"submit\" name=\"submit\">Submit</button>
			</form>
			<p id=\"outputProfileEdit\"></p>
			<h3>Cohort Association</h3>
			<p><a href=\"cohort-edit.php\">change cohort</a></p>

			<!-- Account Settings -->
			<h3>Account Settings</h3>
			<p><a href=\"php/form-processor/change-password.php\">change password</a></p>";
