<?php

namespace app\models\venue;

use Yii;

/**
 * This is the model class for table "venue_website".
 *
 * @property integer $id
 * @property integer $venue_id
 * @property string $font_settings
 * @property integer $logo_type
 * @property string $logo
 * @property integer $navigation_pos
 */
class VenueWebsite extends \yii\db\ActiveRecord
{
    public $logo_file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue_website';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['venue_id'], 'required'],
            [['venue_id', 'logo_type', 'navigation_pos'], 'integer'],
            [['font_settings'], 'string'],
            [['logo', 'url'], 'string', 'max' => 255],
            [['logo_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(VenuePage::className(), ['venue_id' => 'venue_id']);
    }

    public function getSettings()
    {   
        if($this->font_settings!='')
            $settings = unserialize($this->font_settings);
        if($this->font_settings=='' || !is_array($settings)) {
            $settings = [
                'title'=>['font'=>'', 'size'=>'', 'color'=>''],
                'subtitle'=>['font'=>'', 'size'=>'', 'color'=>''],
                'content'=>['font'=>'', 'size'=>'', 'color'=>''],
                'menu'=>['font'=>'', 'size'=>'', 'color'=>''],
                'submenu'=>['font'=>'', 'size'=>'', 'color'=>''],
                'button'=>['font'=>'', 'size'=>'', 'color'=>'','background'=>''],
                'name'=>['font'=>'', 'size'=>'', 'color'=>'']
            ];
        }
       return $settings;
    }

    public function checkUrl($url){
        if($this->findBySql("SELECT * FROM `venue_website` WHERE id!='".$this->id."' AND url='".$url."'")->count()>0)
            return false;

        return true;
    }

    public function generateUrl($name){
        return mb_strtolower(trim(str_replace(array(' ',"'"), '_', $name)));
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'venue_id' => 'Venue ID',
            'font_settings' => 'Font Settings',
            'logo_type' => 'Logo Type',
            'logo' => 'Logo',
            'navigation_pos' => 'Navigation Pos',
        ];
    }
}
