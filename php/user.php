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
	 * securityId identifies the users security clearances
	 */
	private $securityId;
	/**
	 * identifies whether user is logging in through site or external options
	 */
	private $loginSourceId;

	/**
	 * constructor for User
	 *
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
	 * @param mixed $email
	 */
	public function setEmail($email){
		$this->email = $email;
	}

	/**
	 * @param mixed $passwordHash
	 */
	public function setPasswordHash($passwordHash){
		$this->passwordHash = $passwordHash;
	}

	/**
	 * @param mixed $salt
	 */
	public function setSalt($salt){
		$this->salt = $salt;
	}

	/**
	 * @param mixed $authKey
	 */
	public function setAuthKey($authKey){
		$this->authKey = $authKey;
	}

	/**
	 * @param mixed $securityId
	 */
	public function setSecurityId($securityId){
		$this->securityId = $securityId;
	}

	/**
	 * @param mixed $loginSourceId
	 */
		public function setLoginSourceId($loginSourceId){
		$this->loginSourceId = $loginSourceId;
	}




}
?>