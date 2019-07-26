<?php


namespace app\models;


use yii\base\Model;

class AddTagForm extends Model
{
    public $tag;

    public function rules(){
        return [
            [['tag'], 'string'],
        ];
    }
}