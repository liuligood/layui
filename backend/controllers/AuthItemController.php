<?php

namespace backend\controllers;

use Yii;
use common\models\AuthItem;
use backend\models\search\AuthItemSearch;
use common\base\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class AuthItemController extends BaseController
{
    public function model()
    {
        return new AuthItem();
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList(){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $searchModel=new AuthItemSearch();
        $where = $searchModel->search(Yii::$app->request->queryParams);
        $data = $this->lists($where,'update_time desc',null,20);
        foreach ($data['list'] as &$info){
            $info['add_time'] = Yii::$app->formatter->asDatetime($info['add_time']);
            $info['update_time'] = Yii::$app->formatter->asDatetime($info['update_time']);
            $info['type'] = AuthItem::$type_maps[$info['type']];    
        }
        return $this->FormatLayerTable(self::REQUEST_LAY_SUCCESS,"获取成功",$data['list'],$data['pages']->totalCount);
    }

    /**
     * @routeName 新增路由
     * @routeDescription 创建新增路由
     * @throws
     * @return string |Response |array
     */
    public function actionCreate()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = new AuthItem();
            $post = $req->post();
            $model['name'] = $post['name'];
            $model['description'] = $post['description'];
            $model['type'] = 2;
            if ($model->save()) {
                return $this->FormatArray(self::REQUEST_SUCCESS, "添加路由成功", []);
            } else {
                return $this->FormatArray(self::REQUEST_FAIL, $model->getErrorSummary(false)[0], []);
            }
        }
        return $this->render('create');
    }


    /**
     * @routeName 删除路由
     * @routeDescription 删除路由
     * @throws
     * @return string |Response |array
     */
    public function actionDelete(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request;
        $name = $req->get('name');
        $model = AuthItem::find()->where(['name'=>$name])->one();
        if ($model->delete()) {
            return $this->FormatArray(self::REQUEST_SUCCESS, "删除成功", []);
        } else {
            return $this->FormatArray(self::REQUEST_FAIL,'删除失败', []);
        }
    }


    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
