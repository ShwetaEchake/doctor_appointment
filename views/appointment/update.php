<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Update Appointment: ' . $model->id;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="appointment-update">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'appointment_time')->input('datetime-local', [
        'value' => date('Y-m-d\TH:i', strtotime($model->appointment_time))
    ]) ?>

    <?= $form->field($model, 'user_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\User::find()->all(), 'id', 'username'),
        ['prompt' => 'Select User']
    ) ?>

    <?= $form->field($model, 'doctor_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Doctor::find()->all(), 'id', 'name'),
        ['prompt' => 'Select Doctor']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
