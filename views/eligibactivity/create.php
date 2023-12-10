<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Eligibactivity $model */

$this->title = 'Create Eligibility Activities';
$this->params['breadcrumbs'][] = ['label' => 'Eligibactivities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin';

?>
<div class="eligibactivity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'adetailId'=>$adetailId,
        'eligibsubactivity'=>$eligibsubactivity,
        'userId'=>$userId,
        'assgntenderId'=>$assgntenderId,
    ]) ?>

</div>
