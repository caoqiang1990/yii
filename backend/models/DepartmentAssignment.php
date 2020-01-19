<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 *
 * 比稿记录
 *
 */
class DepartmentAssignment extends ActiveRecord
{
    /**
     * 返回表名
     * @return [type] [description]
     */
    public static function tableName()
    {
        return '{{%department_assignment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_id', 'user_id'], 'safe']
        ];
    }

    /**
     * 对应中文
     * @return [type] [description]
     */
    public function attributeLabels()
    {
        return [
        ];
    }

    /**
     * 行为
     * @return [type] [description]
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }


    public static function getByDepartmentId($department_id = '')
    {
        if (!$department_id) {
            return false;
        }
        $where['department_id'] = $department_id;
        $users = self::find()->where($where)->asArray()->all();
        return $users;
    }

    public static function getByParams($department_id = '', $user_id = '')
    {
        if (!$department_id) {
            return false;
        }
        if (!$user_id) {
            return false;
        }
        $where['department_id'] = $department_id;
        $where['user_id'] = $user_id;
        $model = self::find()->where($where)->one();
        if ($model) {
            return $model;
        } else {
            return false;
        }
    }

    /**
     * Grands a roles from a user.
     * @param array $items
     * @return integer number of successful grand
     */
    public function assign($user_ids, $department_id)
    {
        if (empty($user_ids)) {
            return false;
        }
        if (!$department_id) {
            return false;
        }
        $success = 0;
        foreach ($user_ids as $uid) {
            $model = self::getByParams($department_id, $uid);
            if (!$model) {
                $model = new self;
                $model->department_id = $department_id;
                $model->user_id = $uid;
                $model->save();
            }
        }
        return $success;
    }

    /**
     * Revokes a roles from a user.
     * @param array $items
     * @return integer number of successful revoke
     */
    public function revoke($user_ids, $department_id)
    {
        if (empty($user_ids)) {
            return false;
        }
        if (!$department_id) {
            return false;
        }
        $success = 0;
        foreach ($user_ids as $uid) {
            $model = self::getByParams($department_id, $uid);
            $model->delete();
            $success++;
        }
        return $success;
    }

    public static function getByUserId($user_id = '')
    {
        if (!$user_id) {
            return false;
        }
        $where['user_id'] = $user_id;
        $department_ids = self::find()->select('department_id')->where($where)->asArray()->all();
        if ($department_ids) {
            return array_column($department_ids, 'department_id');
        }
        return false;
    }
}
