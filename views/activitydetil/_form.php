<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Activitydetil $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="activitydetil-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="form-row">
    <div class="col-6">
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-6">
    <?= $form->field($model, 'activity_id')->hiddenInput(['value'=>$activityId])->label(false) ?>
    </div>
</div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
