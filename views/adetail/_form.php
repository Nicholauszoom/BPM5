<?php

use app\models\Activity;
use app\models\Adetail;
use app\models\Setting;
use app\models\Tender;
use app\models\User;
use app\models\UserActivity;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserActivity $model */
/** @var yii\widgets\ActiveForm $form */

$tender_by_id = Tender::findOne($tenderId);
$publish_date = $tender_by_id->publish_at;
$submit_date = $tender_by_id->expired_at;

$end_clarification_days= Setting::findOne(1);
$end_clarification= $end_clarification_days->end_clarification;
$end_clarification_days_interval=$submit_date  - ($end_clarification * 3600 * 24);

?>
  <?php
        $user= User::find()->all();
         ?>
<div class="user-activity-form">
<small>The inputs with this <span style="color:red;">*</span> indicate are required to be fill and also End of clarification Date of this tender: <span style="color:red;"><?=Yii::$app->formatter->asDate($end_clarification_days_interval)?></span>  and submission date:<span style="color:red;"> <?=Yii::$app->formatter->asDate($submit_date)?></span> </small>

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-row">
        <div class="col">
        <?= $form->field($model, 'supervisor')->label('Supervisor *<small class="text-muted">eg.tender member</small>')->dropDownList(
   
   ArrayHelper::map($user, 'id', 'username'),
   ['prompt' => 'Select Supervisor', 'id' => 'supervisor']
)?>
    
        </div>
        <div class="col">
        <?= $form->field($model, 'section')->label('Document Section  <small class="text-muted">eg.SECTION II: BID DATA SHEET (BDS)</small>')->textInput(['placeholder'=>'Assign task in section..'])?>

        </div>
        <div class="col">
        <?= $form->field($model, 'activity_id')->checkboxList( ArrayHelper::map($activity, 'id', 'name'), ['prompt' => 'Select Activity', 'id' => 'activity'] )?>


</div>

    </div>

    <div class="form-row">
        <div class="col">
      
        <?= $form->field($model, 'user_id')->label('Assign To * <small class="text-muted">eg.select engineer</small>')->dropDownList(
    ArrayHelper::map($user, 'id', function ($user) use ($model) {
        $assignActivity = UserActivity::findOne(['user_id' => $user->id, 'tender_id' => $model->tender_id]);
        $label = $assignActivity && $assignActivity->assign == 1 ? '(assigned)' : '';

        $activityKind = UserActivity::findOne(['user_id' => $user->id, 'tender_id' => $model->tender_id]);
        $uactivity = $activityKind ? Activity::findOne(['id' => $activityKind->activity_id]) : null;

        $activity = $uactivity && $uactivity->name ? $uactivity->name  : '';
        return $user->username . ($label ? ' <span class="badge badge-success">' . $label . '</span>' : ''). ($activity ? ' <span class="badge badge-success">' . $activity . '</span>' : '');
    }),
    ['prompt' => 'Assigned to', 'id' => 'user-to', 'encode' => false]

) ?>

        </div>

        <div class="col">
        <?= $form->field($model, 'submit_at')->label('Date of Submition  *<small class="text-muted">eg.tender member</small>')->widget(DatePicker::class, [
    'language' => 'ru',
    'dateFormat' => 'MM/dd/yyyy',
    'options' => [
        'class' => 'form-control',
        'type' => 'date', // Use 'text' type instead of 'date' to ensure consistent behavior across browsers
        'id'=> 'submitat-input',
        // $model->start_at => ['selected' => true]
        'value' => Yii::$app->formatter->asDate($model->submit_at, 'MM/dd/yyyy'), // Set the value of the date picker

    ],
]) ?>
<?php
$tender_by_id = Tender::findOne($tenderId);
$publish_date = $tender_by_id->publish_at;
$submit_date = $tender_by_id->expired_at;

$end_clarification_days= Setting::findOne(1);
$end_clarification= $end_clarification_days->end_clarification;
$end_clarification_days_interval=$submit_date  - ($end_clarification * 3600 * 24);


?>
<div id="submitat-warning" style="display: none; color: red;"><i class="fas fa-warning" style="color:orange ;"></i> Date must be between <span style = "color:dimgray;"><?=Yii::$app->formatter->asDatetime($publish_date)?></span>  and <span style = "color:dimgray;"><?=Yii::$app->formatter->asDatetime($submit_date)?></span></div>

        </div>
    </div>


    <?= $form->field($model, 'tender_id')->hiddenInput(['value'=>$tenderId])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>

var submitatInput = document.getElementById('submitat-input');

// Add an event listener to the change event
submitatInput.addEventListener('change', function() {
  // Get the entered publish date and current date
  var enteredDate = new Date(this.value);
  var currentDate = new Date();
  
  var submitDate = new Date("<?php echo date('Y/m/d',$submit_date); ?>"); // Subtract 7 days from the submitted date

  // Compare the entered publish date with the current date and submit date
  if (enteredDate < currentDate || enteredDate > submitDate) {
    // Display a warning message
    var warningMessage = document.getElementById('submitat-warning');
    warningMessage.style.display = 'block';
  } else {
    // Hide the warning message
    var warningMessage = document.getElementById('submitat-warning');
    warningMessage.style.display = 'none';
  }
});



</script>