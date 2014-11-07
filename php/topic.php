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
	 * @param mixed $profileId
	 */
	public function setProfileId($profileId) {
		// TODO: Implement setProfileId() method.
		$this->profileId = $profileId;
	}

	/**
	 * @param STRING $creationDate
	 */
	public function setCreationDate($creationDate) {
		// TODO: Implement setCreationDate() method.
		$this->creationDate = $creationDate;
	}

	/**
	 * @param STRING $topicBody
	 */
	public function setTopicBody($topicBody) {
		// TODO: Implement setTopicBody() method.
		$this->topicBody = $topicBody;
	}

	/**
	 * @param STRING $topicSubject
	 */
	public function setTopicSubject($topicSubject) {
		// TODO: Implement setTopicSubject() method.
		$this->topicSubject = $topicSubject;
	}
}