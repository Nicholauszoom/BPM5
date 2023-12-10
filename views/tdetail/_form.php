<?php

use app\models\Setting;
use app\models\Tender;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\Tdetails $model */
/** @var yii\widgets\ActiveForm $form */

$tender_by_id = Tender::findOne($tenderId);
$publish_date = $tender_by_id->publish_at;
$submit_date = $tender_by_id->expired_at;

$end_clarification_days= Setting::findOne(1);
$end_clarification= $end_clarification_days->end_clarification;
$end_clarification_days_interval=$submit_date  - ($end_clarification * 3600 * 24);


?>

<div class="tdetails-form">
<small>The inputs with this  <span style="color:red;"> * </span> are required to be fill and also End of clarification Date of this tender: <span style="color:red;"><?=Yii::$app->formatter->asDate($end_clarification_days_interval)?></span> </small>
    <?php $form = ActiveForm::begin(); ?>
<div class="form-row">
    <div class="col-6">
    <?= $form->field($model, 'site_visit', ['template' => "{label}\n<div class='input-group'>{input}\n<span class='input-group-addon'><i class='fa fa-bell'></i></span></div>\n{error}"])->label('Sitevisit *<small class="text-muted">from tender department</small>')->dropDownList(
    [
        1 => 'a. YES',
        2 => 'b. NO',
    ],
    [
        'id' => 'site-visit-dropdown',
        'prompt' => 'Tender requires site visit?',
    ]
) ?>
<div id="additional-form" style="display: none;">

<?= $form->field($model, 'site_visit_date')->label('Site visit date * <small class="text-muted">eg.10-12-2025 03:00 AM</small>')->widget(DatePicker::class, [
    'language' => 'ru',
    'dateFormat' => 'MM/dd/yyyy',
    'options' => [
        'class' => 'form-control',
        'type' => 'date', // Use 'text' type instead of 'date' to ensure consistent behavior across browsers
        'id'=> 'site-visit-date-input'
    ],
    'value' => Yii::$app->formatter->asDate($model->site_visit_date, 'MM/dd/yyyy'), // Set the value of the date picker
]) ?>

<?php
$tender_by_id = Tender::findOne($tenderId);
$publish_date = $tender_by_id->publish_at;
$submit_date = $tender_by_id->expired_at;

$end_clarification_days= Setting::findOne(1);
$end_clarification= $end_clarification_days->end_clarification;
$end_clarification_days_interval=$submit_date  - ($end_clarification * 3600 * 24);


?>
<div id="site-visit-date-warning" style="display: none; color: red;"><i class="fas fa-warning" style="color:orange ;"></i> Date must be between <span style = "color:dimgray;"><?=Yii::$app->formatter->asDatetime($publish_date)?></span>  and <span style = "color:dimgray;"><?=Yii::$app->formatter->asDatetime($end_clarification_days_interval)?></span></div>

    </div>
  
</div>
<div class="col">
    <?= $form->field($model, 'bidmeet')->label('Bid Meet Date * <small class="text-muted">eg.10-12-2025 03:00 AM</small>')->widget(DatePicker::class, [
    'language' => 'ru',
    'dateFormat' => 'MM/dd/yyyy',
    'options' => [
        'class' => 'form-control',
        'type' => 'date', // Use 'text' type instead of 'date' to ensure consistent behavior across browsers
        'id'=> 'bidmeet-input'
    ],
    'value' => Yii::$app->formatter->asDate($model->bidmeet, 'MM/dd/yyyy'), // Set the value of the date picker
]) ?>
<?php
$tender_by_id = Tender::findOne($tenderId);
$publish_date = $tender_by_id->publish_at;
$submit_date = $tender_by_id->expired_at;

$end_clarification_days= Setting::findOne(1);
$end_clarification= $end_clarification_days->end_clarification;
$end_clarification_days_interval=$submit_date  - ($end_clarification * 3600 * 24);


?>
<div id="bidmeet-warning" style="display: none; color: red;"><i class="fas fa-warning" style="color:orange ;"></i> Date must be between <span style = "color:dimgray;"><?=Yii::$app->formatter->asDatetime($publish_date)?></span>  and <span style = "color:dimgray;"><?=Yii::$app->formatter->asDatetime($end_clarification_days_interval)?></span></div>


    </div>
</div>
</div>
    <?= $form->field($model, 'tender_id')->hiddenInput(['value' => $tenderId])->label(false) ?>

  
<?php
$tender_by_id = Tender::findOne($tenderId);
$publish_date = $tender_by_id->publish_at;
$submit_date = $tender_by_id->expired_at;

$end_clarification_days = Setting::findOne(1);
$end_clarification = $end_clarification_days->end_clarification;
$end_clarification_days_interval = $submit_date - ($end_clarification * 3600 * 24);

$model->end_clarificatiion = date('m/d/Y', $end_clarification_days_interval);
?>
    <?= $form->field($model, 'end_clarificatiion')->hiddenInput(['value' => $model->end_clarificatiion ])->label(false) ?>

<div class="form-row">
    <div class="col">
    <?= $form->field($model, 'tender_security')->label('Tender Security * <small class="text-muted">eg.security declaration</small>')->dropDownList(
    [
        1 => 'a. Security Declaration',
        2 => 'b. Bid/Tender Security Amount',
        3 => 'c. Bid/Tender Security Percent',
    ],
    [
        'id' => 'tender-security-dropdown',
        'prompt' => 'Select security type',
    ]
) ?>

<div id="add-form" style="display: none;">
    <div class="form-row">
        <div class="col-6">
            <?= $form->field($model, 'amount')->label('Amount* <small class="text-muted">TSH</small>')->textInput(['type'=>'number','placeholder'=>'TSH', 'id' => 'amount-input'])?>
        </div>
    </div>
</div>

<div id="add-formp" style="display: none;">
        <div class="form-row">
        <div class="col-6">
            <?= $form->field($model, 'percentage')->label('Percentage <small class="text-muted">%</small>')->textInput(['type'=>'number','placeholder'=>'%', 'id' => 'percentage-input']) ?>
        </div>
        </div>
  
</div>

    </div>
    <div class="col-6">
    <?php echo $form->field($model, 'office')->label('Office * <small class="text-muted">eg. Dodoma/Dar es salaam/Zanzibar</small>')->dropDownList(
        ArrayHelper::map($office, 'id', function ($item) {
            return '<i class="fas fa-map-marker-alt" style="color: blue;"></i> ' . $item['location'];
        }),
        [
            'prompt' => '<i class="glyphicon glyphicon-envelope" style="color: blue;"></i> Office',
            'encode' => false, // Prevents HTML entities from being encoded
            'class' => 'form-control', // Add the desired CSS class for styling
        ]
    ); ?>
  
</div>
</div>

<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end(); ?>



</div>
<?php
// Embed the JavaScript code
$script = <<< JS
// Listen for changes in the site_visit dropdown
$('#site-visit-dropdown').on('change', function() {
    var selectedValue = $(this).val();
    
    // Show or hide the additional form based on the selected value
    if (selectedValue == 1) {
        $('#additional-form').show();
    } else {
        $('#additional-form').hide();
    }
});

// Check the initial value of the site_visit dropdown on page load
$(document).ready(function() {
    var selectedValue = $('#site-visit-dropdown').val();
    
    // Show or hide the additional form based on the selected value
    if (selectedValue == 1) {
        $('#additional-form').show();
    } else {
        $('#additional-form').hide();
    }
});

JS;

$this->registerJs($script);
?>
<?php
$tender_by_id = Tender::findOne($tenderId);
$submit_date = $tender_by_id->expired_at;

$end_clarification_days= Setting::findOne(1);

$end_clarification=$end_clarification_days->end_clarification;

$end_clarification_days_interval=$submit_date  - ($end_clarification * 3600 * 24);
?>
<script>
// Get the publish date input element
var sitevisitDateInput = document.getElementById('site-visit-date-input');

// Add an event listener to the change event
sitevisitDateInput.addEventListener('change', function() {
  // Get the entered publish date and current date
  var enteredDate = new Date(this.value);
  var currentDate = new Date();
  
  var submitDate = new Date("<?php echo date('Y/m/d',$end_clarification_days_interval); ?>"); // Subtract 7 days from the submitted date

  // Compare the entered publish date with the current date and submit date
  if (enteredDate < currentDate || enteredDate > submitDate) {
    // Display a warning message
    var warningMessage = document.getElementById('site-visit-date-warning');
    warningMessage.style.display = 'block';
  } else {
    // Hide the warning message
    var warningMessage = document.getElementById('site-visit-date-warning');
    warningMessage.style.display = 'none';
  }
});
</script>


<script>

var bidmeetInput = document.getElementById('bidmeet-input');

// Add an event listener to the change event
bidmeetInput.addEventListener('change', function() {
  // Get the entered publish date and current date
  var enteredDate = new Date(this.value);
  var currentDate = new Date();
  
  var submitDate = new Date("<?php echo date('Y/m/d',$end_clarification_days_interval); ?>"); // Subtract 7 days from the submitted date

  // Compare the entered publish date with the current date and submit date
  if (enteredDate < currentDate || enteredDate > submitDate) {
    // Display a warning message
    var warningMessage = document.getElementById('bidmeet-warning');
    warningMessage.style.display = 'block';
  } else {
    // Hide the warning message
    var warningMessage = document.getElementById('bidmeet-warning');
    warningMessage.style.display = 'none';
  }
});
</script>


<script>

var end_clarificatiionInput = document.getElementById('end_clarificatiion-input');

// Add an event listener to the change event
end_clarificatiionInput.addEventListener('change', function() {
  // Get the entered publish date and current date
  var enteredDate = new Date(this.value);
  var currentDate = new Date();
  
  var submitDate = new Date("<?php echo date('Y/m/d',$end_clarification_days_interval); ?>"); // Subtract 7 days from the submitted date

  // Compare the entered publish date with the current date and submit date
  if (enteredDate < currentDate || enteredDate >= submitDate) {
    // Display a warning message
    var warningMessage = document.getElementById('end_clarificatiion-warning');
    warningMessage.style.display = 'block';
  } else {
    // Hide the warning message
    var warningMessage = document.getElementById('end_clarificatiion-warning');
    warningMessage.style.display = 'none';
  }
});
</script>