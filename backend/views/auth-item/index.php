
<?php

use common\models\AuthItem;
use yii\bootstrap\Html;
use yii\helpers\Url;
?>
<div class="layui-fluid">
    <div class="layui-card">
<div class="lay-lists">
<form class="layui-form">
    <blockquote class="layui-elem-quote quoteBox" style="margin-top: 15px;">
        <div class="layui-inline">
            <a class="layui-btn" data-type="url" data-title="添加" data-url="<?=Url::to(['auth-item/create'])?>" data-callback_title = "demo列表" >添加路由</a>
        </div>
    </blockquote>
</form>

<div class="lay-search" style="padding-left: 10px">
    路由名字：
    <div class="layui-inline">
        <input class="layui-input search-con" name="AuthItemSearch[name]" autocomplete="off">
    </div>

    状态：
    <div class="layui-inline layui-vertical-20" style="width: 120px">
        <?= Html::dropDownList('AuthItemSearch[type]',null,AuthItem::$type_maps,
            ['lay-ignore'=>'lay-ignore','prompt' => '全部','class'=>'layui-input search-con ys-select2' ,'lay-search'=>'lay-search' ]) ?>
    </div>

    <button class="layui-btn" data-type="search_lists">搜索</button>
</div>
    <div class="layui-card-body">
<table id="auth-item" class="layui-table" lay-data="{url:'<?=Url::to(['auth-item/list'])?>', height : 'full-20', cellMinWidth : 95, page:{limits:[20, 50, 100, 500, 1000]}}" lay-filter="auth-item">
    <thead>
    <tr>
        <th lay-data="{field: 'name', width:200}">名字</th>
        <th lay-data="{field: 'type', align:'left',width:200}">状态</th>
        <th lay-data="{field: 'description', width:200}">详情描述</th>
        <th lay-data="{field: 'update_time',  align:'left',minWidth:50}">更新时间</th>
        <th lay-data="{field: 'add_time',  align:'left',minWidth:50}">创建时间</th>
        <th lay-data="{minWidth:175, templet:'#listBar',align:'center'}">操作</th>
    </tr>
    </thead>
</table>
</div>
</div>
    </div>
</div>
<!--操作-->
<script type="text/html" id="listBar">
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete" data-url="<?=Url::to(['auth-item/delete'])?>?name={{ d.name }}" data-title="删除" data-callback_title="auth-item列表">删除路由</a>
</script>
<script>
    const tableName="auth-item";
</script>
<?=$this->registerJsFile("@adminPageJs/base/lists.js")?>