<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eligibdone".
 *
 * @property int $id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int $tender_id
 * @property int $user_id
 * @property int $eligibd_id
 */
class Eligibdone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'eligibdone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'created_by', 'tender_id', 'user_id', 'eligibd_id','compldoc_id'], 'integer'],
            [['tender_id', 'user_id', 'eligibd_id'], 'required'],
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
            'tender_id' => 'Tender ID',
            'user_id' => 'User ID',
            'eligibd_id' => 'Eligibd ID',
            'compldoc_id'=> 'compldoc_id',
        ];
    }
}
