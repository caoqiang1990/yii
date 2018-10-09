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
class Suppliers extends ActiveRecord
{
    const SCENARIO_ADD = 'add';

    /**
     * 返回表名
     * @return [type] [description]
     */
    public static function tableName()
    {
        return 'suppliers';
    }

    /**
     * 对应字段的中文翻译
     * @return [type] [description]
     */
    public function attributeLabels()
    {
      return [
        'id' => Yii::t('suppliers','id'),
        'sname' => \Yii::t('suppliers', 'sname'),
        'legal_person' => \Yii::t('suppliers','legal_person'),
        'business_license' => \Yii::t('suppliers','business_license'),
        'tax_registration_certificate' => \Yii::t('suppliers','tax_registration_certificate'),
        'orcc' => \Yii::t('suppliers','orcc'),
        'service_authorization_letter' => \Yii::t('suppliers','service_authorization_letter'),
        'certified_assets' => \Yii::t('suppliers','certified_assets'),
        'effective_credentials' => \Yii::t('suppliers','effective_credentials'),
        'opening_bank' => \Yii::t('suppliers','opening_bank'),
        'bank_no' => \Yii::t('suppliers','bank_no'),
        'account_name' => \Yii::t('suppliers','account_name'),
        'account_no' => \Yii::t('suppliers','account_no'),
        'registration_certificate' => \Yii::t('suppliers','registration_certificate'),
        'manufacturing_licence' => \Yii::t('suppliers','manufacturing_licence'),
        'business_certificate' => \Yii::t('suppliers','business_certificate'),
        'credibility_certificate' => \Yii::t('suppliers','credibility_certificate'),
        'headcount' => \Yii::t('suppliers','headcount'),
        'address' => \Yii::t('suppliers','address'),
        'telephone' => \Yii::t('suppliers','telephone'),
        'mobile' => \Yii::t('suppliers','mobile'),
        'fax' => \Yii::t('suppliers','fax'),
        'email' => \Yii::t('suppliers','email'),
        'contact' => \Yii::t('suppliers','contact'),
        'url' => \Yii::t('suppliers','url'),
        'black_box' => \Yii::t('suppliers','black_box'),
        'white_box' => \Yii::t('suppliers','white_box'),
        'remarks' => \Yii::t('suppliers','remarks'),
        'operator' => \Yii::t('suppliers','operator'),
        'created_at' => \Yii::t('suppliers','created_at'),
        'updated_at' => \Yii::t('suppliers','updated_at'),
        // 'subject' => \Yii::t('app', 'Subject'),
        // 'body' => \Yii::t('app', 'Content'),
      ];
    }

    /**
     * 场景
     * @return [type] [description]
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['sname']
        ];
    }

    /**
     * 规则
     * @return [type] [description]
     */
    public function rules()
    {
        return [
            [['sname'],'required','on'=>'add'],
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
