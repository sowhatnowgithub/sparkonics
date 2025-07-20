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
    GalleryId INTEGER PRIMARY KEY,
    GalleryName TEXT NOT NULL,
    GalleryDate TEXT,
    GalleryDescription TEXT,
    GalleryImageBanner TEXT,
    GalleryDomain TEXT,
    GalleryParticipants TEXT,
    GalleryImagesUrl TEXT,
    GalleryImageDescription TEXT
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
    MemImageUrl TEXT,
    MemRole TEXT
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

$jobTableQuery = "CREATE TABLE Job (
    JobId INTEGER PRIMARY KEY,
    RecipientEmail TEXT NOT NULL,
    SenderEmail TEXT NOT NULL,
    Subject TEXT NOT NULL,
    CC TEXT,
    Body TEXT NOT NULL,
    StartDate TEXT NOT NULL,
    SheduleType TEXT NOT NULL
    EndDate TEXT NOT NULL,
    IntervalDays INTEGER,
    NextScheduledAt TEXT,
    MaxOccurrences INTEGER,
    Active BOOLEAN DEFAULT 1,
);";
$dbPathEvent = Env::BASE_PATH . "/api/Models/Database/eventsPageData.db";
$dbPathProf = Env::BASE_PATH . "/api/Models/Database/profsPageData.db";
$dbPathImages = Env::BASE_PATH . "/api/Models/Database/imagesData.db";
$dbPathGallery = Env::BASE_PATH . "/api/Models/Database/gallery.db";
$dbPathTeam = Env::BASE_PATH . "/api/Models/Database/team.db";
$dbPathMem = Env::BASE_PATH . "/app/Models/Database/members.db";
$dbPathJob = Env::BASE_PATH . "/app/Models/Database/Job.db";

$dataBase = new DatabaseManager($dbPathJob);

$dataBase->CreateAction($eventsTableQuery, "CreateEventsTable");
$dataBase->CreateAction($galleryTableQuery, "CreateGalleryTable");
$dataBase->CreateAction($teamTableQuery, "CreateTeamTable");
$dataBase->CreateAction($memberTableQuery, "CreateMemberTable");
$dataBase->CreateAction($profsTableQuery, "CreateProfsTable");
$dataBase->CreateAction($imagesTableQuery, "CreateImagesTable");
$dataBase->CreateAction($jobTableQuery, "CreateJobTable");

var_dump($dataBase->getAllActions());

//$dataBase->ExecuteAction("CreateProfsTable");
//$dataBase->ExecuteAction("CreateProfsTable");
//$dataBase->ExecuteAction("CreateImagesTable");
//$dataBase->ExecuteAction("CreateGalleryTable");
//$dataBase->ExecuteAction("CreateTeamTable");
//$dataBase->ExecuteAction("CreateMemberTable");
//$dataBase->ExecuteAction("CreateJobTable");
