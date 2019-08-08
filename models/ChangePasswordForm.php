<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $password;
    public $newPassword;
    public $reNewPassword;

    public function rules()
    {
        return [
            ['password', 'validatePassword'],
            ['newPassword', 'validateNewPassword'],
            ['reNewPassword', 'validateReNewPassword'],
            [['password', 'newPassword', 'reNewPassword'], 'required'],
            //[
            //  'password',
            //  'compare',
            //  'compareAttribute' => User::findIdentity(Yii::$app->user->id)->password,
            //  'message' => 'Введен неверный пароль'
            //],
            //[
            //  'reNewPassword',
            //  'compare',
            //  'compareAttribute' => 'newPassword',
            //  'message' => 'Пароли не совпадают'
            //],
        ];
    }

    public function attributeLabels()
    {
        return [
          'password' => 'Старый пароль',
          'newPassword' => 'Новый пароль',
          'reNewPassword' => 'Повторите ввод нового пароля',
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findIdentity(Yii::$app->user->id);
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный пароль');
            }
        }
    }

    public function validateNewPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->password == $this->newPassword) {
                $this->addError($attribute, 'Введите новый пароль');
            }
        }
    }

    public function validateReNewPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->newPassword != $this->reNewPassword) {
                $this->addError($attribute, 'Пароли не совпадают');
            }
        }
    }
}