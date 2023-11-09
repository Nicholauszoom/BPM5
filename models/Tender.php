<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "tender".
 *
 * @property int $id
 * @property string $PE
 * @property string $TenderNo
 * @property string $title
 * @property string $description
 * @property string $document
 * @property string $submission
 * @property int|null $publish_at
 * @property int|null $expired_at
 * @property int|null $assigned_to
 * @property int|null $submit_to
 * @property int|null $supervisor
 * @property int $status
 * @property int $budget
 * 
 * @property int $isViewed
 * @property int $session
 * 
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 */
class Tender extends \yii\db\ActiveRecord
{

    public $date_from;

    public $date_to;
    
    public $assigned_to = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tender';
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
            [['title', 'description','document'], 'required'],
            [['status', 'updated_at', 'created_by','budget','session','submit_to'], 'integer'],
            [['title', 'description','PE','TenderNo','coment'], 'string', 'max' => 255],
            [['session','budget'], 'default', 'value' => 0],
            [['coment'], 'default', 'value'=>'reason not submitted || not awarded'],
            [['document'], 'file','maxSize' => 1024*1024*10],
            [['document','session','submission','assigned_to','status'], 'safe'],
            ['publish_at', 'compare', 'compareValue' => date('Y-m-d'), 'operator' => '<='],
            ['expired_at', 'date', 'format' => 'php:Y-m-d'],
            ['publish_at', 'date', 'format' => 'php:Y-m-d'],

            ['date_from', 'date', 'format' => 'php:Y-m-d'],
            ['date_to', 'date', 'format' => 'php:Y-m-d'],
            // [['assigned_to'], 'each', 'rule' => ['integer']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'expired_at' => 'Submitted Date',
            'status' => 'Status',
            'budget'=>'bid price ',
            'PE'=>'Proqurement Entity',
            'TenderNo'=>'Tender Number',
            'session'=>'session',
            'coment'=>'tender coment',
            'publish_at'=>'Published Date',
            'document'=>'tender Attachment',
            'submission'=>'Tender Submition Document',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            // 'assigned_to'=>'Assigned To',
            'date_from'=>'Date From',
            'date_to'=>'Date To',
            'submit_to'=>'Submitted To',
            // 'supervisor'=>'Supervisor',
            'created_by' => 'Created By',
        ];
    }


public static function findByTitle($title)
{
    return self::findOne(['title'=>$title]);
}

public function getUser()
{
    return $this->hasMany(User::class, ['id' => 'assigned_to']);
}

public function getDepartment()
{
    return $this->hasOne(Department::class, ['id' => 'submit_to']);
}
public function beforeSave($insert)
    {
        if ($this->publish_at && $this->expired_at) {
            $this->publish_at = strtotime($this->publish_at);
            $this->expired_at = strtotime($this->expired_at);
        }

        return parent::beforeSave($insert);
    }


}