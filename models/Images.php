<?php


namespace app\models;


use yii\db\ActiveRecord;
use yii\helpers\Url;

class Images extends ActiveRecord
{
    public static function tableName()
    {
        return '{{ideas_images}}';
    }

    public function getImageUrl()
    {
        return Url::to('@web/images/' . $this->images_name, true);
    }
}