<?php

use app\models\Tender;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/** @var yii\web\View $this */
/** @var app\models\Compliance $model */
/** @var yii\widgets\ActiveForm $form */

$user = User::find()->all();
$tender = Tender::find()->all();
?>


<small>The inputs with this * indicate are required to be fill and also End of clarification Date of this tender</span> </small>

<div class="compliance-form">

    <?php $form = ActiveForm::begin(['id'=>'dynamic-form']); ?>

    <div class="form-row">
        <div class="col">

    <?= $form->field($model, 'supervisor')->label('Supervisor *<small class="text-muted">eg.tender member</small>')->dropDownList(
   
   ArrayHelper::map($user, 'id', 'username'),
   ['prompt' => 'Select Supervisor', 'id' => 'supervisor']
)?>
 </div>

<div class="col">
    <?= $form->field($model, 'tender_id')->label('Tender *<small class="text-muted">eg.tender</small>')->dropDownList(
   
   ArrayHelper::map($tender, 'id', 'title'),
   ['prompt' => 'Select Tender', 'id' => 'tender_id']
)?>
</div>
    </div>
   
     <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Compliance</h4></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsCdetail[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'compliance_id',
                    'submit_at',
                   
                
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelsCdetail as $i => $modelsCdetail): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Compliance Details</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelsCdetail->isNewRecord) {
                                echo Html::activeHiddenInput($modelsCdetail, "[{$i}]id");
                            }
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelsCdetail, "[{$i}]compliance_id")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelsCdetail, "[{$i}]submit_at")->label('Date of Submition  *<small class="text-muted">eg.tender member</small>')->widget(DatePicker::class, [
                                 'language' => 'ru',
                                  'dateFormat' => 'MM/dd/yyyy',
                                  'options' => [
                                  'class' => 'form-control',
                                  'type' => 'date', // Use 'text' type instead of 'date' to ensure consistent behavior across browsers
                                  'id'=> 'submitat-input',
        // $model->start_at => ['selected' => true]
                                  'value' => Yii::$app->formatter->asDate($modelsCdetail->submit_at, 'MM/dd/yyyy'), // Set the value of the date picker

    ],
]) ?>
                            </div>
                        </div><!-- .row -->
                     
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

  </div>

    <div class="form-group">
        <?= Html::submitButton($modelsCdetail->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>



    <?php ActiveForm::end(); ?>

</div>
