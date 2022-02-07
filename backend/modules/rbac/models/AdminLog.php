<?php

namespace rbac\models;

use Yii;

/**
 * This is the model class for table "yp_admin_log".
 *
 * @property int $id
 * @property string $route
 * @property string $url
 * @property string|null $user_agent
 * @property string|null $gets
 * @property string $posts
 * @property int $admin_id
 * @property string|null $admin_email
 * @property string $ip
 * @property int $created_at
 * @property int $updated_at
 */
class AdminLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yp_admin_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['route', 'url', 'posts', 'admin_id', 'ip', 'created_at', 'updated_at'], 'required'],
            [['gets', 'posts'], 'string'],
            [['admin_id', 'created_at', 'updated_at'], 'integer'],
            [['route', 'url', 'user_agent', 'admin_email', 'ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'route' => 'Route',
            'url' => 'Url',
            'user_agent' => 'User Agent',
            'gets' => 'Gets',
            'posts' => 'Posts',
            'admin_id' => 'Admin ID',
            'admin_email' => 'Admin Email',
            'ip' => 'Ip',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
