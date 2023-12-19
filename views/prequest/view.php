<?php

use app\models\Analysis;
use app\models\Comment;
use app\models\Department;
use app\models\Item;
use app\models\Project;
use app\models\Rdetail;
use app\models\Tender;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Prequest $model */
$proj=Project::findOne($model->project_id);
$tendr=Tender::findOne($proj->tender_id);
$this->title = 'Request for :'.$tendr->title;
$this->params['breadcrumbs'][] = ['label' => 'Prequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->context->layout = 'admin';


$userId = Yii::$app->user->id;

$project= Project::findOne(['id'=>$model->project_id]);


$rdetails=Rdetail::find()
        ->where(['prequest_id'=>$model->id])
        ->all();

      
?>
<style>
        .conversation-wrap
    {
        box-shadow: -2px 0 3px #ddd;
        padding:0;
        max-height: 400px;
        overflow: auto;
    }
    .conversation
    {
        padding:5px;
        border-bottom:1px solid #ddd;
        margin:0;

    }

    .message-wrap
    {
        box-shadow: 0 0 3px #ddd;
        padding:0;

    }
    .msg
    {
        padding:5px;
        /*border-bottom:1px solid #ddd;*/
        margin:0;
    }
    .msg-wrap
    {
        padding:10px;
        max-height: 400px;
        overflow: auto;

    }

    .time
    {
        color:#bfbfbf;
    }

    .send-wrap
    {
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
        padding:10px;
        /*background: #f8f8f8;*/
    }

    .send-message
    {
        resize: none;
    }

    .highlight
    {
        background-color: #f7f7f9;
        border: 1px solid #e1e1e8;
    }

    .send-message-btn
    {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-left-radius: 0;

        border-bottom-right-radius: 0;
    }
    .btn-panel
    {
        background: #f7f7f9;
    }

    .btn-panel .btn
    {
        color:#b8b8b8;

        transition: 0.2s all ease-in-out;
    }

    .btn-panel .btn:hover
    {
        color:#666;
        background: #f8f8f8;
    }
    .btn-panel .btn:active
    {
        background: #f8f8f8;
        box-shadow: 0 0 1px #ddd;
    }

    .btn-panel-conversation .btn,.btn-panel-msg .btn
    {

        background: #f8f8f8;
    }
    .btn-panel-conversation .btn:first-child
    {
        border-right: 1px solid #ddd;
    }

    .msg-wrap .media-heading
    {
        color:#003bb3;
        font-weight: 700;
    }


    .msg-date
    {
        background: none;
        text-align: center;
        color:#aaa;
        border:none;
        box-shadow: none;
        border-bottom: 1px solid #ddd;
    }


    body::-webkit-scrollbar {
        width: 12px;
    }
 
    
    /* Let's get this party started */
    ::-webkit-scrollbar {
        width: 6px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
/*        -webkit-border-radius: 10px;
        border-radius: 10px;*/
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
/*        -webkit-border-radius: 10px;
        border-radius: 10px;*/
        background:#ddd; 
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
    }
    ::-webkit-scrollbar-thumb:window-inactive {
        background: #ddd; 
    }

</style>

<div class="prequest-view">

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

<?php if($model->status===1 || $model->status===4 && $project->user_id===$userId):?>

<?= Html::a('pm aprove', ['pmapprove', 'prequestId' => $model->id], [
    'class' => 'btn btn-secondary',
    'data' => [
        'confirm' => 'Are you sure you want to change the status to Submit of this item?',
        'method' => 'post',
    ],
]) ?>

<?= Html::a('Not Approve', ['notapprove', 'prequestId' => $model->id], [
    'class' => 'btn btn-secondary',
    'data' => [
        'confirm' => 'Are you sure you want to change the status to Not Submit of this item?',
        'method' => 'post',
    ],
]) ?>
<?php endif;?>

<?php if(Yii::$app->user->can('admin') &&! Yii::$app->user->can('author') && $model->status===2 ):?>


<?= Html::a('Management Approve', ['approve', 'prequestId' => $model->id], [
'class' => 'btn btn-success',
'data' => [
'confirm' => 'Are you sure you want to change the status to Award of this item?',
'method' => 'post',
],
]) ?>

<?= Html::a('Not Approve', ['notapprove', 'prequestId' => $model->id], [
    'class' => 'btn btn-secondary',
    'data' => [
        'confirm' => 'Are you sure you want to change the status to Not Submit of this item?',
        'method' => 'post',
    ],
]) ?>
<?php endif;?>

    </p>
    <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">General</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Item</button>
    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Comment</button>

  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
  
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute'=>'payee',
                'format'=>'raw',
                'value'=>function ($model){
                    $createdByUser = User::findOne($model->payee);
                    $createdByName = $createdByUser ? $createdByUser->username : 'Unknown';
                     return $createdByName;
                },
            ],
           
            [
                'attribute'=>'department',
                'format'=>'raw',
                'value'=>function ($model){
                    $department = Department::findOne($model->department);
                    $department = $department ? $department->name : 'Unknown';
                     return $department;
                },
            ],
            
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at);
                },
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->updated_at);
                },
            ],
            [
                'attribute'=>'created_by',
                'format'=>'raw',
                'value'=>function ($model){
                    $createdByUser = User::findOne($model->created_by);
                    $createdByName = $createdByUser ? $createdByUser->username : 'Unknown';
                     return $createdByName;
                },
            ],
            'project_id',
        ],
    ]) ?>
  </div>

  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">


<table class="table">
  <thead>
    <tr style="background-color: #f2f2f2;">
  
      <th scope="col">item</th>
      <th scope="col">unit price</th>
      <th scope="col">Qty</th>
      <th scope="col">Amount</th>
      <th scope="col">Created</th>
      <th scope="col">Updated</th>
      <th scope="col"></th>
    </tr>
    </thead>
<tbody>
<?php foreach ($rdetails as $rdetails): ?>
    <tr>
    <?php
        $item=Analysis::findOne($rdetails->iteam);
      ?>
      <?php if($item!==null):?>
        <td><?=$item->item?></td>
        <?php else:?>
            <td>No item</td>
        <?php endif;?>
        <td><?= $rdetails->quantity ?></td>
        <td><?= $rdetails->unit ?></td>
        <td><?= $rdetails->amount ?></td>
        <td><?= Yii::$app->formatter->asDatetime($rdetails->created_at) ?></td>
        <td><?= Yii::$app->formatter->asDatetime($rdetails->updated_at) ?></td>
    
        <td>
        
                <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['update', 'id' => $rdetails->id], [
                    'title' => 'Update',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]) ?>
            

            <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $rdetails->id], [
                'title' => 'Delete',
                'data-confirm' => 'Are you sure you want to delete this updates',
                'data-method' => 'post',
                'data-pjax' => '0',
            ]) ?>
        </td>
    </tr>
<?php endforeach; ?>
<tr>
    <td>
   
           
            <?= Html::a('+ create request', ['rdetail/create', 'prequestId' => $model->id])?>
    </td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td></td>
  
    <td style="background-color: #f2f2f2;">Total Amonut:TSH <?= $total_amount?></td>
    <td style="background-color: #f2f2f2;"></td>
    <td style="background-color: #f2f2f2;"></td>
    <td style="background-color: #f2f2f2;"></td>
    <td style="background-color: #f2f2f2;"></td>
    <td style="background-color: #f2f2f2;"></td>
    <td style="background-color: #f2f2f2;"></td>
</tr>
</tbody>
</table>
</div>
<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
<?php

$comment =Comment::find()->where(['prequest_id'=>$model->id])->all();

?>

<h6>Comments</h6>



 <div class="container">
   
    <div class="row">



        <div class="message-wrap col-lg-12">
            <div class="msg-wrap">


                <div class="alert alert-info msg-date">
                    <strong></strong>
                </div>
                <?php foreach($comment as $comment):?>

                <div class="media msg">
                    <a class="pull-left" href="#">
                        <img class="media-object" data-src="holder.js/64x64" alt="64x64" style="width: 32px; height: 32px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAACqUlEQVR4Xu2Y60tiURTFl48STFJMwkQjUTDtixq+Av93P6iBJFTgg1JL8QWBGT4QfDX7gDIyNE3nEBO6D0Rh9+5z9rprr19dTa/XW2KHl4YFYAfwCHAG7HAGgkOQKcAUYAowBZgCO6wAY5AxyBhkDDIGdxgC/M8QY5AxyBhkDDIGGYM7rIAyBgeDAYrFIkajEYxGIwKBAA4PDzckpd+322243W54PJ5P5f6Omh9tqiTAfD5HNpuFVqvFyckJms0m9vf3EY/H1/u9vb0hn89jsVj8kwDfUfNviisJ8PLygru7O4TDYVgsFtDh9Xo9NBrNes9cLgeTybThgKenJ1SrVXGf1WoVDup2u4jFYhiPx1I1P7XVBxcoCVCr1UBfTqcTrVYLe3t7OD8/x/HxsdiOPqNGo9Eo0un02gHkBhJmuVzC7/fj5uYGXq8XZ2dnop5Mzf8iwMPDAxqNBmw2GxwOBx4fHzGdTpFMJkVzNB7UGAmSSqU2RoDmnETQ6XQiOyKRiHCOSk0ZEZQcUKlU8Pz8LA5vNptRr9eFCJQBFHq//szG5eWlGA1ywOnpqQhBapoWPfl+vw+fzweXyyU+U635VRGUBOh0OigUCggGg8IFK/teXV3h/v4ew+Hwj/OQU4gUq/w4ODgQrkkkEmKEVGp+tXm6XkkAOngmk4HBYBAjQA6gEKRmyOL05GnR99vbW9jtdjEGdP319bUIR8oA+pnG5OLiQoghU5OElFlKAtCGr6+vKJfLmEwm64aosd/XbDbbyIBSqSSeNKU+HXzlnFAohKOjI6maMs0rO0B20590n7IDflIzMmdhAfiNEL8R4jdC/EZIJj235R6mAFOAKcAUYApsS6LL9MEUYAowBZgCTAGZ9NyWe5gCTAGmAFOAKbAtiS7TB1Ng1ynwDkxRe58vH3FfAAAAAElFTkSuQmCC">
                    </a>
                    <div class="media-body">
                        <small class="pull-right time"><i class="fa fa-clock-o"></i> <?= Yii::$app->formatter->asDatetime($comment->created_at)?></small>

                        <?php  
                        $created_by=User::findOne($comment->created_by);
                        ?>
                        <h5 class="media-heading"><?=$created_by->username?></h5>
                        <small class="col-lg-10"><?=$comment->comment?></small>
                    </div>
                </div>
               
                <?php endforeach?>

            </div>

           
           
        </div>
    </div>
</div>
</div>
</div>
