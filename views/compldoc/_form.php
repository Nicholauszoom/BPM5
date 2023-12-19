<?php

use app\models\Activitydetil;
use app\models\Eligibdetail;
use app\models\Tender;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use function PHPUnit\Framework\isEmpty;

/** @var yii\web\View $this */
/** @var app\models\Compldoc $model */
/** @var yii\widgets\ActiveForm $form */
$userId = Yii::$app->user->id;
$tender=Tender::findOne($tenderId);

$eligibdetail=Eligibdetail::find()->where(['tender_id'=>$tenderId, 'user_id'=>$userId])->all();

if(isEmpty($eligibdetail)){
$activityDetail = [];
foreach ($eligibdetail as $eligibdetail) {
    $activityDetaild = $eligibdetail->adetail_id;
    $activityDetail[]=Activitydetil::findOne($activityDetaild);
}
}
?>

<div class="compldoc-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if ($tender->expired_at >= strtotime(date('Y-m-d'))) : ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>$userId])->label(false) ?>

    <?= $form->field($model, 'tender_id')->hiddenInput(['value'=>$tenderId])->label(false) ?>

    <?= $form->field($model, 'document')->fileInput() ?>

   

    <?= $form->field($model, 'eligibd_id')->checkboxList( ArrayHelper::map($activityDetail, 'id', 'title'), ['prompt' => 'Select Eligibility Compliance', 'id' => 'activityDetail'] )?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
<?php endif;?>
    <?php ActiveForm::end(); ?>

</div>
