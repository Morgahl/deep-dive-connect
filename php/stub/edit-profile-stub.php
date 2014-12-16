<?php
 /**
  * Form to edit profile
  *
  * Allows user to upload avatars, edit their information(name, description, location),
  * also provides links to forms to edit cohorts and change their password
  *
  * @author Steven Chavez <schavez256@yahoo.com>
  * @see Profile
  */

//require to verify csrf
require_once("php/lib/csrf.php");
require_once("php/lib/status-message.php");

//form that allows user to upload images
echo		"<h3>Change Profile Picture</h3>
			<form id=\"imgUploadForm\" action=\"php/form-processor/do-upload.php\" enctype=\"multipart/form-data\" method=\"post\">";

//generate input tags for img upload form
echo generateInputTags();

echo  		"<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"5000000\">
				<label for=\"file-upload\">photo location:</label>
				<p>Max-size: 3 mb</p>
				<span class=\"btn btn-primary btn-md btn-file\">Browse...<input type=\"file\" id=\"imgUpload\" name=\"imgUpload\"></span>
				<button id=\"uploadSubmit\" class=\"btn btn-primary btn-md\" type=\"submit\" name=\"submit\" value=\"send\">Change Image</button>
			</form>
			<p id=\"imgUploadOutput\"></p>";

echo getStatusMessage("do-upload");
echo getStatusMessage("profile-edit");
//form to update basic information
echo			"<form id=\"profileEditForm\" action=\"php/form-processor/profile-edit-form-processor.php\" method=\"POST\">";

//generate input tags for basic information form
echo generateInputTags();

echo 			"<!-- Change profile information -->
				<h3>Change Profile Information</h3>
				<p>
					<label for=\"firstName\">First Name:</label><br>
					<input type=\"text\" class=\"form-control\" id=\"firstName\" name=\"firstName\">
				</p>
				<p>
					<label for=\"middleName\">Middle Name:</label><br>
					<input type=\"text\" class=\"form-control\" id=\"middleName\" name=\"middleName\">
				</p>
				<p>
					<label for=\"lastName\">Last Name:</label><br>
					<input type=\"text\" class=\"form-control\" id=\"lastName\" name=\"lastName\">
				</p>
				<p>
					<label for=\"location\">Location:</label><br>
					<input type=\"text\" class=\"form-control\" id=\"location\" name=\"location\">
				</p>
				<p>
					<label for=\"description\">Description:</label><br>
					<textarea id=\"description\" name=\"description\" class=\"form-control\" rows=\"2\" maxlength=\"256\"></textarea>
				</p>
				<button id=\"profileSubmit\" class=\"btn btn-primary btn-md\" type=\"submit\" name=\"submit\">Submit</button>
			</form>
			<p id=\"outputProfileEdit\"></p>";

//links to cohort edit and password change forms
echo		"<h3>Cohort Association</h3>
			<p><a href=\"cohort-edit.php\"><button class=\"btn btn-primary btn-xs\">Change Cohort</button></a></p>

			<!-- Account Settings -->
			<h3>Account Settings</h3>
			<p><a href=\"change-password.php\"><button class=\"btn btn-primary btn-xs\">Change Password</button></a></p>";
