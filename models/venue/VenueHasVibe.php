<?php

namespace app\models\venue;

use Yii;

/**
 * This is the model class for table "venue_has_vibe".
 *
 * @property integer $venue_id
 * @property integer $vibe_id
 *
 * @property Venue $venue
 * @property Vibe $vibe
 */
class VenueHasVibe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue_has_vibe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['venue_id', 'vibe_id'], 'required'],
            [['venue_id', 'vibe_id'], 'integer'],
            [['venue_id'], 'exist', 'skipOnError' => true, 'targetClass' => Venue::className(), 'targetAttribute' => ['venue_id' => 'id']],
            [['vibe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vibe::className(), 'targetAttribute' => ['vibe_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'venue_id' => 'Venue ID',
            'vibe_id' => 'Vibe ID',
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
    public function getVibe()
    {
        return $this->hasOne(Vibe::className(), ['id' => 'vibe_id']);
    }
}
