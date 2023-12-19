<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Eligibactivity $model */
/** @var yii\widgets\ActiveForm $form */


// '$eligibdtilExist '=> $eligibdtilExist,
?>

<div class="eligibactivity-form">

    <?php $form = ActiveForm::begin(); ?>

 
<div class="form-row">
 
    <div class="col-6">

    <?= $form->field($model, 'activitydetail_id')->checkboxList( ArrayHelper::map($eligibsubactivity, 'id', 'title'), ['prompt' => 'Select eligibility activity', 'id' => 'eligibsubactivity'] )?>
   

</div>

    <div class="col-6">
    <?= $form->field($model, 'adetail_id')->hiddenInput(['value' => $adetailId])->label(false)?>
    <?= $form->field($model, 'user_id')->hiddenInput(['value' => $userId])->label(false)?>
    <?= $form->field($model, 'tender_id')->hiddenInput(['value' => $assgntenderId])->label(false)?>

    </div>
</div>




    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
