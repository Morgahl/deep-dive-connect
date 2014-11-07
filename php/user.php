<?php
/**
 * mySQL Enabled User
 *
 * This is a mySQl enabled container for User authentication.
 *
 * @author Steven Chavez <schavez256@yahoo.com>
 * @see Profile
 */
class User{
	/**
	 * user id for User; primary key
	 */
	private $userId;
	/**
	 * email for User; unique field
	 */
	private $email;
	/**
	 * SHA512 PBKDF2 hash of the password
	 */
	private $passwordHash;
	/**
	 * salt used in the PBKDF2 hash
	 */
	private $salt;
	/**
	 * authentication token used in a new account and password resets
	 */
	private $authKey;
	/**
	 * securityId identifies the users security clearances; foreign key
	 */
	private $securityId;
	/**
	 * identifies whether user is logging in through site or external options; foreign key
	 */
	private $loginSourceId;

	/**
	 * Constructor of User
	 *
	 * @param int $newUserId userId
	 * @param string $newEmail email
	 * @param string $newPasswordHash passwordHash
	 * @param string $newSalt salt
	 * @param string $newAuthKey salt
	 * @param int $newSecurityId securityId
	 * @param int $newLoginSourceId loginSourceId
	 */
	public function  __construct($newUserId, $newEmail, $newPasswordHash, $newSalt, $newAuthKey, $newSecurityId, $newLoginSourceId)
	{
		try {
			$this->setUserId($newUserId);
			$this->setEmail($newEmail);
			$this->setPasswordHash($newPasswordHash);
			$this->setSalt($newSalt);
			$this->setAuthKey($newAuthKey);
			$this->setSecurityId($newSecurityId);
			$this->setLoginSorceId($newLoginSourceId);
		} catch(UnexpectedValueException $unexpectedValue) {
			//rethrow to the caller
			throw(new UnexpectedValueException("Unable to construct User", 0, $unexpectedValue));
		} catch(RangeException $range) {
			//rethrow to the caller
			throw(new RangeException("Unable to construct User", 0, $range));
		}
	}

	/**
	 * magic method __get() gets the values from User
	 * @return mixed int or string
	 */
	public function __get($name){
		return($this->$name);
	}

	/**
	 * sets the value for userId
	 *
	 * @param mixed $newUserId user id(or null if new object
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if user id isn't positive
	 */
	public function setUserId($newUserId){
		// zeroth, set allow the user id to be null if a new object
		if($newUserId === null) {
			$this->userId = null;
			return;
		}

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
	 * sets the value of email
	 *
	 * @param string $newEmail email
	 * @throws UnexpectedValueException if the input doesn't appear to be an email
	 */
	public function setEmail($newEmail){
		// sanitize the email as a likely email
		$newEmail = trim($newEmail);
		if(($newEmail = filter_var($newEmail, FILTER_SANITIZE_EMAIL)) === false){
			throw(new UnexpectedValueException("email $newEmail does not appear to be an email address"));
		}

		// now that data has been sanitized assign it
		$this->email = $newEmail;
	}

	/**
	 * sets the value of password
	 *
	 * @param string $newPasswordHash SHA512 PBKDF2 hash of the password
	 * @throws RangeException when input isn't a valid SHA512 PBKDF2 hash
	 */
	public function setPasswordHash($newPasswordHash){
		// verify the password is 128 hex characters
		$newPasswordHash = trim($newPasswordHash);
		$newPasswordHash = strtolower($newPasswordHash);
		$filterOptions = array("options" => array("regexp" => "/^[\da-f]{128}$/"));
		if(filter_var($newPasswordHash, FILTER_VALIDATE_REGEXP, $filterOptions) === false){
			throw(new RangeException("password is not a valid SHA512 PBKDF2 hash"));
		}

		// assign passwordHash
		$this->passwordHash = $newPasswordHash;
	}

	/**
	 * sets value for salt
	 *
	 * @param string $newSalt salt (64 hexadecimal bytes)
	 * @throw RangeException whe input isn't 64 hexadecimal bytes
	 */
	public function setSalt($newSalt){
		//verify the salt is 64 hex characters
		$newSalt	=trim($newSalt);
		$newSalt	=strtolower($newSalt);
		$filterOptions = array("options" => array("regexp" => "/^[|da-f]{64}$/"));
		if(filter_var($newSalt, FILTER_VALIDATE_REGEXP, $filterOptions) === false) {
			throw(new RangeException("salt is not 64 hexadecimal bytes"));
		}

		// finally, take the salt out of quarantine
		$this->salt = $newSalt;
	}



	/**
	 * set value of authKey
	 *
	 * @param mixed $newAuthKey authentication token(32 hexadecimal bytes) or null
	 * @throws RangeException when input isn't 32 hexadecimal bytes
	 */
	public function setAuthKey($newAuthKey){
		//zeroth, set allow the authentication token to be null if an active object
		if($newAuthKey === null) {
			$this->authKey = null;
			return;
		}

		//verify authKey is 32 hex char
		$newAuthKey	=trim($newAuthKey);
		$newAuthKey	=strtolower($newAuthKey);
		$filterOptions = array("options" => array("regexp" => "/^[\da-f]{32}$/"));

		if(filter_var($newAuthKey, FILTER_VALIDATE_REGEXP, $filterOptions) === false){
			throw(new RangeException("authentication token is not 32 hexadecimal bytes"));
		}

		//assign authKey
		$this->authKey = $newAuthKey;
	}

	/**
	 * security Id associated with user
	 *
	 * @param mixed $securityId int (null if new object)
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if profile id isn't positive
	 */
	public function setSecurityId($newSecurityId){
		//todo: Do we want users automatically set to a default security id?
		//allow the securityId to be null if a new object
		if($newSecurityId === null){
			$this->securityId = null;
			return;
		}

		//ensure securityId is an integer
		if(filter_var($newSecurityId, FILTER_VALIDATE_INT) === false){
			throw(new UnexpectedValueException("security id $newSecurityId is not numeric"));
		}

		//enforce security id is an int and positive
		$newSecurityId = intval($newSecurityId);
		if($newSecurityId <= 0) {
			throw(new RangeException("security id $newSecurityId is not positive"));
		}

		//assign securityId
		$this->securityId = $newSecurityId;
	}

	/**
	 * Sets the LoginSource of user
	 *
	 * @param mixed $loginSourceId int (null if new object)
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if profile id isn't positive
	 */
		public function setLoginSourceId($newLoginSourceId){
			//allow the loginSource Id to be null if a new object
			if($newLoginSourceId === null){
				$this->loginSourceId = null;
				return;
			}

			//ensure loginSource Id is an integer
			if(filter_var($newLoginSourceId, FILTER_VALIDATE_INT) === false){
				throw(new UnexpectedValueException("security id $newLoginSourceId is not numeric"));
			}

			//enforce loginSource id is an int and positive
			$newLoginSourceId = intval($newLoginSourceId);
			if($newLoginSourceId <= 0) {
				throw(new RangeException("security id $newLoginSourceId is not positive"));
			}

			//assign loginSource Id
			$this->loginSourceId = $newLoginSourceId;
	}



}
?>