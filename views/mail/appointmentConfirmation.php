<?php
use yii\helpers\Html;

/* @var $user app\models\User */
/* @var $appointment app\models\Appointment */

?>

<p>Hello <?= Html::encode($user->username) ?>,</p>

<p>Your appointment has been successfully booked.</p>

<p><strong>Details:</strong></p>
<ul>
    <li>Doctor: <?= Html::encode($appointment->doctor->name) ?></li>
    <li>Clinic: <?= Html::encode($appointment->clinic->name) ?></li>
    <li>Date & Time: <?= Yii::$app->formatter->asDatetime($appointment->appointment_time) ?></li>
</ul>

<p>Thank you for using our service!</p>
