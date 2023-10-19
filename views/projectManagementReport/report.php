<?php
use yii\helpers\Html;
?>

<h1>Project Management Report</h1>

<table>
    <thead>
        <tr>
            <th>Project Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <!-- Add other columns as per your report requirements -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($projects as $project): ?>
            <tr>
                <td><?= Html::encode($project->name) ?></td>
                <td><?= Html::encode($project->start_at) ?></td>
                <td><?= Html::encode($project->end_at) ?></td>
                <!-- Add other columns as per your report requirements -->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
