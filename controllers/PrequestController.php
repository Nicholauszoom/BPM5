<?php

namespace app\controllers;

use app\models\Department;
use app\models\Prequest;
use app\models\PrequestSearch;
use app\models\Rdetail;
use app\models\User;
use Mpdf\Mpdf;
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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $prequest=Rdetail::find()
        ->where(['prequest_id'=>$id])
        ->all();

        $total_amount= 0;
        foreach ($prequest as $prequest) {
            $total_amount += $prequest->amount;
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
