<?php
$this->registerCssFile(Yii::$app->request->baseUrl . '/plugins/component/pear/css/pear.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/plugins/admin/css/other/error.css');
?>
<div class="content">
    <img src="/plugins/admin/images/403.svg" alt="">
    <div class="content-r">
        <h1>404或500或403</h1>
        <p>无法访问该页面</p>
    </div>
</div>
