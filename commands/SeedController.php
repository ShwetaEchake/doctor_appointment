<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use yii\db\Expression;
use app\models\User;
use app\models\Clinic;

class SeedController extends Controller
{
    public function actionAll()
    {
        $this->actionUsers();
        $this->actionClinics();
        $this->actionDoctorClinics();
        $this->actionDoctorHolidays();
    }

    public function actionUsers()
    {
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => 'admin123',
                'role' => 'admin',
            ],
            [
                'username' => 'drjohn',
                'email' => 'drjohn@example.com',
                'password' => 'doctor123',
                'role' => 'doctor',
            ],
            [
                'username' => 'drjane',
                'email' => 'drjane@example.com',
                'password' => 'doctor123',
                'role' => 'doctor',
            ],
        ];

        foreach ($users as $data) {
            if (User::find()->where(['username' => $data['username']])->exists()) {
                Console::output("⚠️ User {$data['username']} already exists.");
                continue;
            }

            $user = new User();
            $user->username = $data['username'];
            $user->email = $data['email'];
            $user->setPassword($data['password']);
            $user->generateAuthKey();
            $user->role = $data['role'];
            if ($user->save()) {
                Console::output("✔ Created {$data['role']}: {$data['username']}");
            } else {
                Console::output("❌ Failed to create {$data['username']}");
                print_r($user->getErrors());
            }
        }
    }

    public function actionClinics()
    {
        $clinics = [
            ['name' => 'City Health Center', 'address' => '123 Main Street'],
            ['name' => 'Sunrise Clinic', 'address' => '456 Park Avenue'],
        ];

        foreach ($clinics as $data) {
            if (!Clinic::find()->where(['name' => $data['name']])->exists()) {
                $clinic = new Clinic();
                $clinic->name = $data['name'];
                $clinic->address = $data['address'];
                $clinic->contact_number = '1234567890';
                $clinic->created_at = time();
                $clinic->updated_at = time();
                $clinic->save();
                Console::output("✔ Created clinic: {$data['name']}");
            }
        }
    }

    public function actionDoctorClinics()
    {
        $doctors = User::find()->where(['role' => 'doctor'])->all();
        $clinics = Clinic::find()->all();

        foreach ($doctors as $doctor) {
            foreach ($clinics as $clinic) {
                $exists = (new \yii\db\Query())
                    ->from('doctor_clinic')
                    ->where(['doctor_id' => $doctor->id, 'clinic_id' => $clinic->id])
                    ->exists();

                if (!$exists) {
                    Yii::$app->db->createCommand()->insert('doctor_clinic', [
                        'doctor_id' => $doctor->id,
                        'clinic_id' => $clinic->id,
                    ])->execute();
                    Console::output("✔ Linked Dr. {$doctor->username} to {$clinic->name}");
                }
            }
        }
    }

    public function actionDoctorHolidays()
    {
        $doctor = User::findOne(['username' => 'drjohn']);
        if ($doctor) {
            Yii::$app->db->createCommand()->insert('doctor_holidays', [
                'doctor_id' => $doctor->id,
                'holiday_date' => date('Y-m-d', strtotime('+3 days')),
            ])->execute();

            Console::output("✔ Added holiday for Dr. {$doctor->username}");
        }
    }
}
