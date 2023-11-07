<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tender $model */

$this->title = 'Create Tender';
$this->params['breadcrumbs'][] = ['label' => 'Tenders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin';
?>
<style>

    span{
        color:grey;
    }
    .back-arrow{
        color:grey;
    }

    
    
</style>


<a href="/tdetail/create" class="back-arrow">
Next <span class="fas fa-arrow-right" ></span>  
</a>
<a href="<?= Yii::$app->request->referrer ?>" class="back-arrow">
    <span class="fas fa-arrow-left"></span> Back
</a>

<div id="main-content ">
   
    <div id="page-container">
        <!-- ============================================================== -->
        <!-- Sales Cards  -->
        <!-- ============================================================== -->
        <div class="row"></div>
<div class="tender-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
   </div>
</div>
