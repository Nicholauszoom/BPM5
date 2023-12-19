<?php

use app\models\Activity;
use app\models\Activitydetil;
use app\models\Adetail;
use app\models\Compldoc;
use app\models\Eligibactivity;
use app\models\Eligibdetail;
use app\models\Eligibdone;
use app\models\Setting;
use app\models\Tender;
use app\models\User;
use app\models\UserActivity;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

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

<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">General</button>
    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Assignment</button>
    <button class="nav-link" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled" type="button" role="tab" aria-controls="nav-disabled" aria-selected="false" >Required</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
<div class="user-activity-form">
<small>The inputs with this <span style="color:red;">*</span> indicate are required to be fill and also End of clarification Date of this tender: <span style="color:red;"><?=Yii::$app->formatter->asDate($end_clarification_days_interval)?></span>  and submission date:<span style="color:red;"> <?=Yii::$app->formatter->asDate($submit_date)?></span> </small>

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-row">
        <div class="col">
        <?= $form->field($model, 'supervisor')->label('Supervisor *<small class="text-muted">eg.tender member</small>')->dropDownList(
             ArrayHelper::map($user, 'id', function ($user) use ($model) {
                $assignSupervisor = Adetail::findOne(['supervisor' => $user->id, 'tender_id' => $model->tender_id]);
                $label = $assignSupervisor && $assignSupervisor->assign == 1 ? '(assigned)' : '';
                return $user->username . ($label ? '........................ ' . $label . '' : '');
            }),
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
  </div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
  <?= DetailView::widget([
        'model' => $tender_by_id,
        'attributes' => [
         
        [
            'attribute' => 'Asign-to & compliance activity',
            'format' => 'raw',
            'value' => function ($tender_by_id) {
                $assignments = UserActivity::find()
                    ->where(['tender_id' => $tender_by_id->id])
                    ->all();
        
                $assignedUserActivities = [];
         
                foreach ($assignments as $assignment) {
                    $user = User::findOne($assignment->user_id);
                    $activity = Activity::findOne($assignment->activity_id);
                    $adetail = Adetail::findOne(['user_id' => $assignment->user_id]);
                    $compdoc = Compldoc::findOne(['tender_id' => $tender_by_id->id, 'user_id' => $assignment->user_id]);
                
                    if ($user && $activity && $adetail) {
                        if (!isset($assignedUserActivities[$user->username])) {
                            $assignedUserActivities[$user->username] = [];
                        }
                        $assignedUserActivities[$user->username][] = [
                            'activityName' => $activity->name,
                            'submitDate' => Yii::$app->formatter->asDatetime($assignment->submit_at),
                            'section' => $adetail->section,
                            'assignmentId' => $assignment->id, // Add assignment ID for deletion
                            'compdoc' => $compdoc, // Add compdoc variable
                        ];
                    }
                }
                
        
                $tableRows = '';
                foreach ($assignedUserActivities as $username => $activities) {
                    foreach ($activities as $index => $activity) {
                        $byuname=User::findOne(['username'=>$username]);

                         $userIdlogger = Yii::$app->user->id;

                        if((Yii::$app->user->can('admin')&&Yii::$app->user->can('author')) || $userIdlogger==$byuname->id){
                        $tableRows .= '<tr>';
                        if ($index === 0) {
                            $byuname=User::findOne(['username'=>$username]);
                            $compliance = Compldoc::findOne(['user_id' => $byuname->id,'tender_id'=>$tender_by_id->id]);

                            $tableRows .= '<td rowspan="' . count($activities) . '">' . $username . '</td>';

                        }
                        $tableRows .= '<td><a href="' . \yii\helpers\Url::to(['compldoc/create', 'tenderId' => $tender_by_id->id]) . '">' . $activity['activityName'] . '</a></td>';                        $tableRows .= '<td>' . $activity['submitDate'] . '</td>';
                        $sessionValue = $compliance['session'] ?? null;
                        $tableRows .= '<td>';
                        if ($sessionValue === 1) {
                            $tableRows .= '<span class="label label-success">Complete</span>';
                            
                        }
                        $tableRows .= '</td>';
                        
                        $created = $compliance['created_at'] ?? null;
                        $tableRows .= '<td>';
                        if ($created !== null) {
                            $formattedDate = Yii::$app->formatter->asDate($compliance['created_at']);
                            $tableRows .= $formattedDate;
                        }
                        $tableRows .= '</td>';
                      

                        if (isset($compdoc) && !empty($compdoc)) {
                            $eligibdone = Eligibdone::find()
                                ->where(['compldoc_id' => $compdoc->id, 'user_id' => $byuname->id, 'tender_id' => $tender_by_id->id])
                                ->all();
                            
                            $eligib = [];
                            
                            foreach ($eligibdone as $eligibdoneItem) {
                                $activitydetail = Activitydetil::findOne($eligibdoneItem->eligibd_id);
                                
                                if ($activitydetail !== null) {
                                    $eligib[] = $activitydetail->title;
                                }
                            }
                        
                            if (empty($eligibdone)) {
                                $tableRows .= '<td>';
                                $fileName = $compdoc->document;
                                $filePath = Yii::getAlias('@webroot/upload/' . $fileName);
                                $downloadPath = Yii::getAlias('@web/upload/' . $fileName);
                                $documentLink = Html::a('<i class="glyphicon glyphicon-download-alt"></i>' . $fileName, $downloadPath, ['target' => '_blank']);
                                $tableRows .= $documentLink;
                                $tableRows .= '</td>';
                            } else {
                               
                               
                                $tableRows .= '<td>' . implode(', ', $eligib) . '</td>';
                            }
                        }
                        
                        
                        $tableRows .= '</tr>';
                    }
                    }
                }
        
                $table = '
                    <table class="styled-table">
                        <thead>
                            <tr>
                            <th>User</th>
                            <th>Activity Name</th>
                            <th>Required Date</th>
                            <th>Status</th>
                            <th>Submit Date</th>
                            <th>Work</th>
                            </tr>
                        </thead>
                        <tbody>
                            ' . $tableRows . '
                        </tbody>
                    </table>
                ';
        
                return $table;
            },
        ],
        
     
           
         
        ],
    ]) ?>

</div>
<div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">
  <?= DetailView::widget([
        'model' => $tender_by_id,
        'attributes' => [
         
        [
            'attribute' => 'Asign-to & compliance activity',
            'format' => 'raw',
            'value' => function ($tender_by_id) {
                $assignments = UserActivity::find()
                    ->where(['tender_id' => $tender_by_id->id])
                    ->all();
        
                $assignedUserActivities = [];
         
                foreach ($assignments as $assignment) {
                    $user = User::findOne($assignment->user_id);
                    $activity = Activity::findOne($assignment->activity_id);
                    $adetail = Adetail::findOne(['user_id' => $assignment->user_id]);
                    $compdoc = Compldoc::findOne(['tender_id' => $tender_by_id->id, 'user_id' => $assignment->user_id]);
                    
                   
                    $eligibdetail=Eligibdetail::find()->where(['adetail_id'=>$adetail->tender_id])->all();
                
                    if ($user && $activity && $adetail) {
                        if (!isset($assignedUserActivities[$user->username])) {
                            $assignedUserActivities[$user->username] = [];
                        }
                        $assignedUserActivities[$user->username][] = [
                            'activityName' => $activity->name,
                            'submitDate' => Yii::$app->formatter->asDatetime($assignment->submit_at),
                            'section' => $adetail->section,
                            'assignmentId' => $assignment->id, // Add assignment ID for deletion
                            'compdoc' => $compdoc, // Add compdoc variable
                            'eligibdetail'=>$eligibdetail,
                        ];
                    }
                }
                
        
                $tableRows = '';
                foreach ($assignedUserActivities as $username => $activities) {
                    foreach ($activities as $index => $activity) {
                        $byuname=User::findOne(['username'=>$username]);

                         $userIdlogger = Yii::$app->user->id;

                        if((Yii::$app->user->can('admin')&&Yii::$app->user->can('author')) || $userIdlogger==$byuname->id){


                            $tableRows .= '<tr>';
                            if ($index === 0) {
                                $byuname = User::findOne(['username' => $username]);
                                $user_actvty = Eligibdetail::find()->where(['tender_id' => $tender_by_id->id, 'user_id' => $byuname->id])->all();
                            
                                $elgibledetailactivity = [];
                                foreach ($user_actvty as $eligibdetail) {
                                    $elgib_activity = Eligibactivity::findOne($eligibdetail->activitydetail_id);
                                    $actvt_detail = Activitydetil::findOne($eligibdetail->adetail_id);
                                    // $elgibledetailactivityById = Activitydetil::findOne($eligibdetail->activitydetail_id);
                                    $elgibledetailactivity[] = $actvt_detail->title;
                                }
                            
                                $tableRows .= '<td rowspan="' . count($activities) . '">' . $username . '</td>';
                            
                                if (!empty($user_actvty)) {
                                    $tableRows .= '<td>' . implode(', ', $elgibledetailactivity) . '</td>';
                                } else {
                                    $tableRows .= '<td>' . 'document submission' . '</td>';
                                }
                            }
                            $tableRows .= '</tr>';
                    }
                    }
                }
        
                $table = '
                    <table class="styled-table">
                        <thead>
                            <tr>
                            <th>User</th>
                            <th>Required </th>
                            </tr>
                        </thead>
                        <tbody>
                            ' . $tableRows . '
                        </tbody>
                    </table>
                ';
        
                return $table;
            },
        ],
        
     
           
         
        ],
    ]) ?>
  

</div>
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