<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="site-register">
    <p>Please fill out the following fields to register:</p>

    <?php $form = ActiveForm::begin(['id' => 'form-register']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>