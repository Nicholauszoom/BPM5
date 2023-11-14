<?php

// use yii\bootstrap\BootstrapAsset;
// use yii\bootstrap5\BootstrapAsset;

// BootstrapAsset::register($this);
// BootstrapAsset::register($this);

use app\models\Department;
use app\models\User;
use yii\helpers\Html;
use yii\jui\DatePicker;
// use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tender $model */
/** @var yii\widgets\ActiveForm $form */
// $this->registerAssetBundle(BootstrapAsset::class);
$users=User::find()->all();
$department=Department::find()->all();
?>

<div class="tender-form">

    <?php $form = ActiveForm::begin(['id'=>'my-form']); ?>
    <?php if (Yii::$app->user->can('admin')) : ?>
        <div class="form-row">
    <div class="col">
        <?= $form->field($model, 'title', ['template' => "{label}\n<div class='input-group'>{input}\n<span class='input-group-addon'><i class='fa fa-pencil'></i></span></div>\n{error}"])->label('Title * <small class="text-muted">eg.Upgrading of Africana-Kinzudi(0.5Km) road</small>')->textInput(['maxlength' => true, 'placeholder'=>''])?>
    </div>
    <div class="col">
    <?= $form->field($model, 'PE', ['template' => "{label}\n<div class='input-group'>{input}\n<span class='input-group-addon'><i class='fa fa-home'></i></span></div>\n{error}"])->label('Procurement Entity * <small class="text-muted">eg.TARURA - DAR ES SALAAM REGIONAL</small>')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
</div>
    <div class="col">
        <?= $form->field($model, 'TenderNo', ['template' => "{label}\n<div class='input-group'>{input}\n<span class='input-group-addon'><i class='fas fa-barcode'></i></span></div>\n{error}"])->label('Tender Number * <small class="text-muted">eg.S10/002/2023/2024/W/69</small>')->textInput(['maxlength' => true,'placeholder'=>''])?>
    </div>
</div>

<div class="form-row">
    <div class="col mt-3">
   
    <?= $form->field($model, 'document')->label('Attachment * <small class="text-muted"></small>')->fileInput()?>
    </div>
    <div class="col">
 <?= $form->field($model, 'description')->label('Description * <small class="text-muted">eg.information on tender</small>')->textarea(['placeholder'=>'add description..'])?>
</div>
    <div class="col">
    
    <?php endif; ?>
 

<?php if (Yii::$app->user->can('admin')) : ?>   
    
  <?= $form->field($model, 'status', ['template' => "{label}\n<div class='input-group'>{input}\n<span class='input-group-addon'><i class='fa fa-info'></i></span></div>\n{error}"])
    ->label('Status * <small class="text-muted">eg.awarded</small>')
    ->dropDownList(
        [
            1 => 'awarded',
            2 => 'not-awarded',
            3 => 'submitted',
            4 => 'not submitted',
            5 => 'on-progress',
        ],
        [
            'prompt' => 'Select tender Status', // Disable the field if the expiration date is not greater than the current date
            'options' => [
                5 => ['selected' => true] // Set 'on-progress' as the default selected option
            ]
        ]
    );
?>

</div>

<?php endif; ?>
</div>

<?php if (Yii::$app->user->can('admin')) : ?>
<div class="form-row">

<div class="col">
<?= $form->field($model, 'publish_at')->label('Date of Publication/Invitation * <small class="text-muted">eg.16 Nov 2023 2:00 PM</small>')->widget(DatePicker::class, [
    'language' => 'ru',
    'dateFormat' => 'MM/dd/yyyy',
    'options' => [
        'class' => 'form-control',
        'type' => 'date', // Use 'text' type instead of 'date' to ensure consistent behavior across browsers
        'id' => 'publish-date-input', // Add an ID to the input field for easier identification
    ],
    'value' => Yii::$app->formatter->asDate($model->publish_at, 'MM/dd/yyyy'), // Set the value of the date picker
]) ?>
<div id="publish-date-warning" style="display: none; color: red;"> <i class="fas fa-warning" style="color:orange ;"></i> Date must be less or equal to the current date.</div>


</div>

<div class="col">

<?= $form->field($model, 'expired_at')->label('Bid submission deadline date * <small class="text-muted">eg.16 Nov 2023 2:00 PM</small>')->widget(DatePicker::class, [
    'language' => 'ru',
    'dateFormat' => 'MM/dd/yyyy',
    'options' => [
        'class' => 'form-control',
        'type' => 'date', // Use 'text' type instead of 'date' to ensure consistent behavior across browsers
        'id'=>'submit-date-input'
    ],
    'value' => Yii::$app->formatter->asDate($model->expired_at, 'MM/dd/yyyy'), // Set the value of the date picker
]) ?>
<div id="submit-date-warning" style="display: none; color: red;"><i class="fas fa-warning" style="color:orange ;"></i> Date must be greater to publish date</div>

</div>
</div>
  

<?php endif; ?>
    <?php if (Yii::$app->user->can('author') && !Yii::$app->user->can('author')) : ?>

    <?= $form->field($model, 'submission')->fileInput()?>
 
<?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

 
</div>
<script> 


// Get the publish date input element
var publishDateInput = document.getElementById('publish-date-input');

// Add an event listener to the change event
publishDateInput.addEventListener('change', function() {
  // Get the entered publish date and current date
  var enteredDate = new Date(this.value);
  var currentDate = new Date();

  // Remove the time information from the current date
//   currentDate.setHours(0, 0, 0, 0);

  // Compare the entered publish date with the current date
  if (enteredDate > currentDate) {
    // Display a warning message
    var warningMessage = document.getElementById('publish-date-warning');
    warningMessage.style.display = 'block';
  } else {
    // Hide the warning message
    var warningMessage = document.getElementById('publish-date-warning');
    warningMessage.style.display = 'none';
  }

});

//submit date script
//Get the submit date input element
var submitDateInput = document.getElementById('submit-date-input');

// Add an event listener to the change event
submitDateInput.addEventListener('change', function() {
  // Get the entered publish date and current date
  var enterDate = new Date(this.value);
  var currentDate = new Date();

//   Remove the time information from the current date
  currentDate.setHours(0, 0, 0, 0);

  // Compare the entered publish date with the current date
  if (enterDate < currentDate) {
    // Display a warning message
    var warningMessage = document.getElementById('submit-date-warning');
    warningMessage.style.display = 'block';
  } else {
    // Hide the warning message
    var warningMessage = document.getElementById('submit-date-warning');
    warningMessage.style.display = 'none';
  }

});

</script>