<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Rdetail $model */

$this->title = 'Create Rdetail';
$this->params['breadcrumbs'][] = ['label' => 'Rdetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = ('admin');
?>
<div class="rdetail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'prequest'=>$prequest,
        'prequestId'=>$prequestId,
        'total_amount'=>$total_amount,
    ]) ?>

</div>
