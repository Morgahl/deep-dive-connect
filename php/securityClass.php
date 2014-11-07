<?php

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
	$newSiteAdmin) {
		try {
			$this->setsecurityId($newSecurityId);
			$this->setdescription($newDescription);
			$this->setcreateTopic($newCreateTopic)
			$this->setcanEditOther($newCanEditOther);
			$this->setcanPromote($newCanPromote);
			$this->setsiteAdmin($newSiteAdmin);
		} catch{
		// ToDo: implement catchblock
		}
	}


?>