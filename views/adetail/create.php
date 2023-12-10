<?php

use app\models\Tender;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Adetail $model */

$tendertitle=Tender::findOne($tenderId);
$this->title = 'Tender '.$tendertitle->title;
$this->params['breadcrumbs'][] = ['label' => 'Adetails', 'url' => ['index']];
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


<a href="<?= Url::to(['tender/view', 'id' => $tenderId]) ?>" class="back-arrow">
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
<div class="adetail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users'=>$users,
        'tenderId'=>$tenderId,
        'activity'=>$activity,
        'tendrId'=>$tendrId,

    ]) ?>

</div>
    </div>
</div>
