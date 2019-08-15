<?php

namespace app\models;

use yii\base\Model;

/**
 * Class AddCommentForm
 * @package app\models
 */
class AddCommentForm extends Model
{
    public $comment;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['comment'], 'string'],
        ];
    }
}
