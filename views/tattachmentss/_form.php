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
$tattachmentst=Tattachmentss::find()->where(['tender_id'=>$tenderId])->all();
?>
<?php
$hasContract = false;
foreach ($tattachmentst as $tattachment) {
    if ($tattachment->contract !== null) {
        $hasContract = true;
        break;
    }
}
?>
<div class="tattachmentss-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($tender_attach->expired_at <= strtotime(date('Y-m-d')) && $tender_attach->status == 3 ) : ?>

    <div class="form-row">
        <div class="col">
        <?php
$hasDocument = false;
foreach ($tattachmentst as $tattachment) {
    if ($tattachment->document !== null) {
        $hasDocument = true;
        break;
    }
}
?>
            <?php if($hasDocument === null):?>
        <?= $form->field($model, 'document')->label('Openning result* <small class="text-muted">i.e.tender opening result document</small>')->fileInput(['optional' => true])?>
       <?php else :?>
        <?= $form->field($model, 'document')->hiddenInput(['value'=>$t_attachmentss->document])?>
        <?php endif;?>


    </div>
        <div class="col">
        <?php
$hasEvaluation = false;
foreach ($tattachmentst as $tattachment) {
    if ($tattachment->evaluation !== null) {
        $hasEvaluation = true;
        break;
    }
}
?>
        <?php if($hasEvaluation === null):?>

       <?= $form->field($model, 'evaluation')->label('Evaluation* <small class="text-muted">i.e.evaluation document</small>')->fileInput(['optional' => true])?>
       <?php else :?>
        <?= $form->field($model, 'evaluation')->hiddenInput(['value'=>$t_attachmentss->evaluation])?>
        <?php endif;?>
    </div>

  

</div>

<div class="form-row">

<div class="col">
<?php
$hasNegotiation = false;
foreach ($tattachmentst as $tattachment) {
    if ($tattachment->negotiation !== null) {
        $hasNegotiation = true;
        break;
    }
}
?>
<?php if($hasNegotiation === null):?>

<?= $form->field($model, 'negotiation')->label('Negotiation Minutes* <small class="text-muted">etc.negotiation document</small>')->fileInput(['optional' => true])?>
<?php else :?>
    <?= $form->field($model, 'negotiation')->hiddenInput(['value' => $t_attachmentss->negotiation]) ?>        <?php endif;?>
</div>


<div class="col">
<?php
$hasAward = false;
foreach ($tattachmentst as $tattachment) {
    if ($tattachment->award !== null) {
        $hasNegotiation = true;
        break;
    }
}
?>
<?php if($hasAward === null):?>

<?= $form->field($model, 'award')->label('Award Letter* <small class="text-muted">i.e.award document</small>')->fileInput(['optional' => true])?>

<?php else :?>
    <?= $form->field($model, 'award')->hiddenInput(['value'=>$t_attachmentss->award])?>
        <?php endif;?>
</div>
</div>

<div class="form-row">
<div class="col">
<?php
$hasIntention = false;
foreach ($tattachmentst as $tattachment) {
    if ($tattachment->intention !== null) {
        $hasIntention= true;
        break;
    }
}
?>
<?php if($hasIntention === null):?>

<?= $form->field($model, 'intention')->label('Intention* <small class="text-muted">etc.intention document</small>')->fileInput(['optional' => true])?>
<?php else :?>
    <?= $form->field($model, 'intention')->hiddenInput(['value'=>$t_attachmentss->intention])?>
        <?php endif;?>
</div>
<div class="col">
<?php
$hasArithmetic = false;
foreach ($tattachmentst as $tattachment) {
    if ($tattachment->arithmetic !== null) {
        $hasArithmetic= true;
        break;
    }
}
?>
<?php if($hasArithmetic === null):?>

<?= $form->field($model, 'arithmetic')->label('Arithmetic* <small class="text-muted">i.e.arithmentic document</small>')->fileInput(['optional' => true])?>
<?php else :?>
    <?= $form->field($model, 'arithmetic')->hiddenInput(['value'=>$t_attachmentss->arithmetic])?>
        <?php endif;?>
</div>

</div>
  
<div class="form-row">
<div class="col">
<?php
$hasAudit= false;
foreach ($tattachmentst as $tattachment) {
    if ($tattachment->audit !== null) {
        $hasAudit= true;
        break;
    }
}
?>
<?php if($hasAudit=== null):?>

<?= $form->field($model, 'audit')->label('Audit* <small class="text-muted">etc.audit document</small>')->fileInput(['optional' => true])?>
<?php else :?>
    <?= $form->field($model, 'audit')->hiddenInput(['value'=>$t_attachmentss->audit])?>
        <?php endif;?>
</div>

    <div class="col">
    <?php
$hasCancellation= false;
foreach ($tattachmentst as $tattachment) {
    if ($tattachment->cancellation !== null) {
        $hasCancellation= true;
        break;
    }
}
?>
    <?php if($hasCancellation === null):?>

    <?= $form->field($model, 'cancellation')->label('Cancellation* <small class="text-muted">i.e.cancellation document</small>')->fileInput(['optional' => true])?>
    <?php else :?>
    <?= $form->field($model, 'cancellation')->hiddenInput(['value'=>$t_attachmentss->cancellation])?>
        <?php endif;?>

</div>
    
</div>

<div class="form-rom">

<div class="col">
<?php
$hasContract= false;
foreach ($tattachmentst as $tattachment) {
    if ($tattachment->contract !== null) {
        $hasContract= true;
        break;
    }
}
?>
<?php if($hasContract === null):?>
    <?= $form->field($model, 'contract')->label('Contract Document* <small class="text-muted">i.e.contract document</small>')->fileInput(['optional' => true])?>
    <?php else :?>
    <?= $form->field($model, 'contract')->hiddenInput(['value'=>$t_attachmentss->contract])?>
        <?php endif;?>

</div>

<div class="col">
<?php
$hasAcceptance= false;
foreach ($tattachmentst as $tattachment) {
    if ($tattachment->acceptance !== null) {
        $hasAcceptance= true;
        break;
    }
}
?>
<?php if($hasAcceptance === null):?>
    <?= $form->field($model, 'acceptance')->label('Acceptance Document* <small class="text-muted">i.e.acceptance document</small>')->fileInput(['optional' => true])?>
    <?php else :?>
    <?= $form->field($model, 'acceptance')->hiddenInput(['value'=>$t_attachmentss->acceptance])?>
        <?php endif;?>

</div>
</div>

<div class="form-rom">

<div class="col">
<?php
$hasPerformance= false;
foreach ($tattachmentst as $tattachment) {
    if ($tattachment->performance !== null) {
        $hasPerformance= true;
        break;
    }
}
?>
<?php if($hasPerformance=== null):?>
    <?= $form->field($model, 'performance')->label('Performance Guarantee* <small class="text-muted">i.e.performance document</small>')->fileInput(['optional' => true])?>
    <?php else :?>
    <?= $form->field($model, 'performance')->hiddenInput(['value'=>$t_attachmentss->performance])?>
        <?php endif;?>
</div>
</div>
 

    
    <?php else:?>

    <?= $form->field($model, 'evaluation')->hiddenInput(['optional' => true])->label(false) ?>

    <?= $form->field($model, 'negotiation')->hiddenInput(['optional' => true])->label(false) ?>

    <?= $form->field($model, 'award')->hiddenInput(['optional' => true])->label(false) ?>

    <?= $form->field($model, 'intention')->hiddenInput(['optional' => true])->label(false) ?>

    <?= $form->field($model, 'arithmetic')->hiddenInput(['optional' => true])->label(false) ?>

    <?= $form->field($model, 'audit')->hiddenInput(['optional' => true])->label(false) ?>

    <?= $form->field($model, 'contract')->hiddenInput(['optional' => true])->label(false) ?>

    <?= $form->field($model, 'document')->hiddenInput(['optional' => true])->label(false) ?>

    <?= $form->field($model, 'acceptance')->hiddenInput(['optional' => true])->label(false) ?>

<?= $form->field($model, 'performance')->hiddenInput(['optional' => true])->label(false) ?>

    <p>hidden inputs wait until document to be submitted</p>

<?php endif;?>

    <?= $form->field($model, 'tender_id')->hiddenInput(['value'=>$tenderId])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
