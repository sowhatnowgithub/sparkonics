<?php
namespace Sowhatnow\App\Models;
use PDOException;
use Sowhatnow\Env;
class ClientModel extends AdminModel
{
    public $dbConn;
    public function __construct()
    {
        $dbPath = Env::BASE_PATH . "/app/Models/Database/clients.db";
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
    public function GetClients() {
   try {
            $this->query = "SELECT ClientId, ClientName, ClientWebMail,ClientMobile, ClientDegree, ClientRollNo, ClientPassword FROM Clients";
            $stmt = $this->dbConn->prepare($this->query);
            $stmt->execute();
            $clients = $stmt->fetchAll();
            $stmt = null;
            if ($clients != false) {
                return $clients;
            } else {
                return ["Error" => "Failed to fetcI"];
            }
        } catch (\PDOException $e) {
var_dump($e);
            return ["Error" => "Failed to fetch"];
        } 
    }
    public function RegisterClient($query)
    {
       try {
            $stmt = $this->dbConn->prepare($query);
            $stmt->execute();
            $stmt = null;
            return true;
        } catch (PDOException $e) {
            return $e;
        }
    }
    public function DeleteClient($clientId)
    {
        try {
            $query = "DELETE FROM Clients Where ClientId = :clientId";
            $stmt = $this->dbConn->prepare($query);
            $stmt->bindParam(":clientId", $clientId, \PDO::PARAM_INT);
            $stmt->execute();
            $stmt = null;

            return json_encode(["success" => "true"]);
        } catch (\PDOException $e) {
            return json_encode(["success" => "false"]);
        }
    }
}

