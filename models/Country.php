<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "countries".
 *
 * @property integer $id
 * @property string $name
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return array
     */
    public function getList() { 
        $models = $this->find()->orderby('name')->asArray()->all();
        return ArrayHelper::map($models, 'id', 'name');
    }

    /**
     * @return array
     */
    public static function getCountryList() {
        $models = self::find()->orderby('name')->asArray()->all();
        return ArrayHelper::map($models, 'id', 'name');
    }
}
