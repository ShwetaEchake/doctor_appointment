<?php

namespace app\models;

use Yii;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;

class PasswordResetRequestForm extends ActiveRecord
{
      public $password;
    private $_user;

    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [['password', 'required'], ['password', 'string', 'min' => 6]];
    }

    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        return $user->save(false);
    }
}