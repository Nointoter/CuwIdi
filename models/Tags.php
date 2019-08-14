<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "ideas_tags".
 *
 * @property int $id_tags
 * @property string $tag
 * @property int $ideas_id
 *
 * @property Ideas $ideas
 */
class Tags extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{ideas_tags}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdeas()
    {
        return $this->hasOne(Ideas::className(), ['id_ideas' => 'ideas_id']);
    }
}
