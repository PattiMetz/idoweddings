<?php

namespace app\models\venue;

use Yii;

/**
 * This is the model class for table "venue_location_group".
 *
 * @property integer $id
 * @property integer $venue_id
 * @property string $name
 *
 * @property VenueLocation[] $venueLocations
 * @property Venue $venue
 */
class VenueLocationGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue_location_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['venue_id', 'name'], 'required'],
            [['venue_id', 'one_event'], 'integer'],
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
            'one_event' => 'Allow only one event in the same time'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocations()
    {
        return $this->hasMany(VenueLocation::className(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenue()
    {
        return $this->hasOne(Venue::className(), ['id' => 'venue_id']);
    }
}
