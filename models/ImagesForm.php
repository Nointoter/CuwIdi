<?php

namespace app\models;

use yii\base\Model;

/**
 * Class ImagesForm
 * @package app\models
 */
class ImagesForm extends Model
{
    public $imageFile;

    /**
     * @return array
     */
    public function rules()
    {
        return [
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
