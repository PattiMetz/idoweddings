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
            [['venue_id', 'commission_type', 'accommodation_commission_type', 'deposit_currency', 'event_deposit'], 'integer'],
            [['tax', 'service_rate', 'our_service_rate', 'agency_service_rate', 'commission', 'commission_package', 'commission_food', 'commission_items', 'accommodation_commission'], 'number'],
            [['comment', 'accomodation_wholesale','commission_note','accommodation_note','note'], 'string'],
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
            'venue_id' => 'Venue ID',
            'tax' => 'Tax',
            'service_rate' => 'Service Rate',
            'our_service_rate' => 'Our Service Rate',
            'agency_service_rate' => 'Agency Service Rate',
            'comment' => 'Comment',
            'commission_type' => 'Commission Type',
            'commission' => 'Commission',
            'commission_package' => 'Commission Package',
            'commission_food' => 'Commission Food',
            'commission_items' => 'Commission Items',
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
        return $this->hasOne(Venue::className(), ['id' => 'venue_id']);
    }
}
