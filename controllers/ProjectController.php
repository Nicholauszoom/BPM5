<?php

namespace app\controllers;

use app\models\Analysis;
use app\models\AuthAssignment;
use app\models\Notification as ModelsNotification;
use app\models\Project;
use app\models\ProjectSearch;
use app\models\Request;
use app\models\Role;
use app\models\RoleUser;
use app\models\Task;
use app\models\TeamAssignment;
use app\models\Tender;
use app\models\Updates;
use app\models\User;
use app\models\Users;
use Codeception\Lib\Notification;
use Com\Tecnick\Pdf\Tcpdf as PdfTcpdf;
use Mpdf\Mpdf;
use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use TCPDF\TCPDF;
use yii\helpers\FileHelper;
use yii\mail\MailerInterface;
use yii\helpers\Html;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
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
     * Lists all Project models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('admin'))
        {


        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);


        $request_project=Request::find()->all();
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'request_project'=>$request_project,
        ]);

    }else
    {
        throw new ForbiddenHttpException;
    }
    }


    //Project manager authentication on view projects 
    /**
     * Lists Project models by author/p.manager role.
     *
     * @return string
     */
    public function actionPm()
    {
        if(Yii::$app->user->can('author'))
        {
     // Get the logged-in user
    $userId = Yii::$app->user->id;
    
    // Retrieve the projects assigned to the user
    $projects = Project::find()
        ->where(['user_id' => $userId])
        ->all();

    return $this->render('pm', [
        'projects' => $projects,
        
    ]);
    }else
    {
        throw new ForbiddenHttpException;
    }
    }

    public function actionMember()
    {
        if(Yii::$app->user->can('author'))
        {
     // Get the logged-in user
      $userId = Yii::$app->user->id;
    
             //get project for specific assigned as part of team user


        $team_assignment=TeamAssignment::find()
        ->where(['user_id'=>$userId])
        ->all();



        $project_team= [];
        foreach ($team_assignment as $proj) {
          $project_team =Project::find()
            ->where(['id'=>$proj->project_id])
            ->all();
        }

  


    return $this->render('member', [
        'project_team' => $project_team,
        
    ]);
    }else
    {
        throw new ForbiddenHttpException;
    }
    }






    /**
     * Displays a single Project model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
   
    public function actionView($id)
    {
        $profit = 0;
        $profitPerce = 0;
        $projectId=0;
       $project = Project::findOne($id);

        $model= $this->findModel($id);

    
          
        if ($model !== null) {
           
            // Set isViewed attribute to 1
            $model->isViewed= 1;
            Project::updateAll(['isViewed' => $model->isViewed], ['id' => $id]);
    
            // Save the model to persist the changes
            // $model->save();
    
        }
       

        // find task by  project id
        $tasks= Task::find()
         ->where(['project_id'=> $id])
         ->all();

        


        $analysis= Analysis::find()
         ->where(['project' => $id])
         ->all();

         // Find projects assigned 
            $analy = Analysis::find()
               ->where(['project' => $id])
                ->all();

// Calculate the total project budget for the assigned projects
               $projectAmount = 0;
               foreach ($analy as $analy) {
               $projectAmount += $analy->cost;


               //Calculate profit gained  
               $profit =$project->budget - $projectAmount;

            //* Percent of the project profit gained
            $profitPerce = ($profit / $project->budget) * 100;
             
              $id = $projectId;
             


           
              $analyses = Analysis::find()
              ->where(['project' => $id])
              ->all();

            //   $request_on = null;

            //   if ($id !== null) {
            //       $request_on = Request::find()
            //           ->where(['project_id' => $id])
            //           ->all();
            //   }
        }

 
        
        return $this->render('view', [
            'model' => $model,
            'tasks' => $tasks,
            'analysis'=>$analysis,
            'projectAmount'=>$projectAmount,
            'profit' => $profit,
            'profitPerce'=> $profitPerce,
            'projectId' =>$projectId,
            'id'=>$id,
            // 'request_on'=>$request_on,
          
            

        ]);
    }


 
    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    
    

     public function actionCreate($tenderId)
{
    if (Yii::$app->user->can('admin')) {
        $model = new Project();
        $users = User::find()->all();
        

        $model->tender_id=$tenderId;
         $details= Tender::findOne($tenderId);
        
        // $details= Tender::find()
        // ->where(['status'=>1])
        // ->all();
         $model->tender_id=$details;

        if ($model->load(Yii::$app->request->post())) {
            // select to upload document
          
            // Assign the project manager ID from the selected user
            $selectedProjectManager = Yii::$app->request->post('Project')['user_id'];
            if (!empty($selectedProjectManager)&& !empty($tender)) {
                $model->user_id = $selectedProjectManager;
                $tenderTitle = $tender->title;
                // Save the project
                $model->document = UploadedFile::getInstance($model, 'document');
   
                if ($model->validate()){
                    if ($model->document){
                        $uploadPath = Yii::getAlias('@webroot/upload/');
                    $fileName = $model->document->baseName . '.' . $model->document->extension;
                    $filePath = $uploadPath . $fileName;
                
                    if ($model->document->saveAs($filePath)) {
                        $model->document = '' . $fileName;
                    }
    
                        // if ($model->document->saveAs($filePath)) {
                        //     $model->document = $filePath;
                        // Add the file path to attachments array
                         $attachments[] = $filePath;
                        // }
                         // Process the CSV file
                    
                    }

                    $submissionFile = UploadedFile::getInstance($model, 'invite_letter');
                    if ($submissionFile !== null) {
                        $submissionPath = '' . $submissionFile->name; // Adjusted file path
                        $submissionFile->saveAs($submissionPath);
                        $model->invite_letter = $submissionPath;
                    }


                    
                    
                if ($model->save()) {
                    // Send an email to the assigned project user
                    // Find the user with the same ID as the created_by ID in the project
                    $projectManagers = User::findOne(['id' => $model->created_by]);
                    $projectManager = User::findOne($selectedProjectManager);
                    
                    if ($projectManager && !empty($projectManager->email)) {
                        /** @var MailerInterface $mailer */
                        $mailer = Yii::$app->mailer;
                        $message = $mailer->compose()
                            ->setFrom('nicholaussomi5@gmail.com')
                            ->setTo($projectManager->email)
                            ->setSubject('TeraTech Company')
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
                                        <h1>TERATECH ANNOUCEMENT</h1>
                                        <p>Dear ' . Html::encode($projectManager->username) . ',</p>
                                        <p>Your project has been assigned to you. Please find the details below:</p>
                                        <ul>
                                            <li>Project Name: ' . Html::encode($tenderTitle) . '</li>
                                            <li>Project Deadline: ' .  Html::encode(date('Y-m-d',$model->end_at)) . '</li>
                                            <li>Assigned By: ' . Html::encode($projectManagers->username) . '</li>
                                        </ul>
                                        <p>If you have any questions or need further assistance, feel free to contact us.</p>
                                        <a href="' . Yii::$app->request->getHostInfo() . '/upload/' . $model->document . '">View Attachment</a>                       </html>
                            ');

                            // Attach the invite letter document
if ($model->invite_letter) {
    $message->attach($model->invite_letter);
}

                    // Attach the document file to the email
    foreach ($attachments as $attachment) {
        $message->attach($attachment);
    }

                        // $message->send();
                        $mailer->send($message);
                    }
                    // Create a notification for the assigned user
                
                    // return $this->redirect(['view', 'id' => $model->id]);
                return $this->redirect(['project/view', 'id' => $model->id]);
                }
            }
    else {
            $model->loadDefaultValues();
        }
    }
}

        return $this->render('create', [
            'model'=> $model,
            'users' => $users,
            'details'=>$details,
            'tenderId'=>$tenderId,
           
        ]);
    } else {
        throw new ForbiddenHttpException;
    }
}


     
    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

     public function actionUpdate($id)
     {
        $users= User::find()->all();
    
    
         $model = $this->findModel($id);
                     // Retrieve project manager role
                     $details= Tender::find()
                     ->where(['status'=>1])
                     ->all();
     
         if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
             return $this->redirect(['view', 'id' => $model->id]);
         }
     
         return $this->render('update', [
             'model' => $model,
             'users'=>$users,
             'id'=>$id,
             'details'=>$details
            
         ]);

        
     }
     public function actionEdit($id)
     {
        $users= User::find()->all();
    
    
         $model = $this->findModel($id);
                     // Retrieve project manager role
                     $details= Tender::find()
                     ->where(['status'=>1])
                     ->all();
     
         if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
             return $this->redirect(['project']);
         }
     
         return $this->render('edit', [
             'model' => $model,
             'users'=>$users,
             'id'=>$id,
             'details'=>$details
            
         ]);

        
     }
   


     
    // public function actionUpdate($id)
    // {
    //     if (Yii::$app->user->can('updateProject')) {
    //         $model = $this->findModel($id);

    //         if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         }

    //         return $this->render('update', [
    //             'model' => $model,
    //         ]);
    //     } else {
    //         throw new \yii\web\ForbiddenHttpException('You are not allowed to update thisproject.');
    //     }
    // }


    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // if(Yii::$app->user->can('admin'))
        // {

        if (Yii::$app->user->can('admin')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
       
    }else
    {
        throw new ForbiddenHttpException;
    }
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
    return $this->redirect(['index']);
}

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionNotify()
    {
        $expirationDate = date('Y-m-d', strtotime('+1 month'));

        $models = Project::find()
            ->where(['>=', 'end_at', $expirationDate])
            ->all();


        foreach ($models as $model) {
            $user=User::findOne($model->user_id);
            // Send email notification
            $this->sendEmail($user->email, 'Expiration Notification', 'Your expiration date is approaching.');
        }
    }

    private function sendEmail($to, $subject, $body)
    {
        return Yii::$app->mailer->compose()
            ->setFrom('nicholaussomi5@gmail.com')
            ->setTo($to)
            ->setSubject($subject)
            ->setTextBody($body)
            ->send();
    }



    public function actionForm()
    {
        $model = new Project();

        if ($model->load(Yii::$app->request->post())) {

            return $this->redirect(['reports', 'date_from' => $model->date_from, 'date_to' => $model->date_to]);
        }

        return $this->render('report_form', [
            'model' => $model,
        ]);
    }

    public function actionReports()
    {
        $dateFrom = Yii::$app->request->get('date_from');
        $dateTo = Yii::$app->request->get('date_to');
    
        $timestampFrom = strtotime($dateFrom);
        $timestampTo = strtotime($dateTo);
    
        $projects = Project::find()
            ->where(['between', 'created_at', $timestampFrom, $timestampTo])
            ->all();
    
        $content = $this->renderPartial('reports', [
            'projects' => $projects,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    
        $pdf = new Mpdf;
    
        $pdf->WriteHTML($content);
        $pdf->Output();
        exit;
    }


    public function actionBudget()
{
    if (Yii::$app->user->can('admin')) {
        $model=Project::find()
           ->all();
  

    return $this->render('budget', [
      
        'model'=>$model,
    ]);
}else {
    throw new ForbiddenHttpException;
}
}



public function actionComplete()
{
    if (Yii::$app->user->can('admin')) {
        $model=Project::find()
        ->where(['status'=>1])
        ->all();
  

    return $this->render('complete', [
      
        'model'=>$model,
    ]);
}else {
    throw new ForbiddenHttpException;
}
}

public function actionProgress()
{
    if (Yii::$app->user->can('admin')) {
        $model=Project::find()
        ->where(['status'=>2])
        ->all();
  

    return $this->render('progress', [
      
        'model'=>$model,
    ]);
}else {
    throw new ForbiddenHttpException;
}
}

 
    
}

