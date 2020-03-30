<?php

namespace console\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use backend\models\Attachment;
use backend\models\SupplierFunds;
use yii\behaviors\BlameableBehavior;

/**
 * User represents the model behind the search form about `mdm\admin\models\User`.
 */
class Supplier extends ActiveRecord
{
  const SCENARIO_SYNC = 'sync';

  /*
   * 返回表名
   * @return [type] [description]
   */
  public static function tableName()
  {
    return '{{%supplier}}';
  }

  /**
   * 场景
   * @return [type] [description]
   */
  public function scenarios()
  {
    return [
        self::SCENARIO_SYNC => [
            'cate_id1',
            'cate_id2',
            'cate_id3',
            'level',
            'cooperate',
        ],
    ];
  }


  /**
   * 根据id获取信息
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  public static function getByID($id)
  {
    if (($model = self::findOne($id)) !== null) {
      return $model;
    } else {
      throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }
  }
}
