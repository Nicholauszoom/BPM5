<?php

use app\models\Department;
use app\models\Prequest;
use app\models\Project;
use app\models\Tender;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PrequestSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Request';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin';

?>
<div class="prequest-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
     <?php if(Yii::$app->user->can('author') &&! Yii::$app->user->can('admin')):?>
  
         <?= GridView::widget([
    'dataProvider' => new \yii\data\ArrayDataProvider([
        'allModels' => $prequest,
        'pagination' => [
            'pageSize' => 10, // Adjust the page size as per your requirement
        ],
        'sort' => [
            'attributes' => [
                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Created At',
                ],
            ],
            'defaultOrder' => [
                'created_at' => SORT_DESC,
            ],
        ],
    ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'project_id',
                'format' => 'raw',
                'value' => function ($model) {
                    $project= Project::findOne($model->project_id);
                    $tender = Tender::findOne($project->tender_id);
                    $tenderTitle = $tender ? $tender->title : 'Unknown';
                    $label = $model->session ? '' : Html::tag('span', 'New', ['class' => 'badge badge-warning']);
                    return '<div style="display: flex; align-items: flex-start;">' . $label . '<span style="margin-left: 5px;">' . $tenderTitle . '</span></div>';
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
                'attribute' => 'mode',
                'value' => function ($model) {
                    return getModeLabel($model->mode);
                },
                'format' => 'raw',
                'contentOptions' => function ($model) {
                    return ['class' => getModeLabel($model->mode)];
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
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return getStatusLabel($model->status);
                },
                'format' => 'raw',
                'contentOptions' => function ($model) {
                    return ['class' => getStatusLabel($model->status)];
                },
            ],
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, Prequest $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //      }
            // ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'template' => '<div style="display:flex; justify-content:center;">{view} {update} {delete} {download}</div>',
                'buttons' => [

                    'view' => function ($url, $model, $key) {
                        return Html::a(
                            '<span class="fas fa-eye"></span>',
                            ['view', 'id' => $model->id],
                            [
                                'title' => 'View invoice',
                                'aria-label' => 'Invoice view',
                                'id' => 'view',
                                'onclick' => 'showBar();',
                            ]
                        );
                    },

                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="fas fa-pencil-alt"></span>', ['update', 'id' => $model->id], [
                            // 'class' => 'btn btn-success',
                            'title' => 'edit request',
                            'aria-label' => 'request edit',
                        ]);
                    },

                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="fas fa-trash-alt"></span>', ['delete', 'id' => $model->id], [
                            // 'class' => 'btn btn-success',
                            'title' => 'delete request',
                            'aria-label' => 'request delete',
                        ]);
                    },

                    'download' => function ($url, $model, $key) {
                        return Html::a('<span class="fa fa-download"></span>', ['report', 'id' => $model->id], [
                            // 'class' => 'btn btn-success',
                            'title' => 'download request',
                            'aria-label' => 'request download',
                        ]);
                    },


                   
                ],
                
            ],
           
        ],
    ]); ?>
   
            <?php endif;?>

            <?php if(Yii::$app->user->can('admin') &&! Yii::$app->user->can('author')):?>

                <?= GridView::widget([
    'dataProvider' => new \yii\data\ArrayDataProvider([
        'allModels' => $approved_prequest,
        'pagination' => [
            'pageSize' => 10, // Adjust the page size as per your requirement
        ],
        'sort' => [
            'attributes' => [
                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Created At',
                ],
            ],
            'defaultOrder' => [
                'created_at' => SORT_DESC,
            ],
        ],
    ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'project_id',
                'format' => 'raw',
                'value' => function ($model) {
                    $project= Project::findOne($model->project_id);
                    $tender = Tender::findOne($project->tender_id);
                    $tenderTitle = $tender ? $tender->title : 'Unknown';
                    $label = $model->session ? '' : Html::tag('span', 'New', ['class' => 'badge badge-warning']);
                    return '<div style="display: flex; align-items: flex-start;">' . $label . '<span style="margin-left: 5px;">' . $tenderTitle . '</span></div>';
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
                'attribute' => 'mode',
                'value' => function ($model) {
                    return getModeLabel($model->mode);
                },
                'format' => 'raw',
                'contentOptions' => function ($model) {
                    return ['class' => getModeLabel($model->mode)];
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
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return getStatusLabel($model->status);
                },
                'format' => 'raw',
                'contentOptions' => function ($model) {
                    return ['class' => getStatusLabel($model->status)];
                },
            ],
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, Prequest $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //      }
            // ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'template' => '<div style="display:flex; justify-content:center;">{view} {update} {delete} {download}</div>',
                'buttons' => [

                    'view' => function ($url, $model, $key) {
                        return Html::a(
                            '<span class="fas fa-eye"></span>',
                            ['view', 'id' => $model->id],
                            [
                                'title' => 'View invoice',
                                'aria-label' => 'Invoice view',
                                'id' => 'view',
                                'onclick' => 'showBar();',
                            ]
                        );
                    },

                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="fas fa-pencil-alt"></span>', ['update', 'id' => $model->id], [
                            // 'class' => 'btn btn-success',
                            'title' => 'edit request',
                            'aria-label' => 'request edit',
                        ]);
                    },

                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="fas fa-trash-alt"></span>', ['delete', 'id' => $model->id], [
                            // 'class' => 'btn btn-success',
                            'title' => 'delete request',
                            'aria-label' => 'request delete',
                        ]);
                    },

                    'download' => function ($url, $model, $key) {
                        return Html::a('<span class="fa fa-download"></span>', ['report', 'id' => $model->id], [
                            // 'class' => 'btn btn-success',
                            'title' => 'download request',
                            'aria-label' => 'request download',
                        ]);
                    },


                   
                ],
                
            ],
           
        ],
    ]); ?>
   
            <?php endif;?>


</div>

<?php
function getStatusLabel($status)
{
    $statusLabels = [
        1 => '<span class="badge badge-warning">Open</span>',
        2 => '<span class="badge badge-primary">pm approve</span>',
        3 => '<span class="badge badge-success">management approve</span>',
        4 => '<span class="badge badge-danger">Not Approved</span>',
    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}

function getModeLabel($status)
{
    $statusLabels = [
        1 => 'Cash',
        2 => 'Cheque',
    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}
?>