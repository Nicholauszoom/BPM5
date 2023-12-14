<?php

use app\models\Tender;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Compldoc $model */
$tndr=Tender::findOne($tenderId);
$this->title = 'Conduct activities for '.$tndr->title;
$this->params['breadcrumbs'][] = ['label' => 'Compldocs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout='admin';
?>
<div class="compldoc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tenderId'=>$tenderId,
    ]) ?>

</div>
