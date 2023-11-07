<?php
    // Get the current route URL
use dosamigos\chartjs\ChartJs;
use app\models\Department;
use yii\helpers\Url;
use app\models\Project;
use app\models\Tender;
use app\models\User;
use app\models\UserAssignment;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

   // Get the current route URL
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
/** @var yii\web\View $this */

$this->title = 'My Yii Application';

$this->context->layout = 'admin'; 

//PROJECT CONVERSION DATA FROM ARRAY TO STRING

$projectNamesJson = Json::encode($projectNames);
$budgetDataJson = Json::encode($budgetData);

?>

<style>
  div {
    color: grey;
  }

  .card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }


    .popup .overlay {
        position: fixed;
        top: 0;
        left:0;
        width:300vw;
        height: 300vw;
        background: rgba(0, 0, 0, 0.7);
        z-index:1;
        display:none;
    }

    .popup .content {
        position: absolute;
        top:50%;
        left:50%;
        transform:translate(-50%, -50%) scale(0);
        background: #fff;
        width: 1000px;
        height: 500px;
        z-index:2;
        text-align: center;
        padding:20px;
        box-sizing: border-box;
    }
    

    .popup .close-btn {
        position:absolute;
        right: 20px;
        top:20px;
        width: 30px;
        height:30px;
        background: #222;
        color:#fff;
        font-size: 25px;
        font-weight: 600;
        line-height: 30px;
        text-align: center;
        border-radius: 50%;

    }

    .popup.active .overlay{
      display:block;
    }

    .popup.active .content{
       transition: all 300ms ease-in-out;
       transform:translate(-50%, -50%) scale(1);

    }

    .truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    width: 100%; /* Adjust this width to match the container width */
  }
    
    hr {
        color: #222;
        font-weight: bold;
    }

    .list-group {
        position: absolute;
        width: 940px;
        height: 400px;
        text-align: center;
        overflow-y: auto;
    }

    .tender-label {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 9999px;
    background-color: #e2f0d9;
    color: #3c763d;
    display: flex; 
    justify-content: flex-start;
    margin-top: 5px;
  }
</style>

   <!-- top tiles -->

<div class="row justify-content-center">
  <!-- PROJECT MANAGEMENT SUMMARY-->
  <div class="tile_count">


 
  <!-- /admin dash  -->
  <?php if (Yii::$app->user->can('admin')) : ?>
          
    <div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <a  aria-controls="" onclick="togglePopup()">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                            Published Tender
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tender ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300" style="color:cornflowerblue;"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <a  onclick="togglePopup2()">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                            Tender On Progress
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tenderPend ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-circle-o-notch fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
<a  onclick="togglePopup3()">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">Unsuccessful Tender
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tenderFail?></div>

                </div>
                <div class="col-auto">
                    <i class="fa fa-minus-circle fa-2x text-gray-300 " style="color:crimson;"></i>
                </div>
            </div>
        </div>
    </div>
</a>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <?php
               $staff= User::find()
                 ->count();
               ?>
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                      Staff </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"> <?=$staff?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-user fa-2x text-gray-300" style="color:black;"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

     <!-- <div class="col-md-2 col-sm-4 tile_stats_count">
        <?php
          $department = Department::find()
          ->count();
        ?>
      <span class="count_top"><i class="fa fa-users"></i> Departments </span>
      <div class="count "><?=$department?></div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i> </span>
    </div> 

    <div class="col-md-2 col-sm-6 tile_stats_count">
  <span class="count_top"><i class="fa fa-money"></i>Total Projects Budget</span>
  <div class="">
    TSH <?=$totalBudget ?>
  </div>
  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i></span>
</div>-->
<?php endif; ?>
<!-- /admin dash end -->

<!-- /Project Manager Dashboard -->

<!-- /pm end -->
  </div>


  <!-- TENDER MANAGEMENT SUMMARY-->
  <div class="tile_count">

  <!-- /admin dash  -->
  <?php if (Yii::$app->user->can('admin')) : ?>
          
        
    <div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
<a  onclick="togglePopup4()">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                    Total Projects</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-folder fa-2x text-gray-300" style="color: orange;"></i>
                </div>
            </div>
        </div>
    </div>
</a>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
<a  onclick="togglePopup5()">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                    Complete Projects</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $successCount ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clone fa-2x text-gray-300" style="color:cadetblue;"></i>
                </div>
            </div>
        </div>
    </div>
</a>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
<a  onclick="togglePopup6()">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <?php
        
        $projectHolds = Project::find()
            ->Where(['status' => 2])
            ->count();
            
        ?>
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">OnProgress Projects
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $projectHolds?></div>

                </div>
                <div class="col-auto">
                    <i class="fas fa-check fa-2x text-gray-300" ></i>
                </div>
            </div>
        </div>
    </div>
</a>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                    Fail Projects</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $fail?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-close fa-2x text-gray-300" style="color:crimson;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="text-xs font-weight-bold  text-uppercase mb-1">Total Projects Budget
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"> TSH <?=$totalBudget ?></div>

                </div>
                <div class="col-auto">
                    <i class="fa fa-institution fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php endif; ?>

<!-- /Project Manager Dashboard -->
<?php if (Yii::$app->user->can('author')) : ?>

  <div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                        Published Tender</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tender ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <?php
        $userId = Yii::$app->user->getId();

        $user_assignments = UserAssignment::find()
        ->where(['user_id' => $userId])
        ->all();

    $assignedTenderIds = [];
    foreach ($user_assignments as $user_assignment) {
        $assignedTenderIds[] = $user_assignment->tender_id;
    }

        $tender=Tender::find()
           ->where(['id' => $assignedTenderIds])
           ->andWhere(['session'=>0])
           ->count();
        ?>
                    <div class="text-xs font-weight-bold text-uppercase mb-1">
                    Assigned Tender</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tender ?></div>
                </div>
                <div class="col-auto">  .tender-label {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 9999px;
    background-color: #e2f0d9;
    color: #3c763d;
  }
                    <i class="fa fa-circle-o-notch fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <?php
        $userId = Yii::$app->user->getId();
        $projectCount = Project::find()
            ->where(['user_id' => $userId])
            ->count();
        ?>
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">Assigned Project
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $projectCount ?></div>

                </div>
                <div class="col-auto">
                    <i class="fa fa-minus-circle fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <?php
        $userId = Yii::$app->user->getId();
        $projectSuccess = Project::find()
            ->where(['user_id' => $userId])
            ->andWhere(['status' => 1])
            ->count();
        ?>
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                    Complete Project</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"> <?=$projectSuccess?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-user fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <?php
        $userId = Yii::$app->user->getId();
        $projectHold = Project::find()
            ->where(['user_id' => $userId])
            ->andWhere(['status' => 3])
            ->count();
        ?>
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                    Projects OnHold</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"> <?=$projectHold?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-check fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <?php
$userId = Yii::$app->user->getId();

// Count failed projects for the logged-in user
$projectFail = Project::find()
    ->where(['user_id' => $userId])
    ->andWhere(['status' => 2])
    ->count();
?>
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                    Fail Project</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"> <?=$projectFail?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-close fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
      
    <?php
$userId = Yii::$app->user->getId();

// Find projects assigned to the user
$projects = Project::find()
    ->where(['user_id' => $userId])
    ->all();

// Calculate the total project budget for the assigned projects
$projectBudget = 0;
foreach ($projects as $project) {
    $projectBudget += $project->budget;
}
$formattedBudget = number_format($projectBudget, 2)
?>
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                    Projects Budget</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"> <?= $formattedBudget ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-institution fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php endif; ?>
<!-- /pm end -->
  </div>
</div>
          <!-- /top tiles -->
       
           
          <div class="row">
  <div class="col-md-12 col-sm-12">
    
     
      <?php if (Yii::$app->user->can('admin')) : ?>
    <!-- Include the latest version of Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <h2 class="text-muted mt-10 text-center">A Graph Of Project Against Profit</h2>
      <div class="chart-container">
        <canvas id="lineChart" style="width: 100%; height: 400px;"></canvas>
      </div>
    </div>
  </div>

  <div class="row mt-30">
    <div class="col-md-8 offset-md-2">
      <h2 class="text-muted mt-20 text-center">A Graph of Tender per Day</h2>
      <div class="chart-container">
        <canvas id="myChart" style="width: 100%; height: 400px;"></canvas>
      </div>
    </div>
  </div>
</div>

<script>
  // Retrieve the data from the PHP controller
  var projectNames = <?= $projectNamesJson ?>;
  var budgetData = <?= $budgetDataJson ?>;
  var dates = <?= json_encode($dates) ?>;
  var counts = <?= json_encode($counts) ?>;

  // Create the line chart
  var ctxLine = document.getElementById('lineChart').getContext('2d');
  new Chart(ctxLine, {
    type: 'line',
    data: {
      labels: projectNames,
      datasets: [{
        label: 'Profit',
        data: budgetData,
        borderColor: 'rgba(75, 192, 192, 1)',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderWidth: 1,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1000,
          },
        },
      },
    }
  });

  // Create the bar chart
  var ctxBar = document.getElementById('myChart').getContext('2d');
  var myChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: dates,
      datasets: [{
        label: 'Tenders per Day',
        data: counts,
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        x: {
          grid: {
            display: false
          }
        },
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0
          }
        }
      }
    }
  });

  // Add custom animations using jQuery
  $(document).ready(function() {
    // Animate the line chart on page load
    $(".row:first-child .chart-container").hide().fadeIn(1500);

    // Apply additional styling to the line chart container
    $(".row:first-child .chart-container").css({
      'border-radius': '10px',
      'box-shadow': '0 4px 6px rgba(0, 0, 0, 0.1)'
    });

    // Animate the bar chart on page load
    $(".row:last-child .chart-container").hide().fadeIn(1500);

    // Apply additional styling to the bar chart container
    $(".row:last-child .chart-container").css({
      'border-radius': '10px',
      'box-shadow': '0 4px 6px rgba(0, 0, 0, 0.1)'
    });
  });
</script>
<?php endif; ?>
      <div class="clearfix"></div>
    </div>
  </div>
</div>


<div>

<!-- Include Chart.js library -->

<!-- Create the canvas element -->


     <!--   *** projects and tender for a specific user summary *** -->

     <?php if (Yii::$app->user->can('author')) : ?>
     <section style="display: flex; justify-content: center; ">
  <div class="container py-5">
   

    
      <div class="col-lg-8">
        
        <div class="row">

 <!--
          <div class="col-md-6">
            <div class="card mb-4 mb-md-0">
              <div class="card-body">
                <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Tender Status
                </p>
                <?php foreach ($tender_summary as $tender):?>
                  
                <p class="mb-1" style="font-size: .77rem;"><?=$tender->title?></p>
               
                <p class="text-muted mb-0 " style="font-size: .60rem;">Publish: <?=Yii::$app->formatter->asDatetime($tender->publish_at)?>, Submitt:<?=Yii::$app->formatter->asDatetime($tender->expired_at)?></p>
                <?php endforeach;?>
              </div>
              
            </div>
          </div>-->


          <div class="row">
    <div class="col-md-6" style="margin-left: 5px; margin-right: 5px;">
        <div class="card mb-4 mb-md-0">
            <div class="card-body">
                <p class="mb-4"><span class="text-primary font-italic me-1">Assignment</span> Project Assigned as Project Manager</p>

                <?php foreach ($projectsum as $project): ?>
                    <?php
                    $project_title = Tender::findOne($project->tender_id);
                    ?>
                    <p class="mb-1" style="font-size: .77rem;"><?= $project_title->title ?> <?= getStatusLabel($project->status) ?></p>
                    <p class="text-muted mb-0" style="font-size: .60rem;">
                        Start: <?= Yii::$app->formatter->asDatetime($project->start_at) ?>, End: <?= Yii::$app->formatter->asDatetime($project->end_at) ?>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6" style="margin-left: 5px; margin-right: 5px;">
        <div class="card mb-4 mb-md-0">
            <div class="card-body">
                <p class="mb-4"><span class="text-primary font-italic me-1">Assignment</span> Projects Assigned as Member of Team</p>

                <?php foreach ($project_team as $project): ?>
                    <?php
                    $project_title = Tender::findOne($project->tender_id);
                    ?>
                    <p class="mb-1" style="font-size: .77rem;"><?= $project_title->title ?> <?= getStatusLabel($project->status) ?></p>
                    <p class="text-muted mb-0" style="font-size: .60rem;">
                        Start: <?= Yii::$app->formatter->asDatetime($project->start_at) ?>, End: <?= Yii::$app->formatter->asDatetime($project->end_at) ?>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  <?php endif;?>
        </div>


 <!-- POPUP PAGES -->
<?php 
    $all_tender_popup=Tender::find()->all();
?>
 <div class="popup" id="popup-1">
<div class="overlay">
</div>

<div class="content">
    <div class="close-btn " onclick="togglePopup()">&times;</div>
    
        <div>
      
   <ul class="list-group mt-5">
   <?php foreach ($all_tender_popup as $all_tender_popup) : ?>
  <li class="list-group-item">
<h6 class="truncate" style="color:#222; text-align: left;">
 <?=$all_tender_popup->title?>
</h6>
<h6 style="color:cornflowerblue; text-align:left;">
<?=$all_tender_popup->PE ?>
</h6>
<p style="color:grey; text-align:left;">Invitation Date:<span style="color:#222;"><?= Yii::$app->formatter->asDatetime($all_tender_popup->publish_at) ?></span>  Submission Deadline:<span style="color:mediumseagreen;"> <?= Yii::$app->formatter->asDatetime($all_tender_popup->expired_at )?> </span>  Number: <?=$all_tender_popup->TenderNo ?></p>
  
  <div class="tender-label inline-block px-2 py rounded-full bg-green-200 text-green-800"> <?=getStatusLabelTender($all_tender_popup->status)?> </div>
<button class="py-1 whitespace-nowrap px-2 border border-primary rounded text-primary mr-10" style="display: flex; justify-content: flex-end; margin-top: 5px;" >View Details </button>
<hr/>
</li>
  
  <?php endforeach ;?>
  
</ul>


</div>

</div>

 </div>     




 <!-- POPUP PAGES TENDER ON PROGRESS -->
<?php 
    $progress_tender_popup=Tender::find()->where(["status"=>5])->all();
?>
 <div class="popup" id="popup-2">
<div class="overlay">
</div>

<div class="content">
    <div class="close-btn " onclick="togglePopup2()">&times;</div>
    
        <div>
      
   <ul class="list-group mt-5">
   <?php foreach ($progress_tender_popup as $progress_tender_popup) : ?>
  <li class="list-group-item">
<h6 class="truncate" style="color:#222; text-align: left;">
 <?=$progress_tender_popup->title?>
</h6>
<h6 style="color:cornflowerblue; text-align:left;">
<?=$progress_tender_popup->PE ?>
</h6>
<p style="color:grey; text-align:left;">Invitation Date:<span style="color:#222;"><?= Yii::$app->formatter->asDatetime($progress_tender_popup->publish_at) ?></span>  Submission Deadline:<span style="color:mediumseagreen;"> <?= Yii::$app->formatter->asDatetime($progress_tender_popup->expired_at )?> </span>  Number: <?=$progress_tender_popup->TenderNo ?></p>
  
  <div class="tender-label inline-block px-2 py rounded-full bg-green-200 text-green-800"> <?=getStatusLabelTender($progress_tender_popup->status)?> </div>
<button class="py-1 whitespace-nowrap px-2 border border-primary rounded text-primary mr-10" style="display: flex; justify-content: flex-end; margin-top: 5px;" >View Details </button>
<hr/>
</li>
  
  <?php endforeach ;?>
  
</ul>


</div>

</div>

 </div>     

     
           


 <!-- POPUP PAGES TENDER UNSUCESSFULL -->
 <?php 
    $unsuccess_tender_popup=Tender::find()->where(["status"=>2])->all();
?>
 <div class="popup" id="popup-3">
<div class="overlay">
</div>

<div class="content">
    <div class="close-btn " onclick="togglePopup3()">&times;</div>
    
        <div>
      
   <ul class="list-group mt-5">
   <?php foreach ($unsuccess_tender_popup as $unsuccess_tender_popup) : ?>
  <li class="list-group-item">
<h6 class="truncate" style="color:#222; text-align: left;">
 <?=$unsuccess_tender_popup->title?>
</h6>
<h6 style="color:cornflowerblue; text-align:left;">
<?=$unsuccess_tender_popup->PE ?>
</h6>
<p style="color:grey; text-align:left;">Invitation Date:<span style="color:#222;"><?= Yii::$app->formatter->asDatetime($unsuccess_tender_popup->publish_at) ?></span>  Submission Deadline:<span style="color:mediumseagreen;"> <?= Yii::$app->formatter->asDatetime($unsuccess_tender_popup->expired_at )?> </span>  Number: <?=$unsuccess_tender_popup->TenderNo ?></p>
  
  <div class="tender-label inline-block px-2 py rounded-full bg-green-200 text-green-800"> <?=getStatusLabelTender($unsuccess_tender_popup->status)?> </div>
<button class="py-1 whitespace-nowrap px-2 border border-primary rounded text-primary mr-10" style="display: flex; justify-content: flex-end; margin-top: 5px;" >View Details </button>
<hr/>
</li>
  
  <?php endforeach ;?>
  
</ul>


</div>

</div>

 </div>     



 
 <!-- POPUP PAGES ALL PROJECTS -->
 <?php 
    $all_project_popup=Project::find()->all();
?>
 <div class="popup" id="popup-4">
<div class="overlay">
</div>

<div class="content">
    <div class="close-btn " onclick="togglePopup4()">&times;</div>
    
        <div>
      
   <ul class="list-group mt-5">
   <?php foreach ($all_project_popup as $all_project_popup) : ?>
  <li class="list-group-item">
<h6 class="truncate" style="color:#222; text-align: left;">
 
<?php
$project = Project::findOne($all_project_popup->id);
$project_tender = $project ? $project->tender_id : '';
$project_tender_id=Tender::findOne($project_tender);
$projectName = $project_tender_id ? $project_tender_id->title : '';


$p_manager_pop=User::findOne(['id'=>$all_project_popup->user_id]);
?>
<?=$projectName?>
</h6>
<h6 style="color:cornflowerblue; text-align:left;">
Budget: <?=$all_project_popup->budget ?>
</h6>
<p style="color:grey; text-align:left;">Start Date:<span style="color:#222;"><?= Yii::$app->formatter->asDatetime($all_project_popup->start_at) ?></span>  End/Deadline:<span style="color:mediumseagreen;"> <?= Yii::$app->formatter->asDatetime($all_project_popup->end_at )?> </span>  Project Manager: <?=$p_manager_pop->username ?></p>
  
  <div class="tender-label inline-block px-2 py rounded-full bg-green-200 text-green-800"> <?=getStatusLabelProject($all_project_popup->status)?> </div>
<button class="py-1 whitespace-nowrap px-2 border border-primary rounded text-primary mr-10" style="display: flex; justify-content: flex-end; margin-top: 5px;" >View Details </button>
<hr/>
</li>
  
  <?php endforeach ;?>
  
</ul>


</div>

</div>

 </div>     



 <!-- POPUP PAGES SUCCESS PROJECTS -->
 <?php 
    $success_project_popup=Project::find()->where(["status"=>1])->all();
?>
 <div class="popup" id="popup-5">
<div class="overlay">
</div>

<div class="content">
    <div class="close-btn " onclick="togglePopup5()">&times;</div>
    
        <div>
      
   <ul class="list-group mt-5">
   <?php foreach ($success_project_popup as $success_project_popup) : ?>
  <li class="list-group-item">
<h6 class="truncate" style="color:#222; text-align: left;">
 
<?php
$project = Project::findOne($success_project_popup->id);
$project_tender = $project ? $project->tender_id : '';
$project_tender_id=Tender::findOne($project_tender);
$projectName = $project_tender_id ? $project_tender_id->title : '';


$p_manager_pop=User::findOne(['id'=>$success_project_popup->user_id]);
?>
<?=$projectName?>
</h6>
<h6 style="color:cornflowerblue; text-align:left;">
Budget: <?=$success_project_popup->budget ?>
</h6>
<p style="color:grey; text-align:left;">Start Date:<span style="color:#222;"><?= Yii::$app->formatter->asDatetime($success_project_popup->start_at) ?></span>  End/Deadline:<span style="color:mediumseagreen;"> <?= Yii::$app->formatter->asDatetime($success_project_popup->end_at )?> </span>  Project Manager: <?=$p_manager_pop->username ?></p>
  
  <div class="tender-label inline-block px-2 py rounded-full bg-green-200 text-green-800"> <?=getStatusLabelProject($success_project_popup->status)?> </div>
<button class="py-1 whitespace-nowrap px-2 border border-primary rounded text-primary mr-10" style="display: flex; justify-content: flex-end; margin-top: 5px;" >View Details </button>
<hr/>
</li>
  
  <?php endforeach ;?>
  
</ul>


</div>

</div>

 </div>     



 <!-- POPUP PAGES PROGRESS PROJECTS -->
 <?php 
    $hold_project_popup=Project::find()->where(["status"=>2])->all();
?>
 <div class="popup" id="popup-6">
<div class="overlay">
</div>

<div class="content">
    <div class="close-btn " onclick="togglePopup6()">&times;</div>
    
        <div>
      
   <ul class="list-group mt-5">
   <?php foreach ($hold_project_popup as $hold_project_popup) : ?>
  <li class="list-group-item">
<h6 class="truncate" style="color:#222; text-align: left;">
 
<?php
$project = Project::findOne($hold_project_popup->id);
$project_tender = $project ? $project->tender_id : '';
$project_tender_id=Tender::findOne($project_tender);
$projectName = $project_tender_id ? $project_tender_id->title : '';


$p_manager_pop=User::findOne(['id'=>$hold_project_popup->user_id]);
?>
<?=$projectName?>
</h6>
<h6 style="color:cornflowerblue; text-align:left;">
Budget: <?=$hold_project_popup->budget ?>
</h6>
<p style="color:grey; text-align:left;">Start Date:<span style="color:#222;"><?= Yii::$app->formatter->asDatetime($hold_project_popup->start_at) ?></span>  End/Deadline:<span style="color:mediumseagreen;"> <?= Yii::$app->formatter->asDatetime($hold_project_popup->end_at )?> </span>  Project Manager: <?=$p_manager_pop->username ?></p>
  
  <div class="tender-label inline-block px-2 py rounded-full bg-green-200 text-green-800"> <?=getStatusLabelProject($hold_project_popup->status)?> </div>
<button class="py-1 whitespace-nowrap px-2 border border-primary rounded text-primary mr-10" style="display: flex; justify-content: flex-end; margin-top: 5px;" >View Details </button>
<hr/>
</li>
  
  <?php endforeach ;?>
  
</ul>


</div>

</div>

 </div>     

                

        <?php
function getStatusLabel($status)
{
    $statusLabels = [
      1 => '<span class="badge badge-success">Completed</span>',
      2 => '<span class="badge badge-warning">Onprogress</span>',
      3 => '<span class="badge badge-secondary">On Hold</span>',
    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}

function getStatusLabelProject($status)
{
    $statusLabels = [
      1 => 'Completed',
      2 => 'Onprogress',
      3 => 'On Hold',
    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}

function getStatusLabelTender($status)
{
    $statusLabels = [
        1 => 'Awarded',
        2 => 'Not-awarded',
        3 => 'Submitted',
        4 => 'Not-submtted',
        5 => 'On-progress',

    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}
?>

<script>

    function togglePopup(){
        document.getElementById("popup-1").classList.toggle("active");
    }

    function togglePopup2(){
        document.getElementById("popup-2").classList.toggle("active");
    }

    function togglePopup3(){
        document.getElementById("popup-3").classList.toggle("active");
    }

    function togglePopup4(){
        document.getElementById("popup-4").classList.toggle("active");
    }

    function togglePopup5(){
        document.getElementById("popup-5").classList.toggle("active");
    }


    function togglePopup6(){
        document.getElementById("popup-6").classList.toggle("active");
    }
</script>