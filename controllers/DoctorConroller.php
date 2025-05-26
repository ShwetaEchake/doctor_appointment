<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Doctor;
use app\models\Appointment;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DoctorController extends Controller
{
   
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

   
    protected function checkAccess($role)
    {
        $actualRole = Yii::$app->user->isGuest ? 'guest' : Yii::$app->user->identity->role;
        Yii::info("CheckAccess called — expected: $role, actual: $actualRole", 'application');

        if (Yii::$app->user->isGuest || Yii::$app->user->identity->role !== $role) {
            throw new \yii\web\ForbiddenHttpException('Access denied.');
        }
    }

    
    public function actionDashboard()
    {
        $this->checkAccess('doctor');
        return $this->render('dashboard');
    }

   
    public function actionCalendar($doctor_id)
    {
        $doctor = Doctor::findOne($doctor_id);
        if (!$doctor) {
            throw new NotFoundHttpException("Doctor not found.");
        }

        $schedule = $doctor->getSchedules()->all();
        $appointments = Appointment::find()->where(['doctor_id' => $doctor_id])->all();

        return $this->render('calendar', [
            'doctor' => $doctor,
            'schedule' => $schedule,
            'appointments' => $appointments,
        ]);
    }

   
    public function actionBookAppointment($doctor_id)
    {
        $doctor = Doctor::findOne($doctor_id);
        if (!$doctor) {
            throw new NotFoundHttpException("Doctor not found.");
        }

        if (Yii::$app->request->isPost) {
            $appointmentTime = Yii::$app->request->post('appointment_time');
            $userId = Yii::$app->user->id;

            $existingAppointment = Appointment::find()->where([
                'doctor_id' => $doctor_id,
                'appointment_time' => $appointmentTime
            ])->exists();

            if ($existingAppointment) {
                Yii::$app->session->setFlash('error', 'Appointment time is already booked.');
            } else {
                $appointment = new Appointment();
                $appointment->doctor_id = $doctor_id;
                $appointment->user_id = $userId;
                $appointment->appointment_time = $appointmentTime;
                if ($appointment->save()) {
                    Yii::$app->session->setFlash('success', 'Appointment booked successfully.');
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to book appointment.');
                }
            }

            return $this->redirect(['calendar', 'doctor_id' => $doctor_id]);
        }

        return $this->render('book-appointment', ['doctor' => $doctor]);
    }

    
    public function actionViewAppointments()
    {
        $appointments = Appointment::find()->where(['user_id' => Yii::$app->user->id])->all();
        return $this->render('view-appointments', ['appointments' => $appointments]);
    }

   
    public function actionSchedule()
    {
        return $this->render('schedule');
    }
}