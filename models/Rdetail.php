<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "rdetail".
 *
 * @property int $id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int $iteam
 * @property string $unit
 * @property string $amount
 * @property int $prequest_id
 */
class Rdetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rdetail';
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
            [['created_at', 'updated_at', 'created_by', 'iteam', 'prequest_id'], 'integer'],
            [['iteam', 'unit', 'amount', 'prequest_id'], 'required'],
            [['unit', 'amount','quantity'], 'string', 'max' => 255],
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
            'iteam' => 'Iteam',
            'unit' => 'Unit',
            'amount' => 'Amount',
            'prequest_id' => 'Prequest ID',
            'quantity'=>'QTY',
        ];
    }
    public function getItem()
    {
        return $this->hasOne(Item::class, ['id' => 'iteam']);
    }
    
}
