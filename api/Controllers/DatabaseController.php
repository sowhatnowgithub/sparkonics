<?php
require_once "../../vendor/autoload.php";
use Sowhatnow\Api\Models\DatabaseManager;

$query = "CREATE TABLE Events (
	EventId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	EventName TEXT NOT NULL,
	EventDescription TEXT NOT NULL,
	EventStartTime TEXT NOT NULL,
	EventEndTime TEXT NOT NULL,
	EventDomains TEXT NOT NULL,
	EventBanner TEXT,
	EventStatus TEXT NOT NULL CHECK(EventStatus IN ('Active', 'Close', 'Register')),
	EventRegisterLink TEXT NOT NULL
)";
$dbPath =
    "/Users/pavan/Desktop/Current_projects/sparkonics/mainServer/api/Models/Database/eventsPageData.db";
$dataBase = new DatabaseManager($dbPath);

$dataBase->CreateAction($query, "CreateEventsTable");

$dataBase->getAllActions();

$dataBase->ExecuteAction("CreateEventsTable");
