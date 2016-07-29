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
            ['locations_array', 'safe'],
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
    public function getImages()
    {
        return $this->hasMany(VenuePageImage::className(), ['page_id' => 'id']);
    }


    public function setVenuepagesetting($value)
    {
        $this->venuepagesetting = $value;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenuepagesetting()
    {
        return $this->hasOne(VenuePageSetting::className(), ['page_id' => 'id']);
    }

    private $_locations_array;

    public function getLocations_array()
    {
        if ($this->_locations_array === null) {
            $this->_locations_array = $this->getLocations()->select('id')->column();
        }
        return $this->_locations_array;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocations()
    {
        return $this->hasMany(VenueLocation::className(), ['id' => 'location_id'])->viaTable('venue_page_has_location', ['page_id' => 'id']);
    }

    public function setLocations_array($value)
    {
        $this->_locations_array = (array)$value;
    }

    private function updateLocations()
    {
        $current_ids = $this->getLocations()->select('id')->column();
        $new_ids = $this->getLocations_array();

        foreach (array_filter(array_diff($new_ids, $current_ids)) as $location_id) {
            if ($location = VenueLocation::findOne($location_id)) {
                $this->link('locations', $location);
            }
        }

        foreach (array_filter(array_diff($current_ids, $new_ids)) as $location_id) {
            if ($location = VenueLocation::findOne($location_id)) {
                $this->unlink('locations', $location, true);
            }
        }
    }

    private $_groups;
    public function getGroups()
    {
        if($this->_groups === null) {
            $this->_groups = [];
            $groups = [];
            $locations = $this->locations;
            foreach($this->locations as $location) {
                if(!in_array($location->group_id, $groups)) {
                    $this->_groups[] = $location->group;
                    $groups[] = $location->group_id;
                }
            }
        }
        return $this->_groups;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenue()
    {
        return $this->hasOne(Venue::className(), ['id' => 'venue_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert) {
            $default = [
                'top_type'   => 'slideshow',
                'default_slideshow' => '1,2,3',
                'venue_name' => 'Resort Featured Name',
                'slogan'     => 'Amazing Venues',
                'h1'         => 'Title a Description of the Venue',
                'h2'         => 'a subtitle of page',
                'text1'      => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, 
                                        pellentesque eu, pretium quis, sem. <a href="#">Nulla consequat</a> massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu 
                                        pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.
                                    ',
                'text2'      => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, 
                                        pellentesque eu, pretium quis, sem. <a href="#">Nulla consequat</a> massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu 
                                        pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.
                                    '   
            ];
            $setting = new VenuePageSetting($default);
            $this->link('venuepagesetting', $setting);
        }
        $this->updateLocations();
        parent::afterSave($insert, $changedAttributes);
    }
}
