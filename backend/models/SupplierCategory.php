<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;


class SupplierCategory extends ActiveRecord
{

    /**
     *
     * @return [type] [description]
     */
    public static function tableName()
    {
        return '{{%supplier_category}}';
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
            [['id', 'created_at', 'updated_at', 'order_no', 'level', 'pid', 'status'], 'integer'],
            [['category_name'], 'safe'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'category_name' => Yii::t('category', 'category_name'),
            'status' => Yii::t('category', 'status'),
            'created_at' => Yii::t('category', 'created_at'),
            'updated_at' => Yii::t('category', 'updated_at'),
            'level' => Yii::t('category', 'level'),
            'order_no' => Yii::t('category', 'Order No'),
            'pid' => Yii::t('category', 'pid'),
            'id' => Yii::t('category', 'id'),
        ];
    }

    /**
     * 根据参数获取企业类别名称
     * @param  string $column [description]
     * @param  string $id [description]
     * @return [type]         [description]
     */
    public static function getCategoryByParams($column = '', $level = '', $pid = '')
    {
        $where = [];
        $field = '';
        if ($level !== '') {
            $where['level'] = $level;
        }
        if ($pid !== '') {
            $where['pid'] = $pid;
        }
        if ($column) {
            $field = $column;
        }
        $lists = self::find()->select($field)->where($where)->asArray()->all();
        if ($lists) {
            foreach ($lists as $value) {
                $result[$value['id']] = $value['category_name'];
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
    public static function getCategoryById($id = '')
    {
        if (!$id) {
            return false;
        }
        $info = self::find()->where(['id' => $id])->one();
        return $info ? $info : false;
    }

    /**
     * 获取所有的分类
     */
    public function getCategories()
    {
        $data = self::find()->all();
        $data = ArrayHelper::toArray($data);
        return $data;
    }

    /**
     *遍历出各个子类 获得树状结构的数组
     */
    public static function getTree($data, $pid = 0, $lev = 1)
    {
        $tree = [];
        foreach ($data as $value) {
            if ($value['pid'] == $pid) {
                $value['category_name'] = str_repeat('|___', $lev) . $value['category_name'];
                $tree[] = $value;
                $tree = array_merge($tree, self::getTree($data, $value['id'], $lev + 1));
            }
        }
        return $tree;
    }

    /**
     * 得到相应  id  对应的  分类名  数组
     */
    public function getOptions()
    {
        $data = $this->getCategories();
        $tree = $this->getTree($data);
        $list = ['添加顶级分类'];
        foreach ($tree as $value) {
            $list[$value['id']] = $value['category_name'];
        }
        return $list;
    }

    /**
     * 获取key-value键值对
     * @return [type] [description]
     */
    public static function getCategory()
    {
        $category = self::find()->all();
        $category = ArrayHelper::map($category, 'id', 'category_name');
        return $category;
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

    /**
     * 根据条件获取键值对
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public static function getCategoryNameByParams($value = '')
    {
        $where['id'] = explode(',', $value);
        $lists = self::find()->select('id,category_name')->where($where)->asArray()->all();
        $category = ArrayHelper::map($lists, 'id', 'category_name');
        return $category;
    }

    /*
     *
     * 根据名称获取分类
     *
     * */
    public static function getCategoryByName($name, $level = 1)
    {
        if (!$name) {
            return false;
        }
        $where['category_name'] = $name;
        $where['level'] = $level;
        $category = self::find()->where($where)->one();
        if ($category) {
            return $category;
        }
        return false;
    }

    /**
     * 获取key-value键值对
     * @return [type] [description]
     */
    public static function getCategorys($pid = 0)
    {
        $where['pid'] = $pid;
        $category = self::find()->where($where)->all();
        $category = ArrayHelper::map($category, 'id', 'category_name');
        return $category;
    }
}


?>