<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\ProjectManagementReport;
use app\models\ProjectManagementReportForm;
use app\models\Project;

class ReportController extends Controller
{
    public function actionGenerateReport()
    {
        $reportForm = new ProjectManagementReport();
        if ($reportForm->load(Yii::$app->request->post()) && $reportForm->validate()) {
            // Fetch projects based on the report criteria
            $projects = Project::find()
                ->where(['between', 'start_at', $reportForm->start_date, $reportForm->end_date])
                ->all();

            return $this->render('report', [
                'projects' => $projects,
            ]);
        }

        return $this->render('generate-report', [
            'reportForm' => $reportForm,
        ]);
    }
}