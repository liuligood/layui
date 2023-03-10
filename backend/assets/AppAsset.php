<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    
    public $basePath = '@webroot';  // 资源文件并可Web访问的目录、物理路径
    public $baseUrl = '@web';       // Web访问资源文件的URL
    //public $sourcePath = '/tmp/src';
    public $css = [                 // 资源包文件数组
        'css/site.css',
        '/static/plugins/layui/css/layui.css?v=2.6.10',//这个必须先引入
        '/static/css/admin.css?',
    ];
    public $js = [           
        '/static/plugins/layui/layui.js?v=2.6.10',
        '/static/js/lay-sys/layui.util.js',
        '/static/js/lay-sys/javascript.util.js',
        '/static/js/lay-sys/jquery.util.js',
        '/static/plugins/jquery.min.js',       // 资源包文件数组
    ];
    public $jsOptions = [           // 加载JS文件使用的选项
        'condition'=>'lte IE9',
        'position'=> \yii\web\View::POS_HEAD
    ];
    public $cssOptions = [          // 加载CSS文件使用的选项
        'noscript' => true,
    ];
    public $depends = [             // 该资源包依赖的其他资源包
        'yii\web\YiiAsset',             // 资源包
        'yii\bootstrap\BootstrapAsset', // 资源包
    ];
    public $publishOptions = [
        'only'=>[
            'css',
            'fonts'
        ]
    ];
}
