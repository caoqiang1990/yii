<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;


class SupplierType extends ActiveRecord
{

  /**
   *  
   * @return [type] [description]
   */
  public static function tableName()
  {
    return '{{%supplier_type}}';
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
        [['type_name'], 'safe'],
    ];    
  }


  public function attributeLabels()
  {
    return [
      'type_name' => Yii::t('type','type_name'),
      'status' => Yii::t('type','status'),
      'created_at' => Yii::t('type','created_at'),
      'updated_at' => Yii::t('type','updated_at'),
    ];
  }

  /**
   * 根据参数获取企业类别名称firm_nature
   * @param  string $column [description]
   * @param  string $id     [description]
   * @return [type]         [description]
   */
  public static function getTypeByParams($column='',$id='')
  {
    $where = [];
    $field = '';
    if ($id) {
      $where['id'] = $id;
    }
    if ($column) {
      $field = $column;
    }
    $lists = self::find()->select($field)->where($where)->asArray()->all();
    if ($lists) {
      foreach ($lists as $value) {
        $result[$value['id']] = $value['type_name'];
      }
    }else{
      return false;
    }
    return $result;
  }


  /**
   * 根据id获取企业类别名称
   * @param  string $id [description]
   * @return [type]     [description]
   */
  public static function getTypeById($id='')
  {
    if (!$id) {
      return false;
    }
    $info = self::find()->where(['id'=>$id])->one();
    return $info ? $info : false;
  }  

}





?>