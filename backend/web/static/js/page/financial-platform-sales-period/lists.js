var form;
layui.use(['form','layer','laytpl'],function(){
    form = layui.form;

    $ = layui.jquery;
    var layer = parent.layer === undefined ? layui.layer : top.layer;

    var laytpl = layui.laytpl;

    $('#platform').change(function (){
       var platform = $('#platform').val();
        $('#shop').find("option").remove();
       if (platform != ''){
           getOption(platform_type[platform]);
       }else {
           getOption(empty_type);
       }
    });

    function getOption(object){
        var shop = object;
        for (var i in shop){
            var option = "<option value=" + i + ">"+ shop[i] + "</option>"
            $('#shop').append(option);
            $('#shop').val('');
        }
    }

    //获取店铺名称id，修改添加的url
    $('#shop').change(function (){
       var shop_id = $('#shop').val();
       var oldUrl = $('#oldUrl').val();
       var newUrl = $('#createSale');
       var url = oldUrl + shop_id;
       newUrl.data('url',url);
    });

});