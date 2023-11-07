<?php

use app\models\Activity;
use app\models\Adetail;
use app\models\User;
use app\models\UserActivity;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserActivity $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-activity-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-row">
        <div class="col">
            
        <?php
 $user= User::find()->all();
?>
        <?= $form->field($model, 'user_id')->label('Description * <small class="text-muted">eg.information on tender</small>')->dropDownList(
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

        <?= $form->field($model, 'activity_id')->checkboxList(
    ArrayHelper::map($activity, 'id', 'name'),
    ['prompt' => 'Select Activity', 'id' => 'activity']
)?>

        </div>
        <div class="col">

<?= $form->field($model, 'section')->label('Document Section  <small class="text-muted">eg.SECTION II: BID DATA SHEET (BDS)</small>')->textInput(['placeholder'=>'Assign task in section..'])?>

</div>

    </div>

    <div class="form-row">
        <div class="col">
        <?= $form->field($model, 'supervisor')->label('Supervisor *<small class="text-muted">eg.tender member</small>')->dropDownList(
   
   ArrayHelper::map($user, 'id', 'username'),
   ['prompt' => 'Select Supervisor', 'id' => 'supervisor']
)?>
        </div>

        <div class="col">
        <?= $form->field($model, 'submit_at')->label('Date of Submition  *<small class="text-muted">eg.tender member</small>')->widget(DatePicker::class, [
    'language' => 'ru',
    'dateFormat' => 'MM/dd/yyyy',
    'options' => [
        'class' => 'form-control',
        'type' => 'date', // Use 'text' type instead of 'date' to ensure consistent behavior across browsers
        // $model->start_at => ['selected' => true]
        'value' => Yii::$app->formatter->asDate($model->submit_at, 'MM/dd/yyyy'), // Set the value of the date picker

    ],
]) ?>
        </div>
    </div>


    <?= $form->field($model, 'tender_id')->hiddenInput(['value'=>$tenderId])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
