<?php

namespace Sowhatnow\Api\Controllers;

use Sowhatnow\Api\Models\EventsPageModel;
class EventsPageController
{
    public $model;
    public $query;
    // @param $uri
    // @param $method
    // @param $query
    public function __construct()
    {
        $this->model = new EventsPageModel();
    }
    //@param $eventValues
    public function EventAdd($eventValues): void
    {
        $this->query = "	INSERT INTO Events (
		    EventName,
		    EventDescription,
		    EventStartTime,
		    EventEndTime,
		    EventDomains,
		    EventBanner,
		    EventStatus,
		    EventRegisterLink
		) VALUES (";
        $escapedValues = [];
        foreach ($eventValues as $value) {
            $escapedValues[] = $this->model->cleanQuery($value);
        }
        $this->query = $this->query . implode(",", $escapedValues) . ")";
        $this->model->EventAdd($this->query);
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
    //@return void
    public function __destruct()
    {
        $this->model = null;
    }
}
