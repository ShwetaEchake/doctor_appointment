<?php
namespace app\controllers;

use app\models\RegisterForm;
use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\Appointment;
use app\models\PasswordResetRequestForm;
use yii\web\IdentityInterface;
use yii\web\ForbiddenHttpException;

class UserController extends Controller
{
    public function actionLogin()
    {
      
        if (Yii::$app->user->isGuest) {
            return $this->render('login');
        }
        return $this->goHome();
    }

   public function actionRegister()
    {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->username = $model->username;
            $user->email = $model->email;
            $user->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->created_at = time();
            $user->updated_at = time();

            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Registration successful! You can now login.');
                return $this->redirect(['user/login']);
            } else {
                Yii::$app->session->setFlash('error', 'Error saving user.');
            }
        }

        return $this->render('register', ['model' => $model]);
    }

   public function actionForgotPassword()
    {
    $model = new PasswordResetRequestForm('forgotPassword');

    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        if ($model->sendEmail()) {
            Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
            return $this->goHome();
        } else {
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }
    }

    return $this->render('forgotPassword', [
        'model' => $model,
    ]);
    }

    public function actionResetPassword($token)
    {
    
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }


     
}