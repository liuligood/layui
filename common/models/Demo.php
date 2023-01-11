<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yp_demo".
 *
 * @property int $id
 * @property string $title 标题
 * @property string $desc 备注
 * @property int $status 状态
 * @property int $add_time 添加时间
 * @property int $update_time 修改时间
 */
class Demo extends BaseAR
{
    const STATUS_OPEN = 1;
    const STATUS_CLOSE = 2;
    
    public static $status_maps = [
        self::STATUS_OPEN => '正常',
        self::STATUS_CLOSE => '关闭',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yp_demo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'add_time', 'update_time'], 'integer'],
            [['title', 'desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'desc' => 'Desc',
            'status' => 'Status',
            'add_time' => 'Add Time',
            'update_time' => 'Update Time',
        ];
    }
}
