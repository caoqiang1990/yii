<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;

class SupplierExt extends ActiveRecord
{
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';
    
    /**
     * 返回表名
     * @return [type] [description]
     */
    public static function tableName()
    {
        return '{{%supplier_ext}}';
    }

    /**
     * 对应字段的中文翻译
     * @return [type] [description]
     */
    public function attributeLabels()
    {
      return [
        'id' => \Yii::t('suppliers','id'),
        'sid' => \Yii::t('suppliers','sid'),
        'field_name' => \Yii::t('suppliers', 'field_name'),
        'field_label' => \Yii::t('suppliers','field_label'),
        'field_value' => \Yii::t('suppliers','field_value'),
        'field_text' => \Yii::t('suppliers','field_text'),
        'field_type' => \Yii::t('suppliers','field_type'),
        'cate_public' => \Yii::t('suppliers','cate_public'),
        'created_at' => \Yii::t('suppliers','opeated_at'),
        'modifier' => \Yii::t('suppliers','opeated_by'),
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
                'sid',
                'field_name',
                'field_label',
                'field_value',
                'field_text',
                'field_type',
                'cate_public',
                'opeated_at',
                'opeated_by',
            ],
            self::SCENARIO_EDIT => [
                'sid',
                'field_name',
                'field_label',
                'field_value',
                'field_text',
                'field_type',
                'cate_public',
                'opeated_at',
                'opeated_by',
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
//            [['sid','field_name','field_type','opeated_at','opeated_by'],'required','on'=>'add'],
//            ['headcount','integer'],
//            ['sid','double'],
//            [['level'], 'safe'],
//            ['field_name','required','message'=>'字段名不能为空！','on'=>'add'],
//            ['field_type','required','message'=>'联系人电话不能为空！','on'=>'add'],
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