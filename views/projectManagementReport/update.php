<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProjectManagementReport $model */

$this->title = 'Update Project Management Report: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Project Management Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-management-report-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
