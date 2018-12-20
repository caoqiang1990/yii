<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\History;

/**
 * User represents the model behind the search form about `mdm\admin\models\User`.
 */
class SupplierDetail extends ActiveRecord
{
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';
    public $coop_fund1;
    public $coop_fund2;
    public $coop_fund3;

    public $trade_fund1;
    public $trade_fund2;
    public $trade_fund3;

    public $fund_year1;
    public $fund_year2;
    public $fund_year3;

    /**
     * 返回表名
     * @return [type] [description]
     */
    public static function tableName()
    {
        return '{{%supplier_detail}}';
    }

    /**
     * 对应字段的中文翻译
     * @return [type] [description]
     */
    public function attributeLabels()
    {
      return [
        'id' => Yii::t('detail','id'),
        'one_level_department' => Yii::t('detail','one_level_department'),
        'second_level_department' => Yii::t('detail','second_level_department'),
        'name' => Yii::t('detail', 'name'),
        'mobile' => Yii::t('detail','mobile'),
        'reason' => Yii::t('detail','reason'),
        'created_at' => Yii::t('detail','created_at'),
        'updated_at' => Yii::t('detail','updated_at'),
        'coop_fund1' => Yii::t('detail','coop_fund1'),
        'coop_fund2' => Yii::t('detail','coop_fund2'),
        'coop_fund3' => Yii::t('detail','coop_fund3'),
        'trade_fund1' => Yii::t('detail','trade_fund1'),
        'trade_fund2' => Yii::t('detail','trade_fund2'),
        'trade_fund3' => Yii::t('detail','trade_fund3'),
        'sid' => Yii::t('detail','Sid'),
        'level' => Yii::t('detail','level'), 
        'cate_id1' => Yii::t('detail','cate_id1'),
        'cate_id2' => Yii::t('detail','cate_id2'),
        'cate_id3' => Yii::t('detail','cate_id3'),
        'develop_department' => Yii::t('detail','develop_department'),
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
                'one_level_department',
                'second_level_department',
                'name',
                'mobile',
                'reason',
                'sid',
                'coop_date',
                'level',
                'cate_id1',
                'cate_id2',
                'cate_id3',
                'coop_fund1',
                'coop_fund2',
                'coop_fund3',
                'trade_fund1',
                'trade_fund2',
                'trade_fund3',
                'develop_department',
            ],
            self::SCENARIO_EDIT => [
                'one_level_department',
                'second_level_department',
                'name',
                'mobile',
                'reason',
                'coop_date',
                'level',
                'cate_id1',
                'cate_id2',
                'cate_id3',   
                'coop_fund1',
                'coop_fund2',
                'coop_fund3',
                'trade_fund1',
                'trade_fund2',
                'trade_fund3',           
                'develop_department',
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
          [['cate_id1','cate_id2','cate_id3','one_level_department','second_level_department','name','mobile','reason','coop_date','coop_fund1','coop_fund2','coop_fund3','trade_fund1','trade_fund2','trade_fund3','level'],'required'],
        ];
    }

    /**
     * *
     * @return [type] [description]
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * 根据id获取信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getByID($id){
        if (($model = self::findOne($id)) !== null) {
            return json_encode($model->toArray());
        } else {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }     


    public function beforeSave($insert)
    {
      if (parent::beforeSave($insert)) {
          if ($insert) { // 新增操作
            $historyModel = new History;
            $object_id = Yii::$app->request->get('sid');
            $field = 'level';
            $original = '';
            $result = $this->level;
            if ($result) {
              $level_result = SupplierLevel::getLevelById($result);
              $result_value = $level_result ? $level_result->level_name : '';
            }
            $desc = "新增供应商等级{{$result_value}}";
            $historyModel::history($object_id,$field,$original,$result,$desc);

            //对于cate_id1 进行操作
            if ($this->cate_id1) {
              $this->cate_id1 = implode(',', $this->cate_id1);
            }
            if ($this->cate_id2) {
              $this->cate_id2 = implode(',', $this->cate_id2);
            }
            if ($this->cate_id3) {
              $this->cate_id3 = implode(',', $this->cate_id3);
            }
          }else{
              //对比，如果firm_nature有变更。记录下来
              $old = $this->find()->where(['id' => $this->id])->one();
              //如果level有变更，记录下来
              if ($old->level != $this->level) {
                  $historyModel = new History;
                  $object_id = $this->id;
                  $field = 'level';
                  $original = $old->level;
                  $result = $this->level;
                  if ($original) {
                    $level_original = SupplierLevel::getLevelById($original);
                    $original_value = $level_original ? $level_original->level_name : '';
                  }
                  if ($result) {
                    $level_result = SupplierLevel::getLevelById($result);
                    $result_value = $level_result ? $level_result->level_name : '';
                  }
                  $desc = "更新供应商等级从{$original_value}到{$result_value}";
                  $historyModel::history($object_id,$field,$original,$result,$desc);
              }
              //对于cate_id1 进行操作
              if ($this->cate_id1) {
                $this->cate_id1 = implode(',', $this->cate_id1);
              }
              if ($this->cate_id2) {
                $this->cate_id2 = implode(',', $this->cate_id2);
              }
              if ($this->cate_id3) {
                $this->cate_id3 = implode(',', $this->cate_id3);
              }
          }
          return true;
      } else {
          return false;
      }
    }
}
