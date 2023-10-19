<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property int|null $name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role';
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
            [['name'],'string'],
            [[ 'created_at', 'updated_at', 'created_by'], 'integer'],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }
    public function getUsers()
    {
        return $this->hasMany(User::class, ['role_id' => 'id']);
    }
   
    public function getPermissions()
    {
        return $this->hasMany(Permission::class, ['id' => 'permission_id'])
            ->viaTable('role_permission', ['role_id' => 'id']);
    }

    public function getRole(): ActiveQuery
    {
        return $this->hasMany(Users::class, ['id' => 'users_id'])
            ->viaTable('role_user', ['role_id' => 'id']);
    }

  

}
