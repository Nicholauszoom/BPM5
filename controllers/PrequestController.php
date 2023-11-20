<?php

namespace app\controllers;

use app\models\Department;
use app\models\Prequest;
use app\models\PrequestSearch;
use app\models\Project;
use app\models\Rdetail;
use app\models\User;
use Mpdf\Mpdf;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PrequestController implements the CRUD actions for Prequest model.
 */
class PrequestController extends Controller
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
     * Lists all Prequest models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PrequestSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);


    $userId = Yii::$app->user->id;

 $projects = Project::find()
        ->where(['user_id' => $userId])
        ->all();

$prequest=[];
foreach ($projects as $project){
    $prequest = Prequest::find()
            ->where(['project_id' => $project->id])
            ->all();
}

    //management
    $approved_prequest= Prequest::find()->where(['status'=>2])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'prequest'=>$prequest,
            'approved_prequest'=>$approved_prequest,
        ]);
    }

    public function actionPm2(){



    $userId = Yii::$app->user->id;

    $projects = Project::find()
           ->where(['user_id' => $userId])
           ->all();
   
   $prequest=[];
   foreach ($projects as $project){
       $prequest = Prequest::find()
               ->where(['project_id' => $project->id])
               ->all();
   }
   
       //management
       $approved_prequest= Prequest::find()->where(['status'=>1])->all();
   
       return $this->render('pm2', [
    
        'prequest'=>$prequest,
        'approved_prequest'=>$approved_prequest,
    ]);
    }

    /**
     * Displays a single Prequest model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model= $this->findModel($id);

        $prequest=Rdetail::find()
        ->where(['prequest_id'=>$id])
        ->all();

        $total_amount= 0;
        foreach ($prequest as $prequest) {
            $total_amount += $prequest->amount;
        }

        if ($model !== null && Yii::$app->user->can('admin') &&! Yii::$app->user->can('author')) {
           
            // Set isViewed attribute to 1
            $model->session= 1;
            Prequest::updateAll(['session' => $model->session], ['id' => $id]);
    
            // Save the model to persist the changes
            // $model->save();
    
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'total_amount'=> $total_amount,
        ]);
    }

    /**
     * Creates a new Prequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($projectId)
    {
        $model = new Prequest();

        $department=Department::find()->all();
        $user=User::find()->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['rdetail/create', 'prequestId' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'department'=>$department,
            'user'=>$user,
            'projectId'=>$projectId,
        ]);
    }

    /**
     * Updates an existing Prequest model.
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
     * Deletes an existing Prequest model.
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

    public function actionPm(){
        $userId = Yii::$app->user->id;
     //   retrieve the prequest assigned to the user

        $prequest = Prequest::find()
            ->where(['created_by' => $userId])
            ->all();
            return $this->render('pm', [
                'prequest' => $prequest,
                
            ]);

    }


    public function actionReport($id)
    {
      $prequest= Prequest::findOne($id);


        $prequest_details=Rdetail::find()->where(['prequest_id'=>$id])->all();

        $total_amount= 0;
        foreach ($prequest_details as $prequest_details) {
            $total_amount += $prequest_details->amount;
        }
        $content = $this->renderPartial('report', [
             'prequest' => $prequest,
            'total_amount'=>$total_amount,
            'prequest_details'=>$prequest_details,
            'id'=>$id,
           
        ]);
    
        $pdf = new Mpdf;
        $pdf->WriteHTML($content);
        $pdf->Output();
        exit;
    }

    public function actionApprove($prequestId)
    {
       
            $prequest=Prequest::findOne($prequestId);

            
            // Update the status in the database based on the tender ID
            // Replace 'YourModel' with your actual model class name, 'status' with the database column name, and 'tenderId' with the appropriate tender ID column name
            $prequest->status=3;
            Prequest::updateAll(['status' => $prequest->status], ['id' => $prequestId]);
          
            return $this->redirect(['prequest/view', 'id' => $prequestId]);
        
        
        return 'Error'; // Return an error message or any other response if needed
    }
    public function actionPmapprove($prequestId)
    {
       
            $prequest=Prequest::findOne($prequestId);

            
            // Update the status in the database based on the tender ID
            // Replace 'YourModel' with your actual model class name, 'status' with the database column name, and 'tenderId' with the appropriate tender ID column name
            $prequest->status=2;
            Prequest::updateAll(['status' => $prequest->status], ['id' => $prequestId]);
          
            return $this->redirect(['prequest/view', 'id' => $prequestId]);
        
        
        return 'Error'; // Return an error message or any other response if needed
    }

    public function actionNotapprove($prequestId)
    {
       
            $prequest=Prequest::findOne($prequestId);

            
            // Update the status in the database based on the tender ID
            // Replace 'YourModel' with your actual model class name, 'status' with the database column name, and 'tenderId' with the appropriate tender ID column name
            $prequest->status=4;
            Prequest::updateAll(['status' => $prequest->status], ['id' => $prequestId]);
          
            return $this->redirect(['prequest/view', 'id' => $prequestId]);
        
        
        return 'Error'; // Return an error message or any other response if needed
    }



    /**
     * Finds the Prequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Prequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Prequest::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
