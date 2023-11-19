<?php
use app\models\Customer;
use app\models\Idetail;
use app\models\Item;
use app\models\Office;
use app\models\Product;
use app\models\Project;
use app\models\Rdetail;
use app\models\Tattachmentss;
use app\models\Tdetails;
use app\models\Tender;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->context->layout = 'create_main';
?>
<style>

    h1{
        text-align: center;
        color:midnightblue;
        margin-bottom: 5;
    }
    .detail{
        align-content: end;
        margin-bottom: 5;
    }

    .customer{
        align-content: flex-start;
        margin-bottom: 5;
    }

   .content {
        font-size: 12;
        font-family: 'Times New Roman', Times, serif;
    }
</style>
<div id="main-content" class="content">
    <div id="page-container">
        <h1>System Request</h1>
       
        <div class="detail">
           <h3>Request</h3>
           <?php
             $project= Project::findOne($prequest->project_id);
             $tender = Tender::findOne($project->tender_id);
             $tenderTitle = $tender ? $tender->title : 'Unknown';
           ?>
           <h5>PROJECT: <?=$tenderTitle?></h5>
           <h5>REFERENCE: <?=$prequest->id?></h5>
           <h5>CREATED DATE: <?=Yii::$app->formatter->asDatetime($prequest->created_at)?></h5>
           <?php
            $payeeUser = User::findOne($prequest->payee);
            $requestedUser = User::findOne($prequest->created_by);

           ?>
           <h5>PAYEE NAME: <?=$payeeUser->username?></h5>
           <h5>PAYMENT MODE: <?=getModeLabel($prequest->mode)?></h5>
           <h5>REQUESTED BY: <?=$requestedUser->username?></h5>
        </div>

        <hr>
        
      
       
<table class="table">
  <thead>
    <tr style="background-color: #f2f2f2;">
  
      <th scope="col">item</th>
      <th scope="col">Qty</th>
      <th scope="col">Unit price</th>
      <th scope="col">Amount</th>
    
      <th scope="col"></th>
    </tr>
    </thead>
<tbody>
    <?php
    $idetails=Rdetail::find()->where(['prequest_id'=>$id])->all();

    ?>
<?php foreach ($idetails as $idetail): ?>
    <tr>
        <?php 
        // $item=Product::findOne($pdetail->item_id);
        $item=Item::findOne($idetail->iteam);
        ?>
        <td><?= $item->name ?></td>
        <td><?= $idetail->quantity ?></td>
        <td><?= $idetail->unit ?></td>
        <td><?= $idetail->amount ?></td>
       
    </tr>
<?php endforeach; ?>
<tr>
    <td>
   
           
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

   
<?php


function getStatusLabel($status)
{
    $statusLabels = [
        1 => '<span class="badge badge-warning">Open</span>',
        2 => '<span class="badge badge-success">Approved</span>',
    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}

function getModeLabel($status)
{
    $statusLabels = [
        1 => 'Cash',
        2 => 'Cheque',
    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}


?>