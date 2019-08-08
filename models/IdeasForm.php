<?php

namespace app\models;

use yii\base\Model;

class IdeasForm extends Model
{
    public $imageFile;
    public $ideas_name;
    public $id_ideas;
    public $info_short;
    public $info_long;
    public $images_name;


    public function rules()
    {
        return [
            [['ideas_name', 'info_short'], 'required', 'message' => 'Заполните поле'],
            [['ideas_name'], 'string'],
            [['info_short'], 'string'],
            [['info_long'], 'string'],
            [['images_name'], 'string'],
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