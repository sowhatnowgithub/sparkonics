<?php

namespace Sowhatnow\Api\Models;
use Sowhatnow\Env;
class TeamModel
{
    protected $conn;
    protected $query;
    public function __construct()
    {
        try {
            $dbPath = Env::BASE_PATH . "/api/Models/Database/teamData.db";
            $this->conn = new \PDO("sqlite:$dbPath");
            $this->conn->setAttribute(
                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION
            );
            $this->conn->setAttribute(
                \PDO::ATTR_DEFAULT_FETCH_MODE,
                \PDO::FETCH_ASSOC
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
    public function AddMem($query): array
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
    public function FetchMem($memId): array
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM Team WHERE MemId = :memId"
            );
            $stmt->bindParam(":memId", $memId, \PDO::PARAM_INT);
            $stmt->execute();
            $mem = $stmt->fetch();
            $stmt = null;
            if ($mem != false) {
                return $mem;
            } else {
                return ["Error" => "Failed to fetch"];
            }
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    public function FetchAllMems(): array
    {
        try {
            $this->query = "SELECT * FROM Team";
            $stmt = $this->conn->prepare($this->query);
            $stmt->execute();
            $mems = $stmt->fetchAll();
            $stmt = null;
            if ($mems != false) {
                return $mems;
            } else {
                return ["Error" => "Failed to fetch"];
            }
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    public function DeleteMem($memId): array
    {
        try {
            $stmt = $this->conn->prepare(
                "DELETE FROM Team WHERE MemId = :memId"
            );
            $stmt->bindParam(":memId", $memId, \PDO::PARAM_INT);
            $stmt->execute();
            $stmt = null;
            return ["Success" => "god"];
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    public function ModifyMem($query)
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
