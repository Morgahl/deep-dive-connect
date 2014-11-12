<?php
/**
 * Unit test for Topic
 *
 * This is a MySQL enabled container for Topic topic and handling.
 *
 * @author Marc Hayes <marc.hayes.tech@gmail.com>
 */
// require the SimpleTest Framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// require the class under scrutiny
require_once("../php/topic.php");

// require classes that table needs FK data from
require_once("../php/user.php");
require_once("../php/profile.php");
// TODO: bring these back in
//require_once("../php/securityClass.php");
//require_once("../php/loginSource.php");

// require mysqli connection object
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

// the TopicTest is a container for all our tests
class TopicTest extends UnitTestCase {
	// variable to hold mysqli connection
	private $mysqli				= null;
	// variable to hold the test results from database
	private $loginSources		= null;
	// variable to hold the test results from database
	private $securityClasses	= null;
	// variable to hold the test results from database
	private $users					= null;
	// variable to hold the test results from database
	private $profiles				= null;
	// variable to hold the test results from database
	private $topics				= null;

	// "globals" used for testing
	private $topicSubject	= "Nunc ac augue a nisl ultricies finibus vel vitae nulla. Etiam accumsan sem blandit ultricies posuere. Nam hendrerit risus vitae dolor porta rutrum congue ac dolor. Cras nisi orci, eleifend et aliquam eu, accumsan sed metus. Cras sed tortor purus cras amet.";
	private $topicBody		= "Aenean facilisis nibh vitae elementum venenatis. Praesent nisl tortor, posuere non condimentum a, consectetur non erat. Suspendisse dignissim, diam quis rutrum suscipit, eros risus malesuada nisi, non euismod risus ex nec lectus. Proin pulvinar ligula nec lorem venenatis gravida in et sem. Vestibulum sapien arcu, venenatis eget consequat a, varius vel lacus. Nunc nec turpis nec dolor rhoncus pretium eget eget ipsum. Nunc nulla urna, facilisis feugiat erat in, tristique vulputate ipsum. Nunc leo purus, gravida sed sodales vel, aliquet ultrices libero. Quisque non neque dictum, accumsan nulla ut, egestas lorem. Nulla ullamcorper erat sed felis tempor, at bibendum erat ultrices. Nullam at sapien id erat suscipit placerat ac vitae tortor. Curabitur vel gravida nunc. Duis mauris risus, tristique nec maximus et, lobortis a diam. Cras ut mollis orci. Etiam vulputate elementum sapien et fringilla.

Aliquam facilisis est ipsum, at suscipit massa gravida sit amet. Etiam dictum, nisi scelerisque finibus eleifend, quam dui porttitor odio, vitae finibus enim diam eget sapien. Fusce vitae nibh metus. Maecenas laoreet rhoncus magna a cursus. Integer eleifend consequat ipsum maximus mollis. Morbi sit amet tempor eros. Nunc tincidunt viverra ex, in egestas mi.

Nulla vitae mattis enim. Donec vulputate eleifend velit, id venenatis augue sagittis non. Fusce eget lectus massa. Ut consequat purus nisl, at venenatis orci semper vitae. Donec efficitur imperdiet diam ornare convallis. Nulla vel nisi ultricies, efficitur elit at, facilisis sapien. Nunc in nibh sit amet purus placerat auctor sit amet vitae quam. Nam lacinia tristique metus. Integer luctus aliquam neque eu volutpat. Quisque velit dui, euismod et luctus quis, sodales commodo massa. Ut ut feugiat sem. Integer ut nisl tincidunt, placerat orci sit amet, accumsan lectus. Vestibulum elit metus, pharetra nec eros at, vulputate finibus urna. Integer posuere, urna sollicitudin volutpat convallis, risus odio volutpat nisi, ut posuere metus dui nec elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.

Cras volutpat magna ac sapien tempus consequat. Quisque vehicula sodales erat, egestas accumsan quam congue ac. Cras rhoncus tincidunt justo tempor pellentesque. Nunc sed arcu lectus. Morbi molestie nulla nibh, vel interdum nulla gravida id. Nam non accumsan enim, sit amet fermentum lectus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec venenatis scelerisque risus, ut tristique diam interdum at. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce rutrum augue quis ligula pulvinar, convallis laoreet est efficitur.

In luctus velit a nisl semper, ac consectetur risus fermentum. Morbi est lorem, vulputate ut nunc in, euismod tincidunt turpis. Sed ut facilisis purus, in bibendum nulla. Praesent eget placerat ex. Proin justo eros, cursus ut blandit ut, convallis non ipsum. Nunc cursus vestibulum ligula in aliquet. Ut tempus quam lorem, eget sodales diam convallis in. Vestibulum posuere condimentum dapibus. Curabitur hendrerit tortor ligula, dictum hendrerit tellus dignissim ultricies. Etiam a ipsum ipsum. Sed nisl ante, malesuada et tortor a, sagittis cursus enim. Vivamus dictum placerat gravida.

Nulla ante sapien, accumsan sit amet dapibus et, molestie ut dui. Proin varius enim sed justo vehicula lacinia. Sed mollis eu nulla ut porttitor. Aenean bibendum erat id arcu laoreet, non posuere diam consectetur. Duis posuere convallis nisi, vitae mattis mi ullamcorper a. Mauris venenatis vel nibh in pellentesque. Vivamus sed mauris metus.

Maecenas quis lobortis massa. Suspendisse ultricies aliquet dui, sit amet pharetra turpis tempor in.";

	// setUp() is a method the is run before each test
	// here, we use it to connect to mySQL (other functionality can be populated depending on test plan
	public function setUp() {
		// connect to mySQL
		$this->mysqli =  MysqliConfiguration::getMysqli();

		// TODO: set this to use securityClass and loginSourceID from above objects
//		//create new securityClass
//		$this->securityClasses = new SecurityClass(null, "Uber Newb",0,0,0,0,0);
//		$this->securityClasses->insert($this->profiles);
//
//		// create new loginSource
//		$this->loginSources = new LoginSource(null,"thingy.com");
//		$this->loginSources->insert($this->mysqli);

		// create new user
		$this->users = new User(null, "1@1.com", null, null, null, 1, null);
		$this->users->insert($this->mysqli);

		// create new profile
		$this->profiles = new Profile(null, $this->users->getUserId(), "First", "Last", null, "City", "Tester profile", null, null);
		$this->profiles->insert($this->mysqli);
	}

	// tearDown() is a method that is run after each test
	// here, we use it to delete the test record and disconnect from mySQL
	public function tearDown() {
		if($this->topics !== null) {
			$this->topics->delete($this->mysqli);
			$this->topics = null;
		}

		// delete profile object from DB
		$this->profiles->delete($this->mysqli);

		// delete user object from DB
		$this->users->delete($this->mysqli);

		// TODO: bring these back in
//		// delete loginSource object from DB
//		$this->loginSources->delete($this->mysqli);
//
//		// delete securityClass object from DB
//		$this->securityClasses->delete($this->mysqli);
	}

	// test topic creation and insertion
	public function testInsertNewTopic() {
		// first confirm that mySQL connection is OK
		$this->assertNotNull($this->mysqli);

		// second, create a topic to post to mySQL
		$this->topics = new Topic(null, $this->profiles->getProfileId(), null, $this->topicSubject, $this->topicBody);

		// third, insert topic into mySQL
		$this->topics->insert($this->mysqli);

		// forth, rebuild class from mySQL data for the object
		$this->topics = $this->topics->getTopicByTopicId($this->mysqli, $this->topics->getTopicId());

		//finally, compare the fields
		// topicId
		$this->assertNotNull($this->topics->getTopicId());
		$this->assertTrue($this->topics->getTopicId() > 0);
		// profileId
		$this->assertNotNull($this->topics->getProfileId());
		$this->assertTrue($this->topics->getProfileId() > 0);
		$this->assertIdentical($this->topics->getProfileId(),		$this->profiles->getProfileId());
		// topicDate
		$this->assertNotNull($this->topics->getTopicDate());
		// topicSubject
		$this->assertNotNull($this->topics->getTopicSubject());
		$this->assertIdentical($this->topics->getTopicSubject(),	$this->topicSubject);
		// topicBody
		$this->assertNotNull($this->topics->getTopicBody());
		$this->assertIdentical($this->topics->getTopicBody(),		$this->topicBody);
	}

	// test topic update
	public function testUpdateTopic() {
		// value to set for topicSubject
		$newSubject = "This is a test change.";

		// confirm that mySQL connection is OK
		$this->assertNotNull($this->mysqli);

		// create a topic to post to mySQL
		$this->topics = new Topic(null, $this->profiles->getProfileId(), null, $this->topicSubject, $this->topicBody);

		// insert topic into mySQL
		$this->topics->insert($this->mysqli);

		// rebuild class from mySQL data for the object
		$this->topics = $this->topics->getTopicByTopicId($this->mysqli, $this->topics->getTopicId());

		// change a value then push update
		$this->topics->setTopicSubject($newSubject);
		$this->topics->update($this->mysqli);

		// forth, rebuild class from mySQL data for the object
		$this->topics = $this->topics->getTopicByTopicId($this->mysqli, $this->topics->getTopicId());

		//compare the fields
		// topicId
		$this->assertNotNull($this->topics->getTopicId());
		$this->assertTrue($this->topics->getTopicId() > 0);
		// profileId
		$this->assertNotNull($this->topics->getProfileId());
		$this->assertTrue($this->topics->getProfileId() > 0);
		$this->assertIdentical($this->topics->getProfileId(),		$this->profiles->getProfileId());
		// topicDate
		$this->assertNotNull($this->topics->getTopicDate());
		// topicSubject
		$this->assertNotNull($this->topics->getTopicSubject());
		$this->assertIdentical($this->topics->getTopicSubject(),	$newSubject);
		// topicBody
		$this->assertNotNull($this->topics->getTopicBody());
		$this->assertIdentical($this->topics->getTopicBody(),		$this->topicBody);
	}

	// test topic deletion
	public function testDeleteTopic() {
		// confirm that mySQL connection is OK
		$this->assertNotNull($this->mysqli);

		// create a topic to post to mySQL
		$this->topics = new Topic(null, $this->profiles->getProfileId(), null, $this->topicSubject, $this->topicBody);

		// insert topic into mySQL
		$this->topics->insert($this->mysqli);

		// rebuild class from mySQL data for the object
		$this->topics = $this->topics->getTopicByTopicId($this->mysqli, $this->topics->getTopicId());

		//assert that object exists and is valid
		// topicId
		$this->assertNotNull($this->topics->getTopicId());
		$this->assertTrue($this->topics->getTopicId() > 0);
		// profileId
		$this->assertNotNull($this->topics->getProfileId());
		$this->assertTrue($this->topics->getProfileId() > 0);
		$this->assertIdentical($this->topics->getProfileId(),		$this->profiles->getProfileId());
		// topicDate
		$this->assertNotNull($this->topics->getTopicDate());
		// topicSubject
		$this->assertNotNull($this->topics->getTopicSubject());
		$this->assertIdentical($this->topics->getTopicSubject(),	$this->topicSubject);
		// topicBody
		$this->assertNotNull($this->topics->getTopicBody());
		$this->assertIdentical($this->topics->getTopicBody(),		$this->topicBody);

		// delete object
		$this->topics->delete($this->mysqli);

		// get now deleted topic
		$this->topics = $this->topics->getTopicByTopicId($this->mysqli, $this->topics->getTopicId());

		// assert null
		$this->assertNull($this->topics);
	}

	// test topic creation from DB
	public function testGetTopicByTopicId() {
		// first confirm that mySQL connection is OK
		$this->assertNotNull($this->mysqli);

		// second, create a topic to post to mySQL
		$this->topics = new Topic(null, $this->profiles->getProfileId(), null, $this->topicSubject, $this->topicBody);

		// third, insert topic into mySQL
		$this->topics->insert($this->mysqli);

		// forth, unlike insert test we rebuild object into a brand new object
		$newTopics = $this->topics->getTopicByTopicId($this->mysqli, $this->topics->getTopicId());

		//finally, compare the fields
		// topicId
		$this->assertNotNull($newTopics->getTopicId());
		$this->assertTrue($newTopics->getTopicId() > 0);
		// profileId
		$this->assertNotNull($newTopics->getProfileId());
		$this->assertTrue($newTopics->getProfileId() > 0);
		$this->assertIdentical($newTopics->getProfileId(),		$this->profiles->getProfileId());
		// topicDate
		$this->assertNotNull($newTopics->getTopicDate());
		// topicSubject
		$this->assertNotNull($newTopics->getTopicSubject());
		$this->assertIdentical($newTopics->getTopicSubject(),	$this->topicSubject);
		// topicBody
		$this->assertNotNull($newTopics->getTopicBody());
		$this->assertIdentical($newTopics->getTopicBody(),		$this->topicBody);
	}

	// test return of array of topic objects
	public function testGetRecentTopics() {
		// count of topics
		$count = 10;

		// test mySQL object
		$this->assertNotNull($this->mysqli);


		// creat and insert 10 objects via looped instantiation
		for ($i = 0; $i <= $count - 1; $i++){
			$this->topics = new Topic(null, $this->profiles->getProfileId(), null, "This is subject $i", "This is comment $i");
			$this->topics->insert($this->mysqli);
			sleep(1);
		}

		// retrieve new array of objects via getRecentTopics()
		$newTopics = Topic::getRecentTopics($this->mysqli, $count);

		// loop thorugh test of array of retrieved topics
		foreach ($newTopics as $i => $prop){
			$count--;
			// topicId
			$this->assertNotNull($newTopics[$i]->getTopicId());
			$this->assertTrue($newTopics[$i]->getTopicId() > 0);
			// profileId
			$this->assertNotNull($newTopics[$i]->getProfileId());
			$this->assertTrue($newTopics[$i]->getProfileId() > 0);
			$this->assertIdentical($newTopics[$i]->getProfileId(),		$this->profiles->getProfileId());
			// topicDate
			$this->assertNotNull($newTopics[$i]->getTopicDate());
			// topicSubject
			$this->assertNotNull($newTopics[$i]->getTopicSubject());
			$this->assertIdentical($newTopics[$i]->getTopicSubject(),	"This is subject $count");
			// topicBody
			$this->assertNotNull($newTopics[$i]->getTopicBody());
			$this->assertIdentical($newTopics[$i]->getTopicBody(),		"This is comment $count");
		}

		// delete topic records from database
		foreach($newTopics as $i => $prop) {
			$newTopics[$i]->delete($this->mysqli);
		}

		// manual trash collection :D
		$newTopics = null;
	}
}