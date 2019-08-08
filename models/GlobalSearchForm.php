<?php

namespace app\models;

use yii\base\Model;

class GlobalSearchForm extends Model
{
    public $target;

    public function rules()
    {
        return [
            [['target'], 'string'],
        ];
    }
}