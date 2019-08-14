<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "ideas_comments".
 *
 * @property int $id_comments
 * @property string $comment
 * @property int $ideas_id
 * @property int $users_id
 *
 * @property Ideas $idea
 * @property User $user
 */
class Comments extends ActiveRecord
{
    /**
     * @return array
     */
    public function rules()
    {
        return[
            [['id_comments', 'ideas_id', 'users_id'], 'integer'],
            [['comment'], 'string'],
        ];
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{ideas_comments}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdea()
    {
        return $this->hasOne(Ideas::className(), ['id_ideas' => 'ideas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id_users' => 'users_id']);
    }

    /**
     * @return mixed
     */
    public function getAuthorsName()
    {
        return $this->user->users_name;
    }

    /**
     * @return mixed
     */
    public function getIdeasName()
    {
        return $this->idea->ideas_name;
    }
}
