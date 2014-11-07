<?php

// Author Joseph Bottone
// http://josephmichaelbottone.com
// bottone.joseph@gmail.com

class SecurityClass
{
	// assigns the primary key
	private $securityId;
	// names the description
	private $description;
	// name of createTopic
	private $createTopic;
	// name of canEditOther
	private $canEditOther;
	// name of canPromote
	private $canPromote;
	// name of siteAdmin
	private $siteAdmin;

	// here is the constructor
	public function __construct($newSecurityId, $newDescription, $newCreateTopic, $newCanEditOther, $newCanPromote,
										 $newSiteAdmin)
	{
		try {
			$this->setsecurityId($newSecurityId);
			$this->setdescription($newDescription);
			$this->setcreateTopic($newCreateTopic);
			$this->setcanEditOther($newCanEditOther);
			$this->setcanPromote($newCanPromote);
			$this->setsiteAdmin($newSiteAdmin);
		}  catch(UnexpectedValueException $unexpectedValue) {
	// rethrow to the seller
throw(new UnexpectedValueException("Unable to construct securityId, 0, $unexpectedValue"));
} catch(RangeException $range) {
	// rethrow to the caller
	throw(new RangeException("Unable to construct securityId", 0, $range));
}
		}
	// gets the value of the securityId
	public function getSecurityId() {
		return ($this->securityId);
	}

	public function setSecurityId($newSecurityId) {
		//  ensure the securityId is an integer
		if(filter_var($newSecurityId, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("securityId $newSecurityId is not valid"));
		}

		// finally, take the securityId out of quarantine and assign it
		$this->securityId = $newSecurityId;
	}




	public function getDescription() {
		return ($this->description);
	}

	public function setDescription($newDescription)
	{
		// allow the description to be null if a new object

		if($newDescription === null) {
			$this->description = null;
			return;
		}

		//  ensure the description is an integer
		if(filter_var($newDescription, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("description $newDescription is not numeric"));
		}

		$newDescription = intval($newDescription);
		if($newDescription <= 0) {
			throw(new RangeException("securityId $newDescription is not positive"));
		}

		$this->description = $newDescription;

	}

}
?>