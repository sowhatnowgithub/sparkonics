<?php
require_once "../../vendor/autoload.php";
use Sowhatnow\Api\Models\DatabaseManager;

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
	ProfImage TEXT NOT NULL,
	ProfPosition TEXT NOT NULL,
	ProfContact TEXT NOT NULL,
	ProfDomain TEXT NOT NULL,
	ProfCurrentProjects TEXT NOT NULL
)";
$dbPathEvent =
    "/Users/pavan/Desktop/Current_projects/sparkonics/api/Models/Database/eventsPageData.db";
$dbPathProf =
    "/Users/pavan/Desktop/Current_projects/sparkonics/api/Models/Database/profsPageData.db";
$dataBase = new DatabaseManager($dbPathEvent);

$dataBase->CreateAction($eventsTableQuery, "CreateEventsTable");

//$dataBase->CreateAction($profsTableQuery, "CreateProfsTable");
$dataBase->getAllActions();

//$dataBase->ExecuteAction("CreateProfsTable");
$dataBase->ExecuteAction("CreateEventsTable");
