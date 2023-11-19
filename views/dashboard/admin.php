<?php
    // Get the current route URL

use app\models\Adetail;
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
<!--    <a  aria-controls="" onclick="togglePopup()">-->
<a  aria-controls="" href="/tender">

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
                    <i class="badge" ><img src="https://cdn-icons-png.flaticon.com/128/2328/2328936.png" style="width:35px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <!--<a  onclick="togglePopup2()">-->
    <a  aria-controls="" href="/tender/success">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                            Awarded Tender
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tenderWin ?></div>
                    </div>
                    <div class="col-auto">
                    <i class="badge "><img src="https://cdn-icons-png.flaticon.com/128/12503/12503629.png" style="width:35px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
 <!--<a  onclick="togglePopup3()"> __-->
 <a  aria-controls="" href="/tender/submit">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">Submitted Tender
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tenderSubmit?></div>

                </div>
                <div class="col-auto">
                <i class="badge "><img src="https://cdn-icons-png.flaticon.com/128/9497/9497842.png" style="width:35px;"></i>
                </div>
            </div>
        </div>
    </div>
</a>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
 <!--<a  onclick="togglePopup3()"> __-->
 <a  aria-controls="" href="/tender/unsubmit">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">Not Submitted Tender
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tenderFail?></div>

                </div>
                <div class="col-auto">
                <i class="badge "><img src="https://cdn-icons-png.flaticon.com/128/12474/12474134.png" style="width:35px;"></i>
                </div>
            </div>
        </div>
    </div>
</a>
</div>


    
<!-- /pm end -->
  </div>
        
    <div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
<a  href="/project">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                    Total Projects</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total ?></div>
                </div>
                <div class="col-auto">
                <i class="badge" ><img src="https://cdn-icons-png.flaticon.com/128/4946/4946342.png" style="width:35px;"></i>
                </div>
            </div>
        </div>
    </div>
</a>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
<a href="/project/complete">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                    Complete Projects</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $successCount ?></div>
                </div>
                <div class="col-auto">
                <i class="badge" ><img src="https://cdn-icons-png.flaticon.com/128/9733/9733034.png" style="width:35px;"></i>
                </div>
            </div>
        </div>
    </div>
</a>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
<a  href="/project/progress">
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
                    <i class="badge" ><img src="https://cdn-icons-png.flaticon.com/128/10327/10327589.png" style="width:35px;"></i>
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
                <i class="badge" ><img src="https://cdn-icons-png.flaticon.com/128/4476/4476841.png" style="width:35px;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
     <a  onclick="togglePopup6()">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="text-xs font-weight-bold  text-uppercase mb-1">Total Projects Budget
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"> TSH <?=$totalBudget ?></div>

                </div>
                <div class="col-auto">
                <i class="badge" ><img src="https://cdn-icons-png.flaticon.com/128/12371/12371123.png" style="width:38px;"></i>
                </div>
            </div>
        </div>
    </div>
     </a>
</div>

</div>

<?php endif; ?>
      

<!-- /Project Manager Dashboard -->
<?php if (Yii::$app->user->can('author') && ! Yii::$app->user->can('admin')) : ?>
    <div class="tile_count">
    <div class="row">
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
<a href="">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">
                    Published Tender</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tender ?></div>
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
                    <div class="text-xs font-weight-bold  text-uppercase mb-1">Assigned Tender
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


</div>
    </div>
<?php endif; ?>
<!-- /pm end -->
<!-- /top tiles -->
       
           
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
                    <?php if($project_title!==null):?>
                    <p class="mb-1" style="font-size: .77rem;"><?= $project_title->title ?> <?= getStatusLabel($project->status) ?></p>
                    <p class="text-muted mb-0" style="font-size: .60rem;">
                        Start: <?= Yii::$app->formatter->asDatetime($project->start_at) ?>, End: <?= Yii::$app->formatter->asDatetime($project->end_at) ?>
                    </p>
                    <?php endif;?>
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
                        <?php if($project_title!==null):?>
                    <p class="mb-1" style="font-size: .77rem;"><?= $project_title->title ?> <?= getStatusLabel($project->status) ?></p>
                    <p class="text-muted mb-0" style="font-size: .60rem;">
                        Start: <?= Yii::$app->formatter->asDatetime($project->start_at) ?>, End: <?= Yii::$app->formatter->asDatetime($project->end_at) ?>
                    </p>
                    <?php endif;?>

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