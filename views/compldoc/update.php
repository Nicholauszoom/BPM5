<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Compldoc $model */

$this->title = 'Update Compldoc: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Compldocs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin';
?>
<div class="compldoc-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
