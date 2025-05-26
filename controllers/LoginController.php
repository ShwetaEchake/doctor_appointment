<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\IdentityInterface;

class UserController extends Controller
{
    public function actionLogin()
{
   
    if (!Yii::$app->user->isGuest) {
        return $this->goHome();
    }

    
    $model = new \app\models\LoginForm();

  
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
       
        $role = Yii::$app->user->identity->role;

        if ($role === 'admin') {
            return $this->redirect(['admin/dashboard']);
        } elseif ($role === 'doctor') {
            return $this->redirect(['doctor/dashboard']);
        } else {
            return $this->goHome();
        }
    }

   
    return $this->render('login', [
        'model' => $model,
    ]);
}

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}