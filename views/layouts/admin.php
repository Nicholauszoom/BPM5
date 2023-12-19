<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\assets\CustomAsset;
use app\assets\RealAsset;
use app\models\Adetail;
use app\models\Prequest;
use app\models\Project;
use app\models\Setting;
use app\models\TeamAssignment;
use app\models\Tender;
use app\models\User;
use app\models\UserActivity;
use app\models\UserAssignment;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html as HelpersHtml;
use yii\helpers\Url;
use yii\jui\JuiAsset;
use yii\web\View;
use yii\web\JqueryAsset;

// CustomAsset::register($this);
// RealAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$setting=Setting::findOne(1);
$fileName = $setting->logo;
$filePath = Yii::getAlias('@webroot/upload/' . $fileName);
$downloadPath = Yii::getAlias('@web/upload/' . $fileName);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias($downloadPath)]);

// JuiAsset::register($this->getView());
AppAsset::register($this);
JqueryAsset::register($this);
$this->registerCssFile('https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
$this->registerJsFile('https://code.jquery.com/ui/1.12.1/jquery-ui.js', ['depends' => JqueryAsset::class]);

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

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?=$setting->website?> | <?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

  

    <?php $this->head();
      echo Html::cssFile('@web/vendors/bootstrap/dist/css/bootstrap.min.css');
      echo Html::cssFile('@web/vendors/font-awesome/css/font-awesome.min.css');
      echo Html::cssFile('@web/vendors/nprogress/nprogress.css');
      echo Html::cssFile('@web/vendors/iCheck/skins/flat/green.css');
      echo Html::cssFile('@web/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css');
      echo Html::cssFile('@web/vendors/jqvmap/dist/jqvmap.min.css');
      echo Html::cssFile('@web/vendors/bootstrap-daterangepicker/daterangepicker.css');
      echo Html::cssFile('@web/build/css/custom.min.css');
      echo Html::cssFile('href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"');
      // echo Html::cssFile('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.3/font/bootstrap-icons.css');
      echo Html::cssFile('https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');

      $this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
      // $this->registerJsFile('https://code.jquery.com/ui/1.12.1/jquery-ui.js');


      // echo Html::img('@web/images/favicon.png', ['alt' => 'Image'ng">


    
  $this->registerJsFile('@web/vendors/jquery/dist/jquery.min.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/bootstrap/dist/js/bootstrap.bundle.min.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/fastclick/lib/fastclick.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/nprogress/nprogress.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/Chart.js/dist/Chart.min.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/gauge.js/dist/gauge.min.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/iCheck/icheck.min.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/skycons/skycons.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/Flot/jquery.flot.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/Flot/jquery.flot.pie.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/Flot/jquery.flot.time.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/Flot/jquery.flot.resize.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/flot.orderbars/js/jquery.flot.orderBars.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/flot-spline/js/jquery.flot.spline.min.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/flot.curvedlines/curvedLines.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/DateJS/build/date.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/jqvmap/dist/jquery.vmap.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/jqvmap/dist/maps/jquery.vmap.world.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/vendors/bootstrap-daterangepicker/daterangepicker.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('@web/build/js/custom.min.js', ['depends' => 'yii\web\YiiAsset']);
  $this->registerJsFile('https://code.jquery.com/jquery-3.6.0.min.js');
  $this->registerJsFile('@web/js/dashjs.js', ['depends' => 'yii\web\YiiAsset']);
  // $this->registerJsFile('@web/select2/dist/js/select2.min.js', ['depends' => 'yii\web\YiiAsset']);

 

    ?>
<style>

.loading-bar-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.loading-bar {
  position: relative;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3498db;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.progresses{
    display: flex;
        align-items: center;
   }

   .line{

        width: 120px;
    height: 6px;
    background: #63d19e;
   }
   .no_line{


    width: 120px;
    height: 6px;
    background: #ccc;
   }

   
   .steps{

    display: flex;
    background-color: #63d19e;
    color: #fff;
    font-size: 14px;
    width: 40px;
    height: 40px;
    align-items: center;
    justify-content: center;
    border-radius: 50%;

   }

  .completed{

display: flex;
background-color: #ccc;
color: #fff;
font-size: 14px;
width: 40px;
height: 40px;
align-items: button_viewcenter;
justify-content: center;
border-radius: 50%;

}

#counter {
    font-family: "Times New Roman", Times, serif;
    font-size: 15px;
    text-align: center;
    margin: 15px;
    background-color:slategray;
    color: #fff;
    padding: 8px;
    border-radius: 50% 50% 10% 10%;
}


.avatar{
width:200px;
height:200px;
}	

.notification-items {
    max-height: 200px;
    overflow-y: auto;
}

.notification-items .link {
    display: block;
    padding: 10px;
    color: #333;
    text-decoration: none;
}

.notification-items .link:hover {
    background-color: #f5f5f5;
}

.notification-items .link .btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification-items .link .mail-desc {
    font-size: 14px;
}

.notification-items .link h5 {
    font-size: 16px;
    margin-bottom: 5px;
}

.animated-badge {
    animation: badge-animation 1s infinite;
}

@keyframes badge-animation {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.5);
    }
    100% {
        transform: scale(1);
    }
}

.truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    width: 100%; /* Adjust this width to match the container width */
  }
</style>
   
</head>
<?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('author')) : ?>

<body class="nav-md">
  <?php $this->beginBody() ?>
  
  <div class="container  body">
      <div class="main_container">
     
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"> <span>BPM-Tera</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu proconditionfile quick info -->

            <!--
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>John Doe</h2>
              </div>
            </div>
            -->
            <!-- /menu profile quick info -->

            <br />
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  
                  <li><a><i class="fa fa-home"></i> Home<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/dashboard/admin">dashboard</a></li>
                    </ul>
                  </li>
                 
                    <?php 
                $userId = Yii::$app->user->id;
                  // Retrieve the projects assigned to the user
                  // $newTender = Tender::find()
                  //     ->where(['session'=>0])
                  //     ->count();
                  $user_assignments = UserAssignment::find()
                  ->where(['user_id' => $userId])
                  ->all();
      
              $assignedTenderIds = [];
              foreach ($user_assignments as $user_assignment) {
                  $assignedTenderIds[] = $user_assignment->tender_id;
              }

                  $newTender=Tender::find()
                     ->where(['id' => $assignedTenderIds])
                     ->andWhere(['session'=>0])
                     ->count();
                  ?>



<?php
    $userId = Yii::$app->user->id;
    // Retrieve the projects assigned to the user
    $complete_tender = Tender::find()
        ->where(['status' => 1])
        ->all();
    
    $projectCount = 0;

    foreach ($complete_tender as $cmpt_tender) {
        $exist_project = Project::findOne(['tender_id' => $cmpt_tender->id]);
        if ($exist_project === null) {
            $projectCount++;
        }
    }
    ?>
<?php 
$new = Tender::find()->where(['session'=>0])->count();
$tenderPend=Tender::find()->where(['status'=>5])->count();
$tenderFail=Tender::find()->where(['status'=>4])->count();//not submmitted
$tenderSubmit=Tender::find()->where(['status'=>3])->count();
$tenderWin=Tender::find()->where(['status'=>1])->count();
$tenderOnprocess=Tender::find()->where(['session'=>1])->andWhere(['status'=>5])->count();
?>
                  <li><a><i class="fa fa-recycle"></i>Tender
                 
    <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    <?php if (Yii::$app->user->can('admin')) : ?>
                      <li><a href="/tender">all <?php if ($projectCount !== null): ?>
                 <span class="badge bg-red animated-badge"></span>
                  <?php endif; ?></a></li>
                  <li><a href="/tender/new">new
                  <?php if ($new !== null): ?>
                    <span class="badge bg-blue animated-badge"><?=$new?></span>
                    <?php endif; ?>
                  </a></li>
                  <li><a href="/tender/submit">submitted<span class="badge bg-blue animated-badge"><?=$tenderSubmit?></span></a></li>
                  <li><a href="/tender/success">awarded<span class="badge bg-blue animated-badge"><?=$tenderWin?></span></a></li>
                  <li><a href="/tender/unsubmit">not submitted<span class="badge bg-blue animated-badge"><?=$tenderFail?></span></a></li>
                  <li><a href="/tender/pending">onprogress<span class="badge bg-blue animated-badge"><?=$tenderOnprocess?></span></a></li>

                  <?php endif; ?>
                      <?php if (Yii::$app->user->can('author') && !Yii::$app->user->can('admin')) : ?>
                        
                      <li><a href="/tender/pm">assigned <span class="badge bg-blue"><?=$newTender?></span></a></li>
                      <?php endif; ?>

                     
                    </ul>
                  </li>
                 
                  <?php 
                  
                    $userId = Yii::$app->user->id;
                    // Retrieve the projects assigned to the user
                    $newProjects = Project::find()
                        ->where(['user_id' => $userId])
                        ->andWhere(['isViewed'=>0])
                        ->count();

                      
           
                   $team_assignment=TeamAssignment::find()
                   ->where(['user_id'=>$userId])
                   ->all();
           
           
           
                   $project_team='';
                   foreach ($team_assignment as $proj) {
                     $project_team =Project::find()
                       ->where(['id'=>$proj->project_id, 'isViewed'=>0])
                       ->count();
                   }
           

                    ?>
                  <li><a><i class="fa fa-clone"></i> Project <span class="fa fa-chevron-down"></span> </a>
                  
                    <ul class="nav child_menu">
                    <?php if (Yii::$app->user->can('admin')) : ?>
            <li><a href="/project">project<span class="badge bg-green"><?=$newProjects?></span></a></li>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('author')) : ?>
            <li><a href="/project/pm"> pm</a>
            <li><a href="/project/member">member<span class="badge bg-green"><?=$project_team?></span></a>
           
          </li>
        <?php endif; ?>
                    </ul>
                  </li>
                  <?php if (Yii::$app->user->can('admin')&&Yii::$app->user->can('author')) : ?>

                  <li><a><i class="fa fa-plug"></i>  Activity<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

                    <li><a href="/activity">activity</a></li>
  
                    </ul>
                  </li>
                  <?php endif; ?>

                  <?php if (Yii::$app->user->can('admin')&&Yii::$app->user->can('author')) : ?>

                   <li><a><i class="fa fa-sitemap"></i>Department<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">

                 <li><a href="/department">department</a></li>

                     </ul>
                  </li>
          <?php endif; ?>

                  <?php
    $userId = Yii::$app->user->id;
    // Retrieve the projects assigned to the user
    $approved_prequest = Prequest::find()
        ->where(['status' => 2])
        ->andWhere(['session'=>0])
        ->all();
    
    $prequestCount = 0;

    foreach ($approved_prequest as $approved_prequest) {
        // $exist_prequest = Prequest::findOne(['tender_id' => $approved_prequest->id]);
        if ($approved_prequest !== null) {
            $prequestCount++;
        }
    }
    ?>
     <?php
    $userId = Yii::$app->user->id;
    // Retrieve the projects assigned to the user
    $sent_prequest = Prequest::find()
        ->where(['status' => 1])
        ->andWhere(['session'=>0])
        ->all();
    
        
    $prequestsentCount = 0;

    foreach ($sent_prequest as $sent_prequest) {
        // $exist_prequest = Prequest::findOne(['tender_id' => $approved_prequest->id]);
        if ($sent_prequest !== null) {
            $prequestsentCount++;
        }
    }
    ?>
    <?php if(!(Yii::$app->user->can('author') && Yii::$app->user->can('admin') )):?>
                  <li><a><i class="fas fa-balance-scale"></i>  Request  <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/prequest">request
                      <?php if(Yii::$app->user->can('admin') &&! Yii::$app->user->can('author') && $prequestCount!== 0 ):?>
                      <span class="badge bg-primary animated-badge"><?= $prequestCount ?></span>
                      <?php endif;?>

                      <?php if(Yii::$app->user->can('author') &&! Yii::$app->user->can('admin') && $prequestsentCount!== 0 ):?>
                      <span class="badge bg-secondary animated-badge"><?= $prequestsentCount ?></span></a>
                      <?php endif;?>
                    </li>
                      <li><a href="/prequest/member">member
                      <?php if(Yii::$app->user->can('author') &&! Yii::$app->user->can('admin') && $prequestsentCount!== 0 ):?>
                      <span class="badge bg-secondary animated-badge"><?= $prequestsentCount ?></span></a>
                      <?php endif;?>
                      <?php if(Yii::$app->user->can('author') &&! Yii::$app->user->can('admin') && $prequestCount!== 0 ):?>
                        <span class="badge bg-primary animated-badge"><?= $prequestCount ?></span>
                        <?php endif;?>
                        </a></li>
                    </ul>
                  </li>
                  <?php endif;?>

                  <?php if (Yii::$app->user->can('admin')) : ?>
                    <!--
                  <li><a><i class="fa fa-check-square"></i>Task<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/task">index</a></li>
                    </ul>
                  </li>
                  -->
              
                  <?php endif; ?>
                 

                  <li><a><i class="fa fa-user"></i>User & Department<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    <?php if (Yii::$app->user->can('admin')) : ?>
                      <li><a href="/user">user</a></li>
                      <li><a href="/role">role</a></li>
                      
                      </li>
                 
                     
                    </ul>
                
                        <?php endif; ?>
                        <?php if (Yii::$app->user->can('author') &&Yii::$app->user->can('admin')) : ?>
                  <li><a><i class="fa fa-building"></i>Office<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/office">office</a></li>
                    </ul>
                  </li>
                 
                  <li><a><i class="fa fa-file-pdf-o"></i>Report<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/tender/form">tender report</a></li>
                      <li><a href="/project/form">project report</a></li>
                    </ul>
                  </li>
                  
                 <!--
                  <li><a><i class="fa fa-folder-o"></i>Analysis & Requests<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/analysis">Analysis</a></li>
                      <li><a href="#">Request</a></li>
                    </ul>
                  </li>
                  -->
                 
                  <li><a><i class="fa fa-gear"></i>Settings<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/setting">setting</a></li>
                    </ul>
                  </li>
                  <?php endif; ?>
                </ul>
              </div>
            
            </div>
            </div>
        </div>
      </div>
            <!-- top navigation -->
            <div class="top_nav">
          <div class="nav_menu">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <nav class="nav navbar-nav">
                
              <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <img src="https://cdn-icons-png.flaticon.com/128/3177/3177440.png?ga=GA1.1.812721869.1686883631" alt="profile_image">
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="/site/profile"> Profile</a>
                      <a class="dropdown-item"  href="/site/profile">
                        <span class="badge bg-red pull-right"></span>
                        <span>Settings</span>
                      </a>
                  <a class="dropdown-item"  href="javascript:;">Help</a>
                    <a class="dropdown-item"  href=""><i class="fa fa-sign-out pull-right"></i>
                    <?php
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            
            Yii::$app->user->isGuest
                ? ['label' => 'Login', 'url' => ['/site/login']]
                : '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
        ]
    ]);
    
    ?>
                    </a>
                  </div>
                </li>

                <li role="presentation" class="nav-item dropdown open">
                <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                <?php



                  //MANAGEMENT NOTIFICATIONS ON REQUEST PART COUNT
                  $userId = Yii::$app->user->id;
                  // Retrieve the projects assigned to the user
                  $approved_prequest = Prequest::find()
                      ->where(['status' => 2])
                      ->andWhere(['session'=>0])
                      ->all();
                  
                  $prequestCount = 0;
              
                  foreach ($approved_prequest as $approved_prequest) {
                      // $exist_prequest = Prequest::findOne(['tender_id' => $approved_prequest->id]);
                      if ($approved_prequest !== null) {
                          $prequestCount++;
                      }
                  }
                   //...REQUEST COUNT SCRIPT END HERE...


    $userId = Yii::$app->user->id;
    
    // Retrieve the projects assigned to the user
    $complete_tender_count = Tender::find()->all();
    $notificationCount = 0;

    foreach ($complete_tender_count as $cmpt_tender) {
      $assigncompl=UserActivity::find()->where(['tender_id'=>$cmpt_tender])->all();

      $hasContract = false;
foreach ($assigncompl as $assigncompl) {
    if ($assigncompl->user_id === $userId) {
        $hasContract = true;
        break;
    }
  }
  

        $currentDate = date('Y-m-d'); // Get the current date
        $expiredDays = floor(($cmpt_tender->expired_at - strtotime($currentDate)) / (60 * 60 * 24));

        if (($hasContract ||  (Yii::$app->user->can('admin') && Yii::$app->user->can('author'))) && $expiredDays >= 0 && $expiredDays < 8) {
            $notificationCount++;
        }
    }
    ?>

  
        <?php if ($notificationCount > 0): ?>
            <span class="badge bg-red animated-badge " style="position:relative;"><?= $notificationCount ?></span>
        <?php endif; ?>
    
        <?php if ($prequestCount > 0): ?>
            <span class="badge bg-primary animated-badge"><?= $prequestCount ?></span>
        <?php endif; ?>
        <?php if(Yii::$app->user->can('author') &&! Yii::$app->user->can('admin') && $prequestsentCount!== 0 ):?>
          <span class="badge bg-secondary animated-badge " style="position:relative;"><?= $prequestsentCount ?></span></a>
         <?php endif;?>

        <i class="fa fa-envelope-o"></i>
</a>
   
    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown1">
        <!-- Dropdown menu items go here -->
        <li>
            <div class="notification-items ">
              <?php

$complete_tender = Tender::find()
    ->all();
  
 
foreach ($complete_tender as $cmpt_tender) {
  $assgn_user=Adetail::find()->where(['tender_id'=>$cmpt_tender->id])->all();

  $assigncompl=UserActivity::find()->where(['tender_id'=>$cmpt_tender])->all();

  $hasContract = false;
foreach ($assigncompl as $assigncompl) {
if ($assigncompl->user_id === $userId) {
    $hasContract = true;
    break;
}


}
  // foreach ($assgn_user as $a_user) {
  $currentDate = date('Y-m-d'); // Get the current date
  $expiredDays = floor(($cmpt_tender->expired_at - strtotime($currentDate)) / (60 * 60 * 24));
    if (($hasContract ||  (Yii::$app->user->can('admin') && Yii::$app->user->can('author'))) && $expiredDays >= 0 && $expiredDays < 8 ) {
      // if( $userId===$a_user->user_id | $a_user->supervisor){


    
        ?>


        
        <a href="<?= Url::to(['tender/view', 'id' => $cmpt_tender->id]) ?>" class="link border-top">
            <div class="d-flex no-block align-items-center p-7 " >
                <span class="btn btn-primary btn-circle d-flex align-items-center justify-content-center ">
                    <i class="fas uil-mailbox-alt text-white fs-4"></i>
                </span>
                <div class="ms-2 ">
                    <h5 class="mb-0 " style="color:grey; text-align: justify; font-size: 12px; font-weight: 600;"><?= $cmpt_tender->title ?></h5>
                    <span class="mail-des" style="color:grey; text-align: justify; font-size: 11px;">Reminded: submition date is close...<span style="color:#3498db;font-size: 11px;">View</span></span>
                </div>
            </div>
        </a>
       
        <?php
    }
  }

?>

          <?php

                  //MANAGEMENT NOTIFICATIONS ON REQUEST PART
                  $userId = Yii::$app->user->id;
                  // Retrieve the projects assigned to the user
                  $approved_prequest = Prequest::find()
                      ->where(['status' => 2])
                      ->andWhere(['session'=>0])
                      ->all();
                 
                  //...REQUEST SCRIPT END HERE...
       foreach ($approved_prequest  as $approved_p) {         
          
             $project= Project::findOne($approved_p->project_id);
             $tender = Tender::findOne($project->tender_id);
             $tenderTitle = $tender ? $tender->title : 'Unknown';

             $pm=User::findOne($project->user_id);
            ?>
        <a href="<?= Url::to(['prequest/view', 'id' => $approved_p->id]) ?>" class="link border-top">
            <div class="d-flex no-block align-items-center p-7 " >
                <span class="btn btn-primary btn-circle d-flex align-items-center justify-content-center ">
                    <i class="fas uil-mailbox-alt text-white fs-4"></i>
                </span>
                <div class="ms-2 ">
                    <h5 class="mb-0 " style="color:grey; text-align: justify; font-size: 12px; font-weight: 600;"><?= $tenderTitle ?></h5>
                    <span class="mail-des" style="color:grey; text-align: justify; font-size: 11px;">Reminded: New Request from Project Manager <span style="color:#3498db; font-weight:bold;font-size: 11px;"> Eng.<?=$pm->username?></span>...<span style="color:#3498db;font-size: 11px;">View</span></span>
                </div>
            </div>
        </a>
     
<?php 
       }
      
?>

<?php

//MANAGEMENT NOTIFICATIONS ON REQUEST PART
$userId = Yii::$app->user->id;
// Retrieve the projects assigned to the user
$userId = Yii::$app->user->id;
    // Retrieve the projects assigned to the user
    $sent_prequest = Prequest::find()
        ->where(['status' => 1])
        ->andWhere(['session'=>0])
        ->all();
    
      
//...REQUEST SCRIPT END HERE...
foreach ($sent_prequest  as $sent_prequest) {         

$project= Project::findOne($sent_prequest->project_id);
$tender = Tender::findOne($project->tender_id);
$tenderTitle = $tender ? $tender->title : 'Unknown';

$pm=User::findOne($project->user_id);
?>
<a href="<?= Url::to(['prequest/view', 'id' => $sent_prequest->id]) ?>" class="link border-top">
<div class="d-flex no-block align-items-center p-7 " >
<span class="btn btn-primary btn-circle d-flex align-items-center justify-content-center ">
  <i class="fas uil-mailbox-alt text-white fs-4"></i>
</span>
<div class="ms-2 ">
  <h5 class="mb-0 " style="color:grey; text-align: justify; font-size: 12px; font-weight: 600;"><?= $tenderTitle ?></h5>
  <span class="mail-des" style="color:grey; text-align: justify; font-size: 11px;">Reminded: New Request from team member sent to a PM <span style="color:#3498db; font-weight:bold;font-size: 11px;"> Eng.<?=$pm->username?></span>...<span style="color:#3498db;font-size: 11px;">View</span></span>
</div>
</div>
</a>

<?php 
}

?>
           
  
            </div>
        </li>
    </ul>
</li>
              </ul>

            </nav>
          </div>
        </div>
        <!-- /top navigation -->
        <div class="right_col" role="main">
        <div class="">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        
        
        </div>
        </div>
       
         <!-- /page content -->
  
        <!-- footer content -->
        <footer style="">
          <div class="pull-right" >
            Teratech - web application <a href="teratech.co.tz">about us</a>
          </div>
          <div class="clearfix"></div>
      
        </footer>
        <!-- /footer content -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        </div>
        </div>


        <!--begin::Body-->

<?php $this->endBody();

?>
</body>
<?php endif;?>
</html>
<?php $this->endPage() ?>
