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
    MemId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    MemName TEXT NOT NULL,
    MemWebMail TEXT NOT NULL,
    MemMobile TEXT NOT NULL,
    MemDegree TEXT NOT NULL,
    MemRollNo TEXT NOT NULL,
    MemPassword TEXT NOT NULL,
    MemPosition TEXT NOT NULL,
    MemAccessGranted BOOLEAN,
    MemImageUrl TEXT
)";
$teamTableQuery = "CREATE TABLE Team (
    MemId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    MemName TEXT NOT NULL,
    MemPosition TEXT NOT NULL CHECK (MemPosition IN ('Coordinator', 'SubCoordinator')),
    MemRole TEXT NOT NULL,
    MemStartTime TEXT NOT NULL,
    MemEndTime TEXT NOT NULL,
    MemImageUrl TEXT NOT NULL,
    MemLinkedin TEXT NOT NULL
)";
$$dbPathEvent = Env::BASE_PATH . "/api/Models/Database/eventsPageData.db";
$dbPathProf = Env::BASE_PATH . "/api/Models/Database/profsPageData.db";
$dbPathImages = Env::BASE_PATH . "/api/Models/Database/imagesData.db";
$dbPathGallery = Env::BASE_PATH . "/api/Models/Database/gallery.db";
$dbPathMem = Env::BASE_PATH . "/app/Models/Database/members.db";
$dbPathTeam = Env::BASE_PATH . "/api/Models/Database/team.db";

$dataBase = new DatabaseManager($dbPathMem);

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
$dataBase->ExecuteAction("CreateMemberTable");
