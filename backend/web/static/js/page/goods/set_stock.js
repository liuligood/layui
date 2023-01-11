var form;
layui.config({
    base: '/static/plugins/layui-extend/'
}).extend({
    common:'common'
}).use(['form','layer','table','upload', 'laydate','laytpl','common'],function(){
    form = layui.form;
    $ = layui.jquery;
    var layer = parent.layer === undefined ? layui.layer : top.layer;
    var common = layui.common;


    $('.layui-tab-brief .layui-tab-title li').click(function () {
        $('.layui-tag-con').hide().eq($(this).index()).show();
    });
});