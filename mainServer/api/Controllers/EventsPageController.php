<?php

namespace Sowhatnow\Api\Controllers;

use Sowhatnow\Api\Models\EventsPageModel;
class EventsPageHandling
{
    public $model;
    public $query;
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
            $escapedValues[] = $this->conn->quote($value);
        }
        $this->query = $this->query . implode(",", $escapedValues) . ")";
        $this->model->EventAdd($this->query);
    }
    public function FetchEvent() {}
}
