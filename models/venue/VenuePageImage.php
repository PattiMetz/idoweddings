<?php

namespace app\models\venue;

use Yii;

/**
 * This is the model class for table "venue_page_image".
 *
 * @property integer $id
 * @property integer $page_id
 * @property string $image
 *
 * @property VenuePage $page
 */
class VenuePageImage extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue_page_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'image'], 'required'],
            [['page_id'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => VenuePage::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'image' => 'Image',
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
