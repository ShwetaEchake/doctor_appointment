<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Appointments for ' . $doctor->name;
$this->params['breadcrumbs'][] = ['label' => 'Doctors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="doctor-appointments">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => new yii\data\ArrayDataProvider([
            'allModels' => $appointments,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'user.username',
            'appointment_time',
        ],
    ]); ?>

</div>