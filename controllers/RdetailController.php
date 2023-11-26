<?php

namespace app\controllers;

use app\models\Analysis;
use app\models\Prequest;
use app\models\Project;
use app\models\Rdetail;
use app\models\RdetailSearch;
use app\models\Tender;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * RdetailController implements the CRUD actions for Rdetail model.
 */
class RdetailController extends Controller
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
     * Lists all Rdetail models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RdetailSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rdetail model.
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

    /**
     * Creates a new Rdetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($prequestId)
    {
        $model = new Rdetail();

        $prequest=Rdetail::find()
        ->where(['prequest_id'=>$prequestId])
        ->all();
    

        $total_amount= 0;
        foreach ($prequest as $prequest) {
            $total_amount += $prequest->amount;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {


                return $this->redirect(['create','prequestId'=>$prequestId]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'prequestId'=>$prequestId,
            'prequest'=>$prequest,
            'total_amount'=>$total_amount,
        ]);
    }


    public function actionRequestmail($prequestId){

        if ($prequestId && !empty($prequestId)) {

            $proquest =Prequest::findOne([$prequestId]);

            $project=Project::findOne([$proquest->project_id]);
            $user=User::findOne(['id'=>$project->user_id]);

            $tender=Tender::findOne(['id'=>$project->tender_id]);
        
           /** @var MailerInterface $mailer */
           $mailer = Yii::$app->mailer;
           $message = $mailer->compose()
               ->setFrom('nicholaussomi5@gmail.com')
               ->setTo($user->email)
               ->setSubject('tera tech company project new request')
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
                               <img src="http://teratech.co.tz/local/images/uploads/logo/163277576061522e507c527.webp" alt="teralogo">
                           </div>
                           <p>Dear ' . Html::encode($user->username) . ',</p>
                           <ul>
                               <li>Project Title: ' . Html::encode($tender->title) . '</li>
                             
                           </ul>
                           <p>For more information visit the site.</p>
                                                    </html>
               ');

          

           $mailer->send($message);
       }
              Yii::$app->session->setFlash('success', 'Email is successfull sent to pm.');
                return $this->redirect(['/prequest', 'id' => $prequestId]);


            return 'Error'; // Return an error message or any other response if needed
    

    }

    /**
     * Updates an existing Rdetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Rdetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Rdetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Rdetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rdetail::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
