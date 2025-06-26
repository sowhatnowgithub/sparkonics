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
    public function AddEvent($eventValues): void
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
        $this->model->AddEvent($this->query);
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
	public function DeleteEvent($eventId){
		return $this->model->DeleteEvent($eventId);
	}
	public function ModifyEvent($settings){
		$this->query  = "UPDATE EVENTS SET ";
		$clause;
		$escapedValues  =[];
		foreach($settings as $setting => $value) {
			$settingTemp = $this->model->cleanQuery($setting);
			$valueTemp = $this->model->cleanQuery($value);
			if($setting == "EventId") $clause = $valueTemp; 
			else 
			$escapedValues[] = "$settingTemp = $valueTemp";
		}
		$this->query.=implode(",",$escapedValues) . " WHERE EventId = $clause";
		return $this->model->ModifyEvent($this->query);
		
	}
    //@return void
    public function __destruct()
    {
        $this->model = null;
    }
}
