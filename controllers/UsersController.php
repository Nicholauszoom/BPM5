<?php

namespace app\controllers;

use app\models\Department;
use app\models\Role;
use app\models\Users;
use app\models\UsersSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
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
     * Lists all Users models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
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
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    
    
     public function actionCreate()
     {
         $model = new Users();
     
         if ($this->request->isPost) {
             if ($model->load($this->request->post()) && $model->save()) {
                 // Assign selected departments
                 $selectedDepartments = Yii::$app->request->post('Users')['departments'];
                 if (!empty($selectedDepartments)) {
                     foreach ($selectedDepartments as $departmentId) {
                         $department = Department::findOne($departmentId);
                         if ($department !== null) {
                             $model->link('departments', $department);
                         }
                     }
                 }
     
                 $selectedRoles = Yii::$app->request->post('Users')['roles'];
                 if (!empty($selectedRoles)) {
                     foreach ($selectedRoles as $roleId) {
                         $role = Role::findOne($roleId);
                         if ($role !== null) {
                             $model->link('roles', $role);
                         }
                     }
                 }
     
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
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
  
    
     public function actionUpdate($id)
     {
         $model = $this->findModel($id);
     
         if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
             // Unlink previous departments
             $model->unlinkAll('departments', true);
     
             // Unlink previous roles
             $model->unlinkAll('roles', true);
     
             // Assign selected departments
             $selectedDepartments = Yii::$app->request->post('Users')['departments'];
             if (!empty($selectedDepartments)) {
                 foreach ($selectedDepartments as $departmentId) {
                     $department = Department::findOne($departmentId);
                     if ($department !== null) {
                         $model->link('departments', $department);
                     }
                 }
             }
     
             // Assign selected roles
             $selectedRoles = Yii::$app->request->post('Users')['roles'];
             if (!empty($selectedRoles)) {
                 foreach ($selectedRoles as $roleId) {
                     $role = Role::findOne($roleId);
                     if ($role !== null) {
                         $model->link('roles', $role);
                     }
                 }
             }
     
             return $this->redirect(['view', 'id' => $model->id]);
         }
     
         return $this->render('update', [
             'model' => $model,
         ]);
     }
    /**
     * Deletes an existing Users model.
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
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
