<?php
    // Get the current route URL

use app\models\Adetail;
use dosamigos\chartjs\ChartJs;
use app\models\Department;
use app\models\Prequest;
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

$this->registerJsFile('https://cdn.plot.ly/plotly-latest.min.js', ['position' => View::POS_HEAD]);

?>
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

<style>
  div {
    color: grey;
  }

  .card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
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

    .scrow{
        position: absolute;
        width: 940px;
        height: 400px;
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


/* Style for small boxes */
.small-box {
  border-radius: 10px;
  position: relative;
  display: block;
  overflow: hidden;
  margin-bottom: 20px;
  box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}

.bg-unsubmit {
    background-color: #6d6d97; 
  color: white;
}

.bg-total {
    background-color: #69a6a0; 
  color: white;
}

.bg-complete {
    background-color: #73c48f; 
  color: white;
}

.bg-fail {
    background-color: #d0a475; 
  color: white;
}

.bg-budget {
    background-color: #db7171; 
  color: white;
}



/* Inner content styling */
.small-box .inner {
  padding: 10px;
}

/* Icon styling */
.small-box .icon {
  position: absolute;
  top: 10px;
  right: 10px;
  text-align: right;
  font-size: 70px;
  color: rgba(0,0,0,0.15);
}

/* Footer styling */
.small-box-footer {
  background: rgba(0,0,0,0.1);
  display: block;
  padding: 3px 0;
  text-align: center;
  color: #333;
  text-decoration: none;
}

.small-box-footer:hover {
  background: rgba(0,0,0,0.2);
  color: #fff;
}

/* Specific box colors */
.bg-info {
  background-color: #17a2b8 !important;
  color: white;
}

.bg-success {
  background-color: #28a745 !important;
  color: white;
}

.bg-warning {
  background-color: #ffc107 !important;
  color: white;
}



.bg-danger {
  background-color: #dc3545 !important;
  color: white;
}
.container-fluid h3, p, a {
    color:#fff;
    font-size: large;
    font-weight: 700;
   
}

.container-fluid h3 {
  font-weight: 700;
  font-size: 2.2rem; /* Note: No space between value and unit */
  font-family: inherit;
}


</style>

   <!-- top tiles -->
   <?php

        $projectHolds = Project::find()
            ->Where(['status' => 2])
            ->count();

        ?>


<div class="row justify-content-center">
  <!-- PROJECT MANAGEMENT SUMMARY-->
  <div class="tile_count">
  <!-- /admin dash  -->
  <?php if (Yii::$app->user->can('admin')) : ?>


<div class="row">


    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <!--Tender Cards-->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $tender ?></h3>

                <p>Published Tender</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="/tender" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


<!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $tenderWin ?><sup style="font-size: 20px"></sup></h3>

                <p>Awarded Tender</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="/tender/success" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $tenderSubmit ?></h3>

                <p>Submitted Tender</p>
              </div>
              <div class="icon">
                <i class="ion ion-share"></i>
              </div>
              <a href="/tender/submit" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

<div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-unsubmit">
              <div class="inner">
                <h3><?= $tenderFail ?></h3>

                <p>Not Submitted Tender</p>
              </div>
              <div class="icon">
                <i class="ion ion-unlocked"></i>
              </div>
              <a href="/tender/unsubmit" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

        <!-- Projects Cards-->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-total">
              <div class="inner">
                <h3><?= $total ?></h3>

                <p>Total Projects</p>
              </div>
              <div class="icon">
                <i class="ion ion-calendar"></i>
              </div>
              <a href="/project" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

<!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-complete">
              <div class="inner">
                <h3><?= $successCount ?><sup style="font-size: 20px"></sup></h3>

                <p>Complete Projects</p>
              </div>
              <div class="icon">
                <i class="ion ion-chatbox-working"></i>
              </div>
              <a href="/project/complete" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-fail">
              <div class="inner">
                <h3><?= $fail ?></h3>

                <p>Fail Projects</p>
              </div>
              <div class="icon">
                <i class="ion ion-battery-charging""></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


<!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-budget">
              <div class="inner">
              <?php
                    $formattedBudgetadmin = number_format($totalBudget, 2)
                    ?>
                <h3><?=$formattedBudgetadmin?></h3>

                <p>Total Projects Budget</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
    <!-- OnProgress Projects Card -->



  <!--
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="/project/progress" class="card-link">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto mr-3">
                            <img src="https://cdn-icons-png.flaticon.com/128/10327/10327589.png" style="width: 35px;" class="card-icon">
                        </div>
                        <div class="col">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">OnProgress Projects</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$projectHolds?></div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>-->


<!--
<div class="col-xl-3 col-md-6 mb-4">
     <a  onclick="togglePopup6()">
     <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="text-xs font-weight-bold  text-uppercase mb-1">Total Projects Budget
                    </div>
                    <?php
                    $formattedBudgetadmin = number_format($totalBudget, 2)
                    ?>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"> TSH <?=$formattedBudgetadmin?></div>

                </div>
                <div class="col-auto">
                <i class="badge" ><img src="https://cdn-icons-png.flaticon.com/128/12371/12371123.png" style="width:38px;"></i>
                </div>
            </div>
        </div>
    </div>
     </a>
</div>-->

</div>

<?php endif; ?>

<?php

        $projectHolds = Project::find()
            ->Where(['status' => 2])
            ->count();

        ?>

<?php

// new tenders not working yet

        $allNewTnd=Tender::find()
           ->where(['session'=>0])
           ->count();
        ?>
   

<!-- /Project Manager Dashboard -->

<?php if (Yii::$app->user->can('author') && ! Yii::$app->user->can('admin')) : ?>
    <div class="tile_count">
    <div class="row">
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
<a href="">
<?php
        $userId = Yii::$app->user->getId();

        $user_assignments = Adetail::find()
        ->where(['user_id' => $userId])
        ->all();

    $assignedTenderIds = [];
    foreach ($user_assignments as $user_assignment) {
        $assignedTenderIds[] = $user_assignment->tender_id;
    }

        $tassgntend=Tender::find()
           ->where(['id' => $assignedTenderIds])
           ->count();
        ?>
 <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                    Total Assigned Tender</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  $tassgntend?></div>
                </div>
                <div class="col-auto">
                <i class="badge" ><img src="https://cdn-icons-png.flaticon.com/128/4405/4405051.png" style="width:35px;"></i>
                </div>
            </div>
        </div>
    </div>
</a>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
<a  href="">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <?php
        $userId = Yii::$app->user->getId();

        $user_assignments = Adetail::find()
        ->where(['user_id' => $userId])
        ->all();

    $assignedTenderIds = [];
    foreach ($user_assignments as $user_assignment) {
        $assignedTenderIds[] = $user_assignment->tender_id;
    }

        $tend=Tender::find()
           ->where(['id' => $assignedTenderIds])
           ->andWhere(['session'=>0])
           ->count();
        ?>
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">New Assigned Tender
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tend ?></div>

                </div>
                <div class="col-auto">
                    <i class="badge" ><img src="https://cdn-icons-png.flaticon.com/128/5847/5847233.png" style="width:35px;"></i>
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
                    <?php
        $userId = Yii::$app->user->getId();
        $projectCount = Project::find()
            ->where(['user_id' => $userId])
            ->count();
        ?>
                    Assigned Project</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $projectCount ?></div>
                </div>
                <div class="col-auto">
                <i class="badge" ><img src="https://cdn-icons-png.flaticon.com/128/7156/7156236.png" style="width:35px;"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
<a  href="">
    <div class="card border-left-primary shadow h-100 py-2">
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
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$projectSuccess?></div>
                </div>
                <div class="col-auto">
                <i class="badge" ><img src="https://cdn-icons-png.flaticon.com/128/4875/4875033.png" style="width:35px;"></i>
                </div>
            </div>
        </div>
    </div>
</a>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
<a  href="">
    <div class="card border-left-primary shadow h-100 py-2">
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
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$projectHold?></div>
                </div>
                <div class="col-auto">
                <i class="badge" ><img src="https://cdn-icons-png.flaticon.com/128/1087/1087927.png" style="width:35px;"></i>
                </div>
            </div>
        </div>
    </div>
</a>
</div>


<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
<a  href="">
    <div class="card border-left-primary shadow h-100 py-2">
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
                  Fail Projects</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$projectFail?></div>
                </div>
                <div class="col-auto">
                <i class="badge" ><img src="https://cdn-icons-png.flaticon.com/128/10150/10150424.png" style="width:35px;"></i>
                </div>
            </div>
        </div>
    </div>
</a>
</div>
<div class="col-xl-3 col-md-6 mb-4">
     <a  onclick="togglePopup6()">
    <div class="card border-left-info shadow h-100 py-2">
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
                <div class="text-xs font-weight-bold  text-uppercase mb-1"> Projects Budget
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"> TSH <?= $formattedBudget ?></div>

                </div>
                <div class="col-auto">
                <i class="badge" ><img src="https://cdn-icons-png.flaticon.com/128/10842/10842949.png" style="width:38px;"></i>
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
                    <?php
$prequests = Prequest::find()->all();

$proj_ass=Project::find()->where(['user_id'=>$userId])->all();


$ass_project_ids = [];

foreach ($proj_ass as $proj_ass) {
    $ass_project_ids[]= Prequest::findOne(['project_id'=>$proj_ass->id, 'session'=>0]);
}

$newRequestCount = count($ass_project_ids);
?>

<div>
    New Requests
</div>
<div class="h5 mb-0 font-weight-bold text-gray-800">
    <?= $newRequestCount ?>
</div>
                </div>
                <div class="col-auto">
                <i class="badge" ><img src="https://cdn-icons-png.flaticon.com/128/7156/7156236.png" style="width:35px;"></i>
                </div>
            </div>
        </div>
 </div>
</div>


</div>
    </div>
<?php endif; ?>
<!-- /pm end -->
<!-- /top tiles -->



<?php
$awardPercent =0;
$submmitPercent=0;
$notsubmitPercent=0;
$allNewTndPercent=0;

$completePercent=0;
$onprogressPercent=0;
$failPercent=0;


if($tender!=0){
    //Percentage of Award Tenders
$awardPercent=($tenderWin/$tender)*100;
}

if($tender!=0){
//Percentage of Submit Tenders
$submmitPercent=($tenderSubmit/$tender)*100;
}

if($tender!=0){
//Percentage of NotSubmit Tenders
$notsubmitPercent=($tenderFail/$tender)*100;
} 

if($tender!=0){
//Percentage of All new Tenders
$allNewTndPercent=($allNewTnd/$tender)*100;
}

?>


<?php
if($total!=0){
//Percentage of Success Project
$completePercent=($successCount/$total)*100;
}

if($total!=0){
//Percentage of Onprogress Projects
$onprogressPercent=($projectHolds/$total)*100;
}

if($total!=0){
//Percentage of Fail Projetcts
$failPercent=($fail/$total)*100;
}
?>

<?php if ((Yii::$app->user->can('author') && Yii::$app->user->can('admin')) || Yii::$app->user->can('admin')) : ?>
        <?php

        $projectHolds = Project::find()
            ->Where(['status' => 2])
            ->count();

        ?>
        <div class="chart-container" style="margin-bottom: 5%;">
  <div id="myDiv" style="display: inline-block;"></div>
  <div id="chartContainer" style="display: inline-block; height: 300px; width: 60%;"></div>
</div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>


<script>


  var awardPercent = <?= $awardPercent ?>;
    var submmitPercent = <?= $submmitPercent ?>;
    var notsubmitPercent = <?= $notsubmitPercent ?>;
    var allNewTndPercent = <?= $allNewTndPercent ?>;

    var data = [{
        type: "pie",
        values: [awardPercent, submmitPercent, notsubmitPercent, allNewTndPercent],
        labels: ["Award", "Submit", "Not Submit", "New(no work progress)"],
        textinfo: "label+percent",
        textposition: "outside",
        automargin: true
    }];

    var layout = {
        height: 400,
        width: 400,
        margin: {"t": 0, "b": 0, "l": 0, "r": 0},
        title: {
            text: 'Tender Statistics', // Title text
            font: {
                size: 18 // Title font size
            },
            x: 0.5 // Title alignment, 0.5 means center
        },
        showlegend: false
    };


    Plotly.newPlot('myDiv', data, layout);
</script>

<script>
    window.onload = function() {
        var completePercent = <?php echo $completePercent; ?>;
        var onprogressPercent = <?php echo $onprogressPercent; ?>;
        var failPercent = <?php echo $failPercent; ?>;

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Project Statistics"
            },
            data: [{
                type: "pie",
                startAngle: 240,
                yValueFormatString: "##0.00\"%\"",
                indexLabel: "{label} {y}",
                dataPoints: [
                    {y: completePercent, label: "Completed"},
                    {y: onprogressPercent, label: "On Progress"},
                    {y: failPercent, label: "Failed"}
                ]
            }]
        });
        chart.render();
    }
</script>


<?php endif;?>

          <div class="row">
  <div class="col-md-12 col-sm-12">
    


      <?php if (Yii::$app->user->can('admin') && !Yii::$app->user->can('author')) : ?>
    <!-- Include the latest version of Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <h2 class="text-muted mt-10 text-center">A Graph Of Project Against Profit</h2>
      <div class="chart-container">
        <canvas id="lineChart" style="width: 100%; height: 400px;"></canvas>
      </div>
    </div>
    <div class="col-md-6">
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

                <p class="text-muted mb-0 " style="font-size: .60rem;">Publish: <?=Yii::$app->formatter->asDatetime($tender->publish_at)?>, Submitt:<>
                <?php endforeach;?>
              </div>

            </div>
          </div>-->

 <div class="row">
  <!--  <div class="col-md-6" style="margin-left: 5px; margin-right: 5px;">
        <div class="card mb-4 mb-md-0">
            <div class="card-body">
                <p class="mb-4"><span class="text-primary font-italic me-1">Assignment</span> Project Assigned as Project Manager</p>

                <?php foreach ($projectsum as $project): ?>
                    <?php
                    $project_title = Tender::findOne($project->tender_id);
                    ?>
                    <?php if($project_title!==null):?>
                    <p class="mb-1" style="font-size: .77rem;"><?= $project_title->title ?> <?= getStatusLabel($project->status) ?></p>
                    <p class="text-muted mb-0" style="font-size: .60rem;">
                        Start: <?= Yii::$app->formatter->asDatetime($project->start_at) ?>, End: <?= Yii::$app->formatter->asDatetime($project->end_at)?>
                    </p>
                    <?php endif;?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>-->

<!-- <div class="col-md-6" style="margin-left: 5px; margin-right: 5px;">
        <div class="card mb-4 mb-md-0">
            <div class="card-body">
                <p class="mb-4"><span class="text-primary font-italic me-1">Assignment</span> Projects Assigned as Member of Team</p>

                <?php foreach ($project_team as $project): ?>
                    <?php
                    $project_title = Tender::findOne($project->tender_id);
                    ?>
                        <?php if($project_title!==null):?>
                    <p class="mb-1" style="font-size: .77rem;"><?= $project_title->title ?> <?= getStatusLabel($project->status) ?></p>
                    <p class="text-muted mb-0" style="font-size: .60rem;">
                        Start: <?= Yii::$app->formatter->asDatetime($project->start_at) ?>, End: <?= Yii::$app->formatter->asDatetime($project->end_at) ?>
                    </p>
                    <?php endif;?>

                <?php endforeach; ?>
            </div>
        </div>
    </div>-->
</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  <?php endif;?>
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


