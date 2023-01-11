var form;
layui.config({
    base: '/static/plugins/layui-extend/'
}).extend({
    tinymce: 'tinymce/tinymce',
    common:'common'
}).use(['form','layer','laytpl','tinymce','common'],function(){
    form = layui.form;

    $ = layui.jquery;

    var tinymce = layui.tinymce;
    var common = layui.common;


    /*tinymce.render({
        elem: "#goods_content"
        , height: 300
    });*/

    $('#goods_name').bind('input propertychange',function(){
        $('#title-count').html($('#goods_name').val().length);
    });

    $('#title-count').html($('#goods_name').val().length);

    $('#goods_short_name').bind('input propertychange',function(){
        $('#short-title-count').html($('#goods_short_name').val().length);
    });

    $('#short-title-count').html($('#goods_short_name').val().length);

    form.on("submit(form)",function(data){
        var index = layer.msg('提交中，请稍候',{icon: 16,time:false,shade:0.8});
        var form_name = $(this).data('form');
        var form = $('#' + form_name);
        //tinyMCE.triggerSave(true,true);
        setTimeout(function(){
            $.post(form.attr('action'),form.serializeArray(),function(res){
                if (res.status==1){
                    layer.msg(res.msg, {icon: 1});

                    setTimeout(function() {
                        if(window.parent.layui.getTableName()) {
                            window.parent.layui.tableReload();//刷新父列表
                        } else {
                            window.parent.location.reload();//刷新父页面
                        }
                        var parent_index = parent.layer.getFrameIndex(window.name);//获取窗口索引
                        parent.layer.close(parent_index);
                        //location.reload();
                    },2000);
                }else {
                    layer.msg(res.msg, {icon: 5});
                }
            });
            layer.close(index);

        },2000);
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });

    common.upload_img_multiple();

});