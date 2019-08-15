<?php

namespace app\models;

use yii\base\Model;

/**
 * Class AddTagForm
 * @package app\models
 */
class AddTagForm extends Model
{
    public $tag;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['tag'], 'string'],
        ];
    }
}
