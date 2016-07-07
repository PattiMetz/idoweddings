<?php

namespace app\models\venue;

use Yii;

/**
 * This is the model class for table "venue_page_setting".
 *
 * @property integer $page_id
 * @property string $top_type
 * @property string $venue_name
 * @property string $button
 * @property string $slogan
 * @property string $h1
 * @property string $h2
 * @property string $text1
 * @property string $text2
 *
 * @property VenuePage $page
 */
class VenuePageSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue_page_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'top_type'], 'required'],
            [['page_id'], 'integer'],
            [['text1', 'text2'], 'string'],
            [['top_type'], 'string', 'max' => 15],
            [['venue_name', 'button', 'slogan', 'h1', 'h2', 'video'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => VenuePage::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'page_id' => 'Page ID',
            'top_type' => 'Top Type',
            'venue_name' => 'Venue Name',
            'button' => 'Button',
            'slogan' => 'Slogan',
            'h1' => 'H1',
            'h2' => 'H2',
            'text1' => 'Text1',
            'text2' => 'Text2',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(VenuePage::className(), ['id' => 'page_id']);
    }
}
