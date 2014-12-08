<?php
 /**
 * Created by PhpStorm.
 * User: Steven
 * Date: 12/5/2014
 * Time: 11:07 AM
 */

echo 	  "<h3>Change Profile Picture</h3>
			<form id=\"imgUploadForm\" action=\"../form-processor/do-upload.php\" enctype=\"multipart/form-data\" method=\"post\">
				<?php echo generateInputTags(); ?>
				<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"5000000\">
				<label for=\"file-upload\">photo location:</label>
				<p>Max-size: 3 mb</p>
				<input type=\"file\" id=\"imgUpload\" name=\"imgUpload\"><br>
				<button id=\"uploadSubmit\" type=\"submit\" name=\"submit\" value=\"send\">Change Image</button>
			</form>
			<form id=\"profileEditForm\" action=\"../form-processor/profile-edit-form-processor.php\" method=\"post\">
				<?php echo generateInputTags(); ?>
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
			<p><a href=\"php/stub/cohort-edit-stub.php\">change cohort</a></p>

			<!-- Account Settings -->
			<h3>Account Settings</h3>
			<p><a href=\"php/form-processor/change-password.php\">change password</a></p>";
