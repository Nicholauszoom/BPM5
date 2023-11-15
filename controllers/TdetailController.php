<?php

namespace app\controllers;

use app\models\Office;
use app\models\Tdetails;
use app\models\TdetailSearch;
use app\models\Tender;
use app\models\User;
use app\models\UserAssignment;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * TdetailController implements the CRUD actions for Tdetails model.
 */
class TdetailController extends Controller
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
     * Lists all Tdetails models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TdetailSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tdetails model.
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
     * Creates a new Tdetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($tenderId)
    {
        $model = new Tdetails();
        $model->tender_id = $tenderId;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {



                if($model->save()){
                        
                    $tender=Tender::findOne($tenderId);
                    // $tender_supervisor=User::findOne($tender->supervisor);
             
                  

                    // $tender_assigned=User::findOne($tender->assigned_to);
                   

                    

                    $office =Office::findOne($model->office);
           

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

                 
                }
               
                return $this->redirect(['adetail/create', 'tenderId' => $tenderId]);



            }
        } else {
            $model->loadDefaultValues();
        }

        $office=Office::find()->all();

        return $this->render('create', [
            'model' => $model,
            'tenderId'=> $tenderId,
            'office'=>$office,
        ]);
    }

    /**
     * Updates an existing Tdetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $office=Office::find()->all();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['tender/view', 'id' => $model->tender_id]);
        }


        return $this->render('update', [
            'model' => $model,
            'office'=>$office,
        ]);
    }

    /**
     * Deletes an existing Tdetails model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $model = Tdetails::findOne($id);
if ($model) {
    $tenderId = $model->tender_id;
    $model->delete();
    return $this->redirect(['tender/']);
} 

    }

    /**
     * Finds the Tdetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tdetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tdetails::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}


