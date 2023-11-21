<?php

use app\models\Prequest;
use app\models\Project;
use app\models\Tender;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Comment $model */

$prequest=Prequest::findOne(['id'=>$prequestId]);
$project=Project::findOne($prequest->project_id);
$tender=Tender::findOne($project->tender_id);

$this->title = 'Reason for '. $tender->title . ' request is not approved';
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin';
?>
<div class="comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'prequestId'=>$prequestId,
    ]) ?>

</div>
