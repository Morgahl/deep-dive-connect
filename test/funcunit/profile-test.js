// open a new window with the form under scrutiny
module("tabs", {
	setup: function() {
		F.open("../../profile-edit.php");
	}
});

// global variables for form values
var VALID_FIRSTNAME   = "Homer";
var VALID_MIDDLENAME  = "Jay";
var VALID_LASTNAME    = "Simpson";
var VALID_LOCATION    = "Springfield, NT";
var VALID_DESCRIPTION = "Leader of the Stone Cutters";

function testValidFields() {
	// fill in the form values
	F("#firstName").visible(function() {
		this.type(VALID_FIRSTNAME);
	});
	F("#middleName").visible(function() {
		this.type(VALID_MIDDLENAME);
	});
	F("#lastName").visible(function() {
		this.type(VALID_LASTNAME);
	});
	F("#location").visible(function() {
		this.type(VALID_LOCATION);
	});
	F("#description").visible(function() {
		this.type(VALID_DESCRIPTION);
	});
}

test("test valid fields", testValidFields);