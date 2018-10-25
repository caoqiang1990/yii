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
        'address' => \Yii::t('suppliers','address'),
        'url' => \Yii::t('suppliers','url'),
        'register_date' => \Yii::t('suppliers','register_date'),
        'created_at' => \Yii::t('suppliers','created_at'),
        'updated_at' => \Yii::t('suppliers','updated_at'),
      ];
    }

    /**
     * 场景
     * @return [type] [description]
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['name','level','address','url','register_date'],
            self::SCENARIO_EDIT => ['name','level','address','url','register_date'],
        ];
    }

    /**
     * 规则
     * @return [type] [description]
     */
    public function rules()
    {
        return [
            [['name','address'],'required','on'=>'add'],
            ['url','url','on'=>'add'],
            [['level'], 'safe'],
            //['mobile','required','message'=>'手机号码不能为空！','on'=>'add'],
            //['mobile','match','pattern'=>'/^1[345678]\d{9}$/','message'=>'手机号码格式不正确！'],
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
