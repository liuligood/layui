var form;
layui.config({
    base: '/static/plugins/layui-extend/'
}).use(['form','layer','laytpl','common'],function(){
    form = layui.form;
    $ = layui.jquery;
    var common = layui.common;

    $('#discount').change(function (){
        update_price();
    });
    $('#fixed_price').change(function (){
        update_price();
    });
    $('#selling_price').change(function (){
       real_conversion();
    });
    function update_price() {
        var discount = $('#discount').val();
        var fixed_price = $('#fixed_price').val();
        var original_price = $('#original_price').val();
        var price = original_price * discount / 10;
        if (fixed_price > 0) {
            price = fixed_price;
        }
        $('#price').html(price);
    }
    function real_conversion(){
        var sell = $('#selling_price').val();
        var prices = sell*conversion;
        prices = prices.toFixed(2)
        $('#RealConversion').html(prices);
    }
});