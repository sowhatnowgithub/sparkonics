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
        ) VALUES (
            :OppName,
            :OppDesc,
            :OppLink,
            :OppDomain,
            :OppValidFrom,
            :OppValidEnd,
            :OppCreatedAt,
            :OppEligibility,
            :OppOrganiser,
            :OppApplicationProcedure,
            :OppLocation,
            :OppType
        )";

        return $this->model->AddOpp($this->query, $settings);
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
        $allowedColumns = [
            "OppName",
            "OppDesc",
            "OppLink",
            "OppDomain",
            "OppValidFrom",
            "OppValidEnd",
            "OppCreatedAt",
            "OppEligibility",
            "OppOrganiser",
            "OppApplicationProcedure",
            "OppLocation",
            "OppType",
        ];

        $setClauses = [];
        $params = [];

        foreach ($settings as $column => $value) {
            if ($column === "OppId") {
                $oppId = $value;
                continue;
            }

            if (in_array($column, $allowedColumns) && $value !== "") {
                $setClauses[] = "$column = :$column";
                $params[":$column"] = $value;
            }
        }

        if (empty($setClauses) || empty($oppId)) {
            return [
                "Error" =>
                    "Invalid input: no columns to update or missing OppId",
            ];
        }

        $this->query =
            "UPDATE Opp SET " .
            implode(", ", $setClauses) .
            " WHERE OppId = :OppId";
        $params[":OppId"] = $oppId;

        return $this->model->ModifyOpp($this->query, $params);
    }
}
