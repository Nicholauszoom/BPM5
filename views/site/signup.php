<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\SignupForm $model */

use app\models\Setting;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Assign New User';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin';

$setting= Setting::findOne(1);
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
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Assign new user in a system:</p>

   
       

            <?php $form = ActiveForm::begin([
                'id' => 'signup-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => ' col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'invalid-feedback'],
                ],
            ]); ?>
           
             <?php echo $form->field($model, 'department')->dropDownList(
               \yii\helpers\ArrayHelper::map($department, 'id', 'name'),
                ['prompt' => 'Select Department']
              ) ; ?>

          
              <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput(['value' => $setting->password]) ?>

            <?= $form->field($model, 'password_repeat')->passwordInput(['value' => $setting->password]) ?>

            <?= $form->field($model, 'address')->textInput()?>

            <?= $form->field($model, 'nationality')->textInput()?>

            <?= $form->field($model, 'region')->textInput()?>

            <?= $form->field($model, 'gender')->dropDownList(
                   [
                    'male' => 'Male',
                    'female' => 'Female',
                     ],
                  ['prompt' => 'Select Gender']
                 )?>
            <?php 
           
                 $authItems = ArrayHelper::map($authItems,'name','name');
                 
            ?>
           <ul>

            <?= $form->field($model,'permissions')->checkboxList($authItems); ?>
            
            </ul>
            <div class="form-group">
                <div>
                    <?= Html::submitButton('+ Add', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

         
      
    </div>
        </div>
    </div>
</div>