<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use mdm\admin\models\User;
use backend\models\DepartmentAssignment;
use backend\models\DepartmentAudit;

class Department extends ActiveRecord
{

    /**
     *
     * @return [type] [description]
     */
    public static function tableName()
    {
        return '{{%department}}';
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
            [['department_name'], 'safe'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'department_name' => Yii::t('department', 'department_name'),
            'status' => Yii::t('department', 'status'),
            'created_at' => Yii::t('department', 'created_at'),
            'updated_at' => Yii::t('department', 'updated_at'),
            'level' => Yii::t('department', 'level'),
            'order_no' => Yii::t('department', 'Order No'),
            'pid' => Yii::t('department', 'pid'),
            'id' => Yii::t('department', 'id'),
            'modify_department_name' => Yii::t('department', 'modify_department_name'),
        ];
    }

    /**
     * 根据参数获取企业类别名称
     * @param  string $column [description]
     * @param  string $id [description]
     * @return [type]         [description]
     */
    public static function getDepartmentByParams($column = '', $level = '')
    {
        $where = [];
        $field = '';
        if ($level !== '') {
            $where['level'] = $level;
        }
        if ($column) {
            $field = $column;
        }
        $lists = self::find()->select($field)->where($where)->asArray()->all();
        if ($lists) {
            foreach ($lists as $value) {
                $result[$value['id']] = $value['department_name'];
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
    public static function getDepartmentById($id = '')
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
    public function getDepartments()
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
                $value['department_name'] = str_repeat('|___', $lev) . $value['department_name'];
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
        $data = $this->getDepartments();
        $tree = $this->getTree($data);
        $list = ['添加顶级分类'];
        foreach ($tree as $value) {
            $list[$value['id']] = $value['department_name'];
        }
        return $list;
    }

    /**
     * 获取key-value键值对
     * @return [type] [description]
     */
    public static function getDepartment($level = 1)
    {
        $where['level'] = $level;
        $category = self::find()->where($where)->all();
        $category = ArrayHelper::map($category, 'id', 'department_name');
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
    public static function getDepartmentNameByParams($value = '')
    {
        $where['id'] = explode(',', $value);
        $lists = self::find()->select('id,department_name')->where($where)->asArray()->all();
        $category = ArrayHelper::map($lists, 'id', 'department_name');
        return $category;
    }

    /*
     *
     * 根据名称获取分类
     *
     * */
    public static function getDepartmentByName($name, $level = 1)
    {
        if (!$name) {
            return false;
        }
        $where['department_name'] = $name;
        $where['level'] = $level;
        $department = self::find()->where($where)->one();
        if ($department) {
            return $department;
        }
        return false;
    }

    /**
     * 获取所有可能
     * @return array
     */
    public function getItems()
    {
        $available = User::getUsers();
        $assigned = [];
        $lists = DepartmentAssignment::getByDepartmentId($this->id);
        foreach ($lists as $item) {
            if (!User::findIdentity($item['user_id'])) {
                continue;
            }
            $assigned[$item['user_id']] = User::findIdentity($item['user_id'])->truename;
            unset($available[$item['user_id']]);
        }
        return [
            'available' => $available,
            'assigned' => $assigned,
        ];
    }

    /**
     * Name: getItemsAudit
     * User: aimer
     * Date: 2019/10/8
     * Time: 上午8:58
     * @return array
     */
    public function getItemsAudit()
    {
        $available = User::getUsers();
        $assigned = [];
        $lists = DepartmentAudit::getByDepartmentId($this->id);
        foreach ($lists as $item) {
            if (!User::findIdentity($item['user_id'])) {
                continue;
            }
            $assigned[$item['user_id']] = User::findIdentity($item['user_id'])->truename;
            unset($available[$item['user_id']]);
        }
        return [
            'available' => $available,
            'assigned' => $assigned,
        ];
    }
}


?>