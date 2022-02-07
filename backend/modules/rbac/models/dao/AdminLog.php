<?php

namespace rbac\models\dao;

use common\models\Admin;
use common\models\Customer;
use rbac\models\AdminLog as AdminLogModel;
use Yii;
use yii\db\Expression;
use yii\db\Query;
use rbac\models\User;

class AdminLog extends AdminLogModel
{
    function searchs($column ,$condition = []){
        $query = (new Query())
            ->select(new Expression($column))
            ->from(AdminLogModel::tableName().' al')
            ->leftJoin(User::tableName().' u','u.id = al.admin_id')
            ->where("1=1");
        $query->andFilterWhere(['like','al.route',empty($condition['route'])?'':$condition['route']]);
        $query->andFilterWhere(['like','u.nickname',empty($condition['nickname'])?'':$condition['nickname']]);

        if(!empty($condition['created_at'])){
            $condition['created_at'] = strtotime($condition['created_at']);
            $begin = date('Ymd',$condition['created_at']);
            $begin = strtotime($begin);
            $end = strtotime('+1 days',$begin);

            $query->andFilterWhere(['>','al.created_at',$begin]);
            $query->andFilterWhere(['<','al.created_at',$end]);
        }
        
        $count = $query->count();
        if(!empty($condition['page'])&&!empty($condition['limit'])){
            $query->offset(($condition['page']-1)*$condition['limit'])
                ->limit($condition['limit']);
        }

        $logs = $query
            ->orderBy(['al.id'=>SORT_DESC])
            ->all();

        return json_encode(['code'=>0,'count'=>$count,'data'=>$logs]);

    }
}