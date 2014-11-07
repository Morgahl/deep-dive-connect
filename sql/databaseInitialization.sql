-- Database initialization for Deep Dive Connect
--  by Marc Hayes

-- We start with Table tear downs via DROP TABLE IF EXISTS, these are dropped in FK > PK order

DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS topic;
DROP TABLE IF EXISTS profileCohort;
DROP TABLE IF EXISTS cohort;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS loginSource;
DROP TABLE IF EXISTS security;

-- We then build the tables to use in PK > FK order taking care to ensure
-- PK FK Unique and Link table indices are being accounted for

-- security table
CREATE TABLE security (
	securityId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	description VARCHAR(256) NOT NULL,
	createTopic TINYINT NOT NULL,
	canEditOther TINYINT NOT NULL,
	canPromote TINYINT NOT NULL,
	siteAdmin TINYINT NOT NULL,
	PRIMARY KEY (securityId),
	UNIQUE (description)
);

-- loginSource table
CREATE TABLE loginSource (
	loginSourceId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	sourceName VARCHAR(256) NOT NULL,
	PRIMARY KEY (loginSourceId),
	UNIQUE (sourceName)
);

-- user table
CREATE TABLE user (
	userId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	email VARCHAR(256) NOT NULL,
	passwordHash VARCHAR(128),
	salt VARCHAR(64),
	authKey VARCHAR(32),
	securityId INT UNSIGNED NOT NULL,
	loginSourceId INT UNSIGNED,
	PRIMARY KEY (userId),
	UNIQUE (email),
	INDEX (securityId),
	INDEX (loginSourceId),
	FOREIGN KEY (securityId) REFERENCES security(securityId),
	FOREIGN KEY (loginSourceId) REFERENCES loginSource(loginSourceId)
);

-- profile table
CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	userId INT UNSIGNED NOT NULL,
	firstName VARCHAR(64) NOT NULL,
	lastName VARCHAR(64) NOT NULL,
	middleName VARCHAR(64),
	location VARCHAR(256),
	description VARCHAR(4096),
	profilePicFileName VARCHAR(256),
	profilePicFileType VARCHAR(16),
	PRIMARY KEY (profileId),
	UNIQUE (userId),
	FOREIGN KEY (userId) REFERENCES user(userId)
);

-- cohort table
CREATE TABLE cohort (
	cohortId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	startDate DATETIME NOT NULL,
	endDate DATETIME NOT NULL,
	location VARCHAR(256),
	description VARCHAR(1024),
	PRIMARY KEY (cohortId)
);

-- profileCohort table
CREATE TABLE profileCohort (
	profileCohortId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileId INT UNSIGNED NOT NULL,
	cohortId INT UNSIGNED NOT NULL,
	role VARCHAR(256) NOT NULL,
	PRIMARY KEY (profileCohortId),
	INDEX (profileId),
	INDEX (cohortId),
	INDEX (profileId, cohortId),
	FOREIGN KEY (profileId) REFERENCES profile(profileId),
	FOREIGN KEY (cohortId) REFERENCES cohort(cohortId)
);

-- topic table
CREATE TABLE topic (
	topicId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileId INT UNSIGNED NOT NULL,
	topicDate DATETIME NOT NULL,
	topicSubject VARCHAR(256) NOT NULL,
	topicBody VARCHAR(4096) NOT NULL,
	PRIMARY KEY (topicId),
	INDEX (profileId),
	INDEX (topicDate),
	FOREIGN KEY (profileId) REFERENCES profile(profileId)
);

-- comment
CREATE TABLE comment (
	commentId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	topicId INT UNSIGNED NOT NULL,
	profileId INT UNSIGNED NOT NULL,
	commentDate DATETIME NOT NULL,
	commentSubject VARCHAR(256) NOT NULL,
	commentBody VARCHAR(1024) NOT NULL,
	PRIMARY KEY (commentId),
	INDEX (topicId),
	INDEX (profileId),
	INDEX (commentDate),
	INDEX (topicId, profileId),
	FOREIGN KEY (profileId) REFERENCES profile(profileId),
	FOREIGN KEY (topicId) REFERENCES topic(topicId)
);

-- Finally we add some seed data to relevant tables

-- insert for security table
INSERT INTO security (description, createTopic, canEditOther, canPromote, siteAdmin)
	VALUES ('Newb', 0, 0, 0, 0),
		('User', 1, 0, 0, 0),
		('Moderator', 1, 1, 0, 0),
		('Admin', 1, 1, 1, 1);

-- insert for loginSource
INSERT INTO loginSource (sourceName)
	VALUES ('Facebook'),
		('Twitter'),
		('LinkedIn'),
		('GooglePlus');