<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "prequest".
 *
 * @property int $id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property string $payee
 * @property int $department
 * @property int $mode
 * @property int $project_id
 */
class Prequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prequest';
    }

    public function behaviors(){
        return [
            TimestampBehavior::class,
            [
                'class'=>BlameableBehavior::class,
                'updatedByAttribute'=>false,
            ],
          
           
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'created_by', 'department', 'mode', 'project_id','status'], 'integer'],
            [['payee', 'department', 'mode', 'project_id'], 'required'],
            [['payee'], 'string', 'max' => 255],
            [['status','session'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'payee' => 'Payee',
            'department' => 'Department',
            'mode' => 'Mode',
            'project_id' => 'Project ID',
            'status'=>'Status',
            'session'=>'Session',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'payee']);
    }
    
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department']);
    }
    
}
