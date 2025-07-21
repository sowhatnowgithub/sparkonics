<?php

namespace Sowhatnow\Api\Models;
use Sowhatnow\Env;
class OppModel
{
    protected $conn;
    protected $query;
    public function __construct()
    {
        try {
            $dbPath = Env::BASE_PATH . "/api/Models/Database/opp.db";
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
    public function AddOpp($query): array
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stmt = null;
            return ["Success" => "God"];
        } catch (\PDOException $e) {
            return ["Error" => "Failed to add"];
        }
    }
    public function FetchOpp($oppId): array
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM Opp WHERE OppId = :oppId",
            );
            $stmt->bindParam(":oppId", $oppId, \PDO::PARAM_INT);
            $stmt->execute();
            $opp = $stmt->fetch();
            $stmt = null;
            if ($opp != false) {
                return $opp;
            } else {
                return ["Error" => "Failed to fetch"];
            }
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch s"];
        }
    }
    public function FetchAllOpp(): array
    {
        try {
            $this->query = "SELECT * FROM Opp";
            $stmt = $this->conn->prepare($this->query);
            $stmt->execute();
            $opps = $stmt->fetchAll();
            $stmt = null;
            if ($opps != false) {
                return $opps;
            } else {
                return ["Error" => "Failed to fetch a"];
            }
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    public function DeleteOpp($oppId): array
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM
    Opp WHERE OppId = :oppId");
            $stmt->bindParam(":oppId", $oppId, \PDO::PARAM_INT);
            $stmt->execute();
            $stmt = null;
            return ["Success" => "god"];
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    public function ModifyOpp($query)
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $stmt = null;
            return ["Sucess" => "God"];
        } catch (\PDOException $e) {
            return [
                "Error" => "Fetch
    failed",
            ];
        }
    }
}
