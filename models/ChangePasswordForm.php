<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Class ChangePasswordForm
 * @package app\models
 */
class ChangePasswordForm extends Model
{
    public $password;
    public $newPassword;
    public $reNewPassword;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['password', 'validatePassword'],
            ['newPassword', 'validateNewPassword'],
            ['reNewPassword', 'validateReNewPassword'],
            [['password', 'newPassword', 'reNewPassword'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
          'password' => 'Старый пароль',
          'newPassword' => 'Новый пароль',
          'reNewPassword' => 'Повторите ввод нового пароля',
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findIdentity(Yii::$app->user->id);
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный пароль');
            }
        }
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validateNewPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->password == $this->newPassword) {
                $this->addError($attribute, 'Введите новый пароль');
            }
        }
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validateReNewPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->newPassword != $this->reNewPassword) {
                $this->addError($attribute, 'Пароли не совпадают');
            }
        }
    }
}
