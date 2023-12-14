<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Activitydetil $model */

$this->title = 'Update Activitydetil: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Activitydetils', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin';
?>
<div class="activitydetil-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'activityId'=>$activityId,
    ]) ?>

</div>
