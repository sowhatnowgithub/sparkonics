<?php

namespace Sowhatnow\Api\Models;
use Sowhatnow\Env;
class ProfsPageModel
{
    protected $conn;
    protected $query;
    public function __construct()
    {
        try {
            $dbPath = Env::BASE_PATH . "/api/Models/Database/profsPageData.db";
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
    public function AddProf($query, $settings): array
    {
        try {
            $stmt = $this->conn->prepare($query);

            // Bind securely using bindParam
            $stmt->bindParam(":ProfName", $settings["ProfName"]);
            $stmt->bindParam(":ProfPosition", $settings["ProfPosition"]);
            $stmt->bindParam(":ProfImage", $settings["ProfImage"]);
            $stmt->bindParam(":ProfContact", $settings["ProfContact"]);
            $stmt->bindParam(":ProfDomain", $settings["ProfDomain"]);
            $stmt->bindParam(
                ":ProfCurrentProjects",
                $settings["ProfCurrentProjects"],
            );

            $stmt->execute();
            return ["Success" => "God"];
        } catch (\PDOException $e) {
            return ["Error" => "Failed to insert: " . $e->getMessage()];
        }
    }

    public function FetchProf($profId): array
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM Profs WHERE ProfId = :profId",
            );
            $stmt->bindParam(":profId", $profId, \PDO::PARAM_INT);
            $stmt->execute();
            $prof = $stmt->fetch();
            $stmt = null;
            if ($prof != false) {
                return $prof;
            } else {
                return ["Error" => "Failed to fetch"];
            }
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    public function FetchAllProfs(): array
    {
        try {
            $this->query = "SELECT * FROM Profs";
            $stmt = $this->conn->prepare($this->query);
            $stmt->execute();
            $profs = $stmt->fetchAll();
            $stmt = null;
            if ($profs != false) {
                return $profs;
            } else {
                return ["Error" => "Failed to fetch"];
            }
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    public function DeleteProf($profId): array
    {
        try {
            $stmt = $this->conn->prepare(
                "DELETE FROM Profs WHERE ProfId = :profId",
            );
            $stmt->bindParam(":profId", $profId, \PDO::PARAM_INT);
            $stmt->execute();
            $stmt = null;
            return ["Success" => "god"];
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    public function ModifyProf($query, $params): array
    {
        try {
            $stmt = $this->conn->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            return ["Success" => "God"];
        } catch (\PDOException $e) {
            return ["Error" => "Update failed: " . $e->getMessage()];
        }
    }
}
