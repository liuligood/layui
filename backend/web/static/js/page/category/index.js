var form;
layui.config({
    base: '/static/plugins/layui-extend'
}).extend({
    zTree:'/zTree/ztree'
}).use(['layer','table','form','zTree'],function() {
    var layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        form = layui.form;
    var table = layui.table;

    init_tree(1);

    function init_tree(type) {
        type = type || 1;
        $.fn.zTree.init($("#tree"), {
            async: {
                enable: true,
                type: "get",
                url: "/category/get-tree-category-opt?type=" + type,
                autoParam: ["id=parent_id", "name=n", "level=lv"],
                otherParam: {"source_method": source_method}
            },
            callback: {
                onClick: function (event, treeId, treeNode) {
                    $('#add-category').attr('data-url', '/category/create?source_method=' + source_method + '&parent_id=' + treeNode.id);
                    var param = [];
                    param['CategorySearch[parent_id]'] = treeNode.id;
                    //执行重载
                    table.reload(tableName, {
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        , where: param
                    }, 'data');
                }
            }
        });
    }

    form.on("select(category_type)",function(data){
        init_tree(data.value);
    });

});

