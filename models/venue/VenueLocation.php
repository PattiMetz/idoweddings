<?php

namespace app\models\venue;

use Yii;

/**
 * This is the model class for table "venue_location".
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $name
 * @property string $description
 *
 * @property VenueLocationGroup $group
 * @property VenueLocationImage[] $venueLocationImages
 * @property VenueLocationTime[] $venueLocationTimes
 */
class VenueLocation extends \yii\db\ActiveRecord
{
    
    public $files;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'name', 'description'], 'required'],
            [['group_id', 'guest_capacity'], 'integer'],
            [['description'], 'string'],
            [['files'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 5],
            [['name'], 'string', 'max' => 255],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => VenueLocationGroup::className(), 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(VenueLocationGroup::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(VenueLocationImage::className(), ['location_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimes()
    {
        return $this->hasMany(VenueLocationTime::className(), ['location_id' => 'id']);
    }


}
