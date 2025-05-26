<?php

namespace app\models;

use yii\db\ActiveRecord;

class Doctor extends ActiveRecord
{
    public static function tableName()
    {
        return 'doctors';
    }

    public function rules()
    {
        return [
            [['name', 'specialization'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['specialization'], 'string', 'max' => 100],
        ];
    }

    public function getAppointments()
    {
        return $this->hasMany(Appointment::class, ['doctor_id' => 'id']);
    }

      
    public function getSchedules()
    {
        return $this->hasMany(DoctorSchedule::class, ['doctor_id' => 'id']);
    }

   
    public function getHolidays()
    {
        return $this->hasMany(DoctorHoliday::class, ['doctor_id' => 'id']);
    }

    public function getClinics()
{
   
    return $this->hasMany(Clinic::class, ['id' => 'clinic_id'])
                ->viaTable('doctor_clinic', ['doctor_id' => 'id']);
}

}