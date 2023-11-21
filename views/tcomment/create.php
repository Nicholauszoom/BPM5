<?php

use app\models\Tender;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tcomment $model */
$tender=Tender::findOne($tenderId);
$this->title = 'Comment On : ' .$tender->title . ' tender reason for ' . getStatusLabel($tender->status);
$this->params['breadcrumbs'][] = ['label' => 'Tcomments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout=('admin');
?>
<div class="tcomment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tenderId'=>$tenderId,
    ]) ?>

</div>


<?php
function getStatusLabel($status)
{
    $statusLabels = [
        1 => 'awarded',
        2 => 'not-awarded',
        3 => 'submitted',
        4 => 'not-submtted',
        5 => 'on-progress',
    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}

function getStatusClass($status)
{
    $statusClasses = [
       
        1 => 'status-active',
        2 => 'status-inactive',
        3 => 'status-onhold',
    ];

    return isset($statusClasses[$status]) ? $statusClasses[$status] : '';
}
?>


