<?php


namespace app\models;


use yii\base\Model;
use yii\web\UploadedFile;

class ImageForm extends Model
{
    public $imageFile;
    public $name;
    public $id;
    public $info;
    public $images_name;


    public function rules()
    {
        return [
            [['imageFile'], 'file',  'skipOnEmpty' => false, 'extensions' => 'png, jpg, jfif'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('images/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}