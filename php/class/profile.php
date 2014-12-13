<?php
/**
 * mySQL Enabled Profile
 *
 * This is an mySQL enabled container fot the Profile authentication
 *
 * @author Steven Chavez <schavez256@yahoo.com>
 * @see Profile
 **/

require_once("profileCohort.php");

class Profile
{
	/**
	 * profile id for Profile; Primary Key
	 */
	private $profileId;
	/**
	 * userId for Profile; Foreign Key
	 **/
	private $userId;
	/**
	 * firstName for Profile; not null
	 **/
	private $firstName;
	/**
	 * last name for Profile; not null
	 **/
	private $lastName;
	/**
	 * middle name for Profile
	 **/
	private $middleName;
	/**
	 * location associated with Profile
	 **/
	private $location;
	/**
	 * Description associated with Profile
	 **/
	private $description;
	/**
	 * File name of the picture associated with Profile
	 **/
	private $profilePicFileName;
	/**
	 * File type of the profile picture associated with Profile
	 **/
	private $profilePicFileType;
	/**
	 * File destination for profile avatars
	 **/
	private $destination = "/var/www/html/ddconnect/avatars";

	/**
	 * Constructor of Profile
	 *
	 * @param int    $newProfileId   profileId
	 * @param int    $newUserId      userId
	 * @param string $newFirstName   firstName
	 * @param string $newLastName    lastName
	 * @param string $newMiddleName  middleName
	 * @param string $newLocation    location
	 * @param string $newDesc        description
	 * @param string $newPicFileName profilePicFileName
	 * @param string $newPicFileType profilePicFileType
	 */
	public function __construct($newProfileId, $newUserId, $newFirstName,
										 $newLastName, $newMiddleName, $newLocation,
										 $newDesc, $newPicFileName, $newPicFileType)
	{
		try {
			$this->setProfileId($newProfileId);
			$this->setUserId($newUserId);
			$this->setFirstName($newFirstName);
			$this->setLastName($newLastName);
			$this->setMiddleName($newMiddleName);
			$this->setLocation($newLocation);
			$this->setDescription($newDesc);
			$this->setProfilePicFileName($newPicFileName);
			$this->setProfilePicFileType($newPicFileType);
		} catch(UnexpectedValueException $unexpectedValue) {
			//rethrow to the caller
			throw(new UnexpectedValueException("Unable to construct Profile", 0, $unexpectedValue));
		} catch(RangeException $range) {
			//rethrow to the caller
			throw(new RangeException("Unable to construct Profile", 0, $range));
		}

	}

	/**
	 * gets value of $profileId
	 *
	 * @return mixed $profileId int or null if new object
	 */
	public function getProfileId()
	{
		return $this->profileId;
	}


	/**
	 * sets the value for profileId
	 *
	 * @param mixed $newProfileId profile id(or null if new object
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if profile id isn't positive
	 */
	public function setProfileId($newProfileId)
	{
		// zeroth, set allow the profile id to be null if a new object
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}

		// first, make sure profile id is an integer
		if(filter_var($newProfileId, FILTER_VALIDATE_INT) == false) {
			throw(new UnexpectedValueException("profile id $newProfileId is not numeric"));
		}

		//second, enforce that user id is an integer and positive
		$newProfileId = intval($newProfileId);
		if($newProfileId <= 0) {
			throw(new RangeException("profile id $newProfileId is not positive"));
		}

		// finally after sanitizing data assign it
		$this->profileId = $newProfileId;
	}

	/**
	 * get value of $userId
	 *
	 * @return int $userId
	 */
	public function getUserId()
	{
		return $this->userId;
	}


	/**
	 * sets the value for userId
	 *
	 * @param int $newUserId user id
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if user id isn't positive
	 */
	public function setUserId($newUserId)
	{
		// first, make sure user id is an integer
		if(filter_var($newUserId, FILTER_VALIDATE_INT) == false) {
			throw(new UnexpectedValueException("user id $newUserId is not numeric"));
		}

		//second, enforce that user id is an integer and positive
		$newUserId = intval($newUserId);
		if($newUserId <= 0) {
			throw(new RangeException("user id $newUserId is not positive"));
		}

		// finally after sanitizing data assign it
		$this->userId = $newUserId;
	}

	/**
	 * gets value of $firstName
	 *
	 * @return string $firstName
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}



	/**
	 * sets the value of first name
	 *
	 * @param string $newFirstName firstName
	 * @throws UnexpectedValueException if the input does not appear to be an name
	 * @throws RangeException if the input exceeds 64 characters
	 */
	public function setFirstName($newFirstName)
	{
		//first we take out the white space
		$newFirstName = trim($newFirstName);

		//Second we ensure that input is a string
		if(filter_var($newFirstName, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("First name $newFirstName is not string"));
		}

		//third make sure length is not greater than 64
		if(strlen($newFirstName) > 64) {
			throw(new RangeException("First name $newFirstName exceeds 64 character limit"));
		}

		//assign value
		$this->firstName = $newFirstName;
	}

	/**
	 * get value of $lastName
	 *
	 * @return string $lastName
	 */
	public function getLastName()
	{
		return $this->lastName;
	}



	/**
	 * sets the value of last name
	 *
	 * @param string $newLastName last name
	 * @throws UnexpectedValueException if the input does not appear to be an name
	 * @throws RangeException if the input exceeds 64 characters
	 */
	public function setLastName($newLastName)
	{
		//first we take out the white space
		$newLastName = trim($newLastName);

		//Second we ensure that input is a string
		if(filter_var($newLastName, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("Last name $newLastName is not string"));
		}

		//third make sure length is not greater than 64
		if(strlen($newLastName) > 64) {
			throw(new RangeException("First name $newLastName exceeds 64 character limit"));
		}

		//assign value
		$this->lastName = $newLastName;
	}

	/**
	 * get value of $middleName
	 *
	 * @return mixed $middleName string or null if user has no middle name
	 */
	public function getMiddleName()
	{
		return $this->middleName;
	}



	/**
	 * sets the value of middle name
	 *
	 * @param string $newMiddleName middle name
	 * @throws UnexpectedValueException if the input does not appear to be an name
	 * @throws RangeException if the input exceeds 64 characters
	 */
	public function setMiddleName($newMiddleName)
	{
		//zeroth check to see if middle name is null
		if($newMiddleName === null) {
			$this->middleName = null;
			return;
		}
		//first we take out the white space
		$newMiddleName = trim($newMiddleName);

		//Second we ensure that input is a string
		if(filter_var($newMiddleName, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("Middle name $newMiddleName is not string"));
		}

		//third make sure length is not greater than 64
		if(strlen($newMiddleName) > 64) {
			throw(new RangeException("First name $newMiddleName exceeds 64 character limit"));
		}

		$this->middleName = $newMiddleName;
	}

	/**
	 * get value of location
	 *
	 * @return mixed $location string or null if no location
	 */
	public function getLocation()
	{
		return $this->location;
	}



	/**
	 * sets location to Profile
	 *
	 * @param string $newLocation location
	 * @throws UnexpectedValueException if the input does not appear to be a string
	 * @throws RangeException if the input exceeds 256 characters
	 */
	public function setLocation($newLocation)
	{
		//zeroth, allow the location to be null if a new object
		if($newLocation === null) {
			$this->location = null;
			return;
		}

		//first, sanitize string from tags
		if(filter_var($newLocation, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("location $newLocation doesn't appear to be string"));
		}

		//Ensure that location doesn't exceed 256
		if(strlen($newLocation) > 256) {
			throw(new RangeException("location $newLocation exceeds 256 character limit"));
		}

		// assign variable
		$this->location = $newLocation;

	}

	/**
	 * get value of description
	 *
	 * @return mixed $description string or null if no value
	 */
	public function getDescription()
	{
		return $this->description;
	}



	/**
	 * sets description for Profile
	 *
	 * @param string $newDesc location
	 * @throws UnexpectedValueException if the input does not appear to be a string
	 * @throws RangeException if the input exceeds 4096 characters
	 */
	public function setDescription($newDesc)
	{
		//zeroth, allow the Description to be null if a new object
		if($newDesc === null) {
			$this->description = null;
			return;
		}

		//first, sanitize string from tags
		if(filter_var($newDesc, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("location $newDesc doesn't appear to be string"));
		}

		//Ensure that description doesn't exceed 4096
		if(strlen($newDesc) > 4096) {
			throw(new RangeException("description exceeds 256 character limit"));
		}

		// assign variable
		$this->description = $newDesc;

	}

	/**
	 * get value of $profilePicFilename
	 *
	 * @return mixed $profilePicFilename string or null if no value
	 */
	public function getProfilePicFileName()
	{
		return $this->profilePicFileName;
	}



	/**
	 * sets profilePicFileName for Profile
	 *
	 * @param string $newPicFileName profilePicFileName
	 * @throws UnexpectedValueException if not valid upload file
	 * @returns valid upload file
	 **/
	public function setProfilePicFileName($newPicFileName)
	{
		//zeroth, set allow the PicFileName to be null if null
		if($newPicFileName === null) {
			$this->profilePicFileName = null;
			return;
		}

		$newPicFileName = filter_var($newPicFileName, FILTER_SANITIZE_STRING);
		if($newPicFileName === false) {
			throw(new RangeException("Invalid profile picture file name"));
		}

		$this->profilePicFileName = $newPicFileName;
	}

	/**
	 * TODO: write doc block :D
	 */
	public function uploadNewProfilePic() {
		//Catch if the
		if(empty($_FILES) === true) {
			return;
		}

		//create the white list of allowed types
		$goodExtensions = array("jpg", "jpeg", "png", "gif", "JPG");
		$goodMimes      = array("image/jpeg", "image/png", "image/gif");

		// verify the file was uploaded OK
		if($_FILES["imgUpload"]["error"] !== UPLOAD_ERR_OK) {
			throw(new RuntimeException("Error while uploading file: " . $_FILES["imgUpload"]["error"]));
		}

		// verify the file is an allowed extension and type
		$extension = end(explode(".", $_FILES["imgUpload"]["name"]));
		if(in_array($extension, $goodExtensions) === false
			|| in_array($_FILES["imgUpload"]["type"], $goodMimes) === false) {
			throw(new RuntimeException($_FILES["imgUpload"]["name"] . " is not a JPEG, GIF or PNG file"));
		}

		// use PHP's GD library to ensure the image is actually an image
		if($_FILES["imgUpload"]["type"] === "image/png") {
			$image = @imagecreatefrompng($_FILES["imgUpload"]["tmp_name"]);
			if($image === false) {
				throw(new InvalidArgumentException("Image is not a valid PNG file"));
			}
			imagedestroy($image);
		} else if($_FILES["imgUpload"]["type"] === "image/jpeg") {
			$image = @imagecreatefromjpeg($_FILES["imgUpload"]["tmp_name"]);
			if($image === false) {
				throw(new InvalidArgumentException("Image is not a valid JPEG file"));
			}
			imagedestroy($image);
		} else if($_FILES["imgUpload"]["type"] === "image/gif") {
			$image = @imagecreatefromgif($_FILES["imgUpload"]["tmp_name"]);
			if($image === false) {
				throw(new InvalidArgumentException("Image is not a valid GIF file"));
			}
			imagedestroy($image);
		} else {
			throw(new InvalidArgumentException("Image is not a supported format. Please use a JPEG, GIF or PNG file."));
		}

		// move the file to its permanent home
		$fileName    = "avatar-" . $this->profileId . "." . strtolower($extension);
		if(move_uploaded_file($_FILES["imgUpload"]["tmp_name"], "$this->destination/$fileName") === false) {
			throw(new RuntimeException("Unable to move file"));
		}
		else{
			//set $filename into $profilePicFileName
			$this->profilePicFileName = $fileName;
		}

		Profile::setProfilePicFileType($extension);
	}

	/**
	 * get value for $profilePicFileType
	 *
	 * @return mixed $profilePicFileType string or null if no value
	 */
	public function getProfilePicFileType()
	{
		return $this->profilePicFileType;
	}


	/**
	 * sets profilePicFileType for Profile
	 *
	 * @param string $newPicFileType profilePicFileType
	 * @throws UnexpectedValueException if file type not allowed
	 **/
	public function setProfilePicFileType($newPicFileType){
		//zeroth, set allow the PicFileName to be null if null
		if($newPicFileType === null) {
			$this->profilePicFileType = null;
			return;
		}

		//second set $newPicFileType
		$this->profilePicFileType = $newPicFileType;
	}

	/**
	 * get value for $destination
	 *
	 * @return string $destination for avatars
	 */
	public function getDestination(){
		return($this->destination);
	}

	/**
	 * insert this Profile to mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throw mysqli_sql_exception when mySQL related errors occur.
	 **/
	public function insert(&$mysqli){
		//handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the profileId is null (i.e., don't insert a user that already exists)
		if($this->profileId !== null) {
			throw(new mysqli_sql_exception("not a new profile"));
		}

		//create query template
		$query = "INSERT INTO profile(userId, firstName, lastName, middleName, location, description, profilePicFileName, profilePicFileType) VALUES(?,?,?,?,?,?,?,?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		//bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("isssssss", $this->userId, $this->firstName, $this->lastName,
			$this->middleName, $this->location, $this->description,
			$this->profilePicFileName, $this->profilePicFileType);
		if($wasClean === false){
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false){
			throw(new mysqli_sql_exception("unable to execute mySQL statement"));
		}

		//update the null profileId with what mySQL just gave us
		$this->profileId = $mysqli->insert_id;
	}

	/**
	 * deletes this Profile from mySQL
	 * @param resources $mysqli pointer to mySQL connections, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function delete(&$mysqli)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// make sure profileId is not null
		if($this->profileId === null) {
			throw(new mysqli_sql_exception("Unable to delete a user that does not exist"));
		}

		//create query template
		$query = "DELETE FROM profile WHERE profileId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		//bind the member variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->profileId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * updates this Profile in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function update(&$mysqli){
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the profileId is not null (i.e., don't update a user that hasn't been inserted)
		if($this->profileId === null) {
			throw(new mysqli_sql_exception("Unable to update a user that does not exist"));
		}

		//create query template
		$query = "UPDATE profile SET userId = ?, firstName = ?, lastName = ?, middleName = ?, location = ?, description = ?, profilePicFileName = ?, profilePicFileType =? WHERE profileId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false){
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		//bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("isssssssi", $this->userId, $this->firstName, $this->lastName, $this->middleName, $this->location, $this->description, $this->profilePicFileName, $this->profilePicFileType, $this->profileId);
		if($wasClean === false){
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false){
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

	}

	/**
	 * gets the profile by userId
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param string $userId userId to search for
	 * @return mixed Profile found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public static function getProfileByUserId(&$mysqli, $userId){
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize userId before searching
		// first, make sure user id is an integer
		if(filter_var($userId, FILTER_VALIDATE_INT) == false) {
			throw(new UnexpectedValueException("user id $userId is not numeric"));
		}

		//second, enforce that user id is an integer and positive
		$userId = intval($userId);
		if($userId <= 0) {
			throw(new RangeException("user id $userId is not positive"));
		}

		//create query template
		$query = "SELECT profileId, userId, firstName, lastName, middleName, location, description, profilePicFileName, profilePicFileType FROM profile WHERE userId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the userId to the place holder int the template
		$wasClean = $statement->bind_param("i", $userId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// get result from the SELECT query *pounds fists*
		$result = $statement->get_result();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to get result set"));
		}

		// since this is a unique field, this will only return 0 or 1 results. So...
		// 1) if there's a result, we can make it into a Profile object normally
		// 2) if there's no result, we can just return null
		$row = $result->fetch_assoc(); // fetch_assoc() returns a row as an associative array
		// convert the associative array to a Profile
		if($row !== null) {
			try {
				$profile = new Profile($row["profileId"], $row["userId"], $row["firstName"], $row["lastName"], $row["middleName"], $row["location"], $row["description"], $row["profilePicFileName"], $row["profilePicFileType"]);
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to Profile", 0, $exception));
			}
			//if we got here the Profile is good - return it
			return ($profile);
		}
		else {
			//404 Profile not found - return null instead
			return (null);
		}
	}

	/**
	 * gets the profile by profileId
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param string $profileId userId to search for
	 * @return mixed Profile found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public static function getProfileByProfileId(&$mysqli, $profileId){
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize profileId before searching
		// first, make sure profile id is an integer
		if(filter_var($profileId, FILTER_VALIDATE_INT) == false) {
			throw(new UnexpectedValueException("profile id $profileId is not numeric"));
		}

		//second, enforce that user id is an integer and positive
		$profileId = intval($profileId);
		if($profileId <= 0) {
			throw(new RangeException("profile id $profileId is not positive"));
		}

		//create query template
		$query = "SELECT profileId, userId, firstName, lastName, middleName, location, description, profilePicFileName, profilePicFileType FROM profile WHERE profileId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the profileId to the place holder int the template
		$wasClean = $statement->bind_param("i", $profileId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// get result from the SELECT query *pounds fists*
		$result = $statement->get_result();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to get result set"));
		}

		// since this is a unique field, this will only return 0 or 1 results. So...
		// 1) if there's a result, we can make it into a Profile object normally
		// 2) if there's no result, we can just return null
		$row = $result->fetch_assoc(); // fetch_assoc() returns a row as an associative array
		// convert the associative array to a Profile
		if($row !== null) {
			try {
				$profile = new Profile($row["profileId"], $row["userId"], $row["firstName"], $row["lastName"], $row["middleName"], $row["location"], $row["description"], $row["profilePicFileName"], $row["profilePicFileType"]);
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to Profile", 0, $exception));
			}
			//if we got here the Profile is good - return it
			return ($profile);
		}
		else {
			//404 Profile not found - return null instead
			return (null);
		}
	}

	/**
	 * gets the profile by first and last name
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param string $firstName first name to search for
	 * @param string $lastName last name to search for
	 * @return mixed User found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public static function getProfileByFirstAndOrLastName(&$mysqli, $firstName, $lastName)
	{

		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		//sanitize first name if not null
		if($firstName !== null){
			// take out the white space
			$firstName = trim($firstName);

			// ensure that input is a string
			if(filter_var($firstName, FILTER_SANITIZE_STRING) === false) {
				throw(new UnexpectedValueException("First name $firstName is not string"));
			}

			// make sure length is not greater than 64
			if(strlen($firstName) > 64) {
				throw(new RangeException("First name $firstName exceeds 64 character limit"));
			}

		}

		//sanitize last name if not null
		if($lastName !== null){
			// take out the white space
			$lastName = trim($lastName);

			// ensure that input is a string
			if(filter_var($lastName, FILTER_SANITIZE_STRING) === false) {
				throw(new UnexpectedValueException("First name $lastName is not string"));
			}

			// make sure length is not greater than 64
			if(strlen($lastName) > 64) {
				throw(new RangeException("First name $lastName exceeds 64 character limit"));
			}
		}

		// prepare query for firstName and lastName equal to Not Null
		if($firstName !== null && $lastName !== null){
			//create query template
			$query = "SELECT profileId, userId, firstName, lastName, middleName, location, description, profilePicFileName, profilePicFileType FROM profile WHERE firstName = ? AND lastName = ?";
			$statement = $mysqli->prepare($query);
			if($statement === false) {
				throw(new mysqli_sql_exception("Unable to prepare statement"));
			}

			//bind the $firstName and $lastName to the place holder in the template
			$wasClean = $statement->bind_param("ss", $firstName, $lastName);
			if($wasClean === false) {
				throw(new mysqli_sql_exception("Unable to bind parameters"));
			}
		}
		// prepare query for firstName Not Null and lastName null
		elseif($firstName !== null && $lastName === null){
			//create query template
			$query = "SELECT profileId, userId, firstName, lastName, middleName, location, description, profilePicFileName, profilePicFileType FROM profile WHERE firstName = ?";
			$statement = $mysqli->prepare($query);
			if($statement === false) {
				throw(new mysqli_sql_exception("Unable to prepare statement"));
			}

			//bind the $firstName to the place holder in the template
			$wasClean = $statement->bind_param("s", $firstName);
			if($wasClean === false) {
				throw(new mysqli_sql_exception("Unable to bind parameters"));
			}
		}
		//prepare query for lastName not null and firstName null
		elseif($lastName !== null && $firstName === null){
			//create query template
			$query = "SELECT profileId, userId, firstName, lastName, middleName, location, description, profilePicFileName, profilePicFileType FROM profile WHERE lastName = ?";
			$statement = $mysqli->prepare($query);
			if($statement === false) {
				throw(new mysqli_sql_exception("Unable to prepare statement"));
			}

			//bind the $firstName and $lastName to the place holder in the template
			$wasClean = $statement->bind_param("s", $lastName);
			if($wasClean === false) {
				throw(new mysqli_sql_exception("Unable to bind parameters"));
			}
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// get results
		$results = $statement->get_result();
		if($results->num_rows > 0) {
			// retrieve results in bulk into an array
			$results = $results->fetch_all(MYSQL_ASSOC);
			if($results === false) {
				throw(new mysqli_sql_exception("Unable to process result set"));
			}

			// step through results array and convert to Topic objects
			foreach ($results as $index => $row) {
				$results[$index] = new Profile($row["profileId"], $row["userId"], $row["firstName"], $row["lastName"], $row["middleName"], $row["location"], $row["description"], $row["profilePicFileName"], $row["profilePicFileType"]);
			}

			// return resulting array of Topic objects
			return($results);
		}
		else {
			return(null);
		}
	}

	public static function getProfilesByCohortId(&$mysqli, $cohortId)
	{

		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize the cohortId before searching
		$cohortId = trim($cohortId);
		$cohortId = filter_var($cohortId, FILTER_SANITIZE_NUMBER_INT);

		//create query template
		$query = 	"SELECT profile.profileId, userId, firstName, lastName, middleName, location, description, profilePicFileName, profilePicFileType, profileCohortId, profileCohort.profileId, cohortId, role
						FROM profile
						INNER JOIN profileCohort ON profile.profileId = profileCohort.profileId
						WHERE cohortId = ?
						ORDER BY CASE WHEN role = 'Admin' THEN 0 WHEN role = 'Instructor' THEN 1 WHEN role = 'Student' THEN 2 ELSE 3 END, firstName";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		//bind the $firstName and $lastName to the place holder in the template
		$wasClean = $statement->bind_param("i", $cohortId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}


		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// get results
		$results = $statement->get_result();
		if($results->num_rows > 0) {
			// retrieve results in bulk into an array
			$results = $results->fetch_all(MYSQL_ASSOC);
			if($results === false) {
				throw(new mysqli_sql_exception("Unable to process result set"));
			}

			$output = array();
			$count = 0;

			// step through results array and convert to Topic objects
			foreach ($results as $index => $row) {
				$output[$row["role"]][$count]["profile"] = new Profile($row["profileId"], $row["userId"], $row["firstName"], $row["lastName"], $row["middleName"], $row["location"], $row["description"], $row["profilePicFileName"], $row["profilePicFileType"]);
				$output[$row["role"]][$count]["profileCohort"] = new ProfileCohort($row["profileCohortId"], $row["profileId"], $row["cohortId"], $row["role"]);
				$count++;
			}

			// return resulting array of Topic objects
			return($output);
		}
		else {
			return(null);
		}
	}
}
?>