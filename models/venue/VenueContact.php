<?php

namespace app\models\venue;

use Yii;

/**
 * This is the model class for table "venue_contact".
 *
 * @property integer $id
 * @property integer $venue_id
 * @property string $name
 * @property string $email
 * @property string $skype
 * @property string $phone
 * @property integer $contact_type
 *
 * @property Venue $venue
 */
class VenueContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['venue_id', 'contact_type'], 'integer'],
            [['phone'], 'string'],
            [['phones'], 'safe'],
            [['name', 'email'], 'string', 'max' => 100],
            ['email', 'email', 'skipOnEmpty'=>true],
            [['skype'], 'string', 'max' => 255],
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
            'venue_id' => 'Venue',
            'country_id' => 'Country',
            'name' => 'Name',
            'email' => 'Email',
            'skype' => 'Skype',
            'phone' => 'Phone',
            'contact_type' => 'Contact Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenue()
    {
        return $this->hasOne(Venue::className(), ['id' => 'venue_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
     
            $this->phone = serialize($this->phones);

     
            return true;
        }
        return false;
    }

    public function setPhones($value)
    {
        $this->phones = (array)$value;
    }

    public function getPhones()
    {
        
        $phones = @unserialize($this->phone);
        if(!is_array($phones)) {
            $phones = array(array('type'=>'','phone'=>$this->phone));
        }
        return $phones;
    }
}
