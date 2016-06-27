<?php

namespace app\models\venue;

use Yii;

/**
 * This is the model class for table "venue_page".
 *
 * @property integer $id
 * @property integer $venue_id
 * @property string $name
 * @property string $type
 * @property string $content
 *
 * @property Venue $venue
 */
class VenuePage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['venue_id', 'name', 'type'], 'required'],
            [['venue_id', 'active', 'order'], 'integer'],
            [['type', 'content', 'settings'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['venue_id'], 'exist', 'skipOnError' => true, 'targetClass' => Venue::className(), 'targetAttribute' => ['venue_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'venue_id' => 'Venue ID',
            'name' => 'Name',
            'type' => 'Type',
            'content' => 'Content',
        ];
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)) {
            if(!$this->order) {
                $max = $this->find()->andwhere(['venue_id'=>$this->venue_id])->max('`order`'); 
                $this->order = $max+1;
            }
            return true;
        }
        return false;
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenue()
    {
        return $this->hasOne(Venue::className(), ['id' => 'venue_id']);
    }
}
