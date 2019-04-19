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
class SupplierFunds extends ActiveRecord
{
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';

    /**
     * 返回表名
     * @return [type] [description]
     */
    public static function tableName()
    {
        return '{{%supplier_funds}}';
    }

    /**
     * 对应字段的中文翻译
     * @return [type] [description]
     */
    public function attributeLabels()
    {
      return [
        'id' => \Yii::t('funds','id'),
        'created_at' => \Yii::t('funds','created_at'),
        'updated_at' => \Yii::t('funds','updated_at'),
        'coop_fund' => \Yii::t('funds','coop_fund1'),
        'trade_fund' => \Yii::t('funds','trade_fund1'),
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
                'coop_fund',
                'trade_fund',
            ],
            self::SCENARIO_EDIT => [
                'coop_fund',
                'trade_fund',
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

    /**
     * Name: getTotalCountByYear
     * User: aimer
     * Date: 2019/4/18
     * Time: 下午4:20
     * @param int $year
     * @return int
     */
    public static function getTotalCountByYear($year=2015)
    {
        if (!$year) {
            return false;
        }

        $where['year'] = $year;
        $count = self::find()->where($where)->count();
        return $count;
    }

    /**
     * Name: getTotalTradeFundsByYear
     * User: aimer
     * Date: 2019/4/18
     * Time: 下午4:24
     * @param int $year
     * @return float
     */
    public static function getTotalTradeFundsByYear($year=2015)
    {
        if (!$year) {
            return false;
        }

        $where['year'] = $year;
        $num = self::find()->where($where)->sum('trade_fund');
        return $num;
    }
}
