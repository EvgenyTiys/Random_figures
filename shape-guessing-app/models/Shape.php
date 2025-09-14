<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Shape model
 *
 * @property integer $id
 * @property string $name
 * @property string $image_path
 */
class Shape extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shapes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'image_path'], 'required'],
            [['name', 'image_path'], 'string', 'max' => 255],
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
            'image_path' => 'Image Path',
        ];
    }
}