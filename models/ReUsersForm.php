<?php

namespace app\models;

use yii\base\Model;

class ReUsersForm extends Model
{
    public $users_name;
    public $users_info;
    public $imageFile;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['users_name'], 'string'],
            [['users_info'], 'string'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jfif'],
        ];
    }

    /**
     * @return bool
     */
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
