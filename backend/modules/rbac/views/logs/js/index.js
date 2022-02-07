layui.use(['table','layer','form','jquery','ajax','laydate'], function(){
    var layer = layui.layer
        ,table  = layui.table
        ,ajax = layui.ajax
        ,laydate = layui.laydate
        ,form = layui.form;

    table.render({
        skin:'line',
        method: 'post',
        limit: 20,
        id:'main-table',
        headers:{ "X-CSRF-Token":"<?= Yii::$app->request->csrfToken?>"},
        elem: '#main-table',
        url: "/rbac/logs/index",
        page: true,
        cols: [
            [
                {type: 'checkbox'},
                {field: 'route', minWidth: 200, title: '请求路由'},
                {field: 'url', minWidth: 200, title: '绝对路径'},
                {field: 'user_agent', minWidth: 200, title: '用户代理'},
                {field: 'gets', minWidth: 200, title: 'gets'},
                {field: 'posts', minWidth: 200, title: 'posts'},
                {field: 'nickname', minWidth: 200, title: '操作人员'},
                {field: 'ip', minWidth: 200, title: 'IP'},
                {field: 'created_at', minWidth: 200, title: '行为时间'},
            ]
        ],
        done: function (res, curr, count) {
        }
    });

    window.reload = function(data = ''){
        table.reload('main-table', {
            url:"/rbac/logs/index",
            method: 'post',
            limit:'20',
            page: true,
            where:data
        });
    }

    laydate.render({
        elem: '#created_at', //指定元素
    });

    form.on('submit(search)', function(data){
        if(!(data.field.name == '' && data.field.route == '')){
            window.reload(data.field);
        }else{
            location.reload();
        }
        return false;
    });
});