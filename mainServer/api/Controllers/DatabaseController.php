<?php
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

$dataBase = new DatabaseManager("eventsPageData.db");

$dataBase->CreateAction($query, "CreateEventsTable");

$dataBase->getAllActions();

$dataBase->ExecuteAction("CreateEventsTable");
