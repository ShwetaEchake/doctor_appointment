<?php
use yii\helpers\Html;

/** @var $schedule app\models\Schedule[] */

$this->title = "My Schedule";
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Add New Slot', ['schedule/create'], ['class' => 'btn btn-success']) ?>
</p>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($schedule as $slot): ?>
            <tr>
                <td><?= Html::encode($slot->date) ?></td>
                <td><?= Html::encode($slot->start_time) ?></td>
                <td><?= Html::encode($slot->end_time) ?></td>
                <td>
                    <?= Html::a('Edit', ['schedule/update', 'id' => $slot->id], ['class' => 'btn btn-primary btn-sm']) ?>
                    <?= Html::a('Delete', ['schedule/delete', 'id' => $slot->id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => ['confirm' => 'Are you sure?', 'method' => 'post'],
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
