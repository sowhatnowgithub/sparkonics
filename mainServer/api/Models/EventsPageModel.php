<?php

namespace Sowhatnow\Api\Models;
class EventsPageModel
{
    protected $conn = null;
    protected $query;
    public function __construct()
    {
        try {
            $dbPath = __DIR__ . "/Database/eventsPageData.db";
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
    public function AddEvent($query): void
    {
        $this->query = $query;
        try {
            $this->conn->exec($this->query);
        } catch (\Exception $e) {
            echo "Exception at EventAdd: $e\n";
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
        } catch (\Exception $e) {
            //  echo "Exception at Event Fetch : $e\n";
        }
        return ["Error" => "Error in fetching"];
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
        } catch (\Exception $e) {
            // echo "Exception at EventsFethcAll : $e";
        }
        return ["Error" => "Failed to Fetch"];
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
			return ['Sucess' => "God"];
        } catch (\Exception $e) {
            //  echo "Exception at Event Fetch : $e\n";
        }
        return ["Error" => "Error in fetching"];
    }
	public function ModifyEvent($query){
		try {
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return ["Sucess" => "God"];
		} catch (\PDOException $e) {
			return ['Error' => "Fetch failed"];
		}
	}

}
