<?php


namespace app\models;


use yii\db\ActiveRecord;

class Ideas extends  ActiveRecord
{
    /**
     * @return string название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName()
    {
        return '{{ideas}}';
    }

    public function getIdeas_tags()
    {
        return ($this->hasMany(Tags::className(), ['ideas_id' => 'id_ideas']));
    }

    public function getAuthorsName()
    {
        return User::findIdentity($this->creators_id)->users_name;
    }

    public function getImages()
    {
        $images = Images::find()->where(['ideas_id' => $this->id_ideas])->all();
        return $images;
    }

    public function getTags()
    {
        $tags = Tags::find()->where(['ideas_id' => $this->id_ideas])->all();
        return $tags;
    }
}