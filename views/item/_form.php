<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Item $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card-body">

<hr>
    <!--Image-->
    <div>
<div class="mb-4 d-flex justify-content-center">
<img id="selectedImage" src="https://img.icons8.com/?size=80&id=ut1zOcqcXWhJ&format=png" alt="example placeholder" style="width: 150px;" />
</div>
<div class="d-flex justify-content-center">
<?= $form->field($model, 'files')->fileInput(['maxlength' => true])->label(' <small class="text-muted">Select exel/csv file</small>') ?>
</div>

  
   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
