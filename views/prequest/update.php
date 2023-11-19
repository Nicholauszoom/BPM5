<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Prequest $model */

$this->title = 'Update Prequest: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Prequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin';
?>
<div class="prequest-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
