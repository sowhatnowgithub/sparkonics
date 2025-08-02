<?php

namespace Sowhatnow\Api\Controllers;

use Sowhatnow\Api\Models\EventsPageModel;
class EventsPageController
{
    public $model;
    public $query;

    public function __construct()
    {
        $this->model = new EventsPageModel();
    }
    //@param $eventValues
    public function AddEvent($eventValues): array
    {
        // Prepare the SQL with placeholders
        $this->query = "INSERT INTO Events (
            EventName,
            EventDescription,
            EventStartTime,
            EventEndTime,
            EventDomains,
            EventBanner,
            EventRegisterLink
        ) VALUES (
            :eventName,
            :eventDescription,
            :eventStartTime,
            :eventEndTime,
            :eventDomains,
            :eventBanner,
            :eventRegisterLink
        )";

        // Delegate to the model
        return $this->model->AddEvent($this->query, $eventValues);
    }

    //@param $eventId
    public function FetchEvent($eventId): array
    {
        return $this->model->FetchEvent($eventId);
    }
    public function FetchAllEvents(): array
    {
        return $this->model->FetchAllEvents();
    }
    public function DeleteEvent($eventId): array
    {
        return $this->model->DeleteEvent($eventId);
    }
    public function ModifyEvent($settings): array
    {
        // Allowed columns to update — whitelist keys for safety
        $allowedColumns = [
            "EventName",
            "EventDescription",
            "EventStartTime",
            "EventEndTime",
            "EventDomains",
            "EventBanner",
            "EventRegisterLink",
        ];

        $setClauses = [];
        $params = [];

        foreach ($settings as $column => $value) {
            if ($column === "EventId") {
                $eventId = $value;
                continue;
            }

            if (in_array($column, $allowedColumns) && $value !== "") {
                $setClauses[] = "$column = :$column";
                $params[":$column"] = $value;
            }
        }

        if (empty($setClauses) || empty($eventId)) {
            return [
                "Error" =>
                    "Invalid input: no columns to update or missing EventId",
            ];
        }

        $this->query =
            "UPDATE EVENTS SET " .
            implode(", ", $setClauses) .
            " WHERE EventId = :EventId";
        $params[":EventId"] = $eventId;

        return $this->model->ModifyEvent($this->query, $params);
    }

    //@return void
    public function __destruct()
    {
        $this->model = null;
    }
}
