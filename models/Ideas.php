<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "ideas".
 *
 * @property int $id_ideas
 * @property string $ideas_name
 * @property string $info_short
 * @property string $info_long
 * @property int $creators_id
 * @property string $creations_day
 * @property string $creations_month
 * @property string $creations_year
 * @property Tags $tags
 * @property Images $images
 * @property Comments $comments
 * @property User $user
 *
 * @package app\models
 */
class Ideas extends ActiveRecord
{
    /**
     * @return string название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName()
    {
        return '{{ideas}}';
    }

    /**
     * @param $id_ideas
     * @return Ideas|null
     */
    public static function findIdentity($id_ideas)
    {
        return static::findOne($id_ideas);
    }

    /**
     * @return mixed
     */
    public function getAuthorsName()
    {
        return $this->user->users_name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id_users' => 'creators_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Images::className(), ['ideas_id' => 'id_ideas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['ideas_id' => 'id_ideas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return ($this->hasMany(Comments::className(), ['ideas_id' => 'id_ideas']));
    }
}
