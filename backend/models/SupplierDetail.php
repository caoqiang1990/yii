<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;

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
        'id' => \Yii::t('detail','id'),
        'one_level_department' => \Yii::t('detail','one_level_department'),
        'second_level_department' => \Yii::t('detail','second_level_department'),
        'name' => \Yii::t('detail', 'name'),
        'mobile' => \Yii::t('detail','mobile'),
        'reason' => \Yii::t('detail','reason'),
        'created_at' => \Yii::t('detail','created_at'),
        'updated_at' => \Yii::t('detail','updated_at'),
        'coop_fund1' => \Yii::t('detail','coop_fund1'),
        'coop_fund2' => \Yii::t('detail','coop_fund2'),
        'coop_fund3' => \Yii::t('detail','coop_fund2'),
        'trade_fund1' => \Yii::t('detail','trade_fund1'),
        'trade_fund2' => \Yii::t('detail','trade_fund2'),
        'trade_fund3' => \Yii::t('detail','trade_fund3'),
        'sid' => \Yii::t('detail','Sid'),
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
            ],
            self::SCENARIO_EDIT => [
                'one_level_department',
                'second_level_department',
                'name',
                'mobile',
                'reason',
                'sid',
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
    
        ];
    }

    /**
     * *
     * @return [type] [description]
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }
}
