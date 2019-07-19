<?php


namespace app\models;


use yii\db\ActiveRecord;

class Options extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%projects_options}}';
    }

    public function getProjects()
    {
        return $this->hasOne(Projects::className(), ['id' => 'projects_id']);
    }

    public function rules()
    {
        return[
            [['options_name', 'options_value'], 'required', 'message' => 'Заполните поле'],
            [['projects_id'],'integer'],
            [['options_id'], 'integer'],
            [['options_name'],'string'],
            [['options_value'],'string'],
        ];
    }
}