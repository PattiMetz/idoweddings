<?php

namespace app\models\venue;

use Yii;
use yii\imagine\Image;
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
    public $file;
    public $fileSaved;
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
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif'],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => VenueLocation::className(), 'targetAttribute' => ['location_id' => 'id']],
        ];
    }

    public function afterSave($insert, $changedAttributes) {
        if ($insert) {
            $location = VenueLocation::findOne($this->location_id);
            $dir = 'uploads/venue/'.$location->group->venue_id.'/location/';
            @mkdir('uploads/venue/'.$location->group->venue_id);
            @mkdir($dir);
            if (is_dir($dir)) {
                $name = $this->id . '.'.$this->file->extension;
                $this->fileSaved = $this->file->saveAs($dir . '/' . $name);
                Image::thumbnail($dir . '/' . $name, 120, 120)
                ->save(Yii::getAlias($dir . '/thumb/' . $name), ['quality' => 80]);
            }
        }
          
        parent::afterSave($insert, $changedAttributes);
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
