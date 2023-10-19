<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ProjectManagementReport".
 *
 * @property int $id
 * @property int|null $start_date
 * @property int|null $end_date
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 */
class ProjectManagementReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ProjectManagementReport';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_date', 'end_date', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }
}
