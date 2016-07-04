<?php

namespace app\models\venue;

use Yii;

/**
 * This is the model class for table "venue_location_image".
 *
 * @property integer $location_id
 * @property string $image
 *
 * @property VenueLocation $location
 */
class VenueLocationImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue_location_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'location_id', 'image'], 'required'],
            [['location_id', 'id'], 'integer'],
            [['image'], 'string', 'max' => 255],
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
            'image' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(VenueLocation::className(), ['id' => 'location_id']);
    }
}
