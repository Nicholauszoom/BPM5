<?php



/** @var yii\web\View $this */

use yii\helpers\Html;

/** @var app\models\Article $model */
/** @var yii\widgets\ActiveForm $form */
?>


<div>
    <h3><?php echo  Html::encode($model->title)?></h3>


<div>
    <?php echo  Html::encode($model->body)?>
</div>
<hr>
</div>