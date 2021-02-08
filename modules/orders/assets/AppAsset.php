<?php

namespace app\modules\orders\assets;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 * Modules asset class
 *
 * @package app\modules\orders\assets
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/orders/assets';
    public $css = [
        'css/custom.css',
        'css/bootstrap.min.css'
    ];
    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}