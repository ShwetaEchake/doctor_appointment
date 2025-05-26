<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Update Doctor';
?>

<h2><?= Html::encode($this->title) ?></h2>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($doctor, 'name')->textInput(['maxlength' => true]) ?>
<?= $form->field($doctor, 'specialization')->textInput(['maxlength' => true]) ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    <?= Html::a('Cancel', ['admin/doctors'], ['class' => 'btn btn-secondary']) ?>
</div>

<?php ActiveForm::end(); ?>
