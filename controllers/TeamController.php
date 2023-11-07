<?php

namespace app\controllers;

use app\models\Project;
use app\models\Task;
use app\models\Team;
use app\models\TeamAssignment;
use app\models\TeamSearch;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeamController implements the CRUD actions for Team model.
 */
class TeamController extends Controller
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
     * Lists all Team models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TeamSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Team model.
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
     * Creates a new Team model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($projectId)
    {
        $model = new Team();
        $taskList = Task::find()->all();
        $userList = User::find()->all();

        $model->project_id =$projectId;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                if (is_array($model->user_id) && !empty($model->user_id)) {
                    foreach ($model->user_id as $userId) {
                        $assignment = new TeamAssignment();
                        $assignment->team_id = $model->id;
                        $assignment->user_id = $userId;
                        $assignment->project_id=$projectId;
                        $assignment->save();
                    }
                }
                return $this->redirect(['team/detail','projectId'=>$projectId]);
            }
        } else {
            $model->loadDefaultValues();
        }
        

        return $this->render('create', [
            'model' => $model,
             'taskList'=> $taskList,
             'userList'=> $userList,
             'projectId'=>$projectId,
        ]);
    }

    /**
     * Updates an existing Team model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userList = User::find()->all();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'userList'=> $userList,

        ]);
    }

    public function actionDetail($projectId)
    {
         //find team memebers by specific project

         $team_assigned=TeamAssignment::find()
         ->where(['project_id'=>$projectId])
         ->all();




         $assignedTeamIds = [];
         foreach ($team_assigned as $team_assigned) {
             $assignedTeamIds[] = $team_assigned->team_id;
         }
       $team=Team::find()
       ->where(['id'=>$assignedTeamIds])
       ->all();

        return $this->render('detail', [
            'team'=>$team,
            'projectId'=>$projectId,
           
        ]);
    }
    /**
     * Deletes an existing Team model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $team= $this->findModel($id);
        $projectId=Project::findOne(['id'=>$team->project_id]);
        $this->findModel($id)->delete();

        return $this->redirect(['project/pm']);
    }

    /**
     * Finds the Team model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Team the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Team::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
