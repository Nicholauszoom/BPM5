<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $boqFilePath string */

$this->title = 'View BOQ';
$this->params['breadcrumbs'][] = ['label' => 'BOQ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="open-boq">
    <h1><?= Html::encode($this->title) ?></h1>

    <iframe src="<?= $boqFilePath ?>" width="100%" height="600px"></iframe>
</div>