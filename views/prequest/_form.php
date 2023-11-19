<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Prequest $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="prequest-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="card-body">
        <p>Inputs with the * symbol are highly required to be filled</p>
    <div class="row">
        <div class="col-md-6">
        <?php echo $form->field($model, 'payee')->label('Payee Name * <small class="text-muted">select name</small>')->dropDownList(
    ArrayHelper::map($user, 'id', 'username'),
    [
        'prompt' => 'Select Payee Name',
        'options' => [
            $model->payee => ['selected' => true]
        ]
    ]
); ?>
    </div>
    <div class="col-md-6">
    <?php echo $form->field($model, 'department')->label('Payee Name * <small class="text-muted">select department</small>')->dropDownList(
    ArrayHelper::map($department, 'id', 'name'),
    [
        'prompt' => 'Select department',
        'options' => [
            $model->payee => ['selected' => true]
        ]
    ]
); ?>
    </div>
    </div>

        <div class="row">
    <div class="col-md-6">

    <?= $form->field($model, 'mode')->label('Payment Mode * <small class="text-muted">eg.cash/cheque</small>')->dropDownList(
            [
                1 => 'Cheque',
                2 => 'Cash',
              
          
            ],
            ['prompt' => 'Payment Mode'] // Disable the field if the expiration date is not greater than the current date

        ); ?>
    </div>
   
    <div class="col-md-6">
    
    <?= $form->field($model, 'status')->label('Request Status * <small class="text-muted">eg.open/paid</small>')->dropDownList(
   [
    1 => 'Open',
    2 => 'paid',

],
[
    'prompt' => 'Select tender Status', // Disable the field if the expiration date is not greater than the current date
    'disabled' => true,
    'options' => [
        1 => ['selected' => true] // Set 'on-progress' as the default selected option
    ]
]
); ?>


<?= $form->field($model, 'project_id')->hiddenInput(['value' => $projectId])->label(false)?>

    </div>
   
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>



  
