<?php

use app\models\Permission;
use app\models\Role;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin';


$roles = Role::find()->all();
$roleList = ArrayHelper::map($roles, 'id', 'name');

$permissions = Permission::find()->all();
$permissionList = ArrayHelper::map($permissions, 'id', 'name');
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
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'roleList'=>$roleList,
        'permissionList'=>$permissionList,

    ]) ?>

</div>
   </div>
</div>
