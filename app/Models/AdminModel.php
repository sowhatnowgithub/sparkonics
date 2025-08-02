<?php

namespace Sowhatnow\App\Models;
use PDOException;
use Sowhatnow\Env;
class AdminModel
{
    public $dbConn;
    public function __construct()
    {
        $dbPath = Env::BASE_PATH . "/app/Models/Database/members.db";
        try {
            $this->dbConn = new \PDO("sqlite:$dbPath");
            $this->dbConn->setAttribute(
                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION
            );
            $this->dbConn->setAttribute(
                \PDO::ATTR_DEFAULT_FETCH_MODE,
                \PDO::FETCH_ASSOC
            );
        } catch (PDOException $e) {
            echo "Failed to connect to db";
        }
    }
    public function AuthenticateData()
    {
        $secretData = json_decode(
            file_get_contents(
                Env::BASE_PATH . "/app/Models/Database/credentials.json"
            ),
            1
        );
        try {
            $query =
                "SELECT MemId, MemMobile, MemWebMail, MemPassword, MemAccessGranted, MemPosition FROM Members";
            $stmt = $this->dbConn->prepare($query);
            $stmt->execute();
            $members = $stmt->fetchAll();
            $stmt = null;
            if ($members != false) {
                $combined = [];

                foreach ($members as $member) {
                    $combined[$member["MemMobile"]] = $member;
                }
                $combined[$secretData["MemMobile"]] = $secretData;
                return $combined;
            }
        } catch (PDOException $e) {
            return $secretData;
        }
        $data = [];
        $data[$secretData["MemMobile"]] = $secretData;
        $secretData = null;
        return $data;
    }

    public function AdminFormControl($section, $action)
    {
        $formData = json_decode(
            file_get_contents(
                Env::BASE_PATH . "/app/Models/Database/FormControlApi.json"
            ),
            1
        );
        return $formData[$section][$action];
    }
    public function FetchMember($memId)
    {
        try {
            $stmt = $this->dbConn->prepare(
                "SELECT * FROM Members WHERE MemId = :memId"
            );
            $stmt->bindParam(":memId", $memId, \PDO::PARAM_INT);
            $stmt->execute();
            $member = $stmt->fetchAll();
            $stmt = null;
            if ($member != false) {
                return $member;
            } else {
                return ["Error" => "failed to fetch"];
            }
        } catch (PDOException $e) {
            return ["Error Here" => "Failed to fetch"];
        }
    }
    public function FetchMembers()
    {
        try {
            $query = "SELECT * FROM Members";
            $stmt = $this->dbConn->prepare($query);
            $stmt->execute();
            $members = $stmt->fetchAll();
            $stmt = null;
            if ($members != false) {
                return $members;
            } else {
                return ["Error" => "failed to fetch"];
            }
        } catch (PDOException $e) {
            return false;
        }
    }
}
