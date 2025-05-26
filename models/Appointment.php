<?php

namespace app\models;

use yii\db\ActiveRecord;

class Appointment extends ActiveRecord
{
    public static function tableName()
    {
        return 'appointments';
    }

    public $date; 
    public function rules()
    {
        return [
            [['user_id', 'doctor_id', 'appointment_time'], 'required'],
            [['user_id', 'doctor_id'], 'integer'],
            [['appointment_time'], 'safe'],
        ];
    }

    public function getDoctor()
    {
        return $this->hasOne(Doctor::class, ['id' => 'doctor_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getClinic()
    {
        return $this->hasOne(Clinic::class, ['id' => 'clinic_id']);
    }

    public static function getTodaysAppointments()
    {
        return self::find()
            ->where(['DATE(appointment_time)' => date('Y-m-d')])
            ->all();
    }

    public static function getPastAppointments()
    {
        return self::find()
            ->where(['<', 'appointment_time', date('Y-m-d H:i:s')])
            ->all();
    }

    public static function getFutureAppointments()
    {
        return self::find()
            ->where(['>', 'appointment_time', date('Y-m-d H:i:s')])
            ->all();
    }
}