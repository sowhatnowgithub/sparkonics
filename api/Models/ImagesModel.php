<?php

namespace Sowhatnow\Api\Models;
use Sowhatnow\Env;
class ImagesModel
{
    protected $conn;
    protected $query;
    public function __construct()
    {
        try {
            $dbPath = Env::BASE_PATH . "/api/Models/Database/imagesData.db";
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
    public function AddImage(
        $query,
        $tmp_image_name,
        $destinationPath,
        $imageId,
        $imageName,
        $imageUrlPath,
        $imageActualPath,
    ): array {
        try {
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":ImageId", $imageId);
            $stmt->bindParam(":ImageName", $imageName);
            $stmt->bindParam(":ImageUrlPath", $imageUrlPath);
            $stmt->bindParam(":ImageActualPath", $imageActualPath);

            $stmt->execute();

            if (isset($tmp_image_name)) {
                if (move_uploaded_file($tmp_image_name, $destinationPath)) {
                    return ["Success" => "God"];
                } else {
                    return [
                        "Error" =>
                            "Failed to move uploaded file — please check the unique ID and permissions",
                    ];
                }
            }

            return ["Success" => "God"];
        } catch (\PDOException $e) {
            return [
                "Error" => "Failed to insert image record: " . $e->getMessage(),
            ];
        }
    }

    public function FetchImage($imageId): array
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT ImageActualPath FROM Images WHERE ImageId = :imageId",
            );
            $stmt->bindParam(":imageId", $imageId, \PDO::PARAM_INT);
            $stmt->execute();
            $imagePath = $stmt->fetch();

            $stmt = null;
            if ($imagePath != false) {
                $imagePath =
                    Env::API_IMAGES_PATH . "/" . $imagePath["ImageActualPath"];
                return ["ImagePath" => $imagePath];
            } else {
                return ["Error" => "Failed to fetch"];
            }
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    public function FetchAllImages(): array
    {
        try {
            $this->query =
                "SELECT ImageId, ImageName, ImageUrlPath FROM Images";
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
    public function DeleteImage($imageId): array
    {
        try {
            $this->query =
                "SELECT ImageActualPath FROM Images where ImageId = :imageId";
            $stmt = $this->conn->prepare($this->query);
            $stmt->bindParam(":imageId", $imageId, \PDO::PARAM_INT);
            $stmt->execute();
            $imagePath = $stmt->fetch();
            $imagePath =
                Env::API_IMAGES_PATH . "/" . $imagePath["ImageActualPath"];
            if (file_exists($imagePath)) {
                system("rm -f " . escapeshellarg($imagePath));
                $stmt = $this->conn->prepare(
                    "DELETE FROM Images WHERE ImageId = :imageId",
                );
                $stmt->bindParam(":imageId", $imageId, \PDO::PARAM_INT);
                $stmt->execute();
                $stmt = null;
                return ["Success" => "god"];
            } else {
                return ["Failed" => "Delete the image"];
            }
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    public function ModifyImage($query)
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
