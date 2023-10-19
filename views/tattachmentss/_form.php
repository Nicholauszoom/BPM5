<?php

use app\models\Tender;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tattachmentss $model */
/** @var yii\widgets\ActiveForm $form */

$tender_attach=Tender::findOne($tenderId);
?>

<div class="tattachmentss-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($tender_attach->expired_at <= strtotime(date('Y-m-d')) && $tender_attach->status == 3 ) : ?>

    <div class="form-row">
        <div class="col">
        <?= $form->field($model, 'document')->fileInput()?>
        </div>
        <div class="col">

       <?= $form->field($model, 'evaluation')->fileInput()?>
        </div>

  

</div>

<div class="form-row">

<div class="col">
<?= $form->field($model, 'negotiation')->fileInput()?>
</div>
<div class="col">
<?= $form->field($model, 'award')->fileInput()?>
</div>
</div>

<div class="form-row">
<div class="col">
<?= $form->field($model, 'intention')->fileInput()?>
</div>
<div class="col">
<?= $form->field($model, 'arithmetic')->fileInput()?>
</div>

</div>
  
<div class="form-row">
<div class="col">
<?= $form->field($model, 'audit')->fileInput()?>
</div>
    <div class="col">
    <?= $form->field($model, 'cancellation')->fileInput()?>
    </div>
    
</div>

<div class="form-rom">

<div class="col">
    <?= $form->field($model, 'contract')->fileInput()?>
    </div>
</div>
 

    
    <?php else:?>

    <?= $form->field($model, 'evaluation')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'negotiation')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'award')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'intention')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'arithmetic')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'audit')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'contract')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'document')->hiddenInput()->label(false) ?>

    <p>hidden inputs wait until document to be submitted</p>

<?php endif;?>

    <?= $form->field($model, 'tender_id')->hiddenInput(['value'=>$tenderId])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
