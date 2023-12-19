<?php

use app\models\Tender;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Eligibactivity $model */

$eligb_tender=Tender::findOne($tenderId);

$this->title = 'Create Eligibility Activities(tender):'. $eligb_tender->title;
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
        'eligibdtilExist'=> $eligibdtilExist,
    ]) ?>

</div>
