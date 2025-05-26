<?php

namespace app\controllers;

use app\models\Appointment;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegisterForm;
use app\models\User;

class SiteController extends Controller
{
   
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

   
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

   
    public function actionIndex()
    {
        return $this->render('index');
    }

    
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) 
        {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login())
         {
            $role = Yii::$app->user->identity->role;

            if ($role === 'doctor') {
                return $this->redirect(['doctor/dashboard']);
            } elseif ($role === 'admin') {
                return $this->redirect(['admin/dashboard']);
            } elseif ($role === 'user') {
                return $this->redirect(['site/dashboard']);
            }

            return $this->goHome(); // Fallback
        }


        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

   public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $user = $model->register()) {
            Yii::$app->user->login($user);
            return $this->goHome();
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }
    
   
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

   
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    
    public function actionAbout()
    {
        return $this->render('about');
    }

     public function actionDashboard()
    {
       
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $userId = Yii::$app->user->id;
        $user = User::findOne($userId);

       
        $appointments = Appointment::find()->where(['user_id' => $userId])->all();

        return $this->render('dashboard', [
            'user' => $user,
            'appointments' => $appointments,
        ]);
    }
}
