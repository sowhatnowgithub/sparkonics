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
            MemPosition,
            MemRole,
            MemStartTime,
            MemEndTime,
            MemImageUrl,
            MemLinkedin
        ) VALUES (
            :MemName,
            :MemPosition,
            :MemRole,
            :MemStartTime,
            :MemEndTime,
            :MemImageUrl,
            :MemLinkedin
        )";

        return $this->model->AddMem($this->query, $settings);
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
        $allowedColumns = [
            "MemName",
            "MemPosition",
            "MemRole",
            "MemStartTime",
            "MemEndTime",
            "MemImageUrl",
            "MemLinkedin",
        ];

        $setClauses = [];
        $params = [];

        foreach ($settings as $column => $value) {
            if ($column === "MemId") {
                $memId = $value;
                continue;
            }

            if (in_array($column, $allowedColumns) && $value !== "") {
                $setClauses[] = "$column = :$column";
                $params[":$column"] = $value;
            }
        }

        if (empty($setClauses) || empty($memId)) {
            return [
                "Error" =>
                    "Invalid input: no columns to update or missing MemId",
            ];
        }

        $this->query =
            "UPDATE Team SET " .
            implode(", ", $setClauses) .
            " WHERE MemId = :MemId";
        $params[":MemId"] = $memId;

        return $this->model->ModifyMem($this->query, $params);
    }
}
