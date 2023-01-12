<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AuthItem;

/**
 * AuthItemSearch represents the model behind the search form of `common\models\AuthItem`.
 */
class AuthItemSearch extends AuthItem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'rule_name', 'data'], 'safe'],
            [['type', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function search($params)
    {
        $where = [];

        $this->load($params);

        if(!empty($this->name)){
            $where['and'][] = ['like','name',$this->name];
        }
        
        if(!empty($this->type)){
            $where['type'] = $this->type;
        }

        return $where;
    }
}
