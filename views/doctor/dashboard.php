<?php


use yii\helpers\Html;

$this->title = 'Doctor Dashboard';
?>

<h2>Welcome, Dr. <?= Html::encode(Yii::$app->user->identity->username) ?></h2>
<p>Your upcoming appointments will be shown here.</p>

?>
