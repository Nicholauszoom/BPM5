<?php

use app\models\Department;
use app\models\Setting;
use app\models\Tender;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Setting';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin';
$currentUrl = Url::toRoute(Yii::$app->controller->getRoute());

// Define an array of sidebar items with their URLs and labels
$sidebarItems = [
    ['url' => ['/dashboard/admin'], 'label' => 'Home', 'icon' => 'bi bi-house'],
    ['url' => ['/project'], 'label' => 'Projects', 'icon' => 'bi bi-layers'],
    ['url' => ['/task'], 'label' => 'Task', 'icon' => 'bi bi-check2-square'],
    ['url' => ['/team'], 'label' => 'Team', 'icon' => 'bi bi-people'],
    ['url' => ['/member'], 'label' => 'Member', 'icon' => 'bi bi-person'],
    ['url' => ['/report'], 'label' => 'Report', 'icon' => 'bi bi-file-text'],
    ['url' => ['/setting'], 'label' => 'Settings', 'icon' => 'bi bi-gear'],
];


$model=Setting::find()->all();
?>


<div id="main-content ">
   
    <div id="page-container">
        <!-- ============================================================== -->
        <!-- Sales Cards  -->
        <!-- ============================================================== -->
        <di class="row"></di>

        <?php foreach($model as $model):?>
<section style="background-color: #eee;">
  <div class="container py-5">
   

    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
            
          <div class="card-body text-center">
            <?php
              $fileName = $model->logo;
              $filePath = Yii::getAlias('@webroot/upload/' . $fileName);
              $downloadPath = Yii::getAlias('@web/upload/' . $fileName);
            ?>
            <img src=<?=$downloadPath?> alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3"><?=$model->logo?></h5>
          <p class="text-muted mb-1"></p>
      
          <p class="text-muted mb-1"></p>
        
           
            <p class="text-muted mb-4"></p>
          
          </div>
        </div>
        <!--
        <div class="card mb-4 mb-lg-0">
          <div class="card-body p-0">
            <ul class="list-group list-group-flush rounded-3">
              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fas fa-globe fa-lg text-warning"></i>
                <p class="mb-0">https://mdbootstrap.com</p>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fab fa-github fa-lg" style="color: #333333;"></i>
                <p class="mb-0">mdbootstrap</p>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                <p class="mb-0">@mdbootstrap</p>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                <p class="mb-0">mdbootstrap</p>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                <p class="mb-0">mdbootstrap</p>
              </li>
            </ul>
          </div>
        </div>-->
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">End Clarification Days Interval</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?=$model->end_clarification?>  </p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Estimate Days Until Publish Result</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?=$model->result?>  </p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Company Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?=$model->company?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Organization Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?=$model->email?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Default Password</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?=$model->password?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Organization Phone</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?=$model->phone?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Company Address</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?=$model->address?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Created Date</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?=Yii::$app->formatter->asDatetime($model->created_at)?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Updated Date</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?=Yii::$app->formatter->asDatetime($model->updated_at)?></p>
              </div>
            </div>
            <hr>
            <div class="row">
            <div class="col-sm-9">
            
            <?php if (Yii::$app->user->can('admin') && Yii::$app->user->can('author')) : ?>

              <?php if ($model->id!==null):?>
            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span><span style="color:blue;">  Edit Setting </span>', ['update', 'id'=> $model->id], [
                    'title' => 'edit',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]) ?>
              <div style="color:red; margin:5px;">
              <?= Html::a('<span class="glyphicon glyphicon-trash"></span><span>  delete Setting </span>', ['delete','id'=>$model->id], [
                    'title' => 'delete',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]) ?>
              </div>
    
               <?php endif; ?>
               <?php endif; ?>

            </div>
            </div>
          </div>
        </div>
        </div>
        
      </div>
    </div>
  </div>
</section>
<?php endforeach;?>
<?php if ($model==null):?>
<?= Html::a('<span class="glyphicon glyphicon-plus"></span><span style="color:blue;">  New Setting </span>', ['create'], [
                    'title' => 'create',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]) ?>
    <?php endif; ?>
             
    </div>
</div>
