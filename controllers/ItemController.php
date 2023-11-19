<?php

namespace app\controllers;

use app\models\Item;
use app\models\Itemdetail;
use app\models\ItemSearch;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use yii\web\Controller;
use yii\base\InvalidConfigException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
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
     * Lists all Item models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item model.
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
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Item();

        // if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
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
                                $modelRow = new Item();
                                $modelRow->serio = isset($row[0]) ? $row[0] : null;
                                $modelRow->name = isset($row[1]) ? $row[1] : null;
                                $modelRow->unit = isset($row[2]) ? $row[2] : null;
                                $modelRow->quantity = isset($row[3]) ? $row[3] : null;
                                $modelRow->files = $filePath;
                                $modelRow->save();
                            }
                        }
                    }
                    $model->files = implode(',', $filePaths);
                }
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }          
              
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Item model.
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
     * Deletes an existing Item model.
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
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
