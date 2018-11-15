<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@backend';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        //'plugin/timepicker/datepicker3.css',
    ];
    public $js = [
        //'plugin/timepicker/bootstrap-datepicker.js',
        //'js/jquery.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];  // 这是设置所有js放置的位置
}
