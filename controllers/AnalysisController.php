<?php

namespace app\controllers;

use app\models\Analysis;
use app\models\AnalysisSearch;
use app\models\Project;
use app\models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use yii\base\InvalidConfigException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\mail\MessageInterface;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * AnalysisController implements the CRUD actions for Analysis model.
 */
class AnalysisController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Analysis models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AnalysisSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Analysis model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    // public function actionView($id)
    // {
    //     $project = Project::findOne($id);
    //     $tasks = $project->tasks;
        
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //         'tasks' => $tasks,
    //     ]);
    // }

    /**
     * Creates a new Analysis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

     public function actionCreate($projectId)
     {
         $model = new Analysis();
         $data = []; // Define the $data variable
         $rowData = [];
     
         $model->project = $projectId;
     
         // $details = Analysis::find()->all();
     
     
         //////////////
         $details = Analysis::find()
             ->where(['project' => $projectId])
             ->all();
         ///////////////
     
         //find and  calculate the  total amount of the each one  given project
     
         //count project by user_id
     
         // Find projects assigned
         $analysis = Analysis::find()
             ->where(['project' => $projectId])
             ->all();
     
         // Calculate the total project budget for the assigned projects
         $projectAmounts = 0;
         foreach ($analysis as $analysis) {
             $projectAmounts += $analysis->cost;
         }
         //end
         //vat
         $vat= $projectAmounts*(18/100);
        
         //Include vat
         $projectAmount=$projectAmounts - $vat;
         // Calculate profit gained
         $project = Project::findOne($projectId);
         $profit = $project->budget - $projectAmount;
     
         $profitPerce = 0;
         // Percent of the project profit gained
         $profitPerce = ($profit / $project->budget) * 100;
     
         $u_amount = 0;
         $unit_profit = $model->setunit - ($model->unit);
     
         if ($model->load(Yii::$app->request->post())) {
     
            
             // Create the upload directory if it doesn't exist
             $uploadDir = Yii::getAlias('@webroot/upload/');
             if (!is_dir($uploadDir)) {
                 mkdir($uploadDir, 0777, true);
             }
             
             // Upload the files
             $files = UploadedFile::getInstances($model, 'files');
             if (!empty($files)) {
                 $filePaths = [];
                 $fileCount = count($files);
                 $uploadedCount = 0;
             
                 foreach ($files as $file) {
                     $filePath = $uploadDir . $file->baseName . '.' . $file->extension;
             
                     if ($file->saveAs($filePath)) {
                         $filePaths[] = $filePath;
             
                         // Convert Excel file to CSV
                         $csvFilePath = $uploadDir . $file->baseName . '.csv';
                         $spreadsheet = IOFactory::load($filePath);
                         $writer = IOFactory::createWriter($spreadsheet, 'Csv');
                         $writer->save($csvFilePath);
             
                         // Import CSV data into the database
                         $handle = fopen($csvFilePath, 'r');
                         while (($data = fgetcsv($handle)) !== false) {
                             $rowData[] = $data;
                         }
                         fclose($handle);
             
     
                         // Import data into the database
                         foreach ($rowData as $row) {


                            if (empty($row[2]) || empty($row[1])) {
                                continue;
                            }
    
                             $modelRow = new Analysis();
                            
                             
                            
                             $modelRow->serio = isset($row[0]) ? $row[0] : null;
                             $modelRow->item = isset($row[1]) ? $row[1] : null;
                            
                             $modelRow->quantity = isset($row[2]) ? $row[2] : null;
                             
                             $modelRow->description = isset($row[3]) ? $row[3] : null;
                             $modelRow->setunit = isset($row[4]) ? $row[4] : null;
                             $modelRow->cotedAmount = isset($row[5]) ? $row[5] : null;
                             $modelRow->cost = isset($row[6]) ? $row[6] : null;
                             $modelRow->source = isset($row[7]) ? $row[7] : null;
                             // $modelRow->unit = $row[7];
     
                             // Ensure numeric values for unit and quantity
                             // $modelRow->unit = is_numeric($modelRow->unit) ? (float)$modelRow->unit : 0;
                             // $modelRow->quantity = is_numeric($modelRow->quantity) ? (float)$modelRow->quantity : 0;
                             
                             $modelRow->quantity = is_numeric($modelRow->quantity) ? (float)$modelRow->quantity : 0;
                             // $modelRow->setunit = is_numeric($modelRow->setunit) ? (float)$modelRow->setunit : 0;
     
                            //  $modelRow->unit = $modelRow->cost * $modelRow->quantity ;
                             $modelRow->unit = floatval($modelRow->cost) * intval($modelRow->quantity);
                             $setunitWithoutCommas = str_replace(',', '', $modelRow->setunit);
                             $setunitAsInt = intval($setunitWithoutCommas);
     
                             $modelRow->unitprofit = $setunitAsInt - $modelRow->unit;
                            $modelRow->project = $projectId;
                            $modelRow->files = $filePath;
                            $modelRow->save();



                       
                        }

                        // // Redirect after importing
                        // return $this->redirect(['create']);
                    }
                //    ..................


                }
                  // Set the final progress percentage to 100
           

                $model->files = implode(',', $filePaths);
            }
    // Show the progress bar
    Yii::$app->response->format = Response::FORMAT_JSON;
    return ['progressBar' => $this->renderPartial('progress')];
            // Upload the BOQ file
            $boqFile = UploadedFile::getInstance($model, 'boq');
            if ($boqFile !== null) {
                $boqFilePath = $uploadDir . $boqFile->baseName . '.' . $boqFile->extension;
                if ($boqFile->saveAs($boqFilePath)) {
                    $model->boq = $boqFilePath;
                }
            }
    
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }
    
        return $this->render('create', [
            'model' => $model,
            'details' => $details,
           'projectId' => $projectId,
           'projectAmount'=>$projectAmount,
           'profit' => $profit,
           'profitPerce'=> $profitPerce,
           'u_amount'=> $u_amount,
           'unit_profit'=> $unit_profit,
           'vat'=>$vat,
        ]);
    }


    /**
     * Updates an existing Analysis model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
{

    $costs=0;

    $model = $this->findModel($id);


  
    $details = Analysis::find()
    ->where(['project' => $model->project])
    ->all();

//find email of the one who edit the analysis(approve the analysis)
    $login_userId = Yii::$app->user->id;
     $approve_user = User::findOne($login_userId);



// Find projects assigned 
$analysis = Analysis::find()
->where(['project' => $model->project])
->all();

// Calculate the total project budget for the assigned projects
$projectAmount = 0;
foreach ($analysis as $analysis) {
$projectAmount += $analysis->cost;
}

 //find email of the created by  analysisi
 $userE = User::findOne($model->created_by);


 //find project title in analysis project id
$Aproject= Project::findOne($model->project);

//status sent with email


if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
  

    if (Yii::$app->user->can('admin')) {
    try {
        // Get the email message instance from the mailer component
        $message = Yii::$app->mailer->compose()
            ->setFrom('nicholaussomi5@gmail.com')
            ->setTo($userE->email)
            ->setSubject('Analysis Approval')
            ->setHtmlBody('
            <html>
            <head>
                <style>
                    /* CSS styles for the email body */
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #ffffff;
                        border: 1px solid #dddddd;
                        border-radius: 4px;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    }
                    h1 {
                        color: blue;  <!-- Message -->
                        <a href="javascript:void(0)" class="link border-top">
                            <div class="d-flex no-block align-items-center p-10">
                                <span class="btn btn-danger btn-circle d-flex align-items-center justify-content-center">
                                    <i class="mdi mdi-link fs-4"></i>
                                </span>
                                <div class="ms-2">
                                    <h5 class="mb-0">Launch Admin</h5>
                                    <span class="mail-desc">Just see the my new admin!</span>
                                </div>
                            </div>
                        </a>
                        color: #666666;
                    }
                    .logo {
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    .logo img {
                        max-width: 200px;
                    }
                    .assigned-by {
                        font-weight: bold;
                    }
                    .button {
                        display: inline-block;
                        padding: 10px 20px;
                        background-color: #3366cc;
                        color: white;
                        text-decoration: none;
                        border-radius: 4px;
                        margin-top: 20px;
                    }
                    .button:hover {
                        background-color: #235daa;
                    }
                    .status-label {
                        display: inline-block;
                        padding: 5px 10px;
                        color: #ffffff;
                        border-radius: 4px;
                    }
                    .status-pending {
                        background-color: #ffc107;
                    }
                    .status-approved {
                        background-color: #28a745;
                    }
                    .status-rejected {
                        background-color: #dc3545;
                    }
                </style>
        
                <script>
                    function getStatusLabel(status) {
                        switch (status) {
                            case 0:
                                return {
                                    name: "Pending",
                                    labelClass: "status-pending"
                                };
                            case 1:
                                return {
                                    name: "Approved",
                                    labelClass: "status-approved"
                                };
                            case 2:
                                return {
                                    name: "Rejected",
                                    labelClass: "status-rejected"
                                };
                            default:
                                return {
                                    name: "",
                                    labelClass: ""
                                };
                        }
                    }
                </script>
            </head>
            <body>
                <div class="container">
                    <div class="logo">
                        <img src="https://teratechcomponents.com/wp-content/uploads/2011/06/Tera_14_screen-234x60.png" alt="teralogo">
                    </div>
                    <h1>TERATECH</h1>
                    <p>Dear ' . Html::encode($userE->username) . ',</p>
                    <p>You have been sent an approval status, as shown below:</p>
                    <ul>
                        <li>Project Name: ' . Html::encode($Aproject->title) . '</li>
                        <li>Item name : ' . Html::encode($model->item) . '</li>
                        <li>Analysis Approval Status: ' . Html::encode($model->status) . '</li>
                    
                        <li>Approval Status Created By: ' . Html::encode($approve_user->username) . '</li>
                    </ul>
                    <p>If you have any questions or need further assistance, feel free to contact Mr.' . Html::encode($approve_user->username) . '.</p>
                    <a href="http://localhost:8080/" class="button">View Project</a>
                </div>
            </body>
            </html>
        ');

        // Send the email
        if ($message instanceof MessageInterface && $message->send()) {
            // Display a success message
            Yii::$app->session->setFlash('success', 'Email sent successfully.');
        } else {
            // Handle email sending failure
            Yii::$app->session->setFlash('error', 'Failed to send the email.');
        }
    } catch (InvalidConfigException $e) {
        // Handle any configuration errors
        Yii::$app->session->setFlash('error', 'Email configuration error occurred.');
    } catch (\Throwable $e) {
        // Handle any other exceptions
        Yii::$app->session->setFlash('error', 'Error occurred while sending the email.');
    }
}else{
    Yii::$app->session->setFlash('success', 'Updated successfully.');
}
 // Update the costs attribute
 $model->cost = $model->unit * $model->quantity;

 // Calculate costs
 $costs = $model->cost;

 // Remove commas from setunit attribute
 $setunit = str_replace(',', '', $model->setunit);

 // Perform the subtraction operation
 $model->unitprofit = $setunit - $costs;

 
 $model->save();
    return $this->redirect(['project/view', 'id' => $model->project]);
}



    return $this->render('update', [
        'model' => $model,
        'projectId' => $model->project,
        'details' =>$details,
        'projectAmount'=>$projectAmount,
        // 'costs'=>$costs,
        // 'profit'=> $profit,
        // 'profitPerce'=>$profitPerce,
    ]);
}

public function actionDeleteMultiple()
{
   
    
    $post = Yii::$app->request->post();
    $selectedItems = $post['deleteItems'];

    // Delete the selected items
    foreach ($selectedItems as $itemId) {
        $this->findModel($itemId)->delete();
    
    }
    
    // Redirect to the desired page after deletion
    return $this->redirect(['project/pm']);
}
    /**
     * Deletes an existing Analysis model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model =$this->findModel($id);
        $this->findModel($id)->delete();
        
        $projectId = $model->project;

        return $this->redirect(['project/view', 'id' => $projectId]);
    }

    /**
     * Finds the Analysis model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Analysis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */


     protected function findModel($id)
    {
        if (($model = Analysis::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    
 
    public function actionOpenBoq($id)
    {
        // Find the details record based on the provided $id
        $details = Analysis::findOne($id);
    
        if (!$details) {
            throw new NotFoundHttpException('The requested details record does not exist.');
        }
    
        // Get the path to the BOQ file
        $boqFilePath = Yii::getAlias('@webroot/upload/') . $details->boq;
    
        // Check if the BOQ file exists
        if (!file_exists($boqFilePath)) {
            throw new NotFoundHttpException('The BOQ file does not exist.');
        }
    
        // Set the appropriate response headers
        Yii::$app->response->headers->set('Content-Type', 'application/pdf');
    
        // Read the file content
        $fileContent = file_get_contents($boqFilePath);
    
        // Send the file content as the response
        Yii::$app->response->sendContentAsFile($fileContent, $details->boq, ['inline' => true]);
    
        // Return the response to end the action
        return Yii::$app->response;
    }

    

  
    
}