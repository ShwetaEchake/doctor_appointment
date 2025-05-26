<?php
namespace app\models;
use yii\db\ActiveRecord;
use app\models\Doctor;


class Clinic extends ActiveRecord
{
    public static function tableName()
    {
        return 'clinics';
    }

    public function getDoctors()
    {
        return $this->hasMany(Doctor::class, ['id' => 'doctor_id'])
                    ->viaTable('doctor_clinic', ['clinic_id' => 'id']);
    }
}
