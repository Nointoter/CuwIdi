<?php


namespace app\models;


use yii\base\Model;

class ChangeIdeaNameForm extends Model
{
    public $name;

    public function rules(){
        return [
            [['name'], 'string'],
        ];
    }
}