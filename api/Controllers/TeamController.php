<?php

namespace Sowhatnow\Api\Controllers;
use Sowhatnow\Api\Models\TeamModel;

class TeamController
{
    public $model;
    public $query;
    public function __construct()
    {
        $this->model = new TeamModel();
    }

    public function AddMem($settings): array
    {
        $this->query = "INSERT INTO Team (
            MemName,
            MemPosition, MemRole, MemStartTime, MemEndTime,MemImageUrl, MemLinkedin
        ) VALUES (";
        $escapedValues = [];
        foreach ($settings as $setting => $value) {
            $escapedValues[] = $this->model->cleanQuery($value);
        }
        $this->query .= implode(",", $escapedValues) . ")";
        return $this->model->AddMem($this->query);
    }
    public function FetchAllMems(): array
    {
        return $this->model->FetchAllMems();
    }
    public function FetchMem($memId): array
    {
        return $this->model->FetchMem($memId);
    }
    public function DeleteMem($memId): array
    {
        return $this->model->DeleteMem($memId);
    }
    public function ModifyMem($settings): array
    {
        $this->query = "UPDATE Team SET ";
        $escapedValues = [];
        $clause = null;
        foreach ($settings as $setting => $value) {
            if ($value != "") {
                if ($setting == "MemId") {
                    $clause = $this->model->cleanQuery($value);
                } else {
                    $setting = $this->model->cleanQuery($setting);
                    $value = $this->model->cleanQuery($value);
                    $escapedValues[] = "$setting = $value";
                }
            }
        }
        $this->query .= implode(",", $escapedValues) . " WHERE MemId = $clause";
        return $this->model->ModifyMem($this->query);
    }
}
