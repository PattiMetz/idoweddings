<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "agreement".
 *
 * @property integer $id
 * @property string $name
 * @property string $agreement_for
 * @property string $text
 */
class Agreement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agreement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'agreement_for', 'text'], 'required'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['agreement_for'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'agreement_for' => 'Agreement For',
            'text' => 'Text',
        ];
    }
}
