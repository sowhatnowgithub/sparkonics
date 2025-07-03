<?php

namespace Sowhatnow\Api\Models;
use Sowhatnow\Env;
class GalleryModel
{
    protected $conn;
    protected $query;
    public function __construct()
    {
        try {
            $dbPath = Env::BASE_PATH . "/api/Models/Database/gallery.db";
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
    public function AddGallery($query): array
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
    public function FetchGallery($galleryId): array
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM Gallery WHERE GalleryImageId = :galleryId"
            );
            $stmt->bindParam(":galleryId", $galleryId, \PDO::PARAM_INT);
            $stmt->execute();
            $gallery = $stmt->fetch();
            $stmt = null;
            if ($gallery != false) {
                return $gallery;
            } else {
                return ["Error" => "Failed to fetch"];
            }
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    public function FetchAllGallery(): array
    {
        try {
            $this->query = "SELECT * FROM Gallery";
            $stmt = $this->conn->prepare($this->query);
            $stmt->execute();
            $gallery = $stmt->fetchAll();
            $stmt = null;
            if ($gallery != false) {
                return $gallery;
            } else {
                return ["Error" => "Failed to fetch"];
            }
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    public function DeleteGallery($galleryId): array
    {
        try {
            $stmt = $this->conn->prepare(
                "DELETE FROM Gallery WHERE GalleryImageId = :galleryId"
            );
            $stmt->bindParam(":galleryId", $galleryId, \PDO::PARAM_INT);
            $stmt->execute();
            $stmt = null;
            return ["Success" => "god"];
        } catch (\PDOException $e) {
            return ["Error" => "Failed to fetch"];
        }
    }
    public function ModifyGallery($query)
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
