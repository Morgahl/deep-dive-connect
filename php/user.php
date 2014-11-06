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
}
?>