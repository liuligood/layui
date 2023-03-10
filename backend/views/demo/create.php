<?php
/**
 * @var $this \yii\web\View;
 */
use yii\helpers\Url;
?>
<style>
    html {
        background: #fff;
    }
</style>
<form class="layui-form layui-row" id="update_goods" action="<?=Url::to(['demo/create'])?>">

    <div class="layui-col-md6 layui-col-xs12" style="padding-top: 15px">

        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" lay-verify="required" placeholder="请输入标题" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">备注</label>
            <div class="layui-input-block">
                <input type="text" name="desc" lay-verify="required" placeholder="请输入备注" class="layui-input ">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline layui-col-md12">
                <label class="layui-form-label">其他文件</label>
                <div class="layui-input-block" style="border:1px solid #eee;">
                    <div id="word_div" style="padding: 0 5px">
                    </div>
                    <input type="text" style="width: 647px;border:0px" id="word" placeholder="上传不是图片的文件" value="" class="layui-input" autocomplete="off" disabled>
                </div>
                <div class="layui-input-block">
                    <a class="layui-btn layui-btn-warm ys-upload-down" lay-data="{url: '/app/upload-file',accept: 'file'}" style="margin-top: 10px;">上传文件</a>
                </div>
            </div>
        </div>


        <div class="layui-form-item">
        <label class="layui-form-label">图片</label>
                    <div class="layui-inline">
                        <div class="layui-inline" style="width: 250px">
                            <input type="text" name="img" id="img_url" placeholder="图片链接"  value="" class="layui-input" autocomplete="off">
                        </div>
                        <div class="layui-inline" style="width: 80px">
                            <button type="button" class="layui-btn layui-btn-normal" id="js_add_img_url">添加</button>
                        </div>
                        <div class="layui-upload ys-upload-img-multiple" data-number="10">
                            <button type="button" class="layui-btn">上传图片</button>
                            <input type="hidden" name="goods_img"  class="layui-input" >
                            <ol class="layui-upload-con">
                            </ol>
                        </div>
                    </div>
                </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="form" data-form="update_goods">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </div>
</form>
<script id="white_img_tmp" type="text/html">
    <div style="padding: 10px;margin-left: 35px;float: left">
        <div>原图</div>
        <img id="old_white_img" src="{{ d.img || '' }}" width="300px" style="border:4px solid #cccccc">
    </div>
    <div style="padding: 10px;margin-left: 70px;float: left">
        <div>效果图</div>
        <img id="new_white_img" src="{{ d.new_img || '' }}" width="300px" style="border:4px solid #cccccc">
    </div>
</script>
<script id="property_tpl" type="text/html">
    <tr id="protr_{{ d.property.val_id || '' }}">
        <td>{{ d.property.sku_no || '' }}</td>
        <td width="200">
            <div class="layui-inline" style="padding-bottom: 10px">
                <div class="layui-inline" style="width: 150px">
                    <input type="text" name="img" placeholder="图片链接"  value="" class="layui-input img-url-inp" autocomplete="off">
                </div>
                <div class="layui-inline" style="width: 40px">
                    <a class="add-url-img">
                        <i class="layui-icon layui-icon-add-circle" title="添加图片链接" style="font-size: 25px;color:#1E9FFF;font-weight: 200;"></i>
                    </a>
                </div>
            </div>
            <div class="layui-upload ys-upload-img" >
                <button type="button" class="layui-btn layui-btn-xs" style="float: left">上传图片</button>
                <div class="layui-upload-list" style="float: left;margin: 0 10px">
                    <img class="layui-upload-img" style="max-width: 100px" src="{{ d.property.goods_img || '' }}">
                </div>
                <div class="img-tool">
                    <span class="layui-layer-setwin white_img_single" style="top: 135px;left: 35px;"><a style="font-size: 18px;color:#1E9FFF" class="layui-icon layui-icon-layer" href="javascript:;" title="图片白底"></a></span>
                </div>
                <input type="hidden" name="property[goods_img][]" class="layui-input" value="{{ d.property.goods_img || '' }}">
            </div>
        </td>
        <td class="prop-colour">
            <label class="l-prop-colour">{{ d.property.colour || '' }} {{# if(d.property.colour_name != ''){ }} ( {{ d.property.colour_name || ''}} ) {{# } }}</label>
            <input type="hidden" name="property[colour][]" value="{{ d.property.colour || '' }}">
        </td>
        <td class="prop-size">
            <label class="l-prop-size">{{ d.property.size || '' }}</label>
            <input type="hidden" name="property[size][]" value="{{ d.property.size || '' }}">
        </td>
        <td>
            <div class="layui-inline">
                <input type="hidden" name="property[id][]" value="{{ d.property.id || '' }}" class="layui-input">
                <a class="layui-btn layui-btn-danger layui-btn-xs del-property" href="javascript:;">删除</a>

                <a class="batch_set_pro_child" style="margin-left: 5px"><i class="layui-icon layui-icon-set"></i></a>
            </div>
        </td>
    </tr>
</script>
<script id="img_tpl" type="text/html">
    <li class="layui-fluid lay-image">
        <div class="layui-upload-list">
            <a href="{{ d.img || '' }}" data-lightbox="pic">
                <img class="layui-upload-img" style="max-width: 200px;height: 100px"  src="{{ d.img || '' }}">
            </a>
        </div>
        <div class="del-img">
            <span class="layui-layer-setwin"><a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a></span>
        </div>
        <div class="img-tool">
            <span class="layui-layer-setwin translate_img" style="top: 135px;left: 10px;"><a style="font-size: 18px;color:#1E9FFF" class="layui-icon layui-icon-fonts-clear" href="javascript:;" title="翻译成英文"></a></span>

            <span class="layui-layer-setwin white_img" style="top: 135px;left: 35px;"><a style="font-size: 18px;color:#1E9FFF" class="layui-icon layui-icon-layer" href="javascript:;" title="图片白底"></a></span>
        </div>
    </li>
</script>
<script id="tag_tpl" type="text/html">
    <span class="label layui-bg-blue" style="border-radius: 15px;margin: 5px 5px 0 0; padding: 3px 7px 3px 15px; font-size: 14px; display: inline-block;">
        <a href="/images/files/{{d.name}}" target="_blank" style="color: red;">{{d.tag_name}}</a>
        <a href="javascript:;"><i class="layui-icon layui-icon-close del_tag" style="color: #FFFFFF;margin-left: 5px"></i></a>
        <input class="word_ipt" type="hidden" name="word[]" value="{{d.tag_name}}" >
    </span>
</script>
<script>
    var files = '1';
    var files_name = '1';
</script>
<?=$this->registerJsFile("@adminPageJs/base/form.js?".time());?>
<?=$this->registerJsFile("@adminPageJs/goods-selection/form.js?".time());?>
<?=$this->registerJsFile("@adminPageJs/forbidden-word/form.js?".time());?>
<?=$this->registerJsFile("@adminPageJs/base/lists.js?v=0.0.4.6");?>
<?php
$this->registerCssFile("@adminPlugins/lightbox2/css/lightbox.min.css", ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile("@adminPlugins/lightbox2/js/lightbox.min.js", ['depends' => 'yii\web\JqueryAsset']);
?>