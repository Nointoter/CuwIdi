<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Url;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public $authKey;
    public $accessToken;

    public static function tableName()
    {
        return '{{users}}';
    }

    public function getIdeas()
    {
        return ($this->hasMany(Ideas::className(), ['creators_id' => 'id_users']));
    }

    public function getImageUrl()
    {
        return Url::to('@web/images/' . $this->users_image, true);
    }

    public function isActive()
    {
        return (0 == $this->status);
    }

    public function isFreeze()
    {
        return (1 == $this->status);
    }

    public function isAdminFreeze()
    {
        return (2 == $this->status);
    }


    public function getComments()
    {
        return ($this->hasMany(Comments::className(), ['users_id' => 'id_users']));
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id_users)
    {
        return static::findOne($id_users);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by users_name
     *
     * @param string $users_name
     * @return static|null
     */
    public static function findByUsersName($users_name)
    {
        return static::findOne(['users_name' => $users_name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id_users;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
