<?php

namespace backend\modules\rbac\controllers;

use yii\web\Controller;
use rbac\models\dao\AdminLog;
use Yii;

/**
 * Dept controller
 *
 * @author earnest <464605059@qq.com>
 * */
class LogsController extends Controller
{
    /**
     * 浏览器跳转'logs/index'页面
     * @return mixed
     * */
    public function actionIndex(){
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $searchModel = new AdminLog();
            $data = $searchModel->searchs('al.route,al.url,al.user_agent,al.gets,al.posts,al.admin_id,al.ip,from_unixtime(al.`created_at`,"%Y-%m-%d %H:%i:%S") created_at
            ,u.nickname',$post);
            return $data;
        }
        return $this->render('index');
    }

}