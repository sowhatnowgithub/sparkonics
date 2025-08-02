<?php

namespace Sowhatnow\Api\Controllers;
use Sowhatnow\Api\Models\GalleryModel;

class GalleryController
{
    public $model;
    public $query;
    public function __construct()
    {
        $this->model = new GalleryModel();
    }

    public function AddGallery($settings): array
    {
        $this->query = "INSERT INTO Gallery (
            GalleryName,
            GalleryDate,
            GalleryDescription,
            GalleryImageBanner,
            GalleryDomain,
            GalleryParticipants,
            GalleryImagesUrl,
            GalleryImageDescription
        ) VALUES (
            :GalleryName,
            :GalleryDate,
            :GalleryDescription,
            :GalleryImageBanner,
            :GalleryDomain,
            :GalleryParticipants,
            :GalleryImagesUrl,
            :GalleryImageDescription
        )";

        return $this->model->AddGallery($this->query, $settings);
    }

    public function FetchAllGallery(): array
    {
        return $this->model->FetchAllGallery();
    }
    public function FetchGallery($galleryId): array
    {
        return $this->model->FetchGallery($galleryId);
    }
    public function DeleteGallery($galleryId): array
    {
        return $this->model->DeleteGallery($galleryId);
    }
    public function ModifyGallery($settings): array
    {
        $allowedColumns = [
            "GalleryName",
            "GalleryDate",
            "GalleryDescription",
            "GalleryImageBanner",
            "GalleryDomain",
            "GalleryParticipants",
            "GalleryImagesUrl",
            "GalleryImageDescription",
        ];

        $setClauses = [];
        $params = [];

        foreach ($settings as $column => $value) {
            if ($column === "GalleryId") {
                $galleryId = $value;
                continue;
            }

            if (in_array($column, $allowedColumns) && $value !== "") {
                $setClauses[] = "$column = :$column";
                $params[":$column"] = $value;
            }
        }

        if (empty($setClauses) || empty($galleryId)) {
            return [
                "Error" =>
                    "Invalid input: no columns to update or missing GalleryId",
            ];
        }

        $this->query =
            "UPDATE Gallery SET " .
            implode(", ", $setClauses) .
            " WHERE GalleryId = :GalleryId";
        $params[":GalleryId"] = $galleryId;

        return $this->model->ModifyGallery($this->query, $params);
    }
}
