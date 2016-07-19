<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
	'css/easyui.css',
	'css/chosen.css',
	'css/admin.css'
    ];
    public $js = [
	'js/jquery.nicescroll.min.js',
	'js/jquery.formstyler.min.js',
	'js/jquery.easyui.min.js',
	'js/chosen.jquery.min.js',
	'js/admin.js',
//	'js/sett_knbase.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
