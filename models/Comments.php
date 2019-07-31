<?php


namespace app\models;


use yii\db\ActiveRecord;

class Comments extends ActiveRecord
{
    public static function tableName()
    {
        return '{{ideas_comments}}';
    }

    public function getIdeas()
    {
        return $this->hasOne(Ideas::className(), ['id_ideas' => 'ideas_id']);
    }

    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id_users' => 'users_id']);
    }

    public function getAuthorsName()
    {
        return User::findIdentity($this->users_id)->users_name;
    }
}