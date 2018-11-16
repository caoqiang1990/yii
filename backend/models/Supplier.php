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
        'business_type' =>\Yii::t('suppliers','business_type'),
        'factory_summary' =>\Yii::t('suppliers','factory_summary'),
        'factory_land_area' =>\Yii::t('suppliers','factory_land_area'),
        'factory_work_area' =>\Yii::t('suppliers','factory_work_area'),
        'business_customer1' =>\Yii::t('suppliers','business_customer1'),
        'business_customer2' =>\Yii::t('suppliers','business_customer2'),
        'business_customer3' =>\Yii::t('suppliers','business_customer3'),
        'material_name1' => \Yii::t('suppliers','material_name1'),
        'material_name2' => \Yii::t('suppliers','material_name2'),
        'material_name3' => \Yii::t('suppliers','material_name3'),
        'instrument_device1' => \Yii::t('suppliers','instrument_device1'),
        'instrument_device2' => \Yii::t('suppliers','instrument_device2'),
        'instrument_device3' => \Yii::t('suppliers','instrument_device3'),
        'instrument_device4' => \Yii::t('suppliers','instrument_device4'),
        'business_contact' => \Yii::t('suppliers','business_contact'),
        'business_position' =>\Yii::t('suppliers','business_position'),
        'business_email' =>\Yii::t('suppliers','business_email'),
        'legal_person' => \Yii::t('suppliers','legal_person'),
        'legal_position' => \Yii::t('suppliers','legal_position'),
        'legal_phone' => \Yii::t('suppliers','legal_phone'),
        'sales_latest' => \Yii::t('suppliers','sales_latest'),
        'tax_latest' => \Yii::t('suppliers','tax_latest'),
        'social_responsibility' => \Yii::t('suppliers','social_responsibility'),
        'department_name' => \Yii::t('suppliers','department_name'),
        'department_manager' => \Yii::t('suppliers','department_manager'),
        'department_manager_phone' => \Yii::t('suppliers','department_manager_phone'),

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
                'business_contact',
                'business_phone',
                'business_mobile',
                'business_scope',
                'business_type',
                'factory_summary',
                'factory_land_area',
                'factory_work_area',
                'business_customer1',
                'business_customer2',
                'business_customer3',
                'material1',
                'material2',
                'material3',
                'instrument_device1',
                'instrument_device2',
                'instrument_device3',
                'business_position',
                'business_email',
                'legal_person',
                'legal_position',
                'legal_phone',
                'last_sale',
                'last_tax',
                'social_responsibility',
                'department_name',
                'department_manager',
                'department_manager_phone',
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
                'business_contact',
                'business_phone',
                'business_mobile',
                'business_scope',
                'business_type',
                'factory_summary',
                'factory_land_area',
                'factory_work_area',
                'business_customer1',
                'business_customer2',
                'business_customer3',
                'material1',
                'material2',
                'material3',
                'instrument_device1',
                'instrument_device2',
                'instrument_device3',
                'business_position',
                'business_email',
                'legal_person',
                'legal_position',
                'legal_phone',
                'last_sale',
                'last_tax',
                'social_responsibility',
                'department_name',
                'department_manager',
                'department_manager_phone',
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
            [['name','business_address','business_scope','business_type'],'required','on'=>'add'],
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
