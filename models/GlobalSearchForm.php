<?php

namespace app\models;

use yii\base\Model;

/**
 * Class GlobalSearchForm
 * @package app\models
 */
class GlobalSearchForm extends Model
{
    public $target;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['target'], 'string'],
        ];
    }
}
