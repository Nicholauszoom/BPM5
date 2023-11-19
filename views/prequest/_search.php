<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PrequestSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="prequest-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'updated_at') ?>

    <?= $form->field($model, 'created_by') ?>

    <?= $form->field($model, 'payee') ?>

    <?php // echo $form->field($model, 'department') ?>

    <?php // echo $form->field($model, 'mode') ?>

    <?php // echo $form->field($model, 'project_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
