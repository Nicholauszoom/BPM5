<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role_user".
 *
 * @property int $role_id
 * @property int $user_id
 */
class RoleUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'users_id'], 'required'],
            [['role_id', 'users_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'=>'id',
            'role_id' => 'Role ID',
            'user_id' => 'User ID',
        ];
    }
}
