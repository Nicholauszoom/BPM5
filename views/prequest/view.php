<?php

use app\models\Department;
use app\models\Item;
use app\models\Rdetail;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Prequest $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Prequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->context->layout = 'admin';
$rdetails=Rdetail::find()
        ->where(['prequest_id'=>$model->id])
        ->all();

?>
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
    </p>

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

<h2>Request Details</h2>

<table class="table">
  <thead>
    <tr style="background-color: #f2f2f2;">
  
      <th scope="col">item</th>
      <th scope="col">unit price</th>
      <th scope="col">Qty</th>
      <th scope="col">Amount</th>
      <th scope="col">Created</th>
      <th scope="col">Updated</th>
      <th scope="col">Created By</th>
      <th scope="col"></th>
    </tr>
    </thead>
<tbody>
<?php foreach ($rdetails as $rdetails): ?>
    <tr>
      <?php
        $item=Item::findOne($rdetails->iteam);
      ?>
       
        <td><?=$item->name?></td>
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
   
            <?= Html::a('+ create request', '#', ['data-toggle' => 'modal', 'data-target' => '#createModal']) ?>
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
