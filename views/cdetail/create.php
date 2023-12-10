<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Cdetail $model */

$this->title = 'Create Cdetail';
$this->params['breadcrumbs'][] = ['label' => 'Cdetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cdetail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
