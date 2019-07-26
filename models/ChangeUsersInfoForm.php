<?php


namespace app\models;


use yii\base\Model;

class ChangeUsersInfoForm extends Model
{
    public $info;

    public function rules(){
        return [
            [['info'], 'string'],
        ];
    }
}