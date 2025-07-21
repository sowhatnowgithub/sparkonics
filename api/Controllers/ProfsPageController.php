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
            ProfName,
            ProfPosition,
            ProfImage,
            ProfContact,
            ProfDomain,
            ProfCurrentProjects
        ) VALUES (
            :ProfName,
            :ProfPosition,
            :ProfImage,
            :ProfContact,
            :ProfDomain,
            :ProfCurrentProjects
        )";

        return $this->model->AddProf($this->query, $settings);
    }

    public function FetchAllProfs(): array
    {
        return $this->model->FetchAllProfs();
    }
    public function FetchProf($profId): array
    {
        return $this->model->FetchProf($profId);
    }
    public function DeleteProf($profId): array
    {
        return $this->model->DeleteProf($profId);
    }
    public function ModifyProf($settings): array
    {
        $allowedColumns = [
            "ProfName",
            "ProfPosition",
            "ProfImage",
            "ProfContact",
            "ProfDomain",
            "ProfCurrentProjects",
        ];

        $setClauses = [];
        $params = [];

        foreach ($settings as $column => $value) {
            if ($column === "ProfId") {
                $profId = $value;
                continue;
            }

            if (in_array($column, $allowedColumns) && $value !== "") {
                $setClauses[] = "$column = :$column";
                $params[":$column"] = $value;
            }
        }

        if (empty($setClauses) || empty($profId)) {
            return [
                "Error" =>
                    "Invalid input: no columns to update or missing ProfId",
            ];
        }

        $this->query =
            "UPDATE Profs SET " .
            implode(", ", $setClauses) .
            " WHERE ProfId = :ProfId";
        $params[":ProfId"] = $profId;

        return $this->model->ModifyProf($this->query, $params);
    }
}
