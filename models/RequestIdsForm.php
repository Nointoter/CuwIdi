<?php


namespace app\models;

use yii\base\Model;

class RequestIdsForm extends Model
{
    public $name;
    public $info;
    public $options_name;
    public $options_value;

    public function rules()
    {
        return [
            [['name', 'info', 'options_name', 'options_value'], 'required'],
        ];
    }
}