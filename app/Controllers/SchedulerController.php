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
        $this->query = "INSERT INTO Jobs (
            RecipientEmail, SenderEmail, SenderEmailPassword,
            Subject, CC, Body, IsEventMail,
            StartDate, EndDate, IntervalDays,
            NextScheduledAt, MaxOccurrences, Active
        ) VALUES (";

        $escapedValues = [];
        foreach ($settings as $key => $value) {
            $escapedValues[] = $this->model->cleanQuery($value);
        }

        $this->query .= implode(",", $escapedValues) . ")";
        return $this->model->AddJob($this->query);
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
        $this->query = "UPDATE Jobs SET ";
        $escapedValues = [];
        $clause = null;

        foreach ($settings as $setting => $value) {
            if ($value != "") {
                if ($setting == "JobId") {
                    $clause = $this->model->cleanQuery($value);
                } else {
                    $setting = $this->model->cleanQuery($setting);
                    $value = $this->model->cleanQuery($value);
                    $escapedValues[] = "$setting = $value";
                }
            }
        }

        $this->query .= implode(",", $escapedValues) . " WHERE JobId = $clause";
        return $this->model->ModifyJob($this->query);
    }
}
