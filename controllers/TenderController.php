<?php

namespace app\controllers;

use app\models\Adetail;
use app\models\Department;
use app\models\Office;
use app\models\Tdetails;
use app\models\Tender;
use app\models\TenderSearch;
use app\models\User;
use app\models\UserAssignment;
use Mpdf\Mpdf;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use yii\mailer\MailerInterface;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\mail\MessageInterface;

/**
 * TenderController implements the CRUD actions for Tender model.
 */
class TenderController extends Controller
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
     * Lists all Tender models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('admin')) {
        $searchModel = new TenderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }else {
        throw new ForbiddenHttpException;
    }
}
public function actionAssigned()
{
    
        $userId = Yii::$app->user->id;

        // Find user assignments
        $user_assignments = UserAssignment::find()
            ->where(['user_id' => $userId])
            ->all();

        $assignedTenderIds = [];
        foreach ($user_assignments as $user_assignment) {
            $assignedTenderIds[] = $user_assignment->tender_id;
        }

        // Find assigned tenders
        $tender = Tender::find()
            ->where(['id' => $assignedTenderIds])
            ->all();

        return $this->render('pm', [
            'tenders' => $tender,
        ]);
    }





    /**
     * Displays a single Tender model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model= $this->findModel($id);

        
        if ($model !== null && $model->submission !== null) {
           
            // Set isViewed attribute to 1
            $model->session= 1;
            Tender::updateAll(['session' => $model->status], ['id' => $id]);
    
            // Save the model to persist the changes
            // $model->save();
    
        }

        $tdetail=Tdetails::find()
        ->where(['tender_id'=>$id])
        ->all();
        $ttdetail=Tdetails::findOne(['tender_id'=>$id]);

        return $this->render('view', [
            'model' => $model,
            'tdetail'=>$tdetail,
            'ttdetail'=> $ttdetail,
        ]);
        
    }

    /**
     * Creates a new Tender model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('admin')) {
        $model = new Tender();
        

        if ($this->request->isPost) {
            $model->load($this->request->post());

                  // Save the project
                  $model->document = UploadedFile::getInstance($model, 'document');
   
                
                  if ($model->document) {
                    $uploadPath = Yii::getAlias('@webroot/upload/');
                    $fileName = $model->document->baseName . '.' . $model->document->extension;
                    $filePath = $uploadPath . $fileName;
                
                    if ($model->document->saveAs($filePath)) {
                        $model->document = '' . $fileName;
                    }
                
                           // Process the CSV file
                      
                    
                    }
                    if ($model->save()) {
                        // Send an email to a specific department by email

                       
                        if (Yii::$app->user->can('admin')) {
                      
                       $model->expired_at=$model->expired_at;
                       $model->publish_at=$model->publish_at;
                       $model->save();

                       // Save the assigned users
                    // if (is_array($model->assigned_to) && !empty($model->assigned_to)) {
                    //     foreach ($model->assigned_to as $userId) {
                    //         $assignment = new UserAssignment();
                    //         $assignment->tender_id = $model->id;
                    //         $assignment->user_id = $userId;
                    //         $assignment->save();
                    //     }
                    // }
                   }
                   
                   return $this->redirect(['tdetail/create', 'tenderId' => $model->id]);

                    Yii::$app->session->setFlash('success', 'Tender sent successfull.');
                   }
                    
               
                    
                
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }
    else {
        throw new ForbiddenHttpException;
    }

    }
    

    // public function scenarios()
    // {
    //     $scenarios = parent::scenarios();
    //     $scenarios['update'] = ['title','PE','TenderNo','description','budget','assigned_to','status','submission']; // Only attribute1 can be modified in the "update" scenario
    //     return $scenarios;
    // }

    /**
     * Updates an existing Tender model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    
    {
        // if (Yii::$app->user->can('admin')) {
        $model = $this->findModel($id);
         // Set the scenario to "update"
       
        // $userEmail=$user->email;
        // if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }
        
        if ($this->request->isPost) {
            $model->load($this->request->post());
            // $model->document = UploadedFile::getInstance($model, 'document');
            $model->submission = UploadedFile::getInstance($model, 'submission');

           
                // Handle document file upload
                // $model->document = UploadedFile::getInstance($model, 'document');
                
                // Handle submission file upload
                $submissionFile = UploadedFile::getInstance($model, 'submission');
                if ($submissionFile !== null) {
                    $submissionPath = '' . $submissionFile->name; // Adjusted file path
                    $submissionFile->saveAs($submissionPath);
                    $model->submission = $submissionPath;
                }

                if ($model->save()) {
                     // Send an email to a specific department by email
                     if (Yii::$app->user->can('author')) {

                        $tender=Tender::findOne($id);
                        $tender_s=Adetail::findOne(['tender_id'=>$id]);
                        $tender_supervisor=User::findOne($tender_s->supervisor);

                        $userId = Yii::$app->user->id;
                        $assigned_one=User::findOne($userId);
                 
                        $tdetails_office=Tdetails::find()
                        ->where(['tender_id'=>$id])
                        ->one();

                        $office =Office::findOne($tdetails_office->office);

                        if ($tender_supervisor && !empty($tender_supervisor->email)) {
                            /** @var MailerInterface $mailer */
                            $mailer = Yii::$app->mailer;
                            $message = $mailer->compose()
                                ->setFrom('nicholaussomi5@gmail.com')
                                ->setTo($tender_supervisor->email)
                                // ->setCc($tender_assigned->email) // Add CC recipient(s) here
                                ->setSubject('Some one submitt the tender documents as detailed below: ')
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
                                                color: blue;
                                                text-align: center;
                                            }
    
                                            p {
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
                                        </style>
                                    </head>
                                    <body>
                                        <div class="container">
                                            <div class="logo">
                                            <img src="https://ci6.googleusercontent.com/proxy/s2ioZxU1n6rXmuUxz4xYQ36Pfr2j1HnbSNgHwy2c6pjTWEvzsLe9VdZGhYp-7dE-n6oTkJ79jUw9pHPeXRePiOT7U4irwAl5esSZrsPPqvZr8N1o6g2Bhh7k7M5UGUk=s0-d-e1-ft#http://teratech.co.tz/local/images/uploads/logo/163277576061522e507c527.webp" alt="teralogo">
                                            </div>
                                            <h1></h1>
                                            <p>Dear ' . Html::encode($tender_supervisor->username) . ',</p>
                                            <p>Your project has been assigned to you. Please find the details below:</p>
                                            <ul>
                                                <li>Tender Title: ' . Html::encode($tender->title) . '</li>
                                                <li>Submitted By: ' . Html::encode($assigned_one->username) . '</li>
                                                <li>Office: ' . Html::encode($office->location) . '</li>
                                            </ul>
                                            <p>If you have any questions or need further assistance, feel free to contact us.</p>
                                            <a href="' . Yii::$app->request->getHostInfo() . '/upload/' . $tender->submission . '">View Submitted Document</a>                                </html>
                                ');
                                
    
                        // Attach the document file to the email
        // foreach ($attachments as $attachment) {
        //     $message->attach($attachment);
        // }
    
                            // $message->send();
                            $mailer->send($message);
                        }



                    $model->expired_at=$model->expired_at;
                    $model->publish_at=$model->publish_at;
                    $model->save();
                }
                Yii::$app->session->setFlash('success', 'Upload successfull.');

                return $this->redirect(['view', 'id' => $model->id]);
                }
            
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    // }else{
        // throw new ForbiddenHttpException;
    // }
    }


    public function actionPm(){

        
            $userId = Yii::$app->user->id;
    
            // Find user assignments
            $user_assignments = Adetail::find()
                ->where(['user_id' => $userId])
                ->all();
    
            $assignedTenderIds = [];
            foreach ($user_assignments as $user_assignment) {
                $assignedTenderIds[] = $user_assignment->tender_id;
            }
    
            // Find assigned tenders
            $tender = Tender::find()
                ->where(['id' => $assignedTenderIds])
                ->all();
    
           return $this->render('pm', [
               'tender'=>$tender,
           ]);
       }
    

       public function actionNew(){

        
        $userId = Yii::$app->user->id;

        // Find user assignments
        $user_assignments = Adetail::find()
            ->where(['user_id' => $userId])
            ->all();

        $assignedTenderIds = [];
        foreach ($user_assignments as $user_assignment) {
            $assignedTenderIds[] = $user_assignment->tender_id;
        }

        // Find assigned tenders
        $new = Tender::find()
            ->Where(['session'=>0])
            ->all();

       return $this->render('new', [
           'new'=>$new,
       ]);
   }

   public function actionNonnew(){

        
    $userId = Yii::$app->user->id;

    // Find user assignments
    $user_assignments = Adetail::find()
        ->where(['user_id' => $userId])
        ->all();

    $assignedTenderIds = [];
    foreach ($user_assignments as $user_assignment) {
        $assignedTenderIds[] = $user_assignment->tender_id;
    }

    // Find assigned tenders
    $nonnew = Tender::find()
        ->Where(['session'=>!0])
        ->all();

   return $this->render('nonnew', [
       'nonnew'=>$nonnew,
   ]);
}



    /**
     * Deletes an existing Tender model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('admin')) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
        }else{
            throw new ForbiddenHttpException;
        }
    }

    // public function actionAward($tenderId)
    // {
       
    //         $model = Tender::findOne($tenderId);
    
    //         // Assign the new value to the status attribute
    //         $model->status = 1;
    
    //         if ($model->save()) {
    //             return $this->redirect(['project/create', 'tenderId' => $model->id]);
    //         } else {
    //             throw new NotFoundHttpException('The status could not be saved.');
    //         }
       
    // }

    public function actionAward($tenderId)
    {
       
            $tender=Tender::findOne($tenderId);

            
            // Update the status in the database based on the tender ID
            // Replace 'YourModel' with your actual model class name, 'status' with the database column name, and 'tenderId' with the appropriate tender ID column name
            $tender->status=1;
            Tender::updateAll(['status' => $tender->status], ['id' => $tenderId]);
            
            return $this->redirect(['project/create', 'tenderId' => $tenderId]);
        
        
        return 'Error'; // Return an error message or any other response if needed
    }

    public function actionSubmitst($tenderId)
    {
       
            $tender=Tender::findOne($tenderId);

            
            // Update the status in the database based on the tender ID
            // Replace 'YourModel' with your actual model class name, 'status' with the database column name, and 'tenderId' with the appropriate tender ID column name
            $tender->status=3;
            Tender::updateAll(['status' => $tender->status], ['id' => $tenderId]);
            
            return $this->redirect(['tender/view', 'id' => $tenderId]);
        
        
        return 'Error'; // Return an error message or any other response if needed
    }

    public function actionNonsubmitst($tenderId)
    {
       
            $tender=Tender::findOne($tenderId);

            
            // Update the status in the database based on the tender ID
            // Replace 'YourModel' with your actual model class name, 'status' with the database column name, and 'tenderId' with the appropriate tender ID column name
            $tender->status=4;
            Tender::updateAll(['status' => $tender->status], ['id' => $tenderId]);
            
            return $this->redirect(['tcomment', 'tenderId' => $tenderId]);
        
        
        return 'Error'; // Return an error message or any other response if needed
    }


    public function actionUnsucess($tenderId)
    {
       
            $tender=Tender::findOne($tenderId);

            
            // Update the status in the database based on the tender ID
            // Replace 'YourModel' with your actual model class name, 'status' with the database column name, and 'tenderId' with the appropriate tender ID column name
            $tender->status=2;
            Tender::updateAll(['status' => $tender->status], ['id' => $tenderId]);
            
            return $this->redirect(['/tcomment/create', 'tenderId' => $tenderId]);

        
        
        return 'Error'; // Return an error message or any other response if needed
    }

    /**
     * Finds the Tender model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tender the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tender::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSendNotification()
    {
        $tenders = Tender::find()
            ->where(['<', 'expired_at', strtotime('+1 week')])
            ->all();

        foreach ($tenders as $tender) {
            $assignedId = $tender->assigned_to; // Assuming there is an "assignedTo" relation in the Tender model
            $assignedUser =User::findOne($assignedId);
            $assignedEmail= $assignedUser->email;

            $subject = 'Tender Expiration Notification from Tera technologies';
            $body = 'The tender with ID ' . $tender->title . ' is expiring within one week.';

            $mailer = Yii::$app->mailer;
            $mailer->compose()
                ->setFrom('nicholaussomi5@gmail.com')
                ->setTo($assignedEmail)
                ->setSubject($subject)
                ->setTextBody($body)
                ->send();
        }

        // Redirect or display a success message
    }

    // public function actionReport(){
    //     $mpdf = new Mpdf;
    //     $mpdf->WriteHTML('Sample Text');
    //     $mpdf->Output();
    //     exit;
       
    // }

    public function actionForm()
    {
        $model = new Tender();

        if ($model->load(Yii::$app->request->post())) {

            return $this->redirect(['report', 'date_from' => $model->date_from, 'date_to' => $model->date_to]);
        }

        return $this->render('report_form', [
            'model' => $model,
        ]);
    }

    public function actionReport()
    {
        $dateFrom = Yii::$app->request->get('date_from');
        $dateTo = Yii::$app->request->get('date_to');
    
        $timestampFrom = strtotime($dateFrom);
        $timestampTo = strtotime($dateTo);
    
        $tenders = Tender::find()
            ->where(['between', 'created_at', $timestampFrom, $timestampTo])
            ->all();
    
        $content = $this->renderPartial('report', [
            'tenders' => $tenders,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    
        $pdf = new Mpdf;
    
        $pdf->WriteHTML($content);
        $pdf->Output();
        exit;
    }

    public function actionSuccess()
    {
        if (Yii::$app->user->can('admin')) {
            $model=Tender::find()
             ->where(['status'=>1])->all();

        return $this->render('success', [
          
            'model'=>$model,
        ]);
    }else {
        throw new ForbiddenHttpException;
    }
}

public function actionProgress()
{
    if (Yii::$app->user->can('admin')) {
        $model=Tender::find()
         ->where(['status'=>5])->all();
  

    return $this->render('progress', [
      
        'model'=>$model,
    ]);
}else {
    throw new ForbiddenHttpException;
}
}


public function actionPending()
{
    if (Yii::$app->user->can('admin')) {
        $model=Tender::find()
         ->where(['status'=>5])
         ->andWhere(['session'=>1])
         ->all();
  

    return $this->render('pending', [
      
        'model'=>$model,
    ]);
}else {
    throw new ForbiddenHttpException;
}
}

public function actionUnsubmit()
{
    if (Yii::$app->user->can('admin')) {
        $model=Tender::find()
         ->where(['status'=>4])->all();

    return $this->render('unsubmit', [
      
        'model'=>$model,
    ]);
}else {
    throw new ForbiddenHttpException;
}
}


public function actionSubmit()
{
    if (Yii::$app->user->can('admin')) {
        $model=Tender::find()
         ->where(['status'=>3])->all();
  

    return $this->render('submit', [
      
        'model'=>$model,
    ]);
}else {
    throw new ForbiddenHttpException;
}
}

}
