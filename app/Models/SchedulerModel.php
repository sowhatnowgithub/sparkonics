<?php

namespace Sowhatnow\App\Models;
use Sowhatnow\Env;
class SchedulerModel
{
    protected $conn;
    protected $query;
    public function __construct()
    {
        try {
            $dbPath = Env::BASE_PATH . "/app/Models/Database/Job.db";
            $this->conn = new \PDO("sqlite:$dbPath");
            $this->conn->setAttribute(
                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION,
            );
            $this->conn->setAttribute(
                \PDO::ATTR_DEFAULT_FETCH_MODE,
                \PDO::FETCH_ASSOC,
            );
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
            exit();
        }
    }

    public function cleanQuery($query): string
    {
        return $this->conn->quote($query);
    }
    public function AddJob($query): array
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stmt = null;
            return ["Success" => "God"];
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }

    public function FetchAllJobs(): array
    {
        try {
            $this->query = "SELECT * FROM Jobs";
            $stmt = $this->conn->prepare($this->query);
            $stmt->execute();
            $jobs = $stmt->fetchAll();
            $stmt = null;
            if ($jobs != false) {
                return $jobs;
            } else {
                return ["Error" => "Failed to fetch"];
            }
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    public function DeleteJob($jobId): array
    {
        try {
            $stmt = $this->conn->prepare(
                "DELETE FROM Jobs WHERE JobId = :jobId",
            );
            $stmt->bindParam(":jobId", $jobId, \PDO::PARAM_INT);
            $stmt->execute();
            $stmt = null;
            return ["Success" => "god"];
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    public function ModifyJob($query)
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stmt = null;
            return ["Sucess" => "God"];
        } catch (\PDOException $e) {
            return ["Error" => "Fetch failed"];
        }
    }
}
