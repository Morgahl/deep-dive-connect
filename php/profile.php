<?php
/**
 * mySQL Enabled Profile
 *
 * This is an mySQL enabled container fot the Profile authentication
 *
 * @author Steven Chavez <schavez256@yahoo.com>
 * @see Profile
 **/
class Profile{
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
	private  $location;
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
	 * Constructor of Profile
	 *
	 * @param int $newProfileId profileId
	 * @param int $newUserId userId
	 * @param string $newFirstName firstName
	 * @param string $newLastName lastName
	 * @param string $newMiddleName middleName
	 * @param string $newLocation location
	 * @param string $newDesc description
	 * @param string $newPicFileName profilePicFileName
	 * @param string $newPicFileType profilePicFileType
	 */
	public function __construct(	$newProfileId, $newUserId, $newFirstName,
											$newLastName, $newMiddleName, $newLocation,
											$newDesc, $newPicFileName, $newPicFileType){
		try{
			$this->setProfileId($newProfileId);
			$this->setUserId($newUserId);
			$this->setFirstName($newFirstName);
			$this->setLastName($newLastName);
			$this->setMiddleName($newMiddleName);
			$this->setLocation($newLocation);
			$this->setDescription($newDesc);
			$this->setProfilePicFileName($newPicFileName);
			$this->setProfilePicFileType($newPicFileType);
		}catch(UnexpectedValueException $unexpectedValue) {
			//rethrow to the caller
			throw(new UnexpectedValueException("Unable to construct Profile", 0, $unexpectedValue));
		} catch(RangeException $range) {
			//rethrow to the caller
			throw(new RangeException("Unable to construct Profile", 0, $range));
		}

	}

	/**
	 * magic method __get() gets the values from Profile
	 * @return mixed int or string
	 */
	public function __get($name){
		return ($this->$name);
	}

	/**
	 * sets the value for profileId
	 *
	 * @param mixed $newProfileId profile id(or null if new object
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if profile id isn't positive
	 */
	public function setProfileId($newProfileId){
		// zeroth, set allow the profile id to be null if a new object
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}

		// first, make sure profile id is an integer
		if(filter_var($newProfileId, FILTER_VALIDATE_INT)== false) {
			throw(new UnexpectedValueException("profile id $newProfileId is not numeric"));
		}

		//second, enforce that user id is an integer and positive
		$newProfileId = intval($newProfileId);
		if($newProfileId <= 0){
			throw(new RangeException("profile id $newProfileId is not positive"));
		}

		// finally after sanitizing data assign it
		$this->profileId = $newProfileId;
	}

	/**
	 * sets the value for userId
	 *
	 * @param int $newUserId user id
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if user id isn't positive
	 */
	public function setUserId($newUserId){
		// first, make sure user id is an integer
		if(filter_var($newUserId, FILTER_VALIDATE_INT)== false) {
			throw(new UnexpectedValueException("user id $newUserId is not numeric"));
		}

		//second, enforce that user id is an integer and positive
		$newUserId = intval($newUserId);
		if($newUserId <= 0){
			throw(new RangeException("user id $newUserId is not positive"));
		}

		// finally after sanitizing data assign it
		$this->userId = $newUserId;
	}

	/**
	 * sets the value of first name
	 *
	 * @param string $newFirstName firstName
	 * @throws UnexpectedValueException if the input does not appear to be an name
	 * @throws RangeException if the input exceeds 64 characters
	 */
	public function setFirstName($newFirstName){
		//first we take out the white space
		$newFirstName = trim($newFirstName);

		//Second we ensure that input is a string
		if(filter_var($newFirstName, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("First name $newFirstName is not string"));
		}

		//third make sure length is not greater than 64
		if(strlen($newFirstName) > 64){
			throw(new RangeException("First name $newFirstName exceeds 64 character limit"));
		}

		//assign value
		$this->firstName = $newFirstName;
	}

	/**
	 * sets the value of last name
	 *
	 * @param string $newLastName last name
	 * @throws UnexpectedValueException if the input does not appear to be an name
	 * @throws RangeException if the input exceeds 64 characters
	 */
	public function setLastName($newLastName){
		//first we take out the white space
		$newLastName = trim($newLastName);

		//Second we ensure that input is a string
		if(filter_var($newLastName, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("Last name $newLastName is not string"));
		}

		//third make sure length is not greater than 64
		if(strlen($newLastName) > 64){
			throw(new RangeException("First name $newLastName exceeds 64 character limit"));
		}

		//assign value
		$this->lastName = $newLastName;
	}

	/**
	 * sets the value of middle name
	 *
	 * @param string $newMiddleName middle name
	 * @throws UnexpectedValueException if the input does not appear to be an name
	 * @throws RangeException if the input exceeds 64 characters
	 */
	public function setMiddleName($newMiddleName){
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
		if(strlen($newMiddleName) > 64){
			throw(new RangeException("First name $newMiddleName exceeds 64 character limit"));
		}

		$this->middleName = $newMiddleName;
	}

	/**
	 * sets location to Profile
	 *
	 * @param string $newLocation location
	 * @throws UnexpectedValueException if the input does not appear to be a string
	 * @throws RangeException if the input exceeds 256 characters
	 */
	public function setLocation($newLocation){
		//zeroth, allow the location to be null if a new object
		if($newLocation === null){
			$this->location = null;
			return;
		}

		//first, sanitize string from tags
		if(filter_var($newLocation, FILTER_SANITIZE_STRING) === false){
			throw(new UnexpectedValueException("location $newLocation doesn't appear to be string"));
		}

		//Ensure that location doesn't exceed 256
		if(strlen($newLocation) > 256){
			throw(new RangeException("location $newLocation exceeds 256 character limit"));
		}

		// assign variable
		$this->location = $newLocation;

	}

	/**
	 * sets description for Profile
	 *
	 * @param string $newDesc location
	 * @throws UnexpectedValueException if the input does not appear to be a string
	 * @throws RangeException if the input exceeds 4096 characters
	 */
	public function setDescription($newDesc){
		//zeroth, allow the Description to be null if a new object
		if($newDesc === null){
			$this->description = null;
			return;
		}

		//first, sanitize string from tags
		if(filter_var($newDesc, FILTER_SANITIZE_STRING) === false){
			throw(new UnexpectedValueException("location $newDesc doesn't appear to be string"));
		}

		//Ensure that description doesn't exceed 4096
		if(strlen($newDesc) > 4096){
			throw(new RangeException("description exceeds 256 character limit"));
		}

		// assign variable
		$this->description = $newDesc;

	}


	//Todo Profile pic file name
	//can you set up a place to upload pics ask dylan
	//move_uploaded_file

	//TODO profile pic file type
	//in data base store mime type image/*
	//take type from browser
	//after taking that on faith; we through our faith away
	//imgcreatefromfoo
	//imgdestroy
}






?>