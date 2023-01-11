<?php

namespace backend\models\search;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Demo;

/**
 * DemoSearch represents the model behind the search form of `common\models\Demo`.
 */
class DemoSearch extends Demo
{

    public function rules()
    {
        return [
            [['id', 'status', 'add_time', 'update_time'], 'integer'],
            [['title', 'desc'], 'safe'],
        ];
    }


    public function search($params)
    {
        $where = [];

        $this->load($params);

        if(!empty($this->id)){
            $where['id'] = $this->id;
        }

        if(!empty($this->title)){
            $where['and'][] = ['like','title',$this->title];
        }

        return $where;
    }
}
