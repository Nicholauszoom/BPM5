<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Itemdetail".
 *
 * @property int $id
 * @property string|null $item
 * @property string|null $quantity
 * @property string $unit
 * @property string $files
 */
class Itemdetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Itemdetail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit', 'files'], 'required'],
            [['item', 'quantity', 'unit', 'files'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item' => 'Item',
            'quantity' => 'Quantity',
            'unit' => 'Unit',
            'files' => 'Files',
        ];
    }
}
