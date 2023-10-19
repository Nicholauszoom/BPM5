<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProjectManagementReport $model */

$this->title = 'Create Project Management Report';
$this->params['breadcrumbs'][] = ['label' => 'Project Management Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-management-report-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
