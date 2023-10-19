<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UserDepartment $model */

$this->title = 'Create User Department';
$this->params['breadcrumbs'][] = ['label' => 'User Departments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-department-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
