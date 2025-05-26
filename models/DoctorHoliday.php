<?php

namespace app\models;

use yii\db\ActiveRecord;

class DoctorHoliday extends ActiveRecord
{
    public static function tableName()
    {
        return 'doctor_holidays';
    }

    public function rules()
    {
        return [
            [['doctor_id', 'holiday_date'], 'required'],
            [['doctor_id'], 'integer'],
            [['holiday_date'], 'safe'],
        ];
    }
}