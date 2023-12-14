<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "compldoc".
 *
 * @property int $id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int $user_id
 * @property int $tender_id
 * @property string|null $document
 */
class Compldoc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compldoc';
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
            [['created_at', 'updated_at', 'created_by', 'user_id', 'tender_id','session'], 'integer'],
            [['user_id', 'tender_id'], 'required'],
            [['document'], 'string', 'max' => 255],
            [['session'], 'default', 'value' => 1],
            [['eligibd_id'], 'safe'],
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
            'user_id' => 'User ID',
            'session'=>'session',
            'tender_id' => 'Tender ID',
            'document' => 'Document',
            'eligibd_id' => 'Eligibility Detail',
        ];
    }

    public function getEligibd()
    {
        return $this->hasOne(Eligibdetail::class, ['id' => 'eligibd_id']);
    }
    
}
