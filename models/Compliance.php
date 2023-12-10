<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "compliance".
 *
 * @property int $id
 * @property int|null $role_id
 * @property int|null $user_id
 * @property string|null $section
 */
class Compliance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compliance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supervisor','tender_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supervisor' => 'Supervisor',
            'tender_id'=>'Tender Id',

        ];
    }
}
