<?php

namespace app\models;

use yii\base\Model;

class AddCommentForm extends Model
{
    public $comment;

    public function rules()
    {
        return [
            [['comment'], 'string'],
        ];
    }
}