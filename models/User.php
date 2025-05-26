<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use Yii;

class User extends ActiveRecord implements IdentityInterface
{
   

public function rules()
{
    return [
        [['username', 'email', 'password_hash', 'auth_key'], 'required'],
        [['username', 'email'], 'unique'],
        ['email', 'email'],
    ];
}

    public static function tableName()
    {
        return 'users'; 
    }

   
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
 
    }

    public function setPassword($password)
{
    $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
}

public function generateAuthKey()
{
    $this->auth_key = \Yii::$app->security->generateRandomString();
}

public static function findByPasswordResetToken($token)
{
    return static::find()
        ->where(['password_reset_token' => $token])
        ->andWhere(['>', 'token_expire', time()])
        ->one();
}


public function removePasswordResetToken()
{
    $this->password_reset_token = null;
}

}