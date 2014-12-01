<?php
/**
 * change password form processor
 *
 * @author Steven Chavez <schavez256@yahoo.com>
 */
require_once("../class/user.php");

//get current password
$curPass = $_POST['current-password'];

// hash current password
$this->SALT		= bin2hex(openssl_random_pseudo_bytes(32));
$this->AUTHKEY = bin2hex(openssl_random_pseudo_bytes(16));
$this->HASH 	= hash_pbkdf2("sha512", $this->curPass, $this->SALT, 2048, 128);

// get hash from user by email
