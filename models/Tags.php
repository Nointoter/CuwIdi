<?php

namespace app\models;

use yii\db\ActiveRecord;

class Tags extends ActiveRecord
{
    public static function tableName()
    {
        return '{{ideas_tags}}';
    }

    public function getIdeas()
    {
        return $this->hasOne(Ideas::className(), ['id_ideas' => 'ideas_id']);
    }
}