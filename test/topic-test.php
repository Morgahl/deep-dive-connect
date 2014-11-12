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

// require mysqli connection object
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

// the TopicTest is a container for all our tests
class TopicTest extends UnitTestCase {
	// variable to hold mysqli connection
	private $mysqli		= null;
	// variable to hold the test results from database
	private $users			= null;
	// variable to hold the test results from database
	private $profiles		= null;
	// variable to hold the test results from database
	private $topics		= null;

	// "globals" used for testing
	private $securityId		= 1;
	private $email				= "1@1.com";
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

		// create new user
		$this->users = new User(null, $this->email, null, null, null, $this->securityId, null);
		$this->users->insert($this->mysqli);

		// create new profile
		$this->profiles = new Profile(null, $this->users->__get("userId"), "Marc", "Hayes", null, "Albuquerque", "Tester profile", null, null);
		$this->profiles->insert($this->mysqli);
	}

	// tearDown() is a method that is run after each test
	// here, we use it to delete the test record and disconnect from mySQL
	public function tearDown() {
		if($this->topics !== null) {
			$this->topics->delete($this->mysqli);
			$this->topics = null;
		}

		// delete new profile
		$this->profiles->delete($this->mysqli);

		// delete new user
		$this->users->delete($this->mysqli);
	}

	// test topic creation and insertion
	public function testInsertNewTopic() {
		// first confirm that mySQL connection is OK
		$this->assertNotNull($this->mysqli);

		// second, create a topic to post to mySQL
		$this->topics = new Topic(null, $this->profiles->__get("profileId"), null, $this->topicSubject, $this->topicBody);

		// third, insert topic into mySQL
		$this->topics->insert($this->mysqli);

		// forth, rebuild class from mySQL data for the object
		$this->topics = $this->topics->getTopicByTopicId($this->mysqli, $this->topics->__get("topicId"));

		//finally, compare the fields
		// topicId
		$this->assertNotNull($this->topics->__get("topicId"));
		$this->assertTrue($this->topics->__get("topicId") > 0);
		// profileId
		$this->assertNotNull($this->topics->__get("profileId"));
		$this->assertTrue($this->topics->__get("profileId") > 0);
		$this->assertIdentical($this->topics->__get("profileId"),		$this->profiles->__get("profileId"));
		// topicDate
		$this->assertNotNull($this->topics->__get("topicDate"));
		// topicSubject
		$this->assertNotNull($this->topics->__get("topicSubject"));
		$this->assertIdentical($this->topics->__get("topicSubject"),	$this->topicSubject);
		// topicBody
		$this->assertNotNull($this->topics->__get("topicBody"));
		$this->assertIdentical($this->topics->__get("topicBody"),		$this->topicBody);
	}

	public function testUpdateTopic() {
		// value to set for topicSubject
		$newSubject = "This is a test change.";

		// first confirm that mySQL connection is OK
		$this->assertNotNull($this->mysqli);

		// second, create a topic to post to mySQL
		$this->topics = new Topic(null, $this->profiles->__get("profileId"), null, $this->topicSubject, $this->topicBody);

		// third, insert topic into mySQL
		$this->topics->insert($this->mysqli);

		// forth, rebuild class from mySQL data for the object
		$this->topics = $this->topics->getTopicByTopicId($this->mysqli, $this->topics->__get("topicId"));

		// fifth change a value then push update
		$this->topics->setTopicSubject($newSubject);
		$this->topics->update($this->mysqli);

		// forth, rebuild class from mySQL data for the object
		$this->topics = $this->topics->getTopicByTopicId($this->mysqli, $this->topics->__get("topicId"));

		//finally, compare the fields
		// topicId
		$this->assertNotNull($this->topics->__get("topicId"));
		$this->assertTrue($this->topics->__get("topicId") > 0);
		// profileId
		$this->assertNotNull($this->topics->__get("profileId"));
		$this->assertTrue($this->topics->__get("profileId") > 0);
		$this->assertIdentical($this->topics->__get("profileId"),		$this->profiles->__get("profileId"));
		// topicDate
		$this->assertNotNull($this->topics->__get("topicDate"));
		// topicSubject
		$this->assertNotNull($this->topics->__get("topicSubject"));
		$this->assertIdentical($this->topics->__get("topicSubject"),	$$newSubject);
		// topicBody
		$this->assertNotNull($this->topics->__get("topicBody"));
		$this->assertIdentical($this->topics->__get("topicBody"),		$this->topicBody);
	}

	public function testDeleteTopic() {
		//TODO: implement testDeleteTopic
	}

	public function testGetTopicByTopicId() {
		//TODO: implement testGetTopicByTopicId
	}

	public function testGetRecentTopics() {
		//TODO: implement testGetRecentTopics
	}
}