<?php

namespace app\models\venue;

use Yii;
use app\models\VenueType;
use app\models\VenueService;
use app\models\Vibe;
use app\models\Location;
use app\models\User;
/**
 * This is the model class for table "venue".
 *
 * @property integer $id
 * @property string $name
 * @property string $featured_name
 * @property integer $location_id
 * @property string $active
 * @property string $featured
 * @property integer $type_id
 * @property integer $vibe_id
 * @property integer $service_id
 * @property string $comment
 * @property string $guest_capacity
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property VenueType $type
 * @property Vibe $vibe
 * @property VenueService $service
 * @property VenueAddress $venueAddress
 * @property VenueContact[] $venueContact
 * @property VenueDoc[] $venueDoc
 * @property VenueTax $venueTax
 */
class Venue extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','location_id', 'featured_name'], 'required'],
            [['location_id','updated_by', 'type', 'nonguest'], 'integer'],
            [['active', 'featured', 'comment'], 'string'],
            [['name', 'featured_name'], 'string', 'max' => 100],
            [['types_array','vibes_array','services_array', 'type_id', 'vibe_id', 'service_id'],'safe'],
            [['guest_capacity'], 'string', 'max' => 50],
            [['updated_at'], 'string', 'max' => 20],
            
            /*[['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VenueType::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['vibe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vibe::className(), 'targetAttribute' => ['vibe_id' => 'id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => VenueService::className(), 'targetAttribute' => ['service_id' => 'id']],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Venue Name',
            'featured_name' => 'Featured Name',
            'location_id' => 'Location ID',
            'active' => 'Active venue profile',
            'featured' => 'Featured',
            'type_id' => 'Type ID',
            'vibe_id' => 'Vibe ID',
            'service_id' => 'Service ID',
            'comment' => 'Comments',
            'guest_capacity' => 'Guest Capacity',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return $this->hasMany(VenueType::className(), ['id' => 'type_id'])->viaTable('venue_has_type', ['venue_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVibes()
    {
       return $this->hasMany(Vibe::className(), ['id' => 'vibe_id'])->viaTable('venue_has_vibe', ['venue_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(VenueService::className(), ['id' => 'service_id'])->viaTable('venue_has_service', ['venue_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(VenueAddress::className(), ['venue_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(VenueContact::className(), ['venue_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocs()
    {
        return $this->hasMany(VenueDoc::className(), ['venue_id' => 'id']);
    }

    public function getUser()
    {
        $user = new User;
        if($this->updated_by>0) {
            $user_identity = $user->findIdentity($this->updated_by);
            if($user_identity)
                return $user_identity->username;
            else
                return '';
        }
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTax()
    {
        return $this->hasOne(VenueTax::className(), ['venue_id' => 'id']);
    }
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
     
            $this->updated_at = date("Y/m/d h:i:s");

            $this->updated_by = Yii::$app->user->identity->id;
     
            return true;
        }
        return false;
    }


    private $_types_array;

    public function getTypes_array()
    {
        if ($this->_types_array === null) {
            $this->_types_array = $this->getTypes()->select('id')->column();
        }
        return $this->_types_array;
    }

    public function setTypes_array($value)
    {
        $this->_types_array = (array)$value;
    }

    private function updateTypes()
    {

        $current_ids = $this->getTypes()->select('id')->column();
        $new_ids = $this->getTypes_array();

        foreach (array_filter(array_diff($new_ids, $current_ids)) as $type_id) {
            /** @var VenueType $type */
            if ($type = VenueType::findOne($type_id)) {
                $this->link('types', $type);
            }else {
                echo "unknown type";die();
            }
        }

        foreach (array_filter(array_diff($current_ids, $new_ids)) as $type_id) {
            /** @var Tag $type */
            if ($type = VenueType::findOne($type_id)) {
                $this->unlink('types', $type, true);
            }
        }
    }

    private $_vibes_array;

    public function getVibes_array()
    {
        if ($this->_vibes_array === null) {
            $this->_vibes_array = $this->getVibes()->select('id')->column();
        }
        return $this->_vibes_array;
    }

    public function setVibes_array($value)
    {
        $this->_vibes_array = (array)$value;
    }

    private function updateVibes()
    {
        $current_ids = $this->getVibes()->select('id')->column();
        $new_ids = $this->getVibes_array();

        foreach (array_filter(array_diff($new_ids, $current_ids)) as $vibe_id) {
            /** @var Vibe $type */
            if ($vibe = Vibe::findOne($vibe_id)) {
                $this->link('vibes', $vibe);
            }
        }

        foreach (array_filter(array_diff($current_ids, $new_ids)) as $vibe_id) {
            /** @var Vibe $type */
            if ($vibe = Vibe::findOne($vibe_id)) {
                $this->unlink('vibes', $vibe, true);
            }
        }
    }

    private $_services_array;

    public function getServices_array()
    {
        if ($this->_services_array === null) {
            $this->_services_array = $this->getServices()->select('id')->column();
        }
        return $this->_services_array;
    }

    public function setServices_array($value)
    {
        $this->_services_array = (array)$value;
    }

    private function updateServices()
    {
        $current_ids = $this->getServices()->select('id')->column();
        $new_ids = $this->getServices_array();

        foreach (array_filter(array_diff($new_ids, $current_ids)) as $service_id) {
            /** @var VenueService $service */
            if ($service = VenueService::findOne($service_id)) {
                $this->link('services', $service);
            }
        }

        foreach (array_filter(array_diff($current_ids, $new_ids)) as $service_id) {
            /** @var VenueService $service */
            if ($service = VenueService::findOne($ervice_id)) {
                $this->unlink('services', $service, true);
            }
        }
    }

    private function updateTax()
    {
        

        $current_ids = $this->getServices()->select('id')->column();
        $new_ids = $this->getServices_array();

        foreach (array_filter(array_diff($new_ids, $current_ids)) as $service_id) {
            /** @var VenueService $service */
            if ($service = VenueService::findOne($service_id)) {
                $this->link('services', $service);
            }
        }

        foreach (array_filter(array_diff($current_ids, $new_ids)) as $service_id) {
            /** @var VenueService $service */
            if ($service = VenueService::findOne($ervice_id)) {
                $this->unlink('services', $service, true);
            }
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->updateTypes();
        $this->updateVibes();
        $this->updateServices();
        parent::afterSave($insert, $changedAttributes);
    }

}