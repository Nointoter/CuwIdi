<?php

namespace app\models;

use yii\base\Model;

/**
 * Class SingUpForm
 * @package app\models
 */
class SingUpForm extends Model
{

    public $users_name;
    public $username;
    public $password;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['users_name', 'username', 'password'], 'required', 'message' => 'Заполните поле'],
            ['username', 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'users_name' => 'Имя',
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }
}
