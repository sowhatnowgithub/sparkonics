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
$dbPathEvent = Env::BASE_PATH . "/api/Models/Database/eventsPageData.db";
$dbPathProf = Env::BASE_PATH . "/api/Models/Database/profsPageData.db";
$dbPathImages = Env::BASE_PATH . "/api/Models/Database/imagesData.db";

$dataBase = new DatabaseManager($dbPathImages);

$dataBase->CreateAction($eventsTableQuery, "CreateEventsTable");

$dataBase->CreateAction($profsTableQuery, "CreateProfsTable");
$dataBase->CreateAction($imagesTableQuery, "CreateImagesTable");

var_dump($dataBase->getAllActions());

//$dataBase->ExecuteAction("CreateProfsTable");
//$dataBase->ExecuteAction("CreateProfsTable");

$dataBase->ExecuteAction("CreateImagesTable");
