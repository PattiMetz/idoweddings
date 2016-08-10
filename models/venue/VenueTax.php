<?php

namespace app\models\venue;

use Yii;

/**
 * This is the model class for table "venue_tax".
 *
 * @property integer $venue_id
 * @property double $tax
 * @property double $service_rate
 * @property double $our_service_rate
 * @property double $agency_service_rate
 * @property string $comment
 * @property integer $commission_type
 * @property double $commission
 * @property double $commission_package
 * @property double $commission_food
 * @property double $commission_items
 * @property integer $accommodation_commission_type
 * @property double $accommodation_commission
 * @property string $accomodation_wholesale
 *
 * @property Venue $venue
 */
class VenueTax extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue_tax';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['commission_type', 'accommodation_commission_type'] ,'required'],
            [['organization_id', 'commission_type', 'accommodation_commission_type', 'deposit_currency', 'event_deposit'], 'integer'],
            [['tax', 'service_rate', 'our_service_rate', 'agency_service_rate', 'commission', 'commission_package', 'commission_food', 'commission_items', 'accommodation_commission'], 'number'],
            [['comment', 'accomodation_wholesale','commission_note','accommodation_note','note'], 'string'],
            [['organization_id'], 'unique'],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Venue::className(), 'targetAttribute' => ['organization_id' => 'organization_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'organization_id' => 'Organization ID',
            'tax' => 'Tax',
            'service_rate' => 'Service Rate',
            'our_service_rate' => 'Our Service Rate',
            'agency_service_rate' => 'Agency Service Rate',
            'comment' => 'Comment',
            'commission_type' => 'Commission Type',
            'commission' => 'Commission',
            'commission_package' => 'Packages',
            'commission_food' => 'Food & Beverages',
            'commission_items' => 'Items',
            'commission_note' => 'Note',
            'accommodation_commission_type' => 'Accommodation Commission Type',
            'accommodation_commission' => 'Accommodation Commission',
            'accomodation_wholesale' => 'Accomodation Wholesale',
            'accommodation_note' => 'Note',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenue()
    {
        return $this->hasOne(Venue::className(), ['organization_id' => 'organization_id']);
    }
}
