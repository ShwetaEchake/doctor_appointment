<?php
namespace app\controllers;

use app\models\Doctor;
use Yii;
use yii\base\Controller;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    public function actionDashboard()
    {
        $this->checkAccess('admin');
      
        return $this->render('dashboard');
    }

    protected function checkAccess($role)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->role !== $role) {
            throw new \yii\web\ForbiddenHttpException('Access denied.');
        }
    }

    public function actionDoctors()
{
    $this->checkAccess('admin');

    $doctors = Doctor::find()->all();

    return $this->render('doctors', [
        'doctors' => $doctors,
    ]);
}

public function actionUpdateDoctor($id)
{
    $this->checkAccess('admin');

    $doctor = Doctor::findOne($id);
    if (!$doctor) {
        throw new NotFoundHttpException("Doctor not found");
    }

    if ($doctor->load(Yii::$app->request->post()) && $doctor->save()) {
        return $this->redirect(['admin/doctors']);
    }

    return $this->render('update-doctor', [
        'doctor' => $doctor,
    ]);
}

public function actionDeleteDoctor($id)
{
    $this->checkAccess('admin');

    $doctor = Doctor::findOne($id);
    if ($doctor) {
        $doctor->delete();
    }

    return $this->redirect(['admin/doctors']);
}

}