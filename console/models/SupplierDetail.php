<?php

namespace console\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\History;
use backend\models\SupplierFunds;

/**
 * User represents the model behind the search form about `mdm\admin\models\User`.
 */
class SupplierDetail extends ActiveRecord
{
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';

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
        'one_coop_department' => Yii::t('detail','one_coop_department'),
        'second_coop_department' => Yii::t('detail','second_coop_department'),
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
                'one_coop_department',
                'second_coop_department',
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
                'sid',
                'one_coop_department',
                'second_coop_department',                
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
          [['cate_id1','cate_id2','cate_id3','name','mobile','reason','level','one_coop_department','second_coop_department'],'required'],
          ['sid','safe'],
          ['one_level_department','safe']

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
    public static function getByID($id){
        if (($model = self::findOne($id)) !== null) {
            return json_encode($model->toArray());
        } else {
            return false;
        }
    }

    public static function getBySid($sid)
    {
        return self::find()->where(['sid' => $sid])->one();
    }
}
