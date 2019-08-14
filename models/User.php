<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "users".
 *
 * @property int $id_users
 * @property string $users_name
 * @property string $username
 * @property string $password
 * @property string $users_info
 * @property string $users_image
 * @property string $users_role
 * @property int $status
 * @property string $authKey
 * @property string $accessToken
 *
 * @property Ideas[] $ideas
 * @property Comments[] $comments
 *
 * @package app\models
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public $authKey;
    public $accessToken;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{users}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdeas()
    {
        return ($this->hasMany(Ideas::className(), ['creators_id' => 'id_users']));
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return Url::to('@web/images/' . $this->users_image, true);
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return ('admin' == $this->users_role);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return (0 == $this->status);
    }

    /**
     * @return bool
     */
    public function isFreeze()
    {
        return (1 == $this->status);
    }

    /**
     * @return bool
     */
    public function isAdminFreeze()
    {
        return (2 == $this->status);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
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
