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

$jobTableQuery = "CREATE TABLE Jobs (
    JobId INTEGER PRIMARY KEY,
    RecipientEmail TEXT NOT NULL,
    SenderEmail TEXT NOT NULL,
    SenderEmailPassword TEXT NOT NULL,
    Subject TEXT NOT NULL,
    CC TEXT,
    Body TEXT NOT NULL,
    IsEventMail TEXT NOT NULL,
    StartDate TEXT NOT NULL,
    EndDate TEXT NOT NULL,
    IntervalDays INTEGER,
    NextScheduledAt TEXT,
    MaxOccurrences INTEGER,
    Active BOOLEAN DEFAULT 1
)";
$oppTableQuery = "CREATE TABLE Opp (
    OppId INTEGER PRIMARY KEY,
    OppName TEXT NOT NULL,
    OppDesc TEXT NOT NULL,
    OppLink TEXT NOT NULL,
    OppDomain TEXT NOT NULL,
    OppValidFrom TEXT NOT NULL,
    OppValidEnd TEXT NOT NULL,
    OppCreatedAt TEXT NOT NULL,
    OppEligibility TEXT NOT NULL,
    OppOrganiser TEXT NOT NULL,
    OppApplicationProcedure TEXT NOT NULL,
    OppLocation TEXT NOT NULL,
    OppType TEXT NOT NULL
)";
$clientsTableQuery = "CREATE TABLE Clients (
    ClientId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    ClientName TEXT NOT NULL,
    ClientWebMail TEXT NOT NULL,
    ClientMobile TEXT NOT NULL UNIQUE,
    ClientDegree TEXT NOT NULL,
    ClientRollNo TEXT NOT NULL,
    ClientPassword TEXT NOT NULL
)";
$quizTableQuery = "CREATE TABLE Quizes (
    QuizId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    QuizName TEXT NOT NULL,
    QuizDesc TEXT NOT NULL,
    QuizStarts TEXT NOT NULL,
    QuizDomain TEXT NOT NULL,
    QuizEnds TEXT NOT NULL,
    QuizQuestionScore INTEGER NOT NULL,
    QuizHighScore TEXT NOT NULL,
    QuizTopScorer TEXT NOT NULL
)";
$quizQuestionTableQuery = "CREATE TABLE QuizQuestions (
QuizId INTEGER NOT NULL,
QuizQuestionId INTEGER NOT NULL,
QuizQuestion TEXT NOT NULL,
QuizQuestionImage TEXT ,
QuizAnswer INTEGER NOT NULL,
QuizOptions TEXT NOT NULL,
FOREIGN KEY (QuizId) REFERENCES Quizes(QuizId),
PRIMARY KEY (QuizId, QuizQuestionId)
)";
$quizClientTableQuery = "CREATE TABLE QuizClient(
QuizId INTEGER  NOT NULL,
ClientId INTEGER  NOT NULL,
QuizQuestionOptions TEXT NOT NULL,
QuizTotalScore INTEGER NOT NULL,
PRIMARY KEY (QuizId, ClientId),
FOREIGN KEY (QuizId) REFERENCES Quizes(QuizId),
FOREIGN KEY (ClientId) REFERENCES Clients(ClientId)
)";
$dbPathEvent = Env::BASE_PATH . "/api/Models/Database/eventsPageData.db";
$dbPathProf = Env::BASE_PATH . "/api/Models/Database/profsPageData.db";
$dbPathImages = Env::BASE_PATH . "/api/Models/Database/imagesData.db";
$dbPathGallery = Env::BASE_PATH . "/api/Models/Database/gallery.db";
$dbPathTeam = Env::BASE_PATH . "/api/Models/Database/team.db";
$dbPathOpp = Env::BASE_PATH . "/api/Models/Database/opp.db";

$dbPathMem = Env::BASE_PATH . "/app/Models/Database/members.db";
$dbPathJob = Env::BASE_PATH . "/app/Models/Database/Job.db";
$dbPathClientsQuiz = Env::BASE_PATH . "/app/Models/Database/clients.db";


$dataBase = new DatabaseManager($dbPathClientsQuiz);

$dataBase->CreateAction($eventsTableQuery, "CreateEventsTable");
$dataBase->CreateAction($galleryTableQuery, "CreateGalleryTable");
$dataBase->CreateAction($teamTableQuery, "CreateTeamTable");
$dataBase->CreateAction($memberTableQuery, "CreateMemberTable");
$dataBase->CreateAction($profsTableQuery, "CreateProfsTable");
$dataBase->CreateAction($imagesTableQuery, "CreateImagesTable");
$dataBase->CreateAction($jobTableQuery, "CreateJobTable");
$dataBase->CreateAction($oppTableQuery, "CreateOppTable");

$dataBase->CreateAction($clientsTableQuery, "CreateClientTable");
$dataBase->CreateAction($quizTableQuery, "CreateQuizTable");
$dataBase->CreateAction($quizClientTableQuery, "CreateQuizClientTable");

$dataBase->CreateAction($quizQuestionTableQuery, "CreateQuizQuestionTable");

var_dump($dataBase->getAllActions());

//$dataBase->ExecuteAction("CreateProfsTable");
//$dataBase->ExecuteAction("CreateProfsTable");
//$dataBase->ExecuteAction("CreateImagesTable");
//$dataBase->ExecuteAction("CreateGalleryTable");
//$dataBase->ExecuteAction("CreateTeamTable");
//$dataBase->ExecuteAction("CreateMemberTable");
//$dataBase->ExecuteAction("CreateJobTable");
//$dataBase->ExecuteAction("CreateOppTable");
//$dataBase->ExecuteAction("CreateQuizTable");
//$dataBase->ExecuteAction("CreateClientTable");
//$dataBase->ExecuteAction("CreateQuizClientTable");

$dataBase->ExecuteAction("CreateQuizQuestionTable");

