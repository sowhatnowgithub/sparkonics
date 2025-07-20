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
           GalleryName, GalleryDate, GalleryDescription,GalleryImageBanner, GalleryDomain,GalleryParticipants,GalleryImagesUrl,GalleryImageDescription
        ) VALUES (";
        $escapedValues = [];
        foreach ($settings as $setting => $value) {
            $escapedValues[] = $this->model->cleanQuery($value);
        }
        $this->query .= implode(",", $escapedValues) . ")";
        return $this->model->AddGallery($this->query);
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
        $this->query = "UPDATE Gallery SET ";
        $escapedValues = [];
        $clause = null;
        foreach ($settings as $setting => $value) {
            if ($value != "") {
                if ($setting == "GalleryId") {
                    $clause = $this->model->cleanQuery($value);
                } else {
                    $setting = $this->model->cleanQuery($setting);
                    $value = $this->model->cleanQuery($value);
                    $escapedValues[] = "$setting = $value";
                }
            }
        }
        $this->query .=
            implode(",", $escapedValues) . " WHERE GalleryId = $clause";
        return $this->model->ModifyGallery($this->query);
    }
}
