<?php

use app\models\Activity;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Activitydetil $model */
$actvty=Activity::findOne($activityId);
$this->title = 'Create sub activities for ' . $actvty->name;
$this->params['breadcrumbs'][] = ['label' => 'Activitydetils', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin';
?>
<div class="activitydetil-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'activityId'=>$activityId,
    ]) ?>

</div>
