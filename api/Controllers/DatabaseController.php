<?php

require_once "../../vendor/autoload.php";
use Sowhatnow\Api\Models\DatabaseManager;
use Sowhatnow\Env;
$eventsTableQuery = "CREATE TABLE Events (
	EventId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	EventName TEXT NOT NULL,
	EventDescription TEXT NOT NULL,
	EventStartTime TEXT NOT NULL,
	EventEndTime TEXT NOT NULL,
	EventDomains TEXT NOT NULL,
	EventBanner TEXT,
	EventRegisterLink TEXT NOT NULL
)";
$profsTableQuery = "CREATE TABLE Profs (
	ProfId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	ProfName TEXT NOT NULL,
	ProfPosition TEXT NOT NULL,
	ProfImage TEXT NOT NULL,
	ProfContact TEXT NOT NULL,
	ProfDomain TEXT NOT NULL,
	ProfCurrentProjects TEXT NOT NULL
)";
$imagesTableQuery = "CREATE TABLE Images (
	ImageId INTEGER PRIMARY KEY NOT NULL,
	ImageName TEXT NOT NULL,
	ImageUrlPath TEXT NOT NULL,
	ImageActualPath TEXT NOT NULL

)";

$galleryTableQuery = "CREATE TABLE Gallery (
    GalleryImageId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    GalleryImageUrlPath TEXT NOT NULL,
    GalleryImageDate TEXT NOT NULL,
    GalleryImageDescription TEXT NOT NULL
)";

$memberTableQuery = "CREATE TABLE Members (
    MemberId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    MemberName TEXT NOT NULL,
    MemberWebMail TEXT NOT NULL,
    MemberMobile TEXT NOT NULL,
    MemberDegree TEXT NOT NULL,
    MemberRollNo TEXT NOT NULL,
    MemberLinkedin TEXT NOT NULL,
    MemberPassword TEXT NOT NULL
)";
$teamTableQuery = "CREATE TABLE Team (
    TeamMemId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    MemberId INTEGER NOT NULL,
    TeamMemPosition TEXT NOT NULL CHECK (TeamMemPosition IN ('Cord', 'SubCord')),
    TeamMemJob TEXT NOT NULL,
    TeamMemTenure TEXT NOT NULL,
    TeamMemImage TEXT NOT NULL,
    FOREIGN KEY (MemberId) REFERENCES Members(MemberId) ON DELETE CASCADE,
    UNIQUE (MemberId)
)";
$$dbPathEvent = Env::BASE_PATH . "/api/Models/Database/eventsPageData.db";
$dbPathProf = Env::BASE_PATH . "/api/Models/Database/profsPageData.db";
$dbPathImages = Env::BASE_PATH . "/api/Models/Database/imagesData.db";
$dbPathGallery = Env::BASE_PATH . "/api/Models/Database/gallery.db";
$dbPathTeam = Env::BASE_PATH . "/api/Models/Database/team.db";

$dataBase = new DatabaseManager($dbPathTeam);

$dataBase->CreateAction($eventsTableQuery, "CreateEventsTable");
$dataBase->CreateAction($galleryTableQuery, "CreateGalleryTable");
$dataBase->CreateAction($teamTableQuery, "CreateTeamTable");
$dataBase->CreateAction($memberTableQuery, "CreateMemberTable");
$dataBase->CreateAction($profsTableQuery, "CreateProfsTable");
$dataBase->CreateAction($imagesTableQuery, "CreateImagesTable");

var_dump($dataBase->getAllActions());

//$dataBase->ExecuteAction("CreateProfsTable");
//$dataBase->ExecuteAction("CreateProfsTable");
//$dataBase->ExecuteAction("CreateImagesTable");
//$dataBase->ExecuteAction("CreateGalleryTable");
//$dataBase->ExecuteAction("CreateTeamTable");
//$dataBase->ExecuteAction("CreateMemberTable");
