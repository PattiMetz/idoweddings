<?php

namespace app\models\venue;

use Yii;

/**
 * This is the model class for table "venue_location_time".
 *
 * @property integer $location_id
 * @property string $times
 * @property string $days
 *
 * @property VenueLocation $location
 */
class VenueLocationTime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue_location_time';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location_id'], 'required'],
            [['location_id'], 'integer'],
            [['days'], 'safe'],
            [['time_from', 'time_to'], 'string', 'max' => 10],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => VenueLocation::className(), 'targetAttribute' => ['location_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'location_id' => 'Location ID',
            'times' => 'Times',
            'days' => 'Days',
            'days_array' => 'Days',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(VenueLocation::className(), ['id' => 'location_id']);
    }

     public function getDays_array()
    {
        
        return unserialize($this->days);
    }

    public function beforeSave($insert){
        if(is_array($this->days)) {
            $this->days = serialize($this->days);
        }
        return parent::beforeSave($insert);
    }
}
