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
    public $file_saved;
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
        if($this->font_settings == '' || !is_array($settings)) {
            $settings = [
                'title'    => ['font'=>'Conv_proximanova-regular', 'size'=>'36', 'color'=>'#f69997'],
                'subtitle' => ['font'=>'Conv_proximanova-regular', 'size'=>'30', 'color'=>'#917671'],
                'content'  => ['font'=>'Conv_proximanova-regular', 'size'=>'16', 'color'=>'#474747'],
                'menu'     => ['font'=>'Conv_proximanova-regular', 'size'=>'16', 'color'=>'#000'],
                'submenu'  => ['font'=>'Conv_proximanova-regular', 'size'=>'14', 'color'=>'#000'],
                'button'   => ['font'=>'Conv_EuphoriaScript-Regular', 'size'=>'40', 'color'=>'#fff','background'=>'#f69997'],
                'name'     => ['font'=>'Conv_EuphoriaScript-Regular', 'size'=>'72', 'color'=>'#f69997']
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

    public function afterSave($insert, $changedAttributes) {
        
        if($this->logo_file) {    
            $dir = 'uploads/venue/'.$this->venue_id.'/website';
            
            @mkdir($dir);
            
            if (is_dir($dir)) {
                $name = 'logo.'.$this->logo_file->extension;
                if ($this->file_saved = $this->logo_file->saveAs($dir . '/' . $name)){
                    $this->logo = $name;
                    $this->logo_type = 2;
                    $this->updateAttributes(['logo', 'logo_type']);
                }
            }
        }
          
        parent::afterSave($insert, $changedAttributes);
    }
}
