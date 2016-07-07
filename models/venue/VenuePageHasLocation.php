<?php

namespace app\models\venue;

use Yii;

/**
 * This is the model class for table "venue_page_has_location".
 *
 * @property integer $page_id
 * @property integer $location_id
 *
 * @property VenuePage $page
 * @property VenueLocation $location
 */
class VenuePageHasLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue_page_has_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'location_id'], 'required'],
            [['page_id', 'location_id'], 'integer'],
            [['page_id', 'location_id'], 'unique', 'targetAttribute' => ['page_id', 'location_id'], 'message' => 'The combination of Page ID and Location ID has already been taken.'],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => VenuePage::className(), 'targetAttribute' => ['page_id' => 'id']],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => VenueLocation::className(), 'targetAttribute' => ['location_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'page_id' => 'Page ID',
            'location_id' => 'Location ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(VenuePage::className(), ['id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(VenueLocation::className(), ['id' => 'location_id']);
    }
}
