<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;


class SupplierType extends ActiveRecord
{

    /**
     *
     * @return [type] [description]
     */
    public static function tableName()
    {
        return '{{%supplier_type}}';
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
            [['id', 'created_at', 'updated_at', 'order_no', 'status'], 'integer'],
            [['type_name'], 'safe'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'type_name' => Yii::t('type', 'type_name'),
            'status' => Yii::t('type', 'status'),
            'created_at' => Yii::t('type', 'created_at'),
            'updated_at' => Yii::t('type', 'updated_at'),
            'order_no' => Yii::t('type', 'order_no'),
        ];
    }

    /**
     * 根据参数获取企业类别名称firm_nature
     * @param  string $column [description]
     * @param  string $id [description]
     * @return [type]         [description]
     */
    public static function getTypeByParams($column = '', $id = '')
    {
        $where = [];
        $field = '';
        if ($id) {
            $where['id'] = $id;
        }
        if ($column) {
            $field = $column;
        }
        $lists = self::find()->select($field)->where($where)->asArray()->all();
        if ($lists) {
            foreach ($lists as $value) {
                $result[$value['id']] = $value['type_name'];
            }
        } else {
            return false;
        }
        return $result;
    }


    /**
     * 根据id获取企业类别名称
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public static function getTypeById($id = '')
    {
        if (!$id) {
            return false;
        }
        $info = self::find()->where(['id' => $id])->one();
        return $info ? $info : false;
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
     * 根据名称获取业务类型
     *
     * */
    public static function getTypeByName($name)
    {
        if (!$name) {
            return false;
        }
        $where['type_name'] = $name;
        $type = self::find()->where($where)->one();
        if ($type) {
            return $type;
        }
        return false;
    }
}


?>