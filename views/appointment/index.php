<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;



$this->title = 'Appointment Listings';
?>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        
        [
            'attribute' => 'appointment_time',
            'label' => 'Appointment Time',
            'format' => ['date', 'php:Y-m-d H:i:s'],
        ],
        [
            'attribute' => 'user.username',
            'label' => 'User Name',
        ],
        [
            'attribute' => 'user.email',
            'label' => 'User Email',
        ],
      
        [
            'attribute' => 'doctor.name',
            'label' => 'Doctor Name',
        ],


        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>

<script>

document.getElementById('filter-form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    
    const formData = new FormData(this);


    fetch('<?= Yii::$app->urlManager->createUrl(['appointment/index']) ?>', {
        method: 'GET',
        body: formData,
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('appointment-list').innerHTML = html;
    })
    .catch(error => console.error('Error:', error));
});


</script>
