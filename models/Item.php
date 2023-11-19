<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['created_at', 'updated_at', 'created_by'], 'integer'],
            [['name','quantity','unit','serio'], 'string', 'max' => 255],
            [['files'], 'file'],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'quantity'=>'Quantity',
            'unit'=> 'Unit',
            'files'=>'Files',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }
}
