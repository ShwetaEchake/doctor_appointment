<?php

use yii\helpers\Html;
use yii\widgets\DetailView;



$this->title = 'Appointment #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Appointment Listings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="appointment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this appointment?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Back to list', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'appointment_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
                'label' => 'Appointment Time',
            ],
            [
                'label' => 'User Name',
                'value' => $model->user ? $model->user->username : '(not set)',
            ],
            [
                'label' => 'User Email',
                'value' => $model->user ? $model->user->email : '(not set)',
            ],
            [
                'label' => 'Doctor Name',
                'value' => $model->doctor ? $model->doctor->name : '(not set)',
            ],
            [
                'label' => 'Clinic',
                'value' => $model->clinic ? $model->clinic->name : '(not set)',
            ],
        ],
    ]) ?>

</div>
