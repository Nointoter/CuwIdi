<?php

namespace app\models;

use yii\db\ActiveRecord;

class Ideas extends ActiveRecord
{
    /**
     * @return string название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName()
    {
        return '{{ideas}}';
    }

    public static function findIdentity($id_ideas)
    {
        return static::findOne($id_ideas);
    }

    public function getUsers()
    {
        return ($this->hasOne(User::className(), ['id_users' => 'creators_id']));
    }

    public function getideas_tags()
    {
        return ($this->hasMany(Tags::className(), ['ideas_id' => 'id_ideas']));
    }

    public function getAuthorsName()
    {
        return User::findIdentity($this->creators_id)->users_name;
    }

    public function getUser()
    {
        return User::findIdentity($this->creators_id);
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

    public function getComments()
    {
        return ($this->hasMany(Comments::className(), ['ideas_id' => 'id_ideas']));
    }

    public function searchWhere($target)
    {
        if ($target != null) {
            return Ideas::find()
                ->where(['id_ideas' => $target])
                ->orWhere(['ideas_name' => $target])
                ->orWhere(['info_short' => $target])
                ->orWhere(['creators_id' => $target])
                ->orWhere(['creations_day' => $target])
                ->orWhere(['creations_month' => $target])
                ->orWhere(['creations_year' => $target]);
        } else {
            return Ideas::find()->all();
        }
    }
}