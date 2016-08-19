<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class KendoAsset
 * @package app\assets
 * http://demos.telerik.com/kendo-ui/treeview/checkboxes
 */
class KendoAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'js/kendo/kendo.common-material.min.css',
        'js/kendo/kendo.default.mobile.min.css',
        'js/kendo/kendo.material.min.css'
    ];
    public $js = [
        'js/kendo/kendo.all.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}