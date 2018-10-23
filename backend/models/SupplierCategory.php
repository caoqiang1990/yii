<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;


class SupplierCategory extends ActiveRecord
{

  /**
   *  
   * @return [type] [description]
   */
  public static function tableName()
  {
    return '{{%supplier_category}}';
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
        [['id', 'created_at', 'updated_at'], 'integer'],
        [['category_name'], 'safe'],
    ];    
  }


  public function attributeLabels()
  {
    return [
      'category_name' => Yii::t('category','category_name'),
      'status' => Yii::t('category','status'),
      'created_at' => Yii::t('category','created_at'),
      'updated_at' => Yii::t('category','updated_at'),
    ];
  }
}





?>