<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PublicAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "assets-layout/css/bootstrap.min.css",
        "assets-layout/css/font-awesome.min.css",
        "assets-layout/css/animate.min.css",
        "assets-layout/css/owl.carousel.css",
        "assets-layout/css/owl.theme.css",
        "assets-layout/css/owl.transitions.css",
        "assets-layout/css/style.css",
        "assets-layout/css/responsive.css",
    ];
    public $js = [
//        "assets-layout/js/jquery-1.11.3.min.js",
//        "assets-layout/js/bootstrap.min.js",
//        "assets-layout/js/owl.carousel.min.js",
//        "assets-layout/js/jquery.stickit.min.js",
//        "assets-layout/js/menu.js",
//        "assets-layout/js/scripts.js",
    ];
    public $depends = [

    ];
}
