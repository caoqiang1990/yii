<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class SupplierTrade extends ActiveRecord
{
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';

    /**
     * 表名
     * @return [type] [description]
     */
    public static function tableName()
    {
        return '{{%supplier_trade}}';
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
     * 场景
     * @return [type] [description]
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => [
                'trade_name',
                'pid',
                'status',
                'order_no',
            ],
            self::SCENARIO_EDIT => [
                'trade_name',
                'pid',
                'status',
                'order_no',
            ],
        ];
    }

    /**
     * 规则
     * @return [type] [description]
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['trade_name'], 'safe'],
            ['order_no', 'required', 'on' => 'edit']
        ];
    }

    /**
     * 中英文对应
     * @return [type] [description]
     */
    public function attributeLabels()
    {
        return [
            'trade_name' => Yii::t('trade', 'trade_name'),
            'status' => Yii::t('trade', 'status'),
            'created_at' => Yii::t('trade', 'created_at'),
            'updated_at' => Yii::t('trade', 'updated_at'),
            'order_no' => Yii::t('trade', 'Order No'),
            'id' => Yii::t('trade', 'id'),
        ];
    }

    /**
     * 根据参数获取等级名称
     * @param  string $column [description]
     * @param  string $id [description]
     * @return [type]         [description]
     */
    public static function getTradeByParams($column = '', $id = '', $status = '有效')
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
                $result[$value['id']] = $value['trade_name'];
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
    public static function getTradeById($id = '')
    {
        if (!$id) {
            return false;
        }
        $info = self::find()->where(['id' => $id])->one();
        return $info ? $info : false;
    }

    /**
     * 获取key-value键值对
     * @return [type] [description]
     */
    public static function getTrade()
    {
        $trade = self::find()->all();
        $trade = ArrayHelper::map($trade, 'id', 'trade_name');
        return $trade;
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
     * 根据名称获取企业性质
     *
     * **/
    public static function getTradeByName($name)
    {
        if (!$name) {
            return false;
        }
        $where['trade_name'] = $name;
        $trade = self::find()->where($where)->one();
        if ($trade) {
            return $trade;
        }
        return false;
    }
}

?>