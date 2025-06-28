<?php

namespace Sowhatnow\Api\Models;
use Sowhatnow\Env;

class EventsPageModel
{
    protected $conn = null;
    protected $query;
    public function __construct()
    {
        try {
            $dbPath = Env::BASE_PATH . "/api/Models/Database/eventsPageData.db";
            $this->conn = new \PDO("sqlite:$dbPath");
            $this->conn->setAttribute(
                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION
            );
            $this->conn->setAttribute(
                \PDO::ATTR_DEFAULT_FETCH_MODE,
                \PDO::FETCH_ASSOC
            );
            //echo "Connection to the database is successfull \n";
        } catch (\PDOException $e) {
            // echo "Exception PDO : " . $e . "\n";
            return ["Error" => "Failed to connect"];
            exit();
        }
    }
    //@param $query
    // @return string

    public function cleanQuery($query)
    {
        return $this->conn->quote($query);
    }
    // @param $query
    public function AddEvent($query): array
    {
        $this->query = $query;
        try {
            $stmt = $this->conn->prepare($this->query);
            $stmt->execute();
            $stmt = null;
            return ["Success" => "God"];
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    //@param $eventId
    //@return array
    public function FetchEvent($eventId): array
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM Events WHERE EventId = :eventId"
            );
            $stmt->bindParam(":eventId", $eventId, \PDO::PARAM_INT);
            $stmt->execute();
            $event = $stmt->fetch(\PDO::FETCH_ASSOC);
            $stmt = null;
            if ($event != false) {
                return $event;
            } else {
                return ["Error" => "Error in fetching"];
            }
        } catch (\PDOException $e) {
            return ["Error" => "Error in fetching"];
            //  echo "Exception at Event Fetch : $e\n";
        }
    }
    //@return array
    public function FetchAllEvents(): array
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Events");
            $stmt->execute();
            $events = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $stmt = null;
            if ($events != false) {
                return $events;
            } else {
                return ["Error" => "Failed to fetch"];
            }
        } catch (\PDOException $e) {
            // echo "Exception at EventsFethcAll : $e";
            return ["Error" => "Failed to fetch"];
        }
    }
    public function DeleteEvent($eventId): array
    {
        try {
            $stmt = $this->conn->prepare(
                "DELETE FROM Events WHERE EventId = :eventId"
            );
            $stmt->bindParam(":eventId", $eventId, \PDO::PARAM_INT);
            $stmt->execute();
            $stmt = null;
            return ["Sucess" => "God"];
        } catch (\PDOException $e) {
            return ["Error" => "Error in fetching"];
            //  echo "Exception at Event Fetch : $e\n";
        }
    }
    public function ModifyEvent($query)
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stmt = null;
            return ["Sucess" => "God"];
        } catch (\PDOException $e) {
            return ["Error" => "Fetch failed"];
        }
    }
}
