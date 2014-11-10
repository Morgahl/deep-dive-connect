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




}






?>