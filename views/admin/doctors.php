<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Manage Doctors';
?>

<h2><?= Html::encode($this->title) ?></h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Specialization</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($doctors as $doctor): ?>
            <tr>
                <td><?= Html::encode($doctor->id) ?></td>
                <td><?= Html::encode($doctor->name) ?></td>
                <td><?= Html::encode($doctor->specialization) ?></td>
                <td>
                   <?= Html::a('Update', ['admin/update-doctor', 'id' => $doctor->id], ['class' => 'btn btn-sm btn-primary']) ?>

                    <?= Html::a('Delete', ['admin/delete-doctor', 'id' => $doctor->id], [
                        'class' => 'btn btn-sm btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this doctor?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
