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
class Supplier extends ActiveRecord
{
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';


    /**
     * 返回表名
     * @return [type] [description]
     */
    public static function tableName()
    {
        return '{{%supplier}}';
    }

    /**
     * 对应字段的中文翻译
     * @return [type] [description]
     */
    public function attributeLabels()
    {
      return [
        'id' => \Yii::t('suppliers','id'),
        'name' => \Yii::t('suppliers', 'name'),
        'level' => \Yii::t('suppliers','level'),
        'business_address' => \Yii::t('suppliers','business_address'),
        'url' => \Yii::t('suppliers','url'),
        'register_date' => \Yii::t('suppliers','register_date'),
        'created_at' => \Yii::t('suppliers','created_at'),
        'updated_at' => \Yii::t('suppliers','updated_at'),
        'coop_content' => \Yii::t('suppliers','coop_content'),
        'firm_nature' => \Yii::t('suppliers','firm_nature'),
        'register_fund' => \Yii::t('suppliers','register_fund'),
        'headcount' => \Yii::t('suppliers','headcount'),
        'trade' => \Yii::t('suppliers','trade'),
        'business_mobile' => \Yii::t('suppliers','business_mobile'),
        'business_phone' => \Yii::t('suppliers','business_phone'),
        'business_scope' =>\Yii::t('suppliers','business_scope'),
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
                'name',
                'level',
                'business_address',
                'url',
                'register_date',
                'coop_content',
                'firm_nature',
                'register_fund',
                'headcount',
                'trade',
                'business_phone',
                'business_mobile',
                'business_scope',
            ],
            self::SCENARIO_EDIT => [
                'name',
                'level',
                'business_address',
                'url',
                'register_date',
                'coop_content',
                'firm_nature',
                'register_fund',
                'headcount',
                'trade',
                'business_phone',
                'business_mobile',
                'business_scope',
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
            [['name','business_address','business_scope'],'required','on'=>'add'],
            ['url','url','on'=>'add'],
            ['headcount','integer'],
            ['register_fund','double'],
            [['level'], 'safe'],
            ['business_mobile','required','message'=>'联系人电话不能为空！','on'=>'add'],
            ['business_phone','required','message'=>'联系人电话不能为空！','on'=>'add'],
            ['business_phone','match','pattern'=>'/^1[345678]\d{9}$/','message'=>'联系人手机号格式不正确！'],
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
