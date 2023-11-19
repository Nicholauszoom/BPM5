<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Prequest $model */

$this->title = 'Create Request';
$this->params['breadcrumbs'][] = ['label' => 'Prequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin';
?>
<div class="prequest-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'department'=>$department,
        'user'=>$user,
        'projectId'=>$projectId,
     
    ]) ?>

</div>
