<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tcomment $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tcomment-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="form-row">
<div class="col">
<?= $form->field($model, 'comment')->textarea(['maxlength' => true]) ?>

</div>
<div class="col">
<?= $form->field($model, 'tender_id')->hiddenInput(['value'=>$tenderId])->label(false) ?>

</div>
</div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
