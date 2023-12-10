<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Cdetail $model */

$this->title = 'Update Cdetail: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cdetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cdetail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
