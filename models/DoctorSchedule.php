<?php

namespace app\models;

use yii\db\ActiveRecord;

class DoctorSchedule extends ActiveRecord
{
    public static function tableName()
    {
        return 'doctor_schedules';
    }

    public function rules()
    {
        return [
            [['doctor_id', 'day_of_week', 'start_time', 'end_time'], 'required'],
            [['doctor_id'], 'integer'],
            [['day_of_week'], 'in', 'range' => [0, 1, 2, 3, 4, 5, 6]], 
            [['start_time', 'end_time'], 'safe'],
        ];
    }
}