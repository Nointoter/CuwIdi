<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "ideas_images".
 */
class Images extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{ideas_images}}';
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return Url::to('@web/images/' . $this->images_name, true);
    }
}
