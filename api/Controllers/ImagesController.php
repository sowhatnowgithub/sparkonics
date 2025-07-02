<?php

namespace Sowhatnow\Api\Controllers;
use Sowhatnow\Api\Models\ImagesModel;
use Sowhatnow\Env;
class ImagesController
{
    public $model;
    public $query;
    public function __construct()
    {
        $this->model = new ImagesModel();
    }

    public function AddImage($settings): array
    {
        $this->query = "	INSERT INTO Images (
            ImageId, ImageName, ImageUrlPath, ImageActualPath
		) VALUES (";
        $escapedValues = [];
        $type = explode("/", $settings["files"]["type"]);
        $imageId = trim($settings["post"]["ImageId"]);
        $imageActualName = "$imageId.{$type[1]}";
        $escapedValues[] = $imageId;
        $escapedValues[] = $this->model->cleanQuery($settings["files"]["name"]);
        $escapedValues[] = $this->model->cleanQuery("/api/images/$imageId");
        $escapedValues[] = $this->model->cleanQuery($imageActualName);
        $this->query = $this->query . implode(",", $escapedValues) . ")";
        $destinationPath = Env::API_IMAGES_PATH . "/" . "$imageId.{$type[1]}";
        return $this->model->AddImage(
            $this->query,
            $settings["files"]["tmp_name"],
            $destinationPath
        );
    }
    public function FetchAllImages(): array
    {
        return $this->model->FetchAllImages();
    }
    public function FetchImage($imageId): array
    {
        return $this->model->FetchImage($imageId);
    }
    public function DeleteImage($imageId): array
    {
        return $this->model->DeleteImage($imageId);
    }
    public function ModifyImage($settings): array
    {
        return [
            "Author" =>
                "Modify Image is not build delete the image and then add new one",
        ];
    }
}
