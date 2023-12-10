<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Eligibactivity $model */

$this->title = 'Update Eligibactivity: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Eligibactivities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin';

?>
<div class="eligibactivity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
