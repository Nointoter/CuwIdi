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

    public function rules()
    {
        return[
            [['id_ideas'],'integer'],
            [['ideas_name'],'string'],
            [['info_short'],'string'],
            [['info_long'],'string'],
            [['creators_id'],'integer'],
            [['ideas_images'],'integer'],
        ];
    }

    public function getAuthorsName()
    {
        return $this->users_name;
    }
}