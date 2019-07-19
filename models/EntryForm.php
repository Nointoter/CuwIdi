<?php
/* @property string $name
* @property string $email*/

namespace app\models;

use Yii;
use yii\base\Model;

class EntryForm
{
    public $name;
    public $email;

    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 150],
            [['email'], 'string', 'max' => 150],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('app', 'Your name'),
            'email' => \Yii::t('app', 'Your email address'),
        ];
    }
}