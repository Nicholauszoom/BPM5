<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "setting".
 *
 * @property int $id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int $end_clarification
 * @property string $logo
 * @property string $logo2
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting';
    }

    public function behaviors(){
        return [
            TimestampBehavior::class,
            [
                'class'=>BlameableBehavior::class,
                'updatedByAttribute'=>false,
            ],

            // [

            //     'class'=>SluggableBehavior::class,
            //     'attribute'=>'title',
            // ],
            
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'end_clarification'], 'integer'],
            [['end_clarification'], 'required'],
            [['created_at', 'updated_at', 'created_by','password','email','company','address','phone'], 'string', 'max' => 255],
            [['logo', 'logo2'], 'safe'],
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
            'end_clarification' => 'End Clarification',
            'logo' => 'Logo',
            'logo2' => 'Logo2',
            'password'=>'Password',
            'email'=>'Email',
            'company'=>'Company',
            'address'=>'Address',
            'phone'=>'Phone'

        ];
    }
}
