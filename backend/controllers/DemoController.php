<?php

namespace backend\controllers;

use Yii;
use common\models\Demo;
use backend\models\search\DemoSearch;
use moonland\phpexcel\Excel;
use common\base\BaseController;
use common\services\ImportResultService;
use common\services\sys\ExportService;
use XLSXWriter;
use XMLWriter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

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
            $model['files'] = '';
            $model['files_size'] = '';
            if(isset($post['word'])){
                $files = [];
                $file_name = [];
                foreach($post['word'] as $v){
                    $files[] = ['file' => $v];
                    $name = explode(' ',$v);
                    $file_name[] = ['file' => $name[0]];
                }
                $files = json_encode($files,JSON_UNESCAPED_UNICODE);
                $file_name = json_encode($file_name,JSON_UNESCAPED_UNICODE);
                $model['files'] = $file_name;
                $model['files_size'] = $files;
            }
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
        $files = [];
        if(!empty($model['files_size'])){
            foreach(json_decode($model['files_size']) as $v){
                $files[] = $v->file;
            }
            $files = json_encode($files,JSON_UNESCAPED_UNICODE);
        }
        if ($req->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = $req->post();
            $model['files'] = '';
            $model['files_size'] = '';
            if(isset($post['word'])){
                $files = [];
                $file_name = [];
                foreach($post['word'] as $v){
                    $files[] = ['file' => $v];
                    $name = explode(' ',$v);
                    $file_name[] = ['file' => $name[0]];
                }
                $files = json_encode($files,JSON_UNESCAPED_UNICODE);
                $file_name = json_encode($file_name,JSON_UNESCAPED_UNICODE);
                $model['files'] = $file_name;
                $model['files_size'] = $files;
            }
            $model['title'] = $post['title'];
            $model['desc'] = $post['desc'];
            $model['status'] = $post['status'];
            $model['goods_img'] = $post['goods_img'];
            if ($model->save()) {
                return $this->FormatArray(self::REQUEST_SUCCESS, "更新成功", []);
            } else {
                return $this->FormatArray(self::REQUEST_FAIL, $model->getErrorSummary(false)[0], []);
            }
        } else {
            return $this->render('update', ['info' => $model->toArray(),'files'=>$files]);
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

    public function actionExports(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $searchModel=new DemoSearch();
        $where = $searchModel->search(Yii::$app->request->queryParams);
        $export_ser = new ExportService();
        $sort = 'add_time desc';
        $list = Demo::getAllByCond($where,$sort);

        $data = [];
        foreach ($list as $k => $v) {
            $url = json_decode($v['goods_img']);
            $img = $url[0]->img;
            $data[$k]['title'] = $v['title'];
            $data[$k]['desc'] = $v['desc'];
            $data[$k]['goods_img'] = "http://www.layui.com".$img;
        }
        $column = [
            'title' => '标题',
            'desc' => '备注',
            'goods_img' => '图片链接',
        ];

        $result = $export_ser->forData($column,$data,'导出Demo' . date('ymdhis'));
        return $this->FormatArray(self::REQUEST_SUCCESS, "", $result);
    }


    /**
     * @routeName 导入回款
     * @routeDescription 导入回款
     * @return array
     * @throws
     */
    public function actionImport()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $file = UploadedFile::getInstanceByName('file');
        if (!in_array($file->extension, ['xlsx', 'xls'])) {
            return $this->FormatArray(self::REQUEST_FAIL, "只允许使用以下文件扩展名的文件：xlsx, xls。", []);
        }

        // 读取excel文件
        $data = Excel::import($file->tempName, [
            'setFirstRecordAsKeys' => false,
        ]);

        // 多Sheet
        if (isset($data[0])) {
            $data = $data[0];
        }

        $rowKeyTitles = [
            'title' => '标题',
            'desc' => '备注',
            'goods_img' => '图片',
        ];
        $rowTitles = $data[1];
        $keyMap = [];
        foreach ($rowKeyTitles as $k => $v) {
            $excelKey = array_search($v, $rowTitles);
            $keyMap[$k] = $excelKey;
        }

        if(empty($keyMap['title']) || empty($keyMap['desc'])) {
            return $this->FormatArray(self::REQUEST_FAIL, "excel表格式错误", []);
        }


        $count = count($data);
        $success = 0;
        $errors = [];
        for ($i = 2; $i <= $count; $i++) {
            $row = $data[$i];
            foreach ($row as &$rowValue) {
                $rowValue = !empty($rowValue) ? str_replace(' ', ' ', $rowValue) : '';
                $rowValue = !empty($rowValue) ? trim($rowValue) : '';
            }

            foreach (array_keys($rowKeyTitles) as $rowMapKey) {
                $rowKey = isset($keyMap[$rowMapKey]) ? $keyMap[$rowMapKey] : '';
                $$rowMapKey = isset($row[$rowKey]) ? trim($row[$rowKey]) : '';
            }

            if ((empty($title) || empty($desc))) {
                $errors[$i] = '标题备注不能为空';
                continue;
            }

            try {
                var_dump($goods_img);exit();
                $model = new Demo();
                $model['status'] = 1;
                $model['title'] = $title;
                $model['desc'] = $desc;
                $model->save();
            }catch (\Exception $e) {
                $errors[$i] = $e->getMessage();
                continue;
            }
            $success++;
        }
        if(!empty($errors)) {
            $lists = [];
            foreach ($errors as $i => $error) {
                $row = $data[$i];
                $info = [];
                $info['index'] = $i;
                $info['rvalue1'] = empty($row[$keyMap['title']])?'':$row[$keyMap['title']];
                $info['rvalue2'] = empty($row[$keyMap['desc']])?'':$row[$keyMap['desc']];
                $info['reason'] = $error;
                $lists[] = $info;
            }
            $key = (new ImportResultService())->gen('Demo', $lists);
            return $this->FormatArray(self::REQUEST_FAIL, "导入失败问题", [
                'key' => $key
            ]);
        }
        return $this->FormatArray(self::REQUEST_SUCCESS, "导入成功", []);
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
