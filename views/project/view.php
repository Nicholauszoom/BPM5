<?php

use app\models\Analysis;
use app\models\Prequest;
use app\models\Project;
use app\models\Rdetail;
use app\models\Request;
use app\models\TeamAssignment;
use app\models\Tender;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Project $model */

     
$project = Project::findOne($model->id);
$project_tender = $project ? $project->tender_id : '';
$project_tender_id=Tender::findOne($project_tender);
$projectName = $project_tender_id ? $project_tender_id->title : '';
$this->title = 'View for :' . $projectName . ' Project';

$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->context->layout = 'admin';

       /*s AIM OF THIS OPERATION IS TO SHOW THE BUDGET PROGRESS / REMAINNING*/
//project budget per request
$remainingBudget = 0;
$budgetss = Prequest::find()
->where(['project_id' => $model->id])
->andWhere(['status'=>3])
->all();

$budget_prog = 0;
foreach ($budgetss as $progress) {
    $progressr=Rdetail::findOne(['prequest_id'=>$progress->id]);
$budget_prog += $progressr->amount;
    
$remainingBudget = $projectAmount - $budget_prog;

}
    
//logged in use
$userId = Yii::$app->user->id;
    
?>

<a href="<?= Yii::$app->request->referrer ?>" class="back-arrow">
    <span class="arrow">&#8592;</span> Back
</a>

   
        <!-- ============================================================== -->
        <!-- Sales Cards  -->
        <!-- ============================================================== -->
        
        <div class="row">
<div class="project-view col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('author') && $model->user_id== $userId) : ?>
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
    <?php endif;?>

    <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Project</button>
    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Analysis</button>
    <button class="nav-link" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled" type="button" role="tab" aria-controls="nav-disabled" aria-selected="false" >Task</button>

</div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
       
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
              'attribute'=>'tender_id',
              'format'=>'raw',
              'value'=>function ($model){
                  $tender = Tender::findOne($model->tender_id);
                  $tenderTitle = $tender ? $tender->title : 'Unknown';
                   return $tenderTitle;
              },
          ],
            'description:ntext',
            'budget',
            
            // [
            //     'attribute' => 'user_id',
            //     'value' => 'user.email',
            // ],
            [
                'attribute'=>'user_id',
                'format'=>'raw',
                'value'=>function ($model){
                    $createdByUser = User::findOne($model->user_id);
                    $createdByName = $createdByUser ? $createdByUser->username : 'Unknown';
                     return $createdByName;
                },
            ],

            [
              'attribute' => 'team',
              'format' => 'raw',
              'value' => function ($model) {
                  $assignments = TeamAssignment::find()
                      ->where(['project_id' => $model->id])
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

            [
                'attribute' => 'start_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->start_at);
                },
            ],
            [
                'attribute' => 'end_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->end_at);
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
              'attribute' => 'remainingBudget',
              'format' => 'raw',
              'value' => function ($model) use ($budget_prog, $projectAmount, $remainingBudget) {
                  
                  $percentageComplete = ($projectAmount != 0) ? round(($budget_prog / $projectAmount) * 100, 2) : 0;
                  $percentageRemaining = ($projectAmount != 0) ? round(($remainingBudget / $projectAmount) * 100, 2) : 0;
          
                  $progressBar = '<div class="progress progress_sm">';
                  $progressBar .= '<div class="progress-bar bg-blue" role="progressbar" style="width: ' . $percentageComplete . '%;"></div>';
                  $progressBar .= '</div>';
                  $progressBar .= '<small>' . $percentageComplete . '% Complete</small>';
          
                  $progressBar .= '<div class="progress progress_sm">';
                  $progressBar .= '<div class="progress-bar bg-warning" role="progressbar" style="width: ' . $percentageRemaining . '%;"></div>';
                  $progressBar .= '</div>';
                  $progressBar .= '<small>' . $remainingBudget . ' Remaining out of ' . $projectAmount . ' and Used ' .  $budget_prog. '</small>';
          
                  return $progressBar;
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
            
//          [
//     'attribute' => 'status',
//     'value' => function ($model) {
//         return getStatusLabel($model->status);
//     },
//     'format' => 'raw',
//     'contentOptions' => ['class' => function ($model) {
//         return getStatusClass($model->status);
//     }],
//     'headerOptions' => ['class' => 'status-column-header'],
//     'class' => 'yii\grid\DataColumn',
// ],
            // 'progress',
            //  'status',
            
            // 'created_by',
            [
              'attribute' => 'invite_letter',
              'format' => 'raw',
              'value' => function ($model) {
                  $fileName = $model->invite_letter;
                  $filePath = Yii::getAlias('/upload/' . $fileName);
                  $downloadPath = Yii::getAlias('/upload/' . $fileName);
                  return $model->invite_letter ? Html::a('<i class="fa fa-file-pdf" aria-hidden="true"></i> ' . $model->invite_letter, $downloadPath, ['class' => 'btn btn-', 'target' => '_blank']) : '';
              },
          ],
          [
            'attribute' => 'Performance Guarantee',
            'format' => 'raw',
            'value' => function ($model) {
                $fileName = $model->performance;
                $filePath = Yii::getAlias('/upload/' . $fileName);
                $downloadPath = Yii::getAlias('/upload/' . $fileName);
                return $model->performance ? Html::a('<i class="fa fa-file-pdf" aria-hidden="true"></i> ' . $model->performance, $downloadPath, ['class' => 'btn btn-', 'target' => '_blank']) : '';
            },
        ],
        [
          'attribute' => 'Contract Document',
          'format' => 'raw',
          'value' => function ($model) {
              $fileName = $model->contract;
              $filePath = Yii::getAlias('/upload/' . $fileName);
              $downloadPath = Yii::getAlias('/upload/' . $fileName);
              return $model->contract ? Html::a('<i class="fa fa-file-pdf" aria-hidden="true"></i> ' . $model->contract, $downloadPath, ['class' => 'btn btn-', 'target' => '_blank']) : '';
          },
      ],
            [
              'attribute' => 'document',
              'format' => 'raw',
              'value' => function ($model) {
                  $fileName = $model->document;
                  $filePath = Yii::getAlias('/upload/' . $fileName);
                  $downloadPath = Yii::getAlias('/upload/' . $fileName);
                  return $model->document ? Html::a('<i class="fa fa-file-pdf" aria-hidden="true"></i> ' . $model->document, $downloadPath, ['class' => 'btn btn-', 'target' => '_blank']) : '';
              },
          ],
        ]
    ]) ?>

  </div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
    <?php $form = ActiveForm::begin(['action' => ['analysis/delete-multiple']]) ?>
<div style="margin-left:85%;">
<?= Html::submitButton('Delete Selected', ['class' => 'btn btn-danger']) ?>
</div>

<table class="table">
  <thead>
    <tr style="background-color: #f2f2f2;">
    <th scope="col"><?= Html::checkbox('checkAll', false, ['id' => 'checkAll']) ?> All</th>
      <th scope="col">item</th>
      <th scope="col">quantity</th>
      <th scope="col">Unit</th>
      <th scope="col">Unit Price(Cotted)</th>
      <th scope="col">Amount(Cotted)</th>
      <th scope="col">Unit Price(Buying.price)</th>
      <th scope="col">Total Amount(Buying)</th>
      <th scope="col">Unit Profit</th>
      <th scope="col">source</th>
   <!--   <th scope="col">other attachment..</th>-->
      <th scope="col">Prepaired By</th>
      <th scope="col">status</th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($analysis as $analysis): ?>
    <tr>
    <td><?= Html::checkbox('deleteItems[]', false, ['value' => $analysis->id,'class' => 'checkbox-item']) ?></td>
      <td><?= $analysis->item ?></td>
      <td><?= $analysis->quantity ?></td>
      <td><?= $analysis->description ?></td>
      <td><?= $analysis->setunit?></td>
      <td><?= $analysis->cotedAmount?></td>
      <td><?= $analysis->unit?></td>
      <td><?= $analysis->cost ?></td>
      <td><?= $analysis->unitprofit ?></td>
      <td><?= $analysis->source?></td>
  
<td>
      <?php
                $createdByUser = User::findOne($analysis->created_by);
                $createdByName = $createdByUser ? $createdByUser->username : 'Unknown';
                echo $createdByName;
            ?>
      </td>
      <td><?=getStatusLabel($analysis->status)?></td>
      <td>
    <?php
    $requestSum = Request::find()
        ->where(['analysis_id' => $analysis->id])
        ->andWhere(['status' => 1])
        ->sum('ref');
    ?>

    <?php if ($requestSum == $analysis->quantity && $analysis->quantity != 0): ?>
        <?= Html::label('.', null, ['class' => 'badge badge-warning glyphicon glyphicon-ok ']) ?>
    <?php endif; ?>
</td>
      <td>
      <?= Html::a('<span class="glyphicon glyphicon-file"></span>', ['request/create', 'analysisId' => $analysis->id], [
    'title' => 'request',
    'data-method' => 'post',
    'data-pjax' => '0',
]) ?>

<?php if (Yii::$app->user->can('author') && $model->user_id== $userId) : ?>
      <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['analysis/update', 'id' => $analysis->id], [
            'title' => 'Update',
            'data-method' => 'post',
            'data-pjax' => '0',
        ]) ?>
<?php endif?>
<?php if (Yii::$app->user->can('author') && $model->user_id== $userId) : ?>
      <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['analysis/delete', 'id' => $analysis->id], [
            'title' => 'Delete',
            'data-method' => 'post',
            'data-pjax' => '0',
        ]) ?>
<?php endif?>
      </td>
<td>
    </tr>
    <?php endforeach; ?>
    <tr>
      
      <td>
      <?php if (Yii::$app->user->can('author') && $model->user_id== $userId) : ?>

        <?= Html::a('+ Add a document',  [ 'analysis/create', 'projectId' => $model->id]) ?>
        <?php endif;?>

      </td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>.</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td style="background-color: #f2f2f2;">Total Amount: TSH <?=$projectAmount?></td>
      <td style="background-color: #f2f2f2;">Profit:TSH <?=$profit?></td>
      <td style="background-color: #f2f2f2;">Percentage Profit(%) <?=$profitPerce?>%</td>
      <td style="background-color: #f2f2f2;"></td>
      <td style="background-color: #f2f2f2;"></td>
      <td style="background-color: #f2f2f2;"></td>
    </tr>
  </tbody>
</table>

<?php ActiveForm::end() ?>
  </div>

  <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">
  <div class="text-muted">

<table class="table">
  <thead>
    <tr style="background-color: #f2f2f2;">
      <th scope="col">#</th>
      <th scope="col">Task</th>
      <th scope="col">Budget</th>
      <th scope="col">Description</th>
      <th scope="col">Start At</th>
      <th scope="col">End At</th>
      <th scope="col">Status</th>
      <td scope="col"></td>
      
    </tr>
  </thead>
  <tbody>
  <?php foreach ($tasks as $task): ?>
    <tr>
      <th scope="row">1</th>
      <td><?= $task->title ?></td>
      <td><?= $task->budget ?></td>
      <td><?= $task->description ?></td>
      <td><?= Yii::$app->formatter->asDatetime($task->start_at) ?></td>
      <td><?= Yii::$app->formatter->asDatetime($task->end_at) ?></td>
      <td><?=getStatusLabel($task->status)?></td>

      <td>
               
                <?= Html::a('<span class="glyphicon glyphicon-share-alt"></span>', ['task/create', 'projectId' => $model->id], [
                    'title' => 'view',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]) ?>
            </td>
    

    </tr>
    <?php endforeach; ?>
    <tr>
      <td>
      <?php if (Yii::$app->user->can('author') && $model->user_id== $userId) : ?>
        <?= Html::a('+ Add a line', ['task/create', 'projectId' => $model->id]) ?>
      <?php endif;?>
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

  </div>

<?php



// $currentDate = date('m-d-Y');

// if ($model->end_at) {
//     if ($currentDate < $model->end_at) {
//         echo '<span class="alert alert-success">Not Yet Expired</span>';
//     } else {
//         echo '<span class="alert alert-danger">Expired</span>';
//     }
// }
// ?>


<?php
$js = <<<JS
    $('#checkAll').click(function () {
        $('.checkbox-item').prop('checked', this.checked);
    });
JS;
$this->registerJs($js);
?>

</div>

<?php
function getStatusLabel($status)
{
    $statusLabels = [
        1 => '<span class="badge badge-success">Approved</span>',
        2 => '<span class="badge badge-warning">Not Approved</span>',
        0 => '<span class="badge badge-secondary">On Process</span>',
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
?>


</div>
</div>



<script>
 $('#checkAll').click(function () {
        $('.checkbox-item').prop('checked', $(this).is(':checked'));
    });
</script>

