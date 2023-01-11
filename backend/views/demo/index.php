
<?php
use yii\helpers\Url;
?>
<div class="layui-fluid">
    <div class="layui-card">
<div class="lay-lists">
<form class="layui-form">
    <blockquote class="layui-elem-quote quoteBox" style=" margin-top: 15px;">
        <div class="layui-inline">
            <a class="layui-btn" data-type="url" data-title="添加" data-url="<?=Url::to(['demo/create'])?>" data-callback_title = "demo列表" >添加</a>
        </div>
    </blockquote>
</form>
<form>
    <div class="layui-form lay-search" style="padding-left: 10px">
        ID：
        <div class="layui-inline">
            <input class="layui-input search-con" name="DemoSearch[id]" autocomplete="off">
        </div>

        标题：
        <div class="layui-inline">
            <input class="layui-input search-con" name="DemoSearch[title]" autocomplete="off">
        </div>

        <button class="layui-btn" data-type="search_lists">搜索</button>
    </div>
</form>
    <div class="layui-form" style="padding: 10px 0">
        <button class="layui-btn layui-btn-normal" data-type="export_lists" data-url="<?=Url::to(['demo/exports'])?>">导出</button>
    </div>
    <div class="layui-card-body">
<table id="demo" class="layui-table" lay-data="{url:'<?=Url::to(['demo/list'])?>', height : 'full-20', cellMinWidth : 95, page:{limits:[20, 50, 100, 500, 1000]}}" lay-filter="demo">
    <thead>
    <tr>
        <th lay-data="{field: 'id', width:80}">ID</th>
        <th lay-data="{width:130, align:'center',templet:'#goodsImgTpl'}">主图</th>
        <th lay-data="{field: 'title', align:'left',width:100}">标题</th>
        <th lay-data="{field: 'desc', width:100}">备注</th>
        <th lay-data="{field: 'status', width:120}">状态</th>
        <th lay-data="{field: 'update_time',  align:'left',minWidth:50}">更新时间</th>
        <th lay-data="{field: 'add_time',  align:'left',minWidth:50}">创建时间</th>
        <th lay-data="{minWidth:175, templet:'#listBar',fixed:'right',align:'center'}">操作</th>
    </tr>
    </thead>
</table>
</div>
</div>
    </div>
</div>
<!--操作-->
<script type="text/html" id="listBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="update" data-url="<?=Url::to(['demo/update'])?>?id={{ d.id }}" data-title="编辑" data-callback_title="demo列表">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete" data-url="<?=Url::to(['demo/delete'])?>?id={{ d.id }}">删除</a>
</script>
<script type="text/html" id="goodsImgTpl">
    <a href="{{d.goods_img}}" data-lightbox="pic">
        <img class="layui-circle" src="{{d.goods_img}}?imageView2/2/h/120" width="30"/>
    </a>
</script>
<script>
    const tableName="demo";
</script>
<?php
$this->registerJsFile("@adminPageJs/base/lists.js?v=0.0.4.6");
$this->registerJsFile("@adminPageJs/goods-selection/lists.js?v=0.0.4.6");
$this->registerCssFile("@adminPlugins/lightbox2/css/lightbox.min.css", ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile("@adminPlugins/lightbox2/js/lightbox.min.js", ['depends' => 'yii\web\JqueryAsset']);
?>
<?php
$this->registerJsFile('@adminPlugins/export/xlsx.core.min.js?v=1',['depends'=>'yii\web\JqueryAsset']);
$this->registerJsFile('@adminPlugins/export/export-excel.js?v=1',['depends'=>'yii\web\JqueryAsset']);
$this->registerJsFile('@adminPlugins/export/export.js?v=1.2',['depends'=>'yii\web\JqueryAsset']);
$this->registerJsFile('@adminPlugins/export/export-function.js?v=1.3',['depends'=>'yii\web\JqueryAsset']);
?>