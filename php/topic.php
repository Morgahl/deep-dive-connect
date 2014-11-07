<?php
/**
 * MySQL Enabled Topic
 *
 * This is a MySQL enabled container for Topic creation and handling.
 *
 * @author Marc Hayes <marc.hayes.tech@gmail.com>
 */
class Topic {
	/**
	 * @var $topicID INT topicId for the Topic; this is the primary key
	 */
	private $topicId;
	/**
	 * @var $profileId; INT profileId for the Topic; FK to profile table
	 */
	private $profileId;
	/**
	 * @var $creationDate DATETIME creation date for the Topic; format(Y-m-d H-i-s)
	 */
	private $creationDate;
	/**
	 * @var $topicSubject STRING this is the subject for the Topic, 256 character limit
	 */
	private $topicSubject;
	/**
	 * @var $topicBody STRING this is the body for the Topic; 4096 character limit
	 */
	private $topicBody;

	/**
	 * Constructor for Topic
	 *
	 * @param $newTopicId INT topicId (or null if new object)
	 * @param $newProfileId INT profileID (profileId of creator)
	 * @param $newCreationDate STRING creation date of new Topic; format(Y-m-d H-i-s)
	 * @param $newTopicSubject STRING subject of new Topic; 256 character limit
	 * @param $newTopicBody STRING body of new Topic; 4096 character limit
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throes RangeException when a parameter is invalid
	 */
	function __construct($newTopicId, $newProfileId, $newCreationDate, $newTopicSubject, $newTopicBody) {
		try{$this->setTopicId($newTopicId);
			$this->setProfileId($newProfileId);
			$this->setCreationDate($newCreationDate);
			$this->setTopicSubject($newTopicSubject);
			$this->setTopicBody($newTopicBody);
		} catch(UnexpectedValueException $unexpectedValue) {
			// rethrow to caller
			throw(new UnexpectedValueException("Unable to construct Topic", 0, $unexpectedValue));
		} catch(RangeException $range) {
			// rethrow to caller
			throw(new RangeException("Unable to construct Topic", 0, $range));
		}
	}

	/**
	 * Magic method that returns object state as a string
	 *
	 * @return string returns object state as a string
	 */
	function __toString()
	{
		// convert datetime object to string
		$creationDateString = $this->creationDate->format("Y-m-d H:i:s");

		// return string
		return("topicId: $this->topicId<br>" .
			"profileId: $this->profileId<br>" .
			"creationDate: $creationDateString<br>" .
			"topicSubject: $this->topicSubject<br>" .
			"topicBody: $this->topicBody<br>");
	}

	/**
	 * Magic method for getting state information
	 *
	 * @param $name STRING name of instance variable
	 * @return mixed returns value of variable requested by name
	 */
	public function __get($name) {
		return($this->$name);
	}

	/**
	 * Sets the value of topicId
	 *
	 * @param $newTopicId INT topic Id (or null if new object)
	 * @throws UnexpectedValueException if eventId is not an integer
	 * @throws RangeException if eventId is not positive
	 */
	public function setTopicId($newTopicId) {
		// allow the topicId to be null if a new object
		if($newTopicId === null) {
			$this->topicId = null;
			return;
		}

		// ensure that topicId is an int
		if(filter_var($newTopicId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("Topic ID $newTopicId is not numeric"));
		}

		// convert the topicId to int and enforce that it is positive
		$newTopicId = intval($newTopicId);
		if($newTopicId <= 0) {
			throw(new RangeException("Topic ID $newTopicId is not positive"));
		}

		// take topicId out of quarantine and assign it
		$this->topicId = $newTopicId;
	}

	/**
	 * Sets the value of profileId (profileId of creator)
	 *
	 * @param $newProfileId INT
	 * @throws UnexpectedValueException if eventId is not an integer
	 * @throws RangeException if eventId is not positive
	 */
	public function setProfileId($newProfileId) {
		// profileId should never be null
		if($newProfileId === null) {
			throw(new UnexpectedValueException("Profile ID must not be null"));
		}

		// ensure that profileId is an int
		if(($newProfileId = filter_var($newProfileId, FILTER_VALIDATE_INT)) === false) {
			throw(new UnexpectedValueException("Profile ID $newProfileId is not numeric"));
		}

		// convert the profileId to int and enforce that it is positive
		$newProfileId = intval($newProfileId);
		if($newProfileId <= 0) {
			throw(new RangeException("Profile ID $newProfileId is not positive"));
		}

		// take profileId out of quarantine and assign it
		$this->profileId = $newProfileId;
	}

	/**
	 * Sets the value of creationDate from a valid date string in Y-m-d H:i:s format
	 *
	 * @param $newCreationDate STRING Y-m-d H:i:s format
	 * @throws UnexpectedValueException when a parameter is not a valid date string in Y-m-d H:i:s format
	 */
	public function setCreationDate($newCreationDate) {
		// Sanitize Date input to Y-m-d H:i:s MySQL standard
		$newCreationDate = trim($newCreationDate);
		if (($newCreationDate = DateTime::createFromFormat("Y-m-d H:i:s", $newCreationDate)) === false) {
			throw(new UnexpectedValueException("Start date is not valid. Please use Y-m-d H:i:s format"));
		}

		// take creationDate out of quarantine and assign it
		$this->creationDate = $newCreationDate;
	}

	/**
	 * Sets the value of topicSubject
	 *
	 * @param $newTopicSubject STRING 256 character maximum length
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throes RangeException when a parameter length is invalid
	 */
	public function setTopicSubject($newTopicSubject) {
		// topicSubject should never be null
		if($newTopicSubject === null) {
			throw(new UnexpectedValueException("Topic Subject must not be null"));
		}

		// sanitize string
		$newTopicSubject = trim($newTopicSubject);
		if(($newTopicSubject = filter_var($newTopicSubject, FILTER_SANITIZE_STRING)) === false) {
			throw(new UnexpectedValueException("Not a valid string"));
		}

		// enforce 256 character limit to ensure no truncation of data when inserting to database
		if(strlen($newTopicSubject) > 256) {
			throw(new RangeException("Topic Subject must be 256 characters or less in length"));
		}

		// take topicSubject out of quarantine and assign it
		$this->topicSubject = $newTopicSubject;
	}

	/**
	 * Sets the value of topicBody
	 *
	 * @param $newTopicBody STRING 4096 character maximum length
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throes RangeException when a parameter length is invalid
	 */
	public function setTopicBody($newTopicBody) {
		// topicBody should never be null
		if($newTopicBody === null) {
			throw(new UnexpectedValueException("Topic Body must not be null"));
		}

		// sanitize string
		$newTopicBody = trim($newTopicBody);
		if(($newTopicBody = filter_var($newTopicBody, FILTER_SANITIZE_STRING)) === false) {
			throw(new UnexpectedValueException("Not a valid string"));
		}

		// enforce 4096 character limit to ensure no truncation of data when inserting to database
		if(strlen($newTopicBody) > 4096) {
			throw(new RangeException("Topic Body must be 4096 characters or less in length"));
		}

		// take topicBody out of quarantine and assign it
		$this->topicBody = $newTopicBody;
	}

	/**
	 * Inserts this Topic into mySQL
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @throws mysqli_sql_exception when a MySQL error occurs
	 */
	public function insert(&$mysqli) {
		// TODO: implement mySQL insert of validated object
	}

	/**
	 * Updates this Topic in mySQL
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @throws mysqli_sql_exception when a MySQL error occurs
	 */
	public function update(&$mysqli) {
		// TODO: implement mySQL update of validated object
	}

	/**
	 * Deletes this Topic from mySQL
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @throws mysqli_sql_exception when a MySQL error occurs
	 */
	public function delete(&$mysqli) {
		// TODO: implement mySQL deletion of validated object
	}

	/**
	 * Creates a new Topic Object from mySQL base on passed topicId
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @param $newTopicId INT topicId to retrieve from mySQL
	 * @throws mysqli_sql_exception when a MySQL error occurs
	 * @return OBJECT new Topic is returned or null if id specified is not found
	 */
	public function getTopicByTopicId(&$mysqli, $newTopicId) {
		// TODO: implement mySQL select and creation of validated object based on passed topicId
		return(null);
	}

	// TODO: review for any additional methods needed
}