<?php

namespace Sowhatnow\Api\Controllers;
use Sowhatnow\Api\Models\OppModel;

class OppController
{
    public $model;
    public $query;
    public function __construct()
    {
        $this->model = new OppModel();
    }

    public function AddOpp($settings)
    {
        echo "reached here";

        $this->query = "INSERT INTO Opp (
            OppName,
            OppDesc,
            OppLink,
            OppDomain,
            OppValidFrom,
            OppValidEnd,
            OppCreatedAt,
            OppEligibility,
            OppOrganiser,
            OppApplicationProcedure,
            OppLocation,
            OppType
        ) VALUES (";

        $escapedValues = [];
        foreach ($settings as $value) {
            $escapedValues[] = $this->model->cleanQuery($value);
        }

        $this->query .= implode(",", $escapedValues) . ")";

        return $this->model->AddOpp($this->query);
    }
    public function FetchAllOpp(): array
    {
        return $this->model->FetchAllOpp();
    }
    public function FetchOpp($oppId): array
    {
        return $this->model->FetchOpp($oppId);
    }
    public function DeleteOpp($oppId): array
    {
        return $this->model->DeleteOpp($oppId);
    }
    public function ModifyOpp($settings): array
    {
        $this->query = "UPDATE Opp SET ";
        $escapedValues = [];
        $clause = null;
        foreach ($settings as $setting => $value) {
            if ($value != "") {
                if ($setting == "OppId") {
                    $clause = $this->model->cleanQuery($value);
                } else {
                    $setting = $this->model->cleanQuery($setting);
                    $value = $this->model->cleanQuery($value);
                    $escapedValues[] = "$setting = $value";
                }
            }
        }
        $this->query .= implode(",", $escapedValues) . " WHERE OppId = $clause";
        return $this->model->ModifyOpp($this->query);
    }
}
