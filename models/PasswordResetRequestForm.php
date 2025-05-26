<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class PasswordResetRequestForm extends ActiveRecord
{
     public $email;

    public function rules()
    {
        return [['email', 'required'], ['email', 'email']];
    }

    public function sendEmail()
    {
        $user = User::findOne(['email' => $this->email]);

        if (!$user) {
            return false;
        }

        $user->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
        if (!$user->save()) {
            return false;
        }

        return Yii::$app
            ->mailer
            ->compose('passwordResetToken', ['user' => $user])
            ->setFrom([Yii::$app->params['supportEmail'] => 'My App'])
            ->setTo($this->email)
            ->setSubject('Password reset for My App')
            ->send();
    }
}
