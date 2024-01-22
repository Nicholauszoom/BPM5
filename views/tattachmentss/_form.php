<?php

use app\models\Tattachmentss;
use app\models\Tender;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Tattachmentss $model */
/** @var yii\widgets\ActiveForm $form */

$tender_attach=Tender::findOne($tenderId);
$t_attachmentss=Tattachmentss::findOne(['tender_id'=>$tenderId]);
$tattachmentst=Tattachmentss::find()->where(['tender_id'=>$tenderId])->all();
?>
<div class="tattachmentss-form">
  <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Form</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Uploads</button>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
  


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

  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
 

<?= DetailView::widget([
    'model' => $tender_attach,
    'attributes' => [
     
        [
            'label' => 'Documents',
            'format' => 'raw',
            'value' => function ($model) {
                $attachments = Tattachmentss::find()->where(['tender_id' => $model->id])->all();
        
                if (empty($attachments)) {
                    return '';
                }
        
                $documentAttributes = [
                    'document' => 'Opening',
                    'evaluation' => 'Evaluation',
                    'negotiation' => 'Negotiation ',
                    'award' => 'Award ',
                    'intention' => 'Intention ',
                    'arithmetic' => 'Arithmetic',
                    'audit' => 'Audit',
                    'cancellation' => 'Cancellation ',
                    'contract' => 'Contract',
                ];
        
                $documentLinks = [];
        
                foreach ($attachments as $attachment) {
                    foreach ($documentAttributes as $attribute => $label) {
                        $fileName = $attachment->{$attribute};
                        if (!empty($fileName)) {
                            $filePath = Yii::getAlias('@webroot/upload/' . $fileName);
                            $downloadPath = Yii::getAlias('@web/upload/' . $fileName);
                            $documentLinks[] = $label . ': ' . Html::a($fileName, $downloadPath, ['target' => '_blank']);
                        }
                    }
                }
        
                return implode('<br>', $documentLinks);
            },
        ],


    ],
]) ?>

  </div>
</div>
</div>
</div>