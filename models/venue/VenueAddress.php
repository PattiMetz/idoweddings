<?php

namespace app\models\venue;

use Yii;

/**
 * This is the model class for table "venue_address".
 *
 * @property integer $venue_id
 * @property integer $country_id
 * @property string $state
 * @property string $zip
 * @property string $city
 * @property string $address
 * @property integer $timezone
 * @property string $email
 * @property string $site
 *
 * @property Venue $venue
 */
class VenueAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['venue_id', 'country_id', 'timezone'], 'integer'],
            [['state'], 'string', 'max' => 100],
            [['zip'], 'string', 'max' => 10],
            [['city'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 255],
            ['site', 'url', 'defaultScheme' => 'http'],    
            [['email'], 'string', 'max' => 50],
            [['venue_id'], 'unique'],
            [['venue_id'], 'exist', 'skipOnError' => true, 'targetClass' => Venue::className(), 'targetAttribute' => ['venue_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'venue_id' => 'Venue',
            'country_id' => 'Country',
            'state' => 'State',
            'zip' => 'Zip',
            'city' => 'City',
            'address' => 'Address',
            'timezone' => 'Timezone',
            'email' => 'Email',
            'site' => 'Website',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenue()
    {
        return $this->hasOne(Venue::className(), ['id' => 'venue_id']);
    }
}
