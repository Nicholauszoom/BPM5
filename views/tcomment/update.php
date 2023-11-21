<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tcomment $model */

$this->title = 'Update Tcomment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tcomments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout=('admin');
?>
<div class="tcomment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
