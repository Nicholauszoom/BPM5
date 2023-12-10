<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Tenders Report';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin';
?>
<a href="<?= Yii::$app->request->referrer ?>" class="back-arrow">
    <span class="arrow">&#8592;</span> Back
</a>
<div id="main-content ">
   
    <div id="page-container">
        <!-- ============================================================== -->
        <!-- Sales Cards  -->
        <!-- ============================================================== -->
        <div class="row"></div>

        <h2>Generate Tender Report</h2>


<?php $form = ActiveForm::begin(); ?>
<div class="form-row">
    <div class="col">
    <?= $form->field($model, 'date_from')->textInput(['type' => 'date']) ?>
    </div>
    <div class="col">
    <?= $form->field($model, 'date_to')->textInput(['type' => 'date']) ?>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton(' <i class="fas fa-download"></i> pdf ', ['class' => 'btn btn-primary btn-floating']) ?>

</div>

<?php ActiveForm::end(); ?>
    </div>
</div>