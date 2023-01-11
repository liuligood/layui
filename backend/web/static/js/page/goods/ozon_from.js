var form;
layui.config({
    base: '/static/plugins/layui-extend/'
}).use(['form','layer','laytpl','common'],function(){
    form = layui.form;
    $ = layui.jquery;
    var common = layui.common;
    var laytpl = layui.laytpl;

    get_attribute($('input[name="o_category_name"]').val());
    function attribute_tpl(attribute) {
        var html = $('#attribute_tpl').html();
        laytpl(html).render(attribute, function(content){
            $('#attribute').append(content).hide().slideDown();
        });
    }

    function get_attribute(category_id) {
        var goods_shop_id = $('input[name="id"]').val();
        $.get('/category/get-ozon-attribute',{
            category_id: category_id,
            type:4//,
            //goods_shop_id:goods_shop_id
        },function(data){
            if (data.status==1) {
                $('#attribute').html('');
                $.each(data.data, function () {
                    var _self = this;
                    if (sel_attribute_value != "") {
                        $.each(sel_attribute_value, function () {
                            if (_self.attribute_id == this.id) {
                                _self.sel_attribute_value = this.val;
                            }
                        });
                    }
                    attribute_tpl(_self);
                });
                common.select2();
                form.render();
            } else {
                layer.msg(data.msg, {icon: 5});
            }
        });
    }

    common.upload_img_multiple();

});