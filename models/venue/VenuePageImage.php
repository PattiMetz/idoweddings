<?php

namespace app\models\venue;

use Yii;
use yii\imagine\Image;
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
    public $fileSaved;
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
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'checkExtensionByMimeType' => false],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => VenuePage::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    public function afterSave($insert, $changedAttributes) {
        if ($insert) {
            
            $dir = Yii::getAlias('@webroot').'/uploads/venue/'.$this->page->venue_id.'/website/'.$this->page->type.'/';
            $thumb_dir = $dir.'thumb/';

            @mkdir(str_replace('/', '\\', $thumb_dir),'0755',true);
            if (is_dir($dir)) {
                $this->fileSaved = $this->file->saveAs($dir . '/' . $this->id . '.'.$this->file->extension);
                Image::thumbnail($dir . $this->id . '.' . $this->file->extension, 240, 105)
                    ->save(Yii::getAlias($thumb_dir . $this->id . '.' . $this->file->extension), ['quality' => 80]);
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        @unlink(Yii::getAlias('@webroot').'/uploads/venue/'.$this->page->venue_id.'/website/'.$this->page->type.'/'.$this->id.'.'.end(explode(".", $this->image)));
        parent::afterDelete();
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
