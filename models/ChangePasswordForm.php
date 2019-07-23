<?php


namespace app\models;

use yii\base\Model;
use Yii;


class ChangePasswordForm extends Model
{
    public $password;
    public $newPassword;
    public $reNewPassword;

    public function rules()
    {
        return [
            ['password', 'validatePassword'],
            ['newPassword', 'required'],
            ['reNewPassword', 'required'],
            ['reNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Пароли не совпадают'],
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
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }
}