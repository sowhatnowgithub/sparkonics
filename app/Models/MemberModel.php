<?php

namespace Sowhatnow\App\Models;
use PDOException;
use Sowhatnow\Env;
class MemberModel extends AdminModel
{
    public $dbConn;
    public function __construct()
    {
        $dbPath = Env::BASE_PATH . "/app/Models/Database/members.db";
        try {
            $this->dbConn = new \PDO("sqlite:$dbPath");
            $this->dbConn->setAttribute(
                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION,
            );
            $this->dbConn->setAttribute(
                \PDO::ATTR_DEFAULT_FETCH_MODE,
                \PDO::FETCH_ASSOC,
            );
        } catch (PDOException $e) {
            echo "Failed to connect to db";
        }
    }
    public function RegisterMember($query)
    {
        try {
            $stmt = $this->dbConn->prepare($query);
            $stmt->execute();
            $stmt = null;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function UpdateMemberRole($data)
    {
        try {
            $stmt = $this->dbConn->prepare(
                "UPDATE Members SET MemRole = :memRole WHERE MemId = :memId ",
            );
            $stmt->bindParam(":memId", $data["MemId"], \PDO::PARAM_INT);
            $stmt->bindParam(":memRole", $data["MemRole"]);
            $stmt->execute();
            $stmt = null;
            return json_encode(["success" => "true"]);
        } catch (\PDOException $e) {
            return json_encode(["success" => "false"]);
        }
    }

    public function DeleteMember($memId)
    {
        try {
            $query = "DELETE FROM Members Where MemId = :memId";
            $stmt = $this->dbConn->prepare($query);
            $stmt->bindParam(":memId", $memId, \PDO::PARAM_INT);
            $stmt->execute();
            $stmt = null;

            return json_encode(["success" => "true"]);
        } catch (\PDOException $e) {
            return json_encode(["success" => "false"]);
        }
    }
    public function UpdateMemberImage($data)
    {
        try {
            $stmt = $this->dbConn->prepare(
                "UPDATE Members SET MemImageUrl = :imageUrl WHERE MemId = :memId ",
            );
            $stmt->bindParam(":memId", $data["MemId"], \PDO::PARAM_INT);
            $stmt->bindParam(":imageUrl", $data["MemImageUrl"]);
            $stmt->execute();
            $stmt = null;
            return json_encode(["success" => "true"]);
        } catch (\PDOException $e) {
            return json_encode(["success" => "false"]);
        }
    }
    public function GrantAccessMemeber($data)
    {
        try {
            $stmt = $this->dbConn->prepare(
                "UPDATE Members SET MemAccessGranted = :memAccess WHERE MemId = :memId ",
            );
            $stmt->bindParam(":memId", $data["MemId"], \PDO::PARAM_INT);
            $stmt->bindParam(
                ":memAccess",
                $data["MemAccessGranted"],
                \PDO::PARAM_INT,
            );
            $stmt->execute();
            $stmt = null;
            return json_encode(["success" => "true"]);
        } catch (\PDOException $e) {
            return json_encode($e);
        }
    }
}
