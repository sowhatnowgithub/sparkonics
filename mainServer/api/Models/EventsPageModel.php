<?php

namespace Sowhatnow\Api\Models;
class EventsPageModel
{
    protected $conn = null;
    protected $query;
    public function __construct()
    {
        try {
            $this->conn = new \PDO("sqlite:Database/eventsPageData.db");
            $this->conn->setAttribute(
                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION
            );
            $this->conn->setAttribute(
                \PDO::ATTR_DEFAULT_FETCH_MODE,
                \PDO::FETCH_ASSOC
            );
            echo "Connection to the database is successfull \n";
        } catch (\PDOException $e) {
            echo "Exception PDO : " . $e . "\n";
            exit();
        }
    }
    // @param $values
    public function EventAdd($query): void
    {
        $this->query = $query;
        try {
            $this->conn->exec($this->query);
        } catch (\Exception $e) {
            echo "Exception at EventAdd: $e\n";
        }
    }
    //@param $eventId
    public function EventFetch($eventId): array
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM Events WHERE EventId = $eventId"
            );
            $event = $stmt->fetch();
            return $event;
        } catch (\Exception $e) {
            echo "Exception at Event Fetch : $e\n";
        }
    }
    public function EventsFetchAll(): array
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Events");
            $stmt->execute();
            $events = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $events;
        } catch (\Exception $e) {
            echo "Exception at EventsFethcAll : $e";
        }
    }
}
