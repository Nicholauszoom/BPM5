<?php

use app\models\Tender;
use app\models\UserActivity;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\i18n\Formatter;

/** @var yii\web\View $this */
/** @var app\models\TenderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'New Tenders';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin';
?>
<div id="main-content ">
   
   <div id="page-container">
       <!-- ============================================================== -->
       <!-- Sales Cards  -->
       <!-- ============================================================== -->
       <div class="row"></div>
<div class="tender-index">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
    'dataProvider' => new \yii\data\ArrayDataProvider([
        'allModels' => $new,
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
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($model) {
                    $label = $model->session ? '' : Html::tag('span', 'new', ['class' => 'badge badge-warning']);
                    return '<div style="display: flex; align-items: flex-start;">' . $label . '<span style="margin-left: 5px;">' . $model->title . '</span></div>';
                },
            ],
            'PE',
            'TenderNo',
            
            [
                'attribute' => 'publish_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            // [
            //     'attribute' => 'expired_at',
            //     'format' => ['date', 'php:Y-m-d H:i:s'],
            // ],
            [
                'attribute' => 'expired_at',
                'format' => 'raw',
                'label' => 'Submitted Date',
                'value' => function ($model) {
                    $now = time();
                    $expiredDate = $model->expired_at;
                    $oneWeekAhead = strtotime('+1 week');
                    $labelClass = '';
    
                    if ($expiredDate - $now <= 0) {
                        $labelClass = 'badge badge-danger'; // Red label
                    } elseif ($expiredDate > $oneWeekAhead) {
                        $labelClass = 'badge badge-success'; // Yellow label
                    } elseif($expiredDate - $now > 0) {
                        $labelClass = 'badge badge-warning'; // Green label
                    }else{
                        $labelClass = 'badge badge-secondary';
                    }
    
                    $formatter = new Formatter();
                    $formattedDate = $formatter->asDate($model->expired_at, 'php:Y-m-d H:i:s');
                    $label = Html::tag('span', Html::encode($formattedDate), ['class' => $labelClass]);
                    return $label;
                },
            ],
    
            
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return getStatusLabel($model->status);
                },
                'format' => 'raw',
                'contentOptions' => function ($model) {
                    return ['class' => getStatusClass($model->status)];
                },
            ],
            // 'document',
            // [
            //     'attribute' => 'session',
            //     'label' => 'alert',
            //     'format' => 'raw',
            //     'value' => function ($model) {
            //         return $model->session ? '' : Html::tag('span', 'New', ['class' => 'badge badge-success']);
            //     },
            // ],
            // 'status',
            //'created_at',
            //'updated_at',
            //'created_by',
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, Tender $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //      }
            // ],
            // ///////////////////
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {create-project}  {update} {activity}',
                'buttons' => [
                    
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $model->id], [
                            // 'class' => 'btn btn-success',
                            'title' => 'view tender',
                            'aria-label' => 'tender view',
                        ]);
                    },
    
    
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model->id], [
                            // 'class' => 'btn btn-success',
                            'title' => 'view tender',
                            'aria-label' => 'tender update',
                        ]);
                    },

                    'activity' => function ($url, $model, $key) {
                        $userId = Yii::$app->user->id;
                
                        // Check if the tender meets the criteria
                        $isEligibleTender = UserActivity::findOne(['tender_id'=>$model->id])===null ;
                
                        $badgeHtml = '';
                        if ($isEligibleTender) {
                            $badgeHtml = '<img src="https://img.icons8.com/?size=48&id=2EuI26KqYJ6b&format=png" class="truncate"></img>';
                        }
                
                        return Html::a($badgeHtml, ['adetail/create', 'tenderId' => $model->id], [
                            'title' => 'compliance',
                            'aria-label' => 'create compliance',
                            'class' => 'icon-button', // Add a custom CSS class for the icon button
                        ]);
                    },
                    'activity' => function ($url, $model, $key) {
                        $userId = Yii::$app->user->id;
                
                        // Check if the tender meets the criteria
                        $isEligibleTender = UserActivity::findOne(['tender_id'=>$model->id])===null ;
                
                        $badgeHtml = '';
                        if ($isEligibleTender) {
                            $badgeHtml = '<img src="https://img.icons8.com/?size=48&id=2EuI26KqYJ6b&format=png" class="truncate"></img>';
                        }
                
                        return Html::a($badgeHtml, ['adetail/create', 'tenderId' => $model->id], [
                            'title' => 'compliance',
                            'aria-label' => 'create compliance',
                            'class' => 'icon-button', // Add a custom CSS class for the icon button
                        ]);
                    },
                ],
                
            ],
            
            // ///////////////
        ],
    ]); ?>
    <?php
function getStatusLabel($status)
{
    $statusLabels = [
        1 => '<span class="badge badge-success">awarded</span>',
        2 => '<span class="badge badge-warning">not-awarded</span>',
        3 => '<span class="badge badge-secondary">submitted</span>',
        4 => '<span class="badge badge-secondary">not-submtted</span>',
        5 => '<span class="badge badge-secondary">on-progress</span>',


        
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
</div>
