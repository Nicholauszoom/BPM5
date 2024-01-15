<?php

use app\models\Activity;
use app\models\Activitydetil;
use app\models\Adetail;
use app\models\Compldoc;
use app\models\Eligibactivity;
use app\models\Eligibdetail;
use app\models\Eligibdone;
use app\models\Office;
use app\models\Tattachmentss;
use app\models\Tcomment;
use app\models\Tdetails;
use app\models\User;
use app\models\UserActivity;
use yii\helpers\Html;
use yii\widgets\DetailView;

use function PHPUnit\Framework\isEmpty;

/** @var yii\web\View $this */
/** @var app\models\Tender $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tenders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->context->layout = 'admin';
$expireDater=$model->expired_at;

$t_attachmentss=Tattachmentss::findOne(['tender_id'=>$model->id]);
$tattachmentst = Tattachmentss::find()->where(['tender_id'=>$model->id])->all();
$userId = Yii::$app->user->id;
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
.bar{
    display: flex;
    margin-top: 80px;
    
}
.bar li{
    list-style: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    
}
.bar li .icon{
    font-size: 30px;
    color:#63d19e;
    margin: 0 60px;
}
.bar li .text{
    font-size: 14px;
    font-weight: 600;
    color:rgba(68, 68, 68, 0.781);
}
 .bar-progrress {
        display: flex;
        align-items: center;
        justify-content: center;
        
        margin-bottom: 4%;
        height: 10px; /* Adjust the height as needed */
        width: 90%; /* Adjust the width as needed */
         /* Center the progress bar horizontally */
        
    }

/* Progress Div Css  */

.bar li .progress{
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: rgba(68, 68, 68, 0.781);
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
    width: 33%;
    height: 0;
}
.bar li .progress .uil{
    display: none;
}
.bar  li .progress p{
    font-size: 13px;
}

/* Active Css  */

.bar li .active{
    background-color:#63d19e;
    display: grid;
    place-items: center;
}
.bar li .active::after{
    background-color:#63d19e;
}
.bar li .active p{
    display: none;
}
.bar li .active .uil{
    font-size: 20px;
    display: flex;
}

/* Responsive Css  */

@media (max-width: 980px) {
    .bar{
        flex-direction: column;
    }
    .bar li{
        flex-direction: row;
    }
    .bar li .progress{
       
    }
    .progress::after{
        width: 33%;
        height: 55px;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: -1;
    }
    .one::after{
        height: 0;
    }
    .bar li .icon{
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
span{
    color:grey;
}
.back-arrow{
    color:grey;
}

.table-container {
    overflow-x: auto;
    max-width: 100%;
}

.styled-table {
    width: max-content;
    border-collapse: collapse;
}

.styled-table th,
.styled-table td {
    padding: 8px;
    border: 1px solid #ddd;
}

.styled-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.styled-table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

#counter {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: royalblue;
        padding: 10px;
        color: white;
        text-align: center;
        font-size: 16px;
    }

    .overflow-scroll {
    max-width: 90%;
    overflow-x: auto;
}
</style>




<a href="<?= Yii::$app->request->referrer ?>" class="back-arrow">
<span class="fas fa-arrow-left"></span> Back
</a>


<div id="main-content ">
    
   
    <div id="page-container">
        <!-- ============================================================== -->
        <!-- Sales Cards  -->
        <!-- ============================================================== -->
        <div class="row"></div>
<div class="tender-view">



    <h1><?= Html::encode($this->title) ?></h1>

   
<div class="bar-progrress mt-2 mb-5">
<ul class="bar">
    <li>

        <div class="progress one<?= $model->status <= 5 ? ' active' : '' ?>">
            <p></p>
            <i class="uil uil-check"></i>
        </div>
     
        <p style="font-size: 1px small;">step 1(registration)----------------------------</p>
      
    </li>
    <li>
        
        <div class="progress two<?= $model->status <= 3 ? ' active' : '' ?>">
            <p></p>
            <i class="uil uil-check"></i>
        </div>
    
        <p>step 2(submit)----------------------------</p>
    </li>
    <li>
     
        <div class="progress three<?= $model->status <= 1 ? ' active' : '' ?>">
            <p></p>
            <i class="uil uil-check"></i>
        </div>
     
        <p>----------------------------step 3(awarded)</p>
    </li>
</ul>
</div>

<p>

<?php if (Yii::$app->user->can('admin') && Yii::$app->user->can('author')) : ?>

        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('manage activity', ['/adetail/create', 'tenderId' => $model->id], ['class' => 'btn btn-warning']) ?>
<?php if ($model->expired_at <= strtotime(date('Y-m-d'))) : ?>


    <?php 
      $submit_conf=Compldoc::find()->where(['tender_id'=>$model->id])->all(); 
    ?>
<?php if($model->status===5 && !empty( $submit_conf)):?>
<?= Html::a('Submit', ['submitst', 'tenderId' => $model->id], [
            'class' => 'btn btn-secondary',
            'data' => [
                'confirm' => 'Are you sure you want to change the status to Submit of this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif;?>

<?php if($model->status===5):?>
<?= Html::a('Not Submit', ['nonsubmitst', 'tenderId' => $model->id], [
            'class' => 'btn btn-secondary',
            'data' => [
                'confirm' => 'Are you sure you want to change the status to Not Submit of this item?',
                'method' => 'post',
            ],
        ]) ?>
<?php endif;?>
<?php
$hasContract = false;
foreach ($tattachmentst as $tattachment) {
    if ($tattachment->contract !== null) {
        $hasContract = true;
        break;
    }
}
?>

<?php if ($hasContract): ?>


    <?php if ($model->status === 3): ?>

<?= Html::a('Award', ['award', 'tenderId' => $model->id], [
    'class' => 'btn btn-success',
    'data' => [
        'confirm' => 'Are you sure you want to change the status to Award of this item?',
        'method' => 'post',
    ],
]) ?>
<?php endif;?>
<?php endif;?>

<?php if($model->status===3):?>
<?= Html::a('Not Award', ['unsucess', 'tenderId' => $model->id], [
            'class' => 'btn btn-secondary',
            'data' => [
                'confirm' => 'Are you sure you want to change the status to Not Award of this item?',
                'method' => 'post',
            ],
        ]) ?>
<?php endif;?>

<?php endif;?>

<?php endif;?>

<?php 
$comp=Compldoc::findOne(['user_id'=>$userId,'tender_id'=>$model->id]);
?>

<?php if ($model->expired_at > strtotime(date('Y-m-d')) && ((Yii::$app->user->can('author') && ! Yii::$app->user->can('admin'))) && $comp ===null) : ?>

<?= Html::a('Document', ['compldoc/create', 'tenderId' => $model->id], [
            'class' => 'btn btn-primary',
            'data' => [
                // 'confirm' => 'Are you sure you want to change the status to S of this item?',
                'method' => 'post',
            ],
        ]) ?>

<?php endif;?>
    </p>
    <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">General</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">More</button>
    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Assignment</button>
    <button class="nav-link" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled" type="button" role="tab" aria-controls="nav-disabled" aria-selected="false" >Required</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
  
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
                'attribute' => 'Supervisor',
                'format' => 'raw',
                'value' => function ($model) {
                    $adetailt = Adetail::findOne(['tender_id' => $model->id]);
                    $supervisorByName = 'Unknown';
            
                    if ($adetailt !== null) {
                        $supervisor = User::findOne($adetailt->supervisor);
                        $supervisorByName = $supervisor !== null ? $supervisor->username : 'Unknown';
                    }
            
                    return $supervisorByName;
                },
            ],
        //     [
        //     'attribute' => 'assigned_to',
        //     'format' => 'raw',
        //     'value' => function ($model) {
        //         $assignments = UserAssignment::find()
        //             ->where(['tender_id' => $model->id])
        //             ->all();
            
        //         $assignedUsernames = [];
            
        //         foreach ($assignments as $assignment) {
        //             $user = User::findOne($assignment->user_id);
        //             if ($user) {
        //                 $assignedUsernames[] = $user->username;
        //             }
        //         }
            
        //         return implode(', ', $assignedUsernames);
        //     },
        // ],


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
        // [
        //     'attribute' => 'Asign-to & compliance activity',
        //     'format' => 'raw',
        //     'value' => function ($model) {
        //         $assignments = UserActivity::find()
        //             ->where(['tender_id' => $model->id])
        //             ->all();
        
        //         $assignedUserActivities = [];
        
        //         foreach ($assignments as $assignment) {
        //             $user = User::findOne($assignment->user_id);
        //             $activity = Activity::findOne($assignment->activity_id);
        //             $adetail = Adetail::findOne(['user_id' => $assignment->user_id]);
        
        //             if ($user && $activity && $adetail) {
        //                 if (!isset($assignedUserActivities[$user->username])) {
        //                     $assignedUserActivities[$user->username] = [];
        //                 }
        //                 $assignedUserActivities[$user->username][] = [
        //                     'activityName' => $activity->name,
        //                     'submitDate' => Yii::$app->formatter->asDatetime($assignment->submit_at),
        //                     'section' => $adetail->section,
        //                     'assignmentId' => $assignment->id, // Add assignment ID for deletion
        //                 ];
        //             }
        //         }
        
        //         $tableRows = '';
        //         foreach ($assignedUserActivities as $username => $activities) {
        //             foreach ($activities as $index => $activity) {
        //                 $tableRows .= '<tr>';
        //                 if ($index === 0) {
        //                     $byuname=User::findOne(['username'=>$username]);
        //                     $compliance = Compldoc::findOne(['user_id' => $byuname->id,'tender_id'=>$model->id]);
        //                     $tableRows .= '<td rowspan="' . count($activities) . '">' . $username . '</td>';
        //                 }
        //                 $tableRows .= '<td>' . $activity['activityName'] . '</td>';
        //                 $tableRows .= '<td>' . $activity['submitDate'] . '</td>';
        //                 $sessionValue = $compliance['session'] ?? null;
        //                 $tableRows .= '<td>';
        //                 if ($sessionValue === 1) {
        //                     $tableRows .= '<span class="label label-success">Complete</span>';
                            
        //                 }
        //                 $tableRows .= '</td>';
                        
        //                 $created = $compliance['created_at'] ?? null;
        //                 $tableRows .= '<td>';
        //                 if ($created !== null) {
        //                     $formattedDate = Yii::$app->formatter->asDate($compliance['created_at']);
        //                     $tableRows .= $formattedDate;
        //                 }
        //                 $tableRows .= '</td>';
        //                 $tableRows .= '</tr>';
        //             }
        //         }
        
        //         $table = '
        //             <table class="styled-table">
        //                 <thead>
        //                     <tr>
        //                         <th>User</th>
        //                         <th>Activity Name</th>
        //                         <th>Submit Date</th>
        //                         <th>Session</th>
        //                         <th>Date</th>
        //                     </tr>
        //                 </thead>
        //                 <tbody>
        //                     ' . $tableRows . '
        //                 </tbody>
        //             </table>
        //         ';
        
        //         return $table;
        //     },
        // ],
        
            // [
            //     'attribute'=>'supervisor',
            //     'format'=>'raw',
            //     'value'=>function ($model){
            //         $createdByUser = User::findOne($model->supervisor);
            //         $createdByName = $createdByUser ? $createdByUser->username : 'Unknown';
            //          return $createdByName;
            //     },
            // ],
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


            // [
            //     'attribute' => 'submission',
            //     'format' => 'raw',
            //     'value' => function ($model) {
            //         $fileName = $model->submission;
            //         $filePath = Yii::getAlias('@webroot/upload/' . $fileName);
            //         $downloadPath = Yii::getAlias('@web/upload/' . $fileName);
            //         return $model->submission ? Html::a('<i class="fa fa-file-pdf" aria-hidden="true" style="font-size: 24px;"></i> ' . $model->submission, $downloadPath, ['class' => 'btn btn-', 'target' => '_blank']) : '';
            //     },
            // ],

            [
                'label' => 'Compliance Documents',
                'format' => 'raw',
                'value' => function ($model) {
                    $compldocuments = Compldoc::findAll(['tender_id' => $model->id]);
            
                    if (empty($compldocuments)) {
                        return '';
                    }
            
                    $documentAttributes = [
                        'document' => 'Tender Document',
                        // Add more document attributes here if needed
                    ];
            
                    $documentLinks = [];
            
                    foreach ($compldocuments as $compldocument) {
                        foreach ($documentAttributes as $attribute => $label) {
                            $fileName = $compldocument->{$attribute};
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

            
            // [
            //     'attribute' => 'submission',
            //     'format' => 'raw',
            //     'value' => function ($model) {
            //         return $model->submission ? Html::a('<i class="fa fa-download"></i> complete tender submitted document', Url::to($model->submission), ['class' => 'btn btn-warning']) : '';
            //     },
            // ],
           

            [
                'attribute' => 'coment',
                'format' => 'raw',
                'value' => function ($model) {
                    $comment=Tcomment::findOne(['tender_id'=>$model->id]);
                    
                    if ($comment===null) {
                       return 'no comment';
                    }
                    return $comment->comment;
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
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">

  <!--  TENDER MORE DETAILS -->
  <?php


if ($ttdetail !== null) {
    echo DetailView::widget([
        'model' => $ttdetail, // Use 'model' instead of 'ttdetail'
        'attributes' => [
            [
                'attribute' => 'tender_security',
                'label' => 'Tender Security',
                'value' => function ($model) {
                    return getSecurityLabel($model->tender_security);
                },
            ],
            'amount',
            'percentage',
            'bidmeet:datetime',
            'end_clarificatiion:datetime',
            'site_visit_date:datetime',
            [
                'attribute' => 'office',
                'value' => function ($model) {
                    $office = Office::findOne($model->office);
                    return $office->location;
                },
            ],
        ],
    ]);
}
?>

</div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
  <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
         
        [
            'attribute' => 'Asign-to & compliance activity',
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
                    $compdoc = Compldoc::findOne(['tender_id' => $model->id, 'user_id' => $assignment->user_id]);
                
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
                        $byuname = User::findOne(['username' => $username]);
                        $userIdlogger = Yii::$app->user->id;
                
                        if ((Yii::$app->user->can('admin') && Yii::$app->user->can('author')) || $userIdlogger == $byuname->id) {
                            $tableRows .= '<tr>';
                            if ($index === 0) {
                                $byuname = User::findOne(['username' => $username]);
                                $compliance = Compldoc::findOne(['user_id' => $byuname->id, 'tender_id' => $model->id]);
                
                                $tableRows .= '<td rowspan="' . count($activities) . '">' . $username . '</td>';
                            }
                            $tableRows .= '<td><a href="' . \yii\helpers\Url::to(['compldoc/create', 'tenderId' => $model->id]) . '">' . $activity['activityName'] . '</a></td>';
                            $tableRows .= '<td>' . $activity['submitDate'] . '</td>';
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
                
                            if (isset($activity['compdoc']) && $activity['compdoc'] !== null && $activity['compdoc']->document === null) {
                                $eligibdone = Eligibdone::find()
                                    ->where(['compldoc_id' => $activity['compdoc']->id, 'user_id' => $byuname->id, 'tender_id' => $model->id])
                                    ->all();
                
                                $eligib = [];
                
                                foreach ($eligibdone as $eligibdoneItem) {
                                    $activitydetail = Activitydetil::findOne($eligibdoneItem->eligibd_id);
                
                                    if ($activitydetail !== null) {
                                        $eligib[] = $activitydetail->title;
                                    }
                                }
                
                                $tableRows .= '<td>' . implode(', ', $eligib) . '</td>';
                            } else {
                                $tableRows .= '<td>';
                                if ($activity['compdoc'] !== null) {
                                    $fileName = $activity['compdoc']->document;
                                    $filePath = Yii::getAlias('@webroot/upload/' . $fileName);
                                    $downloadPath = Yii::getAlias('@web/upload/' . $fileName);
                                    $documentLink = Html::a('<i class="glyphicon glyphicon-download-alt"></i>' . $fileName, $downloadPath, ['target' => '_blank']);
                                    $tableRows .= $documentLink;
                                }
                                $tableRows .= '</td>';
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
    'model' => $model,
    'attributes' => [
        [
            'label' => 'Asign-to & compliance activity',
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
                    $compdoc = Compldoc::findOne(['tender_id' => $model->id, 'user_id' => $assignment->user_id]);
                    
                   
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
                                $user_actvty = Eligibdetail::find()->where(['tender_id' => $model->id, 'user_id' => $byuname->id])->all();
                            
                                $elgibledetailactivity = [];
                                foreach ($user_actvty as $eligibdetail) {
                                    $elgib_activity = Eligibactivity::findOne($eligibdetail->activitydetail_id);
                                    $actvt_detail = Activitydetil::findOne($eligibdetail->adetail_id);
                                    // $elgibledetailactivityById = Activitydetil::findOne($eligibdetail->activitydetail_id);
                                    $elgibledetailactivity[] = $actvt_detail->title;
                                }
                            
                                $tableRows .= '<td rowspan="' . count($activities) . '">' . $username . '</td>';
                            
                                if (!empty($user_actvty)) {
                                    $tableRows .= '<td><div class="overflow-scroll">' . implode(', ', $elgibledetailactivity) . '</div></td>';
                                


                                    $url = Yii::$app->urlManager->createUrl([
                                        'eligibactivity/create',
                                        'tenderId' => $model->id,
                                        'adetailId' => $eligibdetail->activitydetail_id,
                                        'userId' => $byuname->id
                                    ]);
                                    $tableRows .= '<td><a href="' . $url . '"><i class="fa fa-pencil"></i></a></td>';


                                } else {
                                    $tableRows .= '<td>' . 'document submission' . '</td>';
                                }
                            }

                            // if (!empty($user_actvty)) {
                            //     $tableRows .= '<td><a href="' . Yii::$app->urlManager->createUrl(['eligibactivity/create', 'tenderId' => $model->id]) . '"><i class="fa fa-plus"></i></a></td>';
                            // }


                          
                            

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
                            <th>Action </th>
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


</div>





    </div>

  
   
</div>
<div id="counter" class="m-1" style="background:royalblue;"></div>

<?php
    function getStatusLabel($status)
{
    $statusLabels = [
      1 => 'YES',
      2 => 'NO',
     
    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}

function getSecurityLabel($status)
{
    $statusLabels = [
      1 => 'Security Declaration',
      2 => 'Bid/Tender Security',
     
    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}


function getStatustLabel($status)
{
    $statusLabels = [
        1 => '<span class="badge badge-success">awarded</span>',
        2 => '<span class="badge badge-warning">not-awarded</span>',
        3 => '<span class="badge badge-secondary">submitted</span>',
        4 => '<span class="badge badge-secondary">not-submtted</span>',
        5 => '<span class="badge badge-secondary">on-progress</span>',
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


    function deleteRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

</script>


<script>
$(document).ready(function() {
    console.log('JavaScript code is executing.');
    // Add a click event listener to the award button
    $('#award-button').click(function() {
        var tenderId = <?= $model->id ?>; // Assuming $tenderId is the variable that holds the tender ID in your view file
        
        // Make an AJAX request
        $.ajax({
            url: '/TenderController/award?tenderId=' + tenderId, // Replace with the actual controller and action
            type: 'POST',
            data: {status: 1}, // Data to be sent to the server
            success: function(response) {
                // Handle the success response
                console.log('Award button clicked successfully');
            },
            error: function(xhr, status, error) {
                // Handle the error response
                console.error('Error occurred while clicking the award button');
            }
        });
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>