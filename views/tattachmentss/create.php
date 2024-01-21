<?php

use app\models\Tender;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tattachmentss $model */

$tendattach=Tender::findOne($tenderId);
$this->title = 'Attach Tender document for'. $tendattach->title ;
$this->params['breadcrumbs'][] = ['label' => 'Tattachmentsses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
<div class="tattachmentss-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tenderId'=>$tenderId,
    ]) ?>

</div>
    </div>
</div>
