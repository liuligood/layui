<?php

namespace backend\controllers;

use Yii;
use common\models\Demo;
use backend\models\search\DemoSearch;
use common\base\BaseController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * DemoController implements the CRUD actions for Demo model.
 */
class DemoController extends BaseController
{
    public function model()
    {
        return new Demo();
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList(){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $searchModel=new DemoSearch();
        $where = $searchModel->search(Yii::$app->request->queryParams);
        $data = $this->lists($where);
        foreach ($data['list'] as &$info){
            $image = json_decode($info['goods_img'], true);
            $info['goods_img'] = empty($image) || !is_array($image) ? '' : current($image)['img'];
            $info['add_time'] = Yii::$app->formatter->asDatetime($info['add_time']);
            $info['update_time'] = Yii::$app->formatter->asDatetime($info['update_time']);
            $info['status'] = Demo::$status_maps[$info['status']];
        }
        return $this->FormatLayerTable(self::REQUEST_LAY_SUCCESS,"获取成功",$data['list'],$data['pages']->totalCount);
    }

    /**
     * @routeName 新增Demo
     * @routeDescription 创建新的Demo
     * @throws
     * @return string |Response |array
     */
    public function actionCreate()
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = new Demo();
            $post = $req->post();
            $model['title'] = $post['title'];
            $model['desc'] = $post['desc'];
            $model['status'] = 1;
            $model['goods_img'] = $post['goods_img'];
            if ($model->save()) {
                return $this->FormatArray(self::REQUEST_SUCCESS, "添加成功", []);
            } else {
                return $this->FormatArray(self::REQUEST_FAIL, $model->getErrorSummary(false)[0], []);
            }
        }
        return $this->render('create');
    }

    /**
     * @routeName 更新Demo
     * @routeDescription 更新Demo信息
     * @throws
     */
    public function actionUpdate()
    {
        $req = Yii::$app->request;
        $id = $req->get('id');
        if ($req->isPost) {
            $id = $req->post('id');
        }
        $model = $this->findModel($id);
        if ($req->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->load($req->post(), '') == false) {
                return $this->FormatArray(self::REQUEST_FAIL, "参数异常", []);
            }

            if ($model->save()) {
                return $this->FormatArray(self::REQUEST_SUCCESS, "更新成功", []);
            } else {
                return $this->FormatArray(self::REQUEST_FAIL, $model->getErrorSummary(false)[0], []);
            }
        } else {
            return $this->render('update', ['info' => $model->toArray()]);
        }
    }

    /**
     * @routeName 删除Demo
     * @routeDescription 删除指定Demo
     * @return array
     * @throws
     */
    public function actionDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request;
        $id = (int)$req->get('id');
        $model = $this->findModel($id);
        if ($model->delete()) {
            return $this->FormatArray(self::REQUEST_SUCCESS, "删除成功", []);
        } else {
            return $this->FormatArray(self::REQUEST_SUCCESS, "删除失败", []);
        }
    }

    /**
     * Finds the Demo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Demo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Demo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
