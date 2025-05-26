<?php
use yii\helpers\Html;


$this->title = "Doctor Calendar - " . Html::encode($doctor->name);
?>

<h1><?= Html::encode($this->title) ?></h1>

<h3>Available Schedule</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($schedule as $slot): ?>
            <tr>
                <td><?= Html::encode($slot->date) ?></td>
                <td><?= Html::encode($slot->start_time) ?></td>
                <td><?= Html::encode($slot->end_time) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3>Booked Appointments</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Patient</th>
            <th>Appointment Time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($appointments as $appt): ?>
            <tr>
                <td><?= Html::encode($appt->user->username ?? 'Unknown') ?></td>
                <td><?= Html::encode($appt->appointment_time) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
