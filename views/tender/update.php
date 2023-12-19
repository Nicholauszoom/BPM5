<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tender $model */

$this->title = 'Update Tender: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tenders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin';
?>
<a href="<?= Yii::$app->request->referrer ?>" class="back-arrow">
    <span class="arrow">&#8592;</span> Back
</a>
<div id="main-content ">
   
    <div id="page-container">
        <!-- ============================================================== -->
        <!-- Sales Cards  -->
        <!-- ============================================================== -->
        <div class="row"></div>
<div class="tender-update">
<?php if(Yii::$app->user->can('admin')):?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php endif;?>

    <?php if(Yii::$app->user->can('author')&!Yii::$app->user->can('admin')):?>
    <h1> <?= $model->title?></h1>
    <?php endif;?>
    <?= $this->render('_edit', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
