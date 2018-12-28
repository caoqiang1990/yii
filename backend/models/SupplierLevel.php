<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class SupplierLevel extends ActiveRecord
{
    /**
     * 表名
     * @return [type] [description]
     */
    public static function tableName()
    {
        return '{{%supplier_level}}';
    }

    /**
     * 行为
     * @return [type] [description]
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * 规则
     * @return [type] [description]
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'status', 'order_no'], 'integer'],
            [['level_name'], 'safe'],
        ];
    }

    /**
     * 中英文对应
     * @return [type] [description]
     */
    public function attributeLabels()
    {
        return [
            'level_name' => Yii::t('level', 'level_name'),
            'status' => Yii::t('level', 'status'),
            'created_at' => Yii::t('level', 'created_at'),
            'updated_at' => Yii::t('level', 'updated_at'),
            'order_no' => Yii::t('level', 'order_no'),
            'id' => Yii::t('trade','id'),
        ];
    }

    /**
     * 根据参数获取等级名称
     * @param  string $column [description]
     * @param  string $id [description]
     * @return [type]         [description]
     */
    public static function getLevelByParams($column = '', $id = '', $status = '有效')
    {
        $where = [];
        $field = '';
        if ($id) {
            $where['id'] = $id;
        }
        if ($column) {
            $field = $column;
        }
        if ($status == '有效') {
            $where['status'] = 1;
        } else {
            $where['status'] = 0;
        }
        $lists = self::find()->select($field)->where($where)->orderBy('order_no')->asArray()->all();
        if ($lists) {
            foreach ($lists as $value) {
                $result[$value['id']] = $value['level_name'];
            }
        } else {
            return false;
        }
        return $result;
    }

    /**
     * 根据id获取企业等级名称
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public static function getLevelById($id = '')
    {
        if (!$id) {
            return false;
        }
        $info = self::find()->where(['id' => $id])->orderBy('order_no asc')->one();
        return $info ? $info : false;
    }

    /**
     * 获取key-value键值对
     * @return [type] [description]
     */
    public static function getLevel()
    {
        $level = self::find()->all();
        $level = ArrayHelper::map($level, 'id', 'level_name');
        return $level;
    }

    /**
     * 根据id获取信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getByID($id)
    {
        if (($model = self::findOne($id)) !== null) {
            return json_encode($model->toArray());
        } else {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     *
     * 根据名称获取企业等级
     *
     * **/
    public static function getLevelByName($name)
    {
        if (!$name) {
            return false;
        }
        $where['level_name'] = $name;
        $info = self::find()->where($where)->one();
        if ($info) {
            return $info;
        }
        return false;
    }

}

?>