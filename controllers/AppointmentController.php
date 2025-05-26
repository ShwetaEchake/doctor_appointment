<?php

namespace app\controllers;

use app\models\Appointment;
    use app\models\AppointmentSearch;
use app\models\Clinic;
use app\models\Doctor;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;

class AppointmentController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new AppointmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListAppointments()
    {
        $appointments = Appointment::find()->all();
        return $this->render('list_appointments', ['appointments' => $appointments]);
    }

    private function calculateCharge($appointmentTime)
    {
        $datetime = new \DateTime($appointmentTime);
        $hourMin = (int)$datetime->format('Hi');

        $weekday = (int)$datetime->format('N'); 

        if ($weekday >= 1 && $weekday <= 5 && $hourMin >= 1000 && $hourMin <= 1900) {
            return 100;
        }

        return 300;
    }

    public function actionCalculateCharge()
    {
        $request = Yii::$app->request->getBodyParams();
        $appointmentTime = $request['appointment_time'] ?? null;

        if ($appointmentTime) {
            $charge = $this->calculateCharge($appointmentTime);
            return $this->asJson(['success' => true, 'charge' => $charge]);
        }

        return $this->asJson(['success' => false, 'message' => 'Invalid appointment time.']);
    }

    public function actionBook()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $doctor_id = $request->post('doctor_id');
            $clinic_id = $request->post('clinic_id');
            $appointment_time = $request->post('appointment_time');

            
            $doctor = Doctor::findOne($doctor_id);
            $clinic = Clinic::findOne($clinic_id);

            if (!$doctor || !$clinic) {
                Yii::$app->session->setFlash('error', 'Invalid doctor or clinic.');
                return $this->redirect(['appointment/book']);
            }

            
            $doctorClinicIds = array_map(fn($c) => $c->id, $doctor->clinics);
            if (!in_array($clinic_id, $doctorClinicIds)) {
                Yii::$app->session->setFlash('error', 'Selected clinic does not belong to the selected doctor.');
                return $this->redirect(['appointment/book']);
            }

            $appointment = new Appointment();
            $appointment->doctor_id = $doctor_id;
            $appointment->clinic_id = $clinic_id;
            $appointment->appointment_time = $appointment_time;
            $appointment->user_id = Yii::$app->user->id;

        
            $appointment->charge = $this->calculateCharge($appointment_time);

            if ($appointment->save()) {
                
                $this->sendAppointmentConfirmationEmail($appointment);
                Yii::$app->session->setFlash('success', 'Appointment booked successfully.');
                return $this->redirect(['appointment/index']);
            } else {
            
                Yii::$app->session->setFlash('error', 'Failed to book appointment: ' . json_encode($appointment->getErrors()));
            }
        }

    
        return $this->render('book', [
            'doctors' => Doctor::find()->all(),
            'clinics' => Clinic::find()->all(),
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

  
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

 
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Appointment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested appointment does not exist.');
    }
}
