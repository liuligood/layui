<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yp_auth_item".
 *
 * @property string $name 角色或权限名称
 * @property int $type 1:角色 2.权限
 * @property string|null $description
 * @property string|null $rule_name 规则名称
 * @property resource|null $data 规则数据
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 */
class AuthItem extends BaseAR
{
    const TYPE_OPEN = 2;
    const TYPE_CLOSE = 1;
    
    public static $type_maps = [
        self::TYPE_OPEN => '正常',
        self::TYPE_CLOSE => '禁用',
    ];


    public static function tableName()
    {
        return 'yp_auth_item';
    }


    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at','add_time','update_time'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['name'], 'unique'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
