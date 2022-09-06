<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model
{
    public $image;

    public function rules(): array
    {
        return [
            [["image"], 'required'],
            [["image"], 'file', 'extensions' => 'jpg,png,svg'],
        ];
    }

    public function uploadFile(UploadedFile $file, ?string $oldImage): string
    {
        $filename = $this->generateFileName($file->extension);

        $this->deleteOldImage($oldImage);

        $file->saveAs('uploads/' . $filename);

        return $filename;
    }

    private function generateFileName(string $extension): string
    {
        return strtolower(Yii::$app->security->generateRandomString(60) . '.' . $extension);
    }

    public function deleteOldImage(?string $oldImage): bool{

        if (file_exists("uploads/$oldImage") && !empty($oldImage)) {
            unlink("uploads/$oldImage");

            return true;
        }

        return false;
    }
}