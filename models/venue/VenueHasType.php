<?php

namespace app\models\venue;

use Yii;

/**
 * This is the model class for table "venue_has_type".
 *
 * @property integer $venue_id
 * @property integer $type_id
 *
 * @property Venue $venue
 * @property VenueType $type
 */
class VenueHasType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue_has_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['venue_id', 'type_id'], 'required'],
            [['venue_id', 'type_id'], 'integer'],
            [['venue_id'], 'exist', 'skipOnError' => true, 'targetClass' => Venue::className(), 'targetAttribute' => ['venue_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VenueType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'venue_id' => 'Venue ID',
            'type_id' => 'Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenue()
    {
        return $this->hasOne(Venue::className(), ['id' => 'venue_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(VenueType::className(), ['id' => 'type_id']);
    }
}
