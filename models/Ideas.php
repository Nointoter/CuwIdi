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

    public function getAuthorsName()
    {
        return $this->users_name;
    }
}