<?php
use yii\helpers\Html;


$this->title = 'User Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="card-title">Welcome, <?= Html::encode($user->username) ?>!</h1>
            <p class="text-muted">Email: <?= Html::encode($user->email) ?></p>
        </div>
    </div>

    <div class="mt-4">
        <h2>Your Appointments</h2>

        <?php if (!empty($appointments)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover mt-3">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Doctor</th>
                            <th scope="col">Clinic</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?= Yii::$app->formatter->asDatetime($appointment->appointment_time) ?></td>
                                <td><?= Html::encode($appointment->doctor->name ?? 'N/A') ?></td>
                                <td><?= Html::encode($appointment->clinic->name ?? 'N/A') ?></td>
                                <td>
                                    <span class="badge            
                                        <?= $appointment->status === 'confirmed' ? 'bg-success text-light' :
                                            ($appointment->status === 'pending' ? 'bg-warning text-dark' :
                                            ($appointment->status === 'cancelled' ? 'bg-danger text-light' : 'bg-secondary text-light')) ?>">
                                        <?= Html::encode(ucfirst($appointment->status)) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info mt-3">
                You have no appointments scheduled.
            </div>
        <?php endif; ?>

        <div class="mt-3">
            <?= Html::a('Logout', ['/user/logout'], [
                'class' => 'btn btn-outline-danger',
                'data-method' => 'post'
            ]) ?>
        </div>
    </div>
</div>
