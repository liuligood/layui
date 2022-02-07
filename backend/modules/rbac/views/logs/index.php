<?php
$this->registerJs($this->render('js/index.js'));
?>
<body class="pear-container">
<div class="layui-card">
    <div class="layui-card-body">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <div class="layui-form-item layui-inline">
                    <label class="layui-form-label">请求路由</label>
                    <div class="layui-input-inline">
                        <input type="text" name="route" placeholder="" required class="layui-input" >
                    </div>
                </div>
                <div class="layui-form-item layui-inline">
                    <label class="layui-form-label">操作人员</label>
                    <div class="layui-input-inline">
                        <input type="text" name="nickname" placeholder="" required class="layui-input" >
                    </div>
                </div>
                <div class="layui-form-item layui-inline">
                    <label class="layui-form-label">行为日期</label>
                    <div class="layui-input-inline">
                        <input type="text" class="layui-input" id="created_at" name="created_at">
                    </div>
                </div>

                <div class="layui-form-item layui-inline">
                    <button class="pear-btn pear-btn-md pear-btn-primary" lay-submit="search" lay-filter="search" >
                        <i class="layui-icon layui-icon-search"></i>
                        查询
                    </button>
                    <button type="reset" class="pear-btn pear-btn-md">
                        <i class="layui-icon layui-icon-refresh"></i>
                        重置
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="layui-card">
    <div class="layui-card-body">
        <table class="layui-table" lay-filter="main-table" id ='main-table' >
            <script type="text/html" id="power-bar">
                <button class="pear-btn pear-btn-primary pear-btn-sm" lay-event="edit"><i class="layui-icon layui-icon-edit"></i></button>
                <button class="pear-btn pear-btn-danger pear-btn-sm" lay-event="remove"><i class="layui-icon layui-icon-delete"></i></button>
            </script>

            <script type="text/html" id="icon">
                <i class="layui-icon {{d.icon}}"></i>
            </script>
        </table>
    </div>
</div>
</body>




