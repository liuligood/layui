var form;
var tableSelect;
layui.config({
    base: '/static/plugins/layui-extend/'
}).extend({
    xmSelect:'/xmSelect/xm-select',
    tableSelect:'tableSelect/tableSelect',
    iconPicker: 'iconPicker/iconPicker',
}).use(['form','layer','tableSelect','iconPicker','xmSelect'],function(){
    form = layui.form;
    $ = layui.jquery;
    var iconPicker = layui.iconPicker,
    tableSelect = layui.tableSelect;
    var layer = parent.layer === undefined ? layui.layer : top.layer;

    if(typeof categoryArr != 'undefined') {
        /*var category = $.parseJSON(categoryArr);
        var parent_c = xmSelect.render({
            el: '#parent',
            model: {label: {type: 'text'}},
            radio: true,
            clickClose: true,
            tree: {
                show: true,
                strict: false,
                expandedKeys: true,
            },
            height: 'auto',
            data() {
                return category;
            }
        });*/
    }

    //添加菜单
    form.on("submit(createMenu)",function(data){
        var index = layer.msg('提交中，请稍候',{icon: 16,time:false,shade:0.8});
        setTimeout(function(){
            var parent_id = parent_c.getValue('value');
            $.post(categoryUpdateUrl,{
                parent_id:parent_id[0]||0,
                category_id:data.field.category_id,
                sku_no:data.field.sku_no,
                name:data.field.name,
                sort:data.field.sort,
            },function(res){
                if (res.status==1){
                    layer.msg(res.msg, {icon: 1});
                    parent.location.reload();
                }else {
                    layer.msg(res.msg, {icon: 5});
                }
            });
            layer.close(index);
        },2000);
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });

});