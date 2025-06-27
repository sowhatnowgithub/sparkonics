<?php

namespace Sowhatnow\Api\Controllers;
use Sowhatnow\Api\Models\ProfsPageModel;

class ProfsPageController
{
    public $model;
    public $query;
    public function __construct()
    {
        $this->model = new ProfsPageModel();
    }
    public function AddProf($settings): array
    {
        $this->query = "INSERT INTO Profs (
            ProfName, ProfImage,
            ProfPosition, ProfContact, ProfDomain,
            ProfCurrentProjects
        ) VALUES (";
        $escapedValues = [];
        foreach ($settings as $setting => $value) {
            $escapedValues[] = $this->model->cleanQuery($value);
        }
        $this->query .= implode(",", $escapedValues) . ")";
        return $this->model->AddProf($this->query);
    }
    public function FetchAllProfs(): array
    {
        return $this->model->FetchAllProfs();
    }
    public function DeleteProf($profId): array
    {
        return $this->model->DeleteProf($profId);
    }
    public function ModifyProf($settings): array
    {
        $this->query = "UPDATE Profs SET ";
        $escapedValues = [];
        $clause = null;
        foreach ($settings as $setting => $value) {
            if ($setting == "ProfId") {
                $clause = $this->model->cleanQuote($value);
            } else {
                $setting = $this->model->cleanQuote($setting);
                $value = $this->model->cleanQuote($value);
                $escapedValues[] = "$setting = $value";
            }
        }
        $this->query .=
            implode(",", $escapedValues) . " WHERE ProfId = $clause";
        $this->model->ModifyProf($this->query);
    }
}
