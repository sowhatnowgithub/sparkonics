<?php

namespace Sowhatnow\Api\Models;

class DatabaseManager
{
    protected $conn = null;
    public $actions = [];
    public $query;
    //@param $databasePath expects the path to the sqlite database
    public function __construct($databasePath)
    {
        try {
            $this->conn = new \PDO("sqlite:Database/$databasePath");
            $this->conn->setAttribute(
                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION
            );
            $this->conn->setAttribute(
                \PDO::ATTR_DEFAULT_FETCH_MODE,
                \PDO::FETCH_ASSOC
            );
            echo "DataBaseManger is working ..";
        } catch (\PDOException $e) {
            echo "PDOException : $e \n";
        }
    }

    //public function CreateEntireDB() {}
    // @param $actionName expects the action Name
    public function ExecuteAction($actionName): void
    {
        try {
            $this->conn->exec($this->actions[$actionName]);
        } catch (\Exception $e) {
            echo "Error in code Execution : $e\n";
        }
    }
    public function getAllActions(): array
    {
        return $this->actions;
    }
    //@param $query this should take the sqlite query that should be executed
    public function CustomQuery($query): void
    {
        $this->query = $query;

        try {
            $this->conn->exec($this->query);
            echo "Query executed \n";
        } catch (\Exception $e) {
            echo "Query not sanitised properly \n Error : $e \n";
        }
    }
    //@param $query
    // @param $actionName
    public function CreateAction($query, $actionName): void
    {
        $this->actions[$actionName] = $query;
    }
    // @return void
    public function __destruct()
    {
        $this->conn = null;
    }
}
/*
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


$dataBase = new \DataBaseManager("eventsPageData.db");

$dataBase->CreateAction($query, "CreateEventsTable");

$dataBase->getAllActions();

$dataBase->ExecuteAction("CreateEventsTable");
*/
