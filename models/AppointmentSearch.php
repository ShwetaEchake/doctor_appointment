<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class AppointmentSearch extends Appointment
{
    public $date;
    public $username;
    public $email;
    public $phone;

    public function rules()
    {
        return [
            [['doctor_id', 'clinic_id', 'user_id'], 'integer'],
            [['appointment_time', 'date', 'username', 'email', 'phone'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Appointment::find();
        $query->joinWith('user');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

      
        $query->andFilterWhere(['doctor_id' => $this->doctor_id]);
        $query->andFilterWhere(['clinic_id' => $this->clinic_id]);
        $query->andFilterWhere(['user_id' => $this->user_id]);

        if ($this->date) {
            $query->andWhere(['like', 'DATE(appointment_time)', $this->date]);
        }

       
        $query->andFilterWhere(['like', 'user.username', $this->username]);
        $query->andFilterWhere(['like', 'user.email', $this->email]);
        $query->andFilterWhere(['like', 'user.phone', $this->phone]);

        return $dataProvider;
    }
}
