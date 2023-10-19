<?php

use app\models\Activity;
use app\models\Adetail;
use app\models\Department;
use app\models\Office;
use app\models\Tattachmentss;
use app\models\User;
use app\models\UserActivity;
use app\models\UserAssignment;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Tender $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tenders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->context->layout = 'admin';
$expireDater=$model->expired_at;
?>
<style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
@font-face {
    font-family: pop;
    src: url(./Fonts/Poppins-Medium.ttf);
}

.main{
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: pop;
    flex-direction: column;
}
.head{
    text-align: center;
}
.head_1{
    font-size: 30px;
    font-weight: 600;
    color: #333;
}
.head_1 span{
    color: #ff4732;
}
.head_2{
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-top: 3px;
}
ul{
    display: flex;
    margin-top: 80px;
}
ul li{
    list-style: none;
    display: flex;
    flex-direction: column;
    align-items: center;
}
ul li .icon{
    font-size: 30px;
    color:#63d19e;
    margin: 0 60px;
}
ul li .text{
    font-size: 14px;
    font-weight: 600;
    color:rgba(68, 68, 68, 0.781);
}
 .bar-progrress {
        display: flex;
        align-items: center;
        justify-content: center;
        margin:5%;
        margin-bottom: 4%;
        height: 10px; /* Adjust the height as needed */
        width: 90%; /* Adjust the width as needed */
         /* Center the progress bar horizontally */
        
    }

/* Progress Div Css  */

ul li .progress{
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: rgba(68, 68, 68, 0.781);
    margin: 14px 0;
    display: grid;
    place-items: center;
    color: #fff;
    position: relative;
    cursor: pointer;
}
.progress::after{
    content: " ";
    position: absolute;
    width: 125px;
    height: 5px;
    background-color: rgba(68, 68, 68, 0.781);
    right: 30px;
}
.one::after{
    width: 0;
    height: 0;
}
ul li .progress .uil{
    display: none;
}
ul li .progress p{
    font-size: 13px;
}

/* Active Css  */

ul li .active{
    background-color:#63d19e;
    display: grid;
    place-items: center;
}
li .active::after{
    background-color:#63d19e;
}
ul li .active p{
    display: none;
}
ul li .active .uil{
    font-size: 20px;
    display: flex;
}

/* Responsive Css  */

@media (max-width: 980px) {
    ul{
        flex-direction: column;
    }
    ul li{
        flex-direction: row;
    }
    ul li .progress{
        margin: 0 30px;
    }
    .progress::after{
        width: 5px;
        height: 55px;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: -1;
    }
    .one::after{
        height: 0;
    }
    ul li .icon{
        margin: 15px 0;
    }
}

@media (max-width:600px) {
    .head .head_1{
        font-size: 24px;
    }
    .head .head_2{
        font-size: 16px;
    }
}
</style>
<a href="<?= Yii::$app->request->referrer ?>" class="back-arrow">
    <span class="arrow">&#8592;</span> Back
</a>

<ul class="bar-progrress">
    <li>
        <i class="icon uil uil-spinner-alt"></i>
        <div class="progress one<?= $model->status <= 5 ? ' active' : '' ?>">
            <p></p>
            <i class="uil uil-check"></i>
        </div>
        <p class="text">Registration</p>
    </li>
    <li>
        <i class="icon uil uil-telegram"></i>
        <div class="progress two<?= $model->status <= 3 ? ' active' : '' ?>">
            <p></p>
            <i class="uil uil-check"></i>
        </div>
        <p class="text">Submittion</p>
    </li>
    <li>
        <i class="icon uil uil-trophy"></i>
        <div class="progress three<?= $model->status <= 1 ? ' active' : '' ?>">
            <p></p>
            <i class="uil uil-check"></i>
        </div>
        <p class="text">Awarded</p>
    </li>
</ul>


<div id="counter"></div>

<div id="main-content ">
    
   
    <div id="page-container">
        <!-- ============================================================== -->
        <!-- Sales Cards  -->
        <!-- ============================================================== -->
        <div class="row"></div>
<div class="tender-view">



    <h1><?= Html::encode($this->title) ?></h1>

    

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'PE',
            'TenderNo',
            'description',
            [
                'attribute' => 'publish_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            // 'expired_at',
            // [
            //     'attribute' => 'status',
            //     'value' => function ($model) {
            //         return getStatusLabel($model->status);
            //     },
            //     'format' => 'raw',
            //     'contentOptions' => function ($model) {
            //         return ['class' => getStatusClass($model->status)];
            //     },
            // ],
            [
                'attribute' => 'expired_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
            'attribute' => 'assigned_to',
            'format' => 'raw',
            'value' => function ($model) {
                $assignments = UserAssignment::find()
                    ->where(['tender_id' => $model->id])
                    ->all();
            
                $assignedUsernames = [];
            
                foreach ($assignments as $assignment) {
                    $user = User::findOne($assignment->user_id);
                    if ($user) {
                        $assignedUsernames[] = $user->username;
                    }
                }
            
                return implode(', ', $assignedUsernames);
            },
        ],


        // [
        //     'attribute' => 'activity_id',
        //     'format' => 'raw',
        //     'value' => function ($model) {
        //         $assignments = UserActivity::find()
        //             ->where(['tender_id' => $model->id])
        //             ->all();
        
        //         $assignedUsernames = [];
        
        //         foreach ($assignments as $assignment) {
        //             $user = User::findOne($assignment->user_id);
        //             $activity = Activity::findOne($assignment->activity_id);
        
        //             if ($user && $activity) {
        //                 $assignedUsernames[] = $user->username . ' - ' . $activity->name;
        //             }
        //         }
        
        //         return implode(', ', $assignedUsernames);
        //     },
        // ],
        [
            'attribute' => 'activity & roles',
            'format' => 'raw',
            'value' => function ($model) {
                $assignments = UserActivity::find()
                    ->where(['tender_id' => $model->id])
                    ->all();
        
                $assignedUserActivities = [];
        
                foreach ($assignments as $assignment) {
                    $user = User::findOne($assignment->user_id);
                    $activity = Activity::findOne($assignment->activity_id);
                    $adetail = Adetail::findOne(['user_id' => $assignment->user_id]);
        
                    if ($user && $activity && $adetail) {
                        if (!isset($assignedUserActivities[$user->username])) {
                            $assignedUserActivities[$user->username] = [];
                        }
                        $assignedUserActivities[$user->username][] = $activity->name . ' (Submit Date: ' . Yii::$app->formatter->asDatetime($assignment->submit_at) . ', Section: ' . $adetail->section . ')';
                    }
                }
        
                $assignedUsernames = [];
                foreach ($assignedUserActivities as $username => $activities) {
                    $assignedUsernames[] = $username . ' - ' . implode(', ', $activities);
                }
        
                return implode('<br>', $assignedUsernames);
            },
        ],
       

            [
                'attribute'=>'supervisor',
                'format'=>'raw',
                'value'=>function ($model){
                    $createdByUser = User::findOne($model->supervisor);
                    $createdByName = $createdByUser ? $createdByUser->username : 'Unknown';
                     return $createdByName;
                },
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            // 'created_at',
            // 'updated_at',
            [
                'attribute'=>'created_by',
                'format'=>'raw',
                'value'=>function ($model){
                    $createdByUser = User::findOne($model->created_by);
                    $createdByName = $createdByUser ? $createdByUser->username : 'Unknown';
                     return $createdByName;
                },
            ],
            [
                'attribute' => 'document',
                'format' => 'raw',
                'value' => function ($model) {
                    $fileName = $model->document;
                    $filePath = Yii::getAlias('@webroot/upload/' . $fileName);
                    $downloadPath = Yii::getAlias('@web/upload/' . $fileName);
                    return $model->document ? Html::a('<i class="fa fa-file-pdf" aria-hidden="true" style="font-size: 24px;"></i>' . $model->document, $downloadPath, ['class' => 'btn btn-', 'target' => '_blank']) : '';
                },
            ],


            [
                'attribute' => 'submission',
                'format' => 'raw',
                'value' => function ($model) {
                    $fileName = $model->submission;
                    $filePath = Yii::getAlias('@webroot/' . $fileName);
                    $downloadPath = Yii::getAlias('@web/.
                    ' . $fileName);
                    return $model->submission ? Html::a('<i class="fa fa-file-pdf" aria-hidden="true" style="font-size: 24px;"></i> ' . $model->submission, $downloadPath, ['class' => 'btn btn-', 'target' => '_blank']) : '';
                },
            ],

            
            // [
            //     'attribute' => 'submission',
            //     'format' => 'raw',
            //     'value' => function ($model) {
            //         return $model->submission ? Html::a('<i class="fa fa-download"></i> complete tender submitted document', Url::to($model->submission), ['class' => 'btn btn-warning']) : '';
            //     },
            // ],
            [
                'attribute'=>'submit_to',
                'format'=>'raw',
                'value'=>function ($model){
                    $department = Department::findOne($model->submit_to);
                    $departmentName =  $department ?  $department ->name : 'Unknown';
                     return $departmentName;
                },
            ],

            [
                'attribute' => 'coment',
                'format' => 'raw',
                'value' => function ($model) {
                    $tstatus = $model->status;
                    if ($tstatus==1 || $tstatus==3 ) {
                       return 'no comment';
                    }
                    return $model->coment;
                },
            ],
             
            [
                'attribute' => 'Tender Opening Doc',
                'format' => 'raw',
                'value' => function ($model) {
                    $attachment = Tattachmentss::findOne(['tender_id' => $model->id]);
                    if ($attachment && $attachment->document) {
                        $fileName = $attachment->document;
                        $filePath = Yii::getAlias('@webroot/upload/' . $fileName);
                        $fileUrl = Yii::getAlias('@web/upload/' . $fileName);
                        return '<embed src="' . $fileUrl . '" type="application/pdf" width="70%" height="200px" />';
                    }
                    return '';
                },
            ],
            [
                'label' => 'Documents',
                'format' => 'raw',
                'value' => function ($model) {
                    $attachments = Tattachmentss::findOne(['tender_id' => $model->id]);
            
                    if ($attachments === null) {
                        return '';
                    }
            
                    $documentAttributes = [
                        'evaluation' => 'Evaluation Letter',
                        'negotiation' => 'Negotiation Letter',
                        'award' => 'Award Letter',
                        'intention' => 'Intention Letter',
                        'arithmetic' => 'Arithmetic Letter',
                        'audit' => 'Audit Letter',
                        'cancellation' => 'Cancellation Letter',
                    ];
            
                    $documentLinks = [];
            
                    foreach ($documentAttributes as $attribute => $label) {
                        $fileName = $attachments->{$attribute};
                        if (!empty($fileName)) {
                            $filePath = Yii::getAlias('@webroot/upload/' . $fileName);
                            $downloadPath = Yii::getAlias('@web/upload/' . $fileName);
                            $documentLinks[] = $label . ': ' . Html::a($fileName, $downloadPath, ['target' => '_blank']);
                        }
                    }
            
                    return implode('<br>', $documentLinks);
                },
            ],

            // 'created_by',
            // 'document',
        ],
    ]) ?>




</div>



<center>
<h1 class="text-muted center mt-10" style=" color: blue;">More Details</h1>
</center>


<table class="table">
  <thead>
    <tr style="background-color: #f2f2f2;">
      <th scope="col">#</th>
      <th scope="col">Tender Security</th>
      <th scope="col">Bid Security Amount(tsh)</th>
      <th scope="col">Bid Security Percent(%)</th>
      <th scope='col'>Bid Meet Date</th>
      <th scope="col">End Clarification Date</th>
      <th scope='col'>Site visit date</th>
      <th scope='col'>Office</th>
      <td scope="col"></td>
      
    </tr>
  </thead>
  <tbody>
  <?php foreach ($tdetail as $tdetail): ?>
    <tr>
      <th scope="row">1</th>
      <td><?=getSecurityLabel($tdetail->tender_security)?></td>

      <td><?=$tdetail->amount?></td>
      <td><?=$tdetail->percentage?></td>

     <td><?= Yii::$app->formatter->asDatetime($tdetail->bidmeet)?></td>

      <td><?= Yii::$app->formatter->asDatetime($tdetail->end_clarificatiion) ?></td>

      <td><?= Yii::$app->formatter->asDatetime($tdetail->site_visit_date) ?></td>
      <?php 
      $office=Office::findOne($tdetail->office);
       $office_loca=$office->location;
      ?>
      <td><?= $office_loca?></td>

      <td>
               
                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['tdetail/update', 'id'=> $tdetail->id], [
                    'title' => 'edit',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]) ?>
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['tdetail/delete', 'id'=> $tdetail->id], [
                    'title' => 'edit',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]) ?>
            </td>
    

    </tr>
    <?php endforeach; ?>
    <tr>
      <td>
             
      <?= Html::a('+ Add',  [ 'tdetail/create' , 'tenderId'=> $model->id]) ?>
    </td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
</table>
    </div>

  
   
</div>


<?php
    function getStatusLabel($status)
{
    $statusLabels = [
      1 => '<span class="">YES</span>',
      2 => '<span class="">NO</span>',
     
    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}

function getSecurityLabel($status)
{
    $statusLabels = [
      1 => '<span class="">Security Declaration</span>',
      2 => '<span class="">Bid/Tender Security</span>',
     
    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}


?>
<script>
    // Specify the expired date for the tender (YYYY-MM-DD format)
    var expiredDate = "<?=Yii::$app->formatter->asDatetime($model->expired_at)?>";

    // Calculate the remaining time
    function calculateRemainingTime() {
        var now = new Date().getTime();
        var expiredTime = new Date(expiredDate).getTime();
        if(expiredTime > now){
        var remainingTime = expiredTime - now;
        }else{
            var remainingTime =0;
        }

        // Calculate days, weeks, hours, minutes, seconds, and milliseconds
        var days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
        var weeks = Math.floor(days / 7);
        var hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
        var milliseconds = Math.floor(remainingTime % 1000);

        // Display the remaining time in the HTML element with id "counter"
        document.getElementById('counter').innerHTML = 'Remaining Time Until Submition: ' +
            weeks + ' weeks, ' +
            days + ' days, ' +
            hours + ' hours, ' +
            minutes + ' minutes, ' +
            seconds + ' seconds, ' +
            milliseconds + ' milliseconds';

        // Update the remaining time every second
        setTimeout(calculateRemainingTime, 1000);
    }

    // Start the countdown
    calculateRemainingTime();



const one = document.querySelector(".one");
const two = document.querySelector(".two");
const three = document.querySelector(".three");
const four = document.querySelector(".four");
const five = document.querySelector(".five");

// Replace 'status' with the actual variable or value that holds the tender status
const status = model.status; // Assuming 'tender' is an object containing the Tender model data

// Reset all steps to inactive
function resetSteps() {
  one.classList.remove("active");
  two.classList.remove("active");
  three.classList.remove("active");
  four.classList.remove("active");
  five.classList.remove("active");
}

// Set the active steps based on the tender status
if (status === 1) {
  one.classList.add("active");
  two.classList.add("active");
  three.classList.add("active");
} else if (status === 3) {
  one.classList.add("active");
  two.classList.add("active");
} else if (status === 5) {
  one.classList.add("active");
} else if (status === 4) {
  one.classList.add("active");
} else {
  // Handle the case where status is not 1, 3, 4, or 5
  resetSteps();
}
</script>