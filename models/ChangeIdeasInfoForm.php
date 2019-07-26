<?php


namespace app\models;


use yii\base\Model;

class ChangeIdeasInfoForm extends Model
{

    public $short;
    public $long;

    public function rules(){
        return [
          [['short', 'long'], 'string'],
        ];
    }

}