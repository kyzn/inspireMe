CREATE DATABASE IF NOT EXISTS inspireMe
	CHARACTER SET utf8 collate utf8_turkish_ci;
USE inspireMe;

CREATE TABLE IF NOT EXISTS Users(
UserID bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
Email varchar(255) NOT NULL,
UserName varchar(32),
FullName varchar(128),
Occupation text,
RegDate datetime NOT NULL,
BirthYear int NOT NULL,
Password varchar(32),
UNIQUE(Email)
)CHARACTER SET utf8 collate utf8_turkish_ci;

CREATE TABLE IF NOT EXISTS Comms(
CommID bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
CommName varchar(128) NOT NULL,
ShortDesc varchar(1024),
Privacy enum('public','private') NOT NULL,
CreatedOn datetime NOT NULL
)CHARACTER SET utf8 collate utf8_turkish_ci;

CREATE TABLE IF NOT EXISTS UsersInComms(
UserID bigint NOT NULL,
CommID bigint NOT NULL,
JoinedOn datetime NOT NULL,
ValidUntil datetime default NULL,
Role enum('admin','user') NOT NULL,
PRIMARY KEY(UserID,CommID),
FOREIGN KEY(UserID)
	REFERENCES Users(UserID)
	ON UPDATE CASCADE
	ON DELETE CASCADE,
FOREIGN KEY(CommID)
	REFERENCES Comms(CommID)
	ON UPDATE CASCADE
	ON DELETE CASCADE
)CHARACTER SET utf8 collate utf8_turkish_ci;

CREATE TABLE IF NOT EXISTS Posts(
PostID bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
PostText text NOT NULL,
PostTitle text NOT NULL,
UserID bigint NOT NULL,
CommID bigint NOT NULL,
CreatedOn datetime NOT NULL,
IsDeleted BOOL NOT NULL DEFAULT FALSE,
PrevPostID bigint,
NextPostID bigint,
FOREIGN KEY(UserID)
	REFERENCES Users(UserID)
	ON UPDATE CASCADE
	ON DELETE CASCADE,
FOREIGN KEY(CommID)
	REFERENCES Comms(CommID)
	ON UPDATE CASCADE
	ON DELETE CASCADE,
FOREIGN KEY(PrevPostID)
	REFERENCES Posts(PostID)
	ON UPDATE CASCADE
	ON DELETE CASCADE,
FOREIGN KEY(NextPostID)
	REFERENCES Posts(PostID)
	ON UPDATE CASCADE
	ON DELETE CASCADE
)CHARACTER SET utf8 collate utf8_turkish_ci;

CREATE TABLE IF NOT EXISTS Comments(
CommentID bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
CommentText text NOT NULL,
UserID bigint NOT NULL,
PostID bigint NOT NULL,
CreatedOn datetime NOT NULL,
FOREIGN KEY(UserID)
	REFERENCES Users(UserID)
	ON UPDATE CASCADE
	ON DELETE CASCADE,
FOREIGN KEY(PostID)
	REFERENCES Posts(PostID)
	ON UPDATE CASCADE
	ON DELETE CASCADE
)CHARACTER SET utf8 collate utf8_turkish_ci;

CREATE TABLE IF NOT EXISTS UpvotesForPosts(
UserID bigint NOT NULL,
PostID bigint NOT NULL,
CreatedOn datetime NOT NULL,
IsDeleted BOOL NOT NULL DEFAULT FALSE,
PRIMARY KEY(UserID,PostID),
FOREIGN KEY(UserID)
	REFERENCES Users(UserID)
	ON UPDATE CASCADE
	ON DELETE CASCADE,
FOREIGN KEY(PostID)
	REFERENCES Posts(PostID)
	ON UPDATE CASCADE
	ON DELETE CASCADE
)CHARACTER SET utf8 collate utf8_turkish_ci;

CREATE TABLE IF NOT EXISTS UpvotesForComments(
UserID bigint NOT NULL,
CommentID bigint NOT NULL,
CreatedOn datetime NOT NULL,
IsDeleted BOOL NOT NULL DEFAULT FALSE,
PRIMARY KEY(UserID,CommentID),
FOREIGN KEY(UserID)
	REFERENCES Users(UserID)
	ON UPDATE CASCADE
	ON DELETE CASCADE,
FOREIGN KEY(CommentID)
	REFERENCES Comments(CommentID)
	ON UPDATE CASCADE
	ON DELETE CASCADE
)CHARACTER SET utf8 collate utf8_turkish_ci;

CREATE TABLE IF NOT EXISTS TagsForPosts(
TagID bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
PostID bigint NOT NULL,
CreatedOn datetime NOT NULL,
Tag TEXT NOT NULL,
IsDeleted BOOL NOT NULL DEFAULT FALSE,
FOREIGN KEY(PostID)
	REFERENCES Posts(PostID)
	ON UPDATE CASCADE
	ON DELETE CASCADE
)CHARACTER SET utf8 collate utf8_turkish_ci;

CREATE TABLE IF NOT EXISTS TagsForComms(
TagID bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
CommID bigint NOT NULL,
CreatedOn datetime NOT NULL,
Tag TEXT NOT NULL,
IsDeleted BOOL NOT NULL DEFAULT FALSE,
FOREIGN KEY(CommID)
	REFERENCES Comms(CommID)
	ON UPDATE CASCADE
	ON DELETE CASCADE
)CHARACTER SET utf8 collate utf8_turkish_ci;

CREATE TABLE IF NOT EXISTS Requests(
UserID bigint NOT NULL,
CommID bigint NOT NULL,
SentOn datetime NOT NULL, 
PRIMARY KEY(UserID,CommID),
FOREIGN KEY(UserID)
	REFERENCES Users(UserID)
	ON UPDATE CASCADE
	ON DELETE CASCADE,
FOREIGN KEY(CommID)
	REFERENCES Comms(CommID)
	ON UPDATE CASCADE
	ON DELETE CASCADE
)CHARACTER SET utf8 collate utf8_turkish_ci;