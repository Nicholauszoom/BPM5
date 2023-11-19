<?php

use app\models\Item;
use app\models\Rdetail;
use yii\bootstrap5\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Rdetail $model */
/** @var yii\widgets\ActiveForm $form */


// Modal pop-up
Modal::begin([
    'id' => 'createModal',
    'title' => 'Create',
]);

// Header
echo '<div class="modal-header">';
echo '</div>';

// Form
$form = ActiveForm::begin([
   
]);

$item=Item::find()->all();

echo $form->field($model, 'iteam')->label('Item * <small class="text-muted">eg.3 quoter pipes</small>')->dropDownList(
    ArrayHelper::map($item, 'id', 'name'),
    ['prompt' => 'select item']
);


// $request_qty=Request::findOne(condition)

echo $form->field($model, 'prequest_id')->hiddenInput(['value' => $prequestId])->label(false);


echo $form->field($model, 'unit')->textInput(['maxlength' => true, 'id' => 'unit', 'readonly' => false]) ;

echo $form->field($model, 'quantity')->textInput(['maxlength' => true, 'id' => 'qty', 'readonly' => false]);

echo $form->field($model, 'amount')->textInput(['maxlength' => true, 'id' => 'amount', 'readonly' => false]) ;

// Add remaining form fields...

echo '<div class="modal-footer">';
echo Html::submitButton('Save', ['class' => 'btn btn-success']);
echo '</div>';

ActiveForm::end();

Modal::end();

$rdetails=Rdetail::find()
        ->where(['prequest_id'=>$prequestId])
        ->all();

?>

<div class="rdetail-form">


<table class="table">
  <thead>
    <tr style="background-color: #f2f2f2;">
  
      <th scope="col">item</th>
      <th scope="col">unit price</th>
      <th scope="col">Qty</th>
      <th scope="col">Amount</th>
      <th scope="col">Created</th>
      <th scope="col">Updated</th>
      <th scope="col">Created By</th>
      <th scope="col"></th>
    </tr>
    </thead>
<tbody>
<?php foreach ($rdetails as $rdetails): ?>
    <tr>
      <?php
        $item=Item::findOne($rdetails->iteam);
      ?>
       
        <td><?=$item->name?></td>
        <td><?= $rdetails->quantity ?></td>
        <td><?= $rdetails->unit ?></td>
        <td><?= $rdetails->amount ?></td>
        <td><?= Yii::$app->formatter->asDatetime($rdetails->created_at) ?></td>
        <td><?= Yii::$app->formatter->asDatetime($rdetails->updated_at) ?></td>
        
        <td>
        
                <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['update', 'id' => $rdetails->id], [
                    'title' => 'Update',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]) ?>
            

            <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $rdetails->id], [
                'title' => 'Delete',
                'data-confirm' => 'Are you sure you want to delete this updates',
                'data-method' => 'post',
                'data-pjax' => '0',
            ]) ?>
        </td>
    </tr>
<?php endforeach; ?>
<tr>
    <td>
   
            <?= Html::a('+ create request', '#', ['data-toggle' => 'modal', 'data-target' => '#createModal']) ?>
    </td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td></td>
  
    <td style="background-color: #f2f2f2;">Total Amonut:TSH <?= $total_amount?></td>
    <td style="background-color: #f2f2f2;"></td>
    <td style="background-color: #f2f2f2;"></td>
    <td style="background-color: #f2f2f2;"></td>
    <td style="background-color: #f2f2f2;"></td>
    <td style="background-color: #f2f2f2;"></td>
    <td style="background-color: #f2f2f2;"></td>
</tr>
</tbody>
</table>


</div>
<script>

$(document).ready(function() {
  // Function to calculate the amount
  function calculateAmount() {
    var unitPrice = parseFloat($('#unit').val());
    var quantity = parseFloat($('#qty').val());

    if (!isNaN(unitPrice) && !isNaN(quantity)) {
      var amount = unitPrice * quantity;
      $('#amount').val(amount.toFixed(2));
    }
  }

  // Trigger the calculation when the unit price or quantity changes
  $('#unit, #qty').on('input', calculateAmount);
});

</script>
