<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'adminLte3/custom.css',
        '//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css',
        'adminLte3/dist/css/bootstrap-iconpicker.min.css'
    ];
    public $js = [
        'adminLte3/js/adminlte.min.js',
        'adminLte3/js/chart.js/Chart.min.js',
        '//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js',
        'adminLte3/js/demo.js',
        'adminLte3/dist/js/bootstrap-iconpicker.bundle.min.js',
        'adminLte3/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
