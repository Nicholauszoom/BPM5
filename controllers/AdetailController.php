<?php

namespace app\controllers;

use app\models\Activity;
use app\models\Adetail;
use app\models\AdetailSearch;
use app\models\Office;
use app\models\Tdetails;
use app\models\Tender;
use app\models\User;
use app\models\UserActivity;
use app\models\UserAssignment;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * AdetailController implements the CRUD actions for Adetail model.
 */
class AdetailController extends Controller
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
     * Lists all Adetail models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AdetailSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adetail model.
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
     * Creates a new Adetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($tenderId)
    {
        $model = new Adetail();

       
        $model->tender_id= $tenderId;

        $tendrId=$tenderId;

        $assign = UserAssignment::find()
        ->where(['tender_id' => $tenderId])
        ->all();

        
    
    $users = [];
    foreach ($assign as $assignment) {
        $user = User::findOne($assignment->user_id);
        if ($user !== null) {
            $users[] = $user;
        }
    }

    $activity=Activity::find()->all();

                    // functions for status
                    function getStatusLabel($status)
                    {
                        $statusLabels = [
                          1 => 'Security Declaration',
                          2 => 'Bid/Tender Security',
                         
                        ];
                    
                        return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
                    }
                    
                    function getSiteVisitLabel($status)
                    {
                        $statusLabels = [
                          1 => 'YES',
                          2 => 'NO',
                         
                        ];
                    
                        return isset($statusLabels[$status]) ? $statusLabels[$status] : '';
                    }
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                

                       // Save the assigned users
                       if (is_array($model->activity_id) && !empty($model->activity_id)) {
                        foreach ($model->activity_id as $activityId) {
                            $assignment = new UserActivity();
                            $assignment->tender_id = $model->tender_id;
                            $assignment->user_id = $model->user_id;
                            $assignment->submit_at = $model->submit_at;
                            $assignment->assign = 1;
                            $assignment->activity_id = $activityId;
                            $assignment->save();


                            
                            //Sending Email to each user 
                            if ($assignment && !empty($assignment->user_id)) {

                                
                                 $activity_role =Activity::findOne($assignment->activity_id);
                                //find by user id
                                $assign=User::findOne(['id'=>$assignment->user_id]);

                                // $activity_role=Adetail::find()->where(['tender_id'=>$tenderId])->andWhere([])

                                //find by tender id
                                $tendr=Tender::findOne(['id'=>$assignment->tender_id]);

                                //find by t-detail
                                $tdetail = Tdetails::findOne(['tender_id'=>$assignment->tender_id]);

                                //find supervisor by user id
                                $supervisor= User:: findOne(['id'=>$model->supervisor]);

                                //find office by id
                                $office =Office::findOne(['id'=>$tdetail->office]);

                                /** @var MailerInterface $mailer */
                                $mailer = Yii::$app->mailer;
                                $message = $mailer->compose()
                                    ->setFrom('nicholaussomi5@gmail.com')
                                    ->setTo($assign->email)
                                    ->setCc($supervisor->email) // Add CC recipient(s) here
                                    ->setSubject('tera tech company is confortably assign you a tender to work on')
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
                                                <p>Dear ' . Html::encode($assign->username) . ',</p>
                                                <ul>
                                                    <li>Tender Title: ' . Html::encode($tendr->title) . '</li>
                                                    <li> Procurement Entity: ' . Html::encode($tendr->PE) . '</li>
                                                    <li> Site Visit: ' . Html::encode(getSiteVisitLabel($tdetail->site_visit)) . '</li>
                                                    <li>Site Visit Date: ' . Html::encode(date('Y-m-d', $tdetail->site_visit_date)). '</li>    
                                                    <li> End Clarification Date: ' . Html::encode(date('Y-m-d',$tdetail->end_clarificatiion)). '</li>
                                                    <li> Bid Meeting Date: ' . Html::encode(date('Y-m-d',$tdetail->bidmeet)) . '</li>
                                                    <li>Tender Security: ' . Html::encode(getStatusLabel($tdetail->tender_security)) . '</li>
                                                    <li>Submission Date: ' . Html::encode(date('Y-m-d',$tendr->expired_at)) . '</li>
                                                    <li>Assign Role: ' . Html::encode($activity_role->name) . '</li>
                                                    <li> Security Amount: ' . Html::encode($tdetail->amount) . '</li>
                                                    <li>Security %: ' . Html::encode($tdetail->percentage) . '</li>
                                                    <li>Office: ' . Html::encode($office->location) . '</li>
                                                </ul>
                                                <p>If you have any questions or need further assistance, feel free to contact us.</p>
                                                <a href="' . Yii::$app->request->getHostInfo() . '/upload/' . $tendr->document . '">View Attachment</a>                                </html>
                                    ');
        
                               

                                $mailer->send($message);
                            }
                       
                            if ($activityId == 1) {
                                Yii::$app->session->setFlash('success', 'saved and email notification successfully.');
                                // return $this->redirect(['eligibactivity/create', 'adetailId' => $model->id]);
                                $activity_role =Activity::findOne($assignment->activity_id);
                                //find by user id
                                $assign=User::findOne(['id'=>$assignment->user_id]);
                                return $this->redirect([
                                    'eligibactivity/create',
                                    'adetailId' => $model->id,
                                    'userId' => $assignment->user_id,
                                    'tenderId'=>$assignment->tender_id,
                                ]);
                            } else {
                                Yii::$app->session->setFlash('success', 'saved and email notification successfully.');
                                return $this->redirect(['adetail/create', 'tenderId' => $tenderId]);
                                
                            }
                        }
                    }


               



            }
        } else {
            $model->loadDefaultValues();
        }
          
        return $this->render('create', [
            'model' => $model,
            'users'=>$users,
            'tenderId'=>$tenderId,
            'activity'=>$activity,
            'tendrId'=>$tendrId,
        ]);
    }

    /**
     * Updates an existing Adetail model.
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
     * Deletes an existing Adetail model.
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
     * Finds the Adetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Adetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adetail::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
