<?php

namespace app\models\venue;

use Yii;

/**
 * This is the model class for table "venue_doc".
 *
 * @property integer $id
 * @property integer $venue_id
 * @property string $doc
 *
 * @property Venue $venue
 */
class VenueDoc extends \yii\db\ActiveRecord
{
    public $file;
    public $fileSaved;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue_doc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['venue_id'], 'required'],
            [['venue_id'], 'integer'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, xls, xlsx, doc, docx, csv'],
            [['doc'], 'string', 'max' => 255],
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
            'doc' => 'Doc',
        ];
    }

    public function afterSave($insert, $changedAttributes) {
        if ($insert) {
            $dir = 'uploads/venue/'.$this->venue_id;
            @mkdir($dir);
            if (is_dir($dir)) {
                $this->fileSaved = $this->file->saveAs($dir . '/' . $this->id . '.'.$this->file->extension);
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        @unlink('uploads/venue/'.$this->venue_id.'/'.$this->id.'.'.end(explode(".", $this->doc)));
        parent::afterDelete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenue()
    {
        return $this->hasOne(Venue::className(), ['id' => 'venue_id']);
    }
}
