<?php

use app\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use app\widgets\Alert;
use yii\helpers\Url;
use yii\bootstrap5\Breadcrumbs;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset]);
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']);
$this->title = Html::encode($this->title);

$role = !Yii::$app->user->isGuest ? Yii::$app->user->identity->role : null;
$username = !Yii::$app->user->isGuest ? Yii::$app->user->identity->username : null;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode(Yii::$app->name) ?> | <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100 bg-light">
<?php $this->beginBody() ?>

<header>
    <?php
    
NavBar::begin([
    'brandLabel' => '<i class="bi bi-heart-pulse-fill text-danger"></i> Virtual Doctor',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => ['class' => 'navbar navbar-expand-md navbar-dark bg-primary fixed-top']
]);

$menuItems = [
    ['label' => 'Home', 'url' => ['/site/index']],
];

if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    $menuItems[] = ['label' => 'Register', 'url' => ['/site/register']];
} else {
    if ($role === 'admin') {
        $menuItems[] = ['label' => 'Dashboard', 'url' => ['/admin/dashboard']];
        $menuItems[] = ['label' => 'Doctors', 'url' => ['/doctor/index']];
        $menuItems[] = ['label' => 'Appointments', 'url' => ['/admin/appointments']];
        $menuItems[] = ['label' => 'Users', 'url' => ['/admin/users']];
    } elseif($role === 'doctor') {
    $menuItems[] = ['label' => 'Dashboard', 'url' => ['/doctor/dashboard']];
    $menuItems[] = ['label' => 'My Calendar', 'url' => Url::to(['doctor/calendar', 'doctor_id' => Yii::$app->user->identity->id])];
    $menuItems[] = ['label' => 'My Appointments', 'url' => Url::to(['doctor/view-appointments'])];
    $menuItems[] = ['label' => 'Schedule', 'url' => Url::to(['doctor/schedule'])];
    } elseif ($role === 'user') {
        $menuItems[] = ['label' => 'Dashboard', 'url' => ['/site/dashboard']];
        $menuItems[] = ['label' => 'Book Appointment', 'url' => ['/appointment/book']];
        $menuItems[] = ['label' => 'My Appointments', 'url' => ['/appointment/index']];
    }

    $menuItems[] = [
        'label' => "Logout ($username)",
        'url' => ['/site/logout'],
        'linkOptions' => ['data-method' => 'post']
    ];
}

echo Nav::widget([
    'options' => ['class' => 'navbar-nav ms-auto'],
    'items' => $menuItems,
]);

NavBar::end();

    ?>
</header>

<main role="main" class="flex-shrink-0 pt-5 mt-5">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 bg-primary text-white">
    <div class="container text-center">
        <p class="mb-1">&copy; Virtual Doctor Appointment <?= date('Y') ?></p>
        
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
