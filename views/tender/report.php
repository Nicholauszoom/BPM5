<?php

use app\models\Adetail;
use app\models\Office;
use app\models\Tattachmentss;
use app\models\Tdetails;
use app\models\Tender;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->context->layout = 'admin';
?>
<style>

h1{
    color: darkblue;
    text-align: center;

}
</style>
<div>
    <div>
        <h1>Tender Report</h1>
        <hr>

        <p>Date Range: <?= Html::encode($dateFrom) ?> - <?= Html::encode($dateTo) ?></p>

        <table class="table table-striped" >
            <thead>
                <tr>
                    <th scope="col">Tender Title</th>
                    <th scope="col">Supervisor</th>
                    <th scope="col">Publish Date</th>
                    <th scope="col">Expired Date</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tenders as $tender): ?>
                    <tr>
                        <td scope="row"><?= Html::encode($tender->title) ?></td>
                        <?php 
                        // $supervisor = User::findOne($tender->supervisor); 
                        $tender_supervisor=Adetail::find()->where(['tender_id'=>$tender->id])->all();
                      
                        $supervisorTenderIds = [];
                        foreach ($tender_supervisor as $t_supervisor) {
                            $supervisorTenderIds[] = $t_supervisor->supervisor;
                        }
                        $supervisor =User::findOne(['id'=>$supervisorTenderIds]);
                         
                        ?>
                      
                        <td><?= Yii::$app->formatter->asDatetime($tender->publish_at) ?></td>
                        <td><?= Yii::$app->formatter->asDatetime($tender->expired_at) ?></td>
                        <td><?= Yii::$app->formatter->asDatetime($tender->created_at) ?></td>
                        <td><?= getStatusLabel($tender->status) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Tender Report</h2>
        <hr>
        <ol>
            <?php foreach ($tenders as $tender): ?>
                <li>
                    <h3 class="tender-title"><?= $tender->title ?></h3>
                    <ul class="tender-details">
                       
                        <li><strong>Publish Date:</strong> <?= Yii::$app->formatter->asDatetime($tender->publish_at) ?></li>
                        <li><strong>Expired Date:</strong> <?= Yii::$app->formatter->asDatetime($tender->expired_at) ?></li>
                        <li><strong>Created At:</strong> <?= Yii::$app->formatter->asDatetime($tender->created_at) ?></li>
                        <li><strong>Status:</strong> <?= getStatusLabel($tender->status) ?></li>
                    </ul>

                    <?php
                    $advance = Tdetails::findOne(['tender_id' => $tender->id]);
                    ?>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Site Visit</th>
                                <th scope="col">Office</th>
                                <th scope="col">End Clarification</th>
                                <th scope="col">Site Visit Date</th>
                                <th scope="col">Bid Meet</th>
                                <th scope="col">Tender Security</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Percent(%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <?php if ($advance !== null): ?>
                              <td scope="row"><?= getSiteLabels($advance->site_visit) ?></td>
                                       
                                 <?php
                                $office = Office::findOne($advance->office);
                                $office_loca = $office->location;
                                ?>
                                <td><?= $office_loca ?></td>
                                
                                <td><?= Yii::$app->formatter->asDatetime($advance->end_clarificatiion) ?></td>
                                <td><?= Yii::$app->formatter->asDatetime($advance->site_visit_date) ?></td>
                                <td><?= Yii::$app->formatter->asDatetime($advance->bidmeet) ?></td>
                                <td><?= getSecurityLabel($advance->tender_security) ?></td>
                                <td><?= $advance->amount ?></td>
                                <td><?= $advance->percentage ?></td>
                                <?php endif; ?>   
                            </tr>
                        </tbody>
                    </table>

                    <h3 style="text-align: center; color:grey; font-family:Georgia, 'Times New Roman', Times, serif"> tender document's</h3>

                    <?php
                   $attachments = Tattachmentss::findOne(['tender_id' => $tender->id]);

                   if ($attachments !== null) {
                 ?>
    <ol>
    <?php
              $fileName = $attachments->evaluation;
              $filePath = Yii::getAlias('@webroot/upload/' . $fileName);
              $downloadPath = Yii::getAlias('@web/upload/' . $fileName);
            ?>
                    <iframe src=<?=$downloadPath?> width="50%" height="100"></iframe>

        <li>

    </li>
        <li>
        <?php
              $fileName = $attachments->negotiation;
              $filePath = Yii::getAlias('@webroot/upload/' . $fileName);
              $downloadPath1 = Yii::getAlias('@web/upload/' . $fileName);
            ?>    
        
        <iframe src=<?= Yii::getAlias($downloadPath1) ?> width="50%" height="100"></iframe>

    </li>
        <li><?= $attachments->award ?></li>
        <li>
        <?php
$fileName = $attachments->intention;
$filePath = Yii::getAlias('@webroot/upload/' . $fileName);
$downloadPath3 = Yii::getAlias('@web/upload/' . $fileName);
?>
<?=$downloadPath3 ?>
<iframe src="<?= Yii::getAlias('@web/'.$downloadPath3) ?>" width="70%" height="200px"></iframe>
</li>
        <li><?= $attachments->arithmetic ?></li>
        <li><?= $attachments->audit ?></li>
        <li><?= $attachments->cancellation ?></li>
    </ol>
       <?php
          } else {
           echo "No attachments found for the tender.";
             }
?>
                    <hr>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>

<?php
function getStatusLabel($status)
{
    $statusLabels = [
        1 => '<span class="badge badge-success">awarded</span>',
        2 => '<span class="badge badge-warning">not-awarded</span>',
        3 => '<span class="badge badge-secondary">submitted</span>',
        4 => '<span class="badge badge-secondary">not-submtted</span>',
        5 => '<span class="badge badge-secondary">on-progress</span>',

        
        
    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}

function getStatusClass($status)
{
    $statusClasses = [
       
        1 => 'status-active',
        2 => 'status-inactive',
        3 => 'status-onhold',
    ];

    return isset($statusClasses[$status]) ? $statusClasses[$status] : '';
}

function getSiteLabels($status)
{
    $statusLabels = [
      1 => '<span class="">YES</span>',
      2 => '<span class="">NO</span>',
     
    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}

function getSecurityLabel($status)
{
    $statusLabels = [
      1 => '<span class="">Security Declaration</span>',
      2 => '<span class="">Bid/Tender Security</span>',
     
    ];

    return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
}

?>
