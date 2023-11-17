<?php

use app\models\Tattachmentss;
use app\models\Tender;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tattachmentss $model */
/** @var yii\widgets\ActiveForm $form */

$tender_attach=Tender::findOne($tenderId);
$t_attachmentss=Tattachmentss::findOne(['tender_id'=>$tenderId]);
?>

<div class="tattachmentss-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($tender_attach->expired_at <= strtotime(date('Y-m-d')) && $tender_attach->status == 3 ) : ?>

    <div class="form-row">
        <div class="col">
            <?php if($t_attachmentss->document === null):?>
        <?= $form->field($model, 'document')->label('Openning result* <small class="text-muted">i.e.tender opening result document</small>')->fileInput()?>
       <?php else :?>
        <?= $form->field($model, 'document')->hiddenInput(['value'=>$t_attachmentss->document])?>
        <?php endif;?>


    </div>
        <div class="col">
        <?php if($t_attachmentss->evaluation === null):?>

       <?= $form->field($model, 'evaluation')->label('Evaluation* <small class="text-muted">i.e.evaluation document</small>')->fileInput()?>
       <?php else :?>
        <?= $form->field($model, 'evaluation')->hiddenInput(['value'=>$t_attachmentss->evaluation])?>
        <?php endif;?>
    </div>

  

</div>

<div class="form-row">

<div class="col">
<?php if($t_attachmentss->negotiation === null):?>

<?= $form->field($model, 'negotiation')->label('Negotiation Minutes* <small class="text-muted">etc.negotiation document</small>')->fileInput()?>
<?php else :?>
    <?= $form->field($model, 'negotiation')->hiddenInput(['value' => $t_attachmentss->negotiation]) ?>        <?php endif;?>
</div>
<div class="col">
<?php if($t_attachmentss->award === null):?>

<?= $form->field($model, 'award')->label('Award * <small class="text-muted">i.e.award document</small>')->fileInput()?>

<?php else :?>
    <?= $form->field($model, 'award')->hiddenInput(['value'=>$t_attachmentss->award])?>
        <?php endif;?>
</div>
</div>

<div class="form-row">
<div class="col">
<?php if($t_attachmentss->intention === null):?>

<?= $form->field($model, 'intention')->label('Intention* <small class="text-muted">etc.intention document</small>')->fileInput()?>
<?php else :?>
    <?= $form->field($model, 'intention')->hiddenInput(['value'=>$t_attachmentss->intention])?>
        <?php endif;?>
</div>
<div class="col">
<?php if($t_attachmentss->arithmetic === null):?>

<?= $form->field($model, 'arithmetic')->label('Arithmetic* <small class="text-muted">i.e.arithmentic document</small>')->fileInput()?>
<?php else :?>
    <?= $form->field($model, 'arithmetic')->hiddenInput(['value'=>$t_attachmentss->arithmetic])?>
        <?php endif;?>
</div>

</div>
  
<div class="form-row">
<div class="col">
<?php if($t_attachmentss->audit === null):?>

<?= $form->field($model, 'audit')->label('Audit* <small class="text-muted">etc.audit document</small>')->fileInput()?>
<?php else :?>
    <?= $form->field($model, 'audit')->textInput(['value'=>$t_attachmentss->audit])?>
        <?php endif;?>
</div>
    <div class="col">
    <?php if($t_attachmentss->cancellation === null):?>

    <?= $form->field($model, 'cancellation')->label('Cancellation* <small class="text-muted">i.e.cancellation document</small>')->fileInput()?>
    <?php else :?>
    <?= $form->field($model, 'cancellation')->hiddenInput(['value'=>$t_attachmentss->cancellation])?>
        <?php endif;?>

</div>
    
</div>

<div class="form-rom">

<div class="col">
<?php if($t_attachmentss->cancellation === null):?>
    <?= $form->field($model, 'contract')->label('Contract Document* <small class="text-muted">i.e.contract document</small>')->fileInput()?>
    <?php else :?>
    <?= $form->field($model, 'contract')->hiddenInput(['value'=>$t_attachmentss->contract])?>
        <?php endif;?>

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
