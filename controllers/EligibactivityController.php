<?php

namespace app\controllers;

use app\models\Activitydetil;
use app\models\Adetail;
use app\models\Eligibactivity;
use app\models\EligibactivitySearch;
use app\models\Eligibdetail;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EligibactivityController implements the CRUD actions for Eligibactivity model.
 */
class EligibactivityController extends Controller
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
     * Lists all Eligibactivity models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EligibactivitySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Eligibactivity model.
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
     * Creates a new Eligibactivity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($adetailId,$tenderId,$userId)
    {
        $assgntenderId = $tenderId;
        $assgnuserId = $userId;
        

        $model = new Eligibactivity();
        $eligibsubactivity=Activitydetil::find()->where(['activity_id'=>1])->all();

       $eligibdtil= Eligibactivity::find()->where(['tender_id'=>$tenderId, 'adetail_id'=>$adetailId,'user_id'=>$userId])->all();

       $eligibdtilExist = [];
       foreach ($eligibdtil as $eligibdtil) {
        $eligibdtilExist[] =Eligibdetail::find()->where(['activitydetail_id'=>$eligibdtil->id])->all();
       
       }

        
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                if (is_array($model->activitydetail_id) && !empty($model->activitydetail_id)) {
                    foreach ($model->activitydetail_id as $adetailId) {
                        $assignment = new Eligibdetail();
                        $assignment->adetail_id = $adetailId;
                        $assignment->user_id =$userId;
                        $assignment->tender_id = $tenderId;
                        $assignment->activitydetail_id = $model->id;
                        $assignment->save();
                    }

                }
                $tendadetail=Adetail::findOne($adetailId);
                Yii::$app->session->setFlash('success', 'saved successfully.');
                return $this->redirect(['adetail/create', 'tenderId' => $assgntenderId]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'adetailId'=>$adetailId,
            'eligibsubactivity'=>$eligibsubactivity,
            'assgnuserId'=>$assgnuserId,
            'assgntenderId'=>$assgntenderId,
            'userId'=>$userId,
            'tenderId'=>$tenderId,
            'eligibdtilExist'=> $eligibdtilExist,


        ]);
    }

    /**
     * Updates an existing Eligibactivity model.
     * If update is su$eligibsuba$eligibsubactivityccessful, the browser will be redirected to the 'view' page.
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
     * Deletes an existing Eligibactivity model.
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
     * Finds the Eligibactivity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Eligibactivity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Eligibactivity::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
