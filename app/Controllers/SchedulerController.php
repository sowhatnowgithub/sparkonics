<?php

namespace Sowhatnow\App\Controllers;
use Sowhatnow\App\Models\SchedulerModel;
use Sowhatnow\Env;
use Sowhatnow\App\Controllers\AdminController;
class SchedulerController extends AdminController
{
    public $model;
    public $query;

    public function __construct()
    {
        parent::__construct();
        $this->model = new SchedulerModel();
    }
    public function SchedulerPage()
    {
        $this->sessionStatusCord("Using the scheduler");
        $data = $this->FetchAllJobs();
        require Env::BASE_PATH . "/app/Views/Scheduler.php";
    }
    /**
     * @param mixed $settings
     */
    public function AddJob($settings): array
    {
        $allowedColumns = [
            "RecipientEmail",
            "SenderEmail",
            "SenderEmailPassword",
            "Subject",
            "CC",
            "Body",
            "IsEventMail",
            "StartDate",
            "EndDate",
            "IntervalDays",
            "NextScheduledAt",
            "MaxOccurrences",
            "Active",
        ];

        $columns = [];
        $placeholders = [];
        $params = [];

        foreach ($allowedColumns as $column) {
            if (isset($settings[$column])) {
                $columns[] = $column;
                $placeholders[] = ":" . $column;
                $params[":" . $column] = $settings[$column];
            }
        }

        if (empty($columns)) {
            return ["Error" => "No valid data to insert"];
        }

        $this->query =
            "INSERT INTO Jobs (" .
            implode(", ", $columns) .
            ") VALUES (" .
            implode(", ", $placeholders) .
            ")";

        return $this->model->AddJob($this->query, $params);
    }

    public function FetchAllJobs(): array
    {
        return $this->model->FetchAllJobs();
    }

    /**
     * @param mixed $jobId
     */
    public function DeleteJob($jobId): array
    {
        return $this->model->DeleteJob($jobId);
    }
    /**
     * @param mixed $settings
     */
    public function ModifyJob($settings): array
    {
        $allowedColumns = [
            "RecipientEmail",
            "SenderEmail",
            "SenderEmailPassword",
            "Subject",
            "CC",
            "Body",
            "IsEventMail",
            "StartDate",
            "EndDate",
            "IntervalDays",
            "NextScheduledAt",
            "MaxOccurrences",
            "Active",
        ];

        $setClauses = [];
        $params = [];

        foreach ($settings as $column => $value) {
            if ($column === "JobId") {
                $jobId = $value;
                continue;
            }

            if (in_array($column, $allowedColumns) && $value !== "") {
                $setClauses[] = "$column = :$column";
                $params[":$column"] = $value;
            }
        }

        if (empty($setClauses) || empty($jobId)) {
            return ["Error" => "Missing data to update or JobId"];
        }

        $this->query =
            "UPDATE Jobs SET " .
            implode(", ", $setClauses) .
            " WHERE JobId = :JobId";
        $params[":JobId"] = $jobId;

        return $this->model->ModifyJob($this->query, $params);
    }
}
