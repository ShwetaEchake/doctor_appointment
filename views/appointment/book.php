<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Book Appointment';
?>

<h1><?= Html::encode($this->title) ?></h1>

<form method="post" action="<?= Url::to(['appointment/book']) ?>">
    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>

    <div class="form-group">
        <label for="doctor_id">Select Doctor:</label>
        <select name="doctor_id" class="form-control" required>
            <?php foreach ($doctors as $doctor): ?>
                <option value="<?= Html::encode($doctor->id) ?>"><?= Html::encode($doctor->name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="clinic_id">Select Clinic:</label>
        <select name="clinic_id" class="form-control" required>
            <?php foreach ($clinics as $clinic): ?>
                <option value="<?= Html::encode($clinic->id) ?>"><?= Html::encode($clinic->name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="appointment_time">Appointment Time:</label>
        <input type="datetime-local" name="appointment_time" class="form-control" required>
    </div>

    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary">Book Appointment</button>
    </div>
</form>