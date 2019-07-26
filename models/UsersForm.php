<?php


namespace app\models;

use yii\base\Model;

class UsersForm extends Model
{
    public $users_name;
    public $users_info;
    public $imageFile;

    public function rules()
    {
        return [
            [['users_name'], 'string'],
            [['users_info'], 'string'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jfif'],
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