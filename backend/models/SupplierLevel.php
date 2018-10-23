<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;

class SupplierLevel extends ActiveRecord
{
  /**
   * 表名
   * @return [type] [description]
   */
  public static function tableName()
  {
    return '{{%supplier_level}}';
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
        [['level_name'], 'safe'],
    ];    
  }

  public function attributeLabels()
  {
    return [
      'level_name' => Yii::t('level','level_name'),
      'status' => Yii::t('level','status'),
      'created_at' => Yii::t('level','created_at'),
      'updated_at' => Yii::t('level','updated_at'),
    ];
  }
}

?>