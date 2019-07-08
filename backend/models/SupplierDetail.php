<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\History;
use backend\models\SupplierFunds;
use yii\helpers\FileHelper;
use backend\models\Attachment;

/**
 * User represents the model behind the search form about `mdm\admin\models\User`.
 */
class SupplierDetail extends ActiveRecord
{
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';
    const SCENARIO_UPLOAD = 'upload';
    public $coop_fund1;
    public $coop_fund2;
    public $coop_fund3;

    public $trade_fund1;
    public $trade_fund2;
    public $trade_fund3;

    public $fund_year1;
    public $fund_year2;
    public $fund_year3;
    public $department;
    public $supplier_name;

    public $evaluate_url;
    public $evaluate_image_id;
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
        'supplier_name' => Yii::t('detail','supplier_name'),
        'evaluate_image_id' => Yii::t('detail','evaluate_image_id'),
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
                'evaluate',
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
                'evaluate',
            ],
            self::SCENARIO_UPLOAD => [
                'evaluate',
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
          ['one_level_department','safe'],
          ['evaluate','safe'],
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
    public function getByID($id){
        if (($model = self::findOne($id)) !== null) {
            return json_encode($model->toArray());
        } else {
            return false;
        }
    }     


    public function beforeSave($insert)
    {
      if (parent::beforeSave($insert)) {
          if ($insert) { // 新增操作
            $historyModel = new History;
            $object_id = $this->sid;
            $field = 'level';
            $original = '';
            $result = $this->level;
            if ($result) {
              $level_result = SupplierLevel::getLevelById($result);
              $result_value = $level_result ? $level_result->level_name : '';
              $desc = "新增供应商等级{{$result_value}}";
              $historyModel::history($object_id,$field,$original,$result,$desc);
            }
            //对于cate_id1 进行操作
            if (is_array($this->cate_id1)) {
              $this->cate_id1 = implode(',', $this->cate_id1);
            }
            if (is_array($this->cate_id2)) {
              $this->cate_id2 = implode(',', $this->cate_id2);
            }
            if (is_array($this->cate_id3)) {
              $this->cate_id3 = implode(',', $this->cate_id3);
            }
            $department = Department::getDepartmentByName($this->one_level_department);
            $this->one_level_department = $department ? $department->id : $this->one_level_department;
          }else{
              //对比，如果firm_nature有变更。记录下来
              $old = $this->find()->where(['id' => $this->id])->one();
              //如果level有变更，记录下来
              if ($old->level != $this->level) {
                  $historyModel = new History;
                  $object_id = $this->id;
                  $field = 'level';
                  $original = $old->level;
                  $result = $this->level;
                  $original_value = '';
                  $result_value = '';
                  if ($original) {
                    $level_original = SupplierLevel::getLevelById($original);
                    $original_value = $level_original ? $level_original->level_name : '';
                  }
                  if ($result) {
                    $level_result = SupplierLevel::getLevelById($result);
                    $result_value = $level_result ? $level_result->level_name : '';
                  }
                  if ($original_value && $result_value) {
                    $desc = "更新供应商等级从{$original_value}到{$result_value}";
                    $historyModel::history($object_id,$field,$original,$result,$desc);
                  }
               
              }
              //对于cate_id1 进行操作
              if (is_array($this->cate_id1)) {
                $this->cate_id1 = implode(',', $this->cate_id1);
              }
              if (is_array($this->cate_id2)) {
                $this->cate_id2 = implode(',', $this->cate_id2);
              }
              if (is_array($this->cate_id3)) {
                $this->cate_id3 = implode(',', $this->cate_id3);
              }
          }
          //追加cate_id1  cate_id2  cate_id3到主表中。
          //TODO
          return true;
      } else {
          return false;
      }
    }

    /**
    * @param bool $insert
    * @param array $changedAttributes
    */
    public function afterSave($insert, $changedAttributes)
    {
        //新增操作
        $this->fund_year1 = date('Y') - 2;
        $this->fund_year2 = date('Y') - 1;
        $this->fund_year3 = date('Y') - 0;
        if ($insert) {


           $funds = array();
           for($i=1;$i<=3;$i++) {
              $funds[$i-1]["sid"] = $this->sid;
              $funds[$i-1]["detail_id"] = $this->id;
              $coop_fund = "coop_fund{$i}";
              $trade_fund = "trade_fund{$i}";
              $fund_year = "fund_year{$i}";
              $funds[$i-1]["coop_fund"] = $this->{$coop_fund};
              $funds[$i-1]["trade_fund"] = $this->{$trade_fund};
              $funds[$i-1]["year"] = $this->{$fund_year};
              $funds[$i-1]["created_at"] = time();
              $funds[$i-1]["updated_at"] = time();
          }     
          Yii::$app->db->createCommand()->batchInsert('supplier_funds',['sid','detail_id','coop_fund','trade_fund','year','created_at','updated_at'],$funds)->execute();
        } else { // 编辑操作
          //2015
          $fundModel = new SupplierFunds;
          $where['detail_id'] = $this->id;
          $where['year'] = $this->fund_year1;
          $fundModel = SupplierFunds::find()->where($where)->one();
          if ($fundModel) {
            $fundModel->scenario = 'edit';
            $fundModel->coop_fund = $this->coop_fund1;
            $fundModel->trade_fund = $this->trade_fund1;
          } else {
            $fundModel = new SupplierFunds;
            $fundModel->scenario = 'add';
            $fundModel->coop_fund = $this->coop_fund3;
            $fundModel->trade_fund = $this->trade_fund3;
            $fundModel->year = $this->fund_year3;
            $fundModel->sid = $this->sid;
            $fundModel->detail_id = $this->id;
          }                    
          $fundModel->save();
          //2016
          $fundModel = '';
          $where['detail_id'] = $this->id;
          $where['year'] = $this->fund_year2;
          $fundModel = SupplierFunds::find()->where($where)->one();
          if ($fundModel) {
            $fundModel->scenario = 'edit';
            $fundModel->coop_fund = $this->coop_fund2;
            $fundModel->trade_fund = $this->trade_fund2;
          } else {
            $fundModel = new SupplierFunds;
            $fundModel->scenario = 'add';
            $fundModel->coop_fund = $this->coop_fund3;
            $fundModel->trade_fund = $this->trade_fund3;
            $fundModel->year = $this->fund_year3;
            $fundModel->sid = $this->sid;
            $fundModel->detail_id = $this->id;
          }          
          $fundModel->save();
          //2017
          $fundModel = '';
          $where['detail_id'] = $this->id;
          $where['year'] = $this->fund_year3;
          $fundModel = SupplierFunds::find()->where($where)->one();
          if ($fundModel) {
            $fundModel->scenario = 'edit';
            $fundModel->coop_fund = $this->coop_fund3;
            $fundModel->trade_fund = $this->trade_fund3;
          } else {
            $fundModel = new SupplierFunds;
            $fundModel->scenario = 'add';
            $fundModel->coop_fund = $this->coop_fund3;
            $fundModel->trade_fund = $this->trade_fund3;
            $fundModel->year = $this->fund_year3;
            $fundModel->sid = $this->sid;
            $fundModel->detail_id = $this->id;
          }
          $fundModel->save();          
        }
    }    

    /**
     *
     * 根据部门id来获取对应的部门集合
     * 
     */
    public static function getDepartmentIdsByDepartment($id)
    {
      if (!$id) {
        return false;
      }
      $where['one_level_department'] = $id;
      $supplier_ids = self::find()->select('department')
      ->leftJoin('supplier','`supplier`.`id` = `sid`')
      ->where($where)
      ->andwhere(['not',['department' => null]])
      ->all();
      if ($supplier_ids) {
        $ids = array_column($supplier_ids, 'department');
        $ids = array_unique($ids);
        return  $ids;
      } else {
        return false;
      }

    }


    public static function getSupplierByDepartment($department)
    {
        if (!$department) {
            return false;
        }
        $where = ['in','one_coop_department',$department];
        //$where['one_coop_department'] = $department;
        $ids = self::find()->select('sid')->distinct()->where($where)->asArray()->all();
        if ($ids) {
          return array_column($ids,'sid');
        } else {
          return false;
        }

    }

    /**
     *
     * 上传附件
     *
     */
    public function upload($field)
    {
        if ($this->validate()) {
            $path = \Yii::getAlias('@uploadPath') . '/' . date("Ymd");
            if (!is_dir($path) || !is_writable($path)) {
                FileHelper::createDirectory($path, 0777, true);
            }
            $filePath = $path . '/' . \Yii::$app->request->post('model', '') . '_' . md5(uniqid() . mt_rand(10000, 99999999)) . '.' . $this->{$field}->extension;
            if($this->{$field}->saveAs($filePath)) {
                //如果上传成功，保存附件信息到数据库。TODO
                //这里将上传成功后的图片信息保存到数据库
                $imageUrl = $this->parseImageUrl($filePath);
                $attachmentModel = new Attachment;
                $attachmentModel->url = $imageUrl;
                $attachmentModel->filepath = $filePath;
                $attachmentModel->status = 1;
                $attachmentModel->type = 'image';
                $attachmentModel->module = Yii::$app->request->post('model', '');
                $attachmentModel->created_at = time();
                $attachmentModel->updated_at = time();
                $attachmentModel->save(false);
                $imageId = Yii::$app->db->getLastInsertID();
                return ['filepath' => $filePath,'imageid' => $imageId];
            }else{
                return false;
            }
        } else {
            return false;
        }
    }  

    /**
     * 这里在upload中定义了上传目录根目录别名，以及图片域名
     * 将/var/www/html/advanced/frontend/web/uploads/20160626/file.png 转化为 http://statics.gushanxia.com/uploads/20160626/file.png
     * format:http://domain/path/file.extension
     * @param $filePath
     * @return string
     */
    public function parseImageUrl($filePath)
    {
        if (strpos($filePath, Yii::getAlias('@uploadPath')) !== false) {
            $url =  Yii::$app->params['assetDomain'] . str_replace(Yii::getAlias('@uploadPath'), '', $filePath);
            return $url;
        } else {
            return $filePath;
        }
    }      

}
