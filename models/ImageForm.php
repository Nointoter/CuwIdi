<?php


namespace app\models;


use yii\base\Model;
use yii\web\UploadedFile;

class ImageForm extends Model
{
    public $imageFile;
    public $users_name;
    public $id_users;
    public $users_info;
    public $images_name;


    public function rules()
    {
        return [
            [['users_name'], 'required'],
            [['imageFile'], 'file',  'skipOnEmpty' => true, 'extensions' => 'png, jpg, jfif'],
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