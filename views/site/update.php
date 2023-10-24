<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

// Assuming $model represents the user model

$form = ActiveForm::begin();

echo $form->field($model, 'username')->textInput();
echo $form->field($model, 'email')->textInput();
echo $form->field($model, 'password')->passwordInput();
echo $form->field($model,'address')->textInput();
echo $form->field($model, 'region')->textInput();
echo $form->field($model, 'nationality')->textInput();
echo$form->field($model, 'gender')->dropDownList(
    [
        'male' => 'Male',
        'female' => 'Female',
    ],
    ['prompt' => 'Select Gender']
) ;

echo Html::submitButton('Update', ['class' => 'btn btn-primary']);

ActiveForm::end();


      $this->context->layout = 'admin';

?>


<div id="main-content ">
   
    <div id="page-container">
        <!-- ============================================================== -->
        <!-- Sales Cards  -->
        <!-- ============================================================== -->
        <div class="row"></div>

    </div>
</div>
