<?php
use app\models\Office;
use app\models\Tdetails;
use app\models\Tender;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->context->layout = 'admin';
?>

<div id="main-content">
    <div id="page-container">
        <h1>Projects Report</h1>
        <hr>

        <p>Date Range: <?= Html::encode($dateFrom) ?> - <?= Html::encode($dateTo) ?></p>

        <table class="table table-striped" >
            <thead>
                <tr>
                    <th scope="col">Tender Title</th>
                    <th scope="col">Project Manager</th>
                    <th scope="col">Publish Date</th>
                    <th scope="col">Expired Date</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project): ?>
                    <tr>
                        <?php 
                           $tender=Tender::findOne(['id'=>$project->tender_id]);
                        ?>
                        <td scope="row"><?= Html::encode($tender->title) ?></td>
                        <?php $pm = User::findOne($project->user_id); ?>
                        <td><?= $pm->username ?></td>
                        <td><?= Yii::$app->formatter->asDatetime($project->start_at) ?></td>
                        <td><?= Yii::$app->formatter->asDatetime($project->end_at) ?></td>
                        <td><?= Yii::$app->formatter->asDatetime($project->created_at) ?></td>
                        <td><?= getStatusLabel($project->status) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Project Report</h2>
        <hr>
        <ol>
            <?php foreach ($projects as $project): ?>
                <li>
                <?php 
                           $tender=Tender::findOne(['id'=>$project->tender_id]);
                        ?>
                    <h3 class="tender-title"><?= $tender->title ?></h3>
                    <ul class="tender-details">
                        <li><strong>Project Manager:</strong> <?= $pm->username ?></li>
                        <li><strong>Start Date:</strong> <?= Yii::$app->formatter->asDatetime($project->start_at) ?></li>
                        <li><strong>End Date:</strong> <?= Yii::$app->formatter->asDatetime($project->end_at) ?></li>
                        <li><strong>Created At:</strong> <?= Yii::$app->formatter->asDatetime($project->created_at) ?></li>
                        <li><strong>Status:</strong> <?= getStatusLabel($project->status) ?></li>
                    </ul>

                    <hr>
                </li>
            <?php endforeach; ?>
        </ol>
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

function getStatusClass($status)
{
    $statusClasses = [
       
        1 => 'status-active',
        2 => 'status-inactive',
        3 => 'status-onhold',
    ];

    return isset($statusClasses[$status]) ? $statusClasses[$status] : '';
}

function getSiteLabels($status)
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
