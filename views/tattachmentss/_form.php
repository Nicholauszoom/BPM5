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

<div class="tattachmentss-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($tender_attach->expired_at <= strtotime(date('Y-m-d')) && $tender_attach->status == 3 ) : ?>

    <div class="form-row">
        <div class="col">


    <?= $form->field($model, 'document')->label('Openning result* <small class="text-muted">i.e.tender opening result document</small>')->fileInput(['optional' => true]) ?>



    </div>
        <div class="col">
    

       <?= $form->field($model, 'evaluation')->label('Evaluation* <small class="text-muted">i.e.evaluation document</small>')->fileInput(['optional' => true])?>
      
    </div>

  

</div>

<div class="form-row">

<div class="col">



<?= $form->field($model, 'negotiation')->label('Negotiation Minutes* <small class="text-muted">etc.negotiation document</small>')->fileInput(['optional' => true])?>

</div>

<div class="col">



<?= $form->field($model, 'award')->label('Award Letter* <small class="text-muted">i.e.award document</small>')->fileInput(['optional' => true])?>
      
</div>
</div>

<div class="form-row">
<div class="col">

<?= $form->field($model, 'intention')->label('Intention* <small class="text-muted">etc.intention document</small>')->fileInput(['optional' => true])?>

</div>
<div class="col">



<?= $form->field($model, 'arithmetic')->label('Arithmetic* <small class="text-muted">i.e.arithmentic document</small>')->fileInput(['optional' => true])?>

</div>

</div>
  
<div class="form-row">
<div class="col">

<?= $form->field($model, 'audit')->label('Audit* <small class="text-muted">etc.audit document</small>')->fileInput(['optional' => true])?>

</div>

    <div class="col">

    <?= $form->field($model, 'cancellation')->label('Cancellation* <small class="text-muted">i.e.cancellation document</small>')->fileInput(['optional' => true])?>
        

</div>
    
</div>

<div class="form-rom">

<div class="col">


    <?= $form->field($model, 'contract')->label('Contract Document* <small class="text-muted">i.e.contract document</small>')->fileInput(['optional' => true])?>


</div>

<div class="col">


    <?= $form->field($model, 'acceptance')->label('Acceptance Document* <small class="text-muted">i.e.acceptance document</small>')->fileInput(['optional' => true])?>
    

</div>
</div>

<div class="form-rom">

<div class="col">


    <?= $form->field($model, 'performance')->label('Performance Guarantee* <small class="text-muted">i.e.performance document</small>')->fileInput(['optional' => true])?>
   
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