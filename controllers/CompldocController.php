<?php

namespace app\controllers;

use app\models\Compldoc;
use app\models\CompldocSearch;
use app\models\Tender;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Eligibdone;

/**
 * CompldocController implements the CRUD actions for Compldoc model.
 */
class CompldocController extends Controller
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
     * Lists all Compldoc models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CompldocSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Compldoc model.
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
     * Creates a new Compldoc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($tenderId)
    {
        $model = new Compldoc();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

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
                    $tender=Tender::findOne($tenderId);
                     $tender->session = 1;
                   
                     $tender->save();

                     $tender->session=1;
                     Tender::updateAll(['session' => $tender->session], ['id' => $tenderId]);
                     




                     if (is_array($model->eligibd_id) && !empty($model->eligibd_id)) {
                        foreach ($model->eligibd_id as $eligibdId) {
                            $assignment = new Eligibdone();
                            $assignment->tender_id = $model->tender_id;
                            $assignment->user_id = $model->user_id;
                            $assignment->compldoc_id=$model->id;
                            $assignment->eligibd_id = $eligibdId;
                            $assignment->save();

                        }
                    }

                return $this->redirect(['/tender/view', 'id' => $tenderId]);
                 }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'tenderId' => $tenderId,
        ]);
    }

    /**
     * Updates an existing Compldoc model.
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
     * Deletes an existing Compldoc model.
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
     * Finds the Compldoc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Compldoc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Compldoc::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
