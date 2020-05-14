<?php
declare(strict_types=1);

namespace backend\models;

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
use backend\models\History;
use backend\models\SupplierNature;
use yii\helpers\ArrayHelper;

/**
 * User represents the model behind the search form about `mdm\admin\models\User`.
 */
class Supplier extends ActiveRecord
{
  const SCENARIO_ADD = 'add';
  const SCENARIO_EDIT = 'edit';
  const SCENARIO_UPLOAD = 'upload';
  const SCENARIO_ADMIN_ADD = 'admin-add';
  const SCENARIO_AUDIT = 'audit';
  const SCENARIO_SYNC = 'sync';
  public $enterprise_code_url;
  public $enterprise_license_url;
  public $enterprise_certificate_url;
  public $enterprise_certificate_etc_url;
  public $enterprise_license_relate_url;
  public $enterprise_code_image_id;
  public $enterprise_license_image_id;
  public $enterprise_certificate_image_id;
  public $enterprise_certificate_etc_image_id;
  public $enterprise_license_relate_image_id;
  public $total_fund;//总
  public $filter_cate_id1;
  public $check_id;

  /**
   * 返回表名
   * @return [type] [description]
   */
  public static function tableName():string
  {
    return '{{%supplier}}';
  }

  /**
   * 对应字段的中文翻译
   * @return [type] [description]
   */
  public function attributeLabels():array
  {
    return [
        'id' => Yii::t('suppliers', 'id'),
        'name' => Yii::t('suppliers', 'name'),
        'level' => Yii::t('suppliers', 'level'),
        'business_address' => Yii::t('suppliers', 'business_address'),
        'url' => Yii::t('suppliers', 'url'),
        'register_date' => Yii::t('suppliers', 'register_date'),
        'created_at' => Yii::t('suppliers', 'created_at'),
        'updated_at' => Yii::t('suppliers', 'updated_at'),
        'coop_content' => Yii::t('suppliers', 'coop_content'),
        'firm_nature' => Yii::t('suppliers', 'firm_nature'),
        'register_fund' => Yii::t('suppliers', 'register_fund'),
        'headcount' => Yii::t('suppliers', 'headcount'),
        'trade' => Yii::t('suppliers', 'trade'),
        'business_mobile' => Yii::t('suppliers', 'business_mobile'),
        'business_phone' => Yii::t('suppliers', 'business_phone'),
        'business_scope' => Yii::t('suppliers', 'business_scope'),
        'business_type' => Yii::t('suppliers', 'business_type'),
        'factory_summary' => Yii::t('suppliers', 'factory_summary'),
        'factory_land_area' => Yii::t('suppliers', 'factory_land_area'),
        'factory_work_area' => Yii::t('suppliers', 'factory_work_area'),
        'business_customer1' => Yii::t('suppliers', 'business_customer1'),
        'business_customer2' => Yii::t('suppliers', 'business_customer2'),
        'business_customer3' => Yii::t('suppliers', 'business_customer3'),
        'material_name1' => Yii::t('suppliers', 'material_name1'),
        'material_name2' => Yii::t('suppliers', 'material_name2'),
        'material_name3' => Yii::t('suppliers', 'material_name3'),
        'instrument_device1' => Yii::t('suppliers', 'instrument_device1'),
        'instrument_device2' => Yii::t('suppliers', 'instrument_device2'),
        'instrument_device3' => Yii::t('suppliers', 'instrument_device3'),
        'instrument_device4' => Yii::t('suppliers', 'instrument_device4'),
        'business_contact' => Yii::t('suppliers', 'business_contact'),
        'business_position' => Yii::t('suppliers', 'business_position'),
        'business_email' => Yii::t('suppliers', 'business_email'),
        'legal_person' => Yii::t('suppliers', 'legal_person'),
        'legal_position' => Yii::t('suppliers', 'legal_position'),
        'legal_phone' => Yii::t('suppliers', 'legal_phone'),
        'sales_latest' => Yii::t('suppliers', 'sales_latest'),
        'tax_latest' => Yii::t('suppliers', 'tax_latest'),
        'social_responsibility' => Yii::t('suppliers', 'social_responsibility'),
        'department_name' => Yii::t('suppliers', 'department_name'),
        'department_manager' => Yii::t('suppliers', 'department_manager'),
        'department_manager_phone' => Yii::t('suppliers', 'department_manager_phone'),
        'enterprise_code_image_id' => Yii::t('suppliers', 'enterprise_code'),
        'enterprise_license_image_id' => Yii::t('suppliers', 'enterprise_license'),
        'enterprise_certificate_image_id' => Yii::t('suppliers', 'enterprise_certificate'),
        'enterprise_certificate_etc_image_id' => Yii::t('suppliers', 'enterprise_certificate_etc'),
        'enterprise_license_relate' => Yii::t('suppliers', 'enterprise_license_relate'),
        'enterprise_license_relate_image_id' => Yii::t('suppliers', 'enterprise_license_relate_image_id'),
        'total_fund' => Yii::t('suppliers', 'total_fund'),
        'cate_id1' => Yii::t('suppliers', 'cate_id1'),
        'cate_id2' => Yii::t('suppliers', 'cate_id2'),
        'cate_id3' => Yii::t('suppliers', 'cate_id3'),
        'enterprise_code_desc' => Yii::t('suppliers', 'enterprise_code_desc'),
        'enterprise_license_desc' => Yii::t('suppliers', 'enterprise_license_desc'),
        'enterprise_certificate_desc' => Yii::t('suppliers', 'enterprise_certificate_desc'),
        'enterprise_certificate_etc_desc' => Yii::t('suppliers', 'enterprise_certificate_etc_desc'),
        'enterprise_license_relate_desc' => Yii::t('suppliers', 'enterprise_license_relate_desc'),
        'status' => Yii::t('suppliers', 'status'),
        'source' => Yii::t('suppliers', 'source'),
        'department' => Yii::t('suppliers', 'department'),
        'public_flag' => Yii::t('suppliers', 'public_flag'),
        'created_by' => Yii::t('suppliers', 'created_by'),
        'updated_by' => Yii::t('suppliers', 'updated_by'),
        'cooperate' => Yii::t('suppliers', 'cooperate'),
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
            'sales_latest',
            'tax_latest',
            'social_responsibility',
            'department_name',
            'department_manager',
            'department_manager_phone',
            'enterprise_code',
            'enterprise_license',
            'enterprise_certificate',
            'enterprise_certificate_etc',
            'enterprise_license_relate',
            'cate_id1',
            'cate_id2',
            'cate_id3',
            'status',
            'source',
            'public_flag',
            'enterprise_code_desc',
            'enterprise_license_desc',
            'enterprise_certificate_desc',
            'enterprise_certificate_etc_desc',
            'enterprise_license_relate_desc',
            'department',
            'cooperate',
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
            'sales_latest',
            'tax_latest',
            'social_responsibility',
            'department_name',
            'department_manager',
            'department_manager_phone',
            'enterprise_code',
            'enterprise_license',
            'enterprise_certificate',
            'enterprise_certificate_etc',
            'enterprise_license_relate',
            'cate_id1',
            'cate_id2',
            'cate_id3',
            'status',
            'source',
            'public_flag',
            'enterprise_code_desc',
            'enterprise_license_desc',
            'enterprise_certificate_desc',
            'enterprise_certificate_etc_desc',
            'enterprise_license_relate_desc',
            'department',
            'cooperate',
        ],
        self::SCENARIO_UPLOAD => [
            'enterprise_code',
            'enterprise_license',
            'enterprise_certificate',
            'enterprise_certificate_etc',
            'enterprise_license_relate',
        ],
        self::SCENARIO_ADMIN_ADD => [
            'name',
            'enterprise_code_desc',
            'public_flag',
            'department',
            'source',
            'status',
        ],
        self::SCENARIO_AUDIT => [
            'status',
            'public_flag',
        ],
        self::SCENARIO_SYNC => [
            'cate_id1',
            'cate_id2',
            'cate_id3',
            'level',
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
        [['name'], 'required', 'on' => 'add'],
        ['name', 'unique'],
      //['url','url','on'=>'add'],
        ['headcount', 'integer', 'on' => 'add,edit'],
        ['register_fund', 'double', 'on' => 'add,edit'],
        [['level', 'enterprise_code', 'enterprise_license', 'enterprise_certificate', 'enterprise_certificate_etc', 'enterprise_license_relate','cooperate'], 'safe'],
      //['business_mobile','required','message'=>'联系人电话不能为空！','on'=>'add'],
      //['business_phone','required','message'=>'联系人电话不能为空！','on'=>'add'],
        ['business_phone', 'match', 'pattern' => '/^1[345678]\d{9}$/', 'message' => '联系人手机号格式不正确！', 'on' => 'add,edit'],
        [['enterprise_code_image_id'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg', 'on' => 'add,edit,upload'],
        [['enterprise_license_image_id'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg', 'on' => 'add,edit,upload'],
        [['check_id'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg', 'on' => 'add,edit,upload'],
        [['enterprise_certificate'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg', 'on' => 'add,edit,upload'],
        [['enterprise_certificate_etc'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg', 'on' => 'add,edit,upload'],
        [['enterprise_license_relate_image_id'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg', 'on' => 'add,edit,upload'],
        [['last_tax', 'last_sale'], 'required', 'on' => 'edit'],
        ['status', 'required', 'on' => 'audit']
    ];
  }

  /**
   * *
   * @return [type] [description]
   */
  public function behaviors():array
  {
    return [
        TimestampBehavior::className(),
        BlameableBehavior::className(),
    ];
  }

  public function getNameByID($id)
  {
    if (!$id) {
      return false;
    }
    $where['id'] = $id;
    $name = self::find()->select('name')->where($where)->one();
    return $name;
  }

  public function upload($field)
  {
    if ($this->validate()) {
      $path = \Yii::getAlias('@uploadPath') . '/' . date("Ymd");
      if (!is_dir($path) || !is_writable($path)) {
        FileHelper::createDirectory($path, 0777, true);
      }
      $filePath = $path . '/' . \Yii::$app->request->post('model', '') . '_' . md5(uniqid() . mt_rand(10000, 99999999)) . '.' . $this->{$field}->extension;
      if ($this->{$field}->saveAs($filePath)) {
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
        return ['filepath' => $filePath, 'imageid' => $imageId];
      } else {
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
  public function parseImageUrl($filePath):string
  {
    if (strpos($filePath, Yii::getAlias('@uploadPath')) !== false) {
      $url = Yii::$app->params['assetDomain'] . str_replace(Yii::getAlias('@uploadPath'), '', $filePath);
      return $url;
    } else {
      return $filePath;
    }
  }

  /**
   * 根据id获取信息
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  public function getByID($id)
  {
    if (($model = self::findOne($id)) !== null) {
      return json_encode($model->toArray());
    } else {
      throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }
  }


  public function getTotalFund($id)
  {
    $supplierFundModel = new SupplierFunds;
    if (!$id) {
      return false;
    }
    $where['sid'] = $id;
    $where['year'] = date('Y') - 1;
    $fund = $supplierFundModel::find()->where($where)->one();
    return $fund;
  }

  /**
   * 插入前修改
   * @param  [type] $insert [description]
   * @return [type]         [description]
   */
  public function beforeSave($insert):bool
  {
    if (parent::beforeSave($insert)) {

      if ($insert) { // 新增操作
        if (is_array($this->business_type)) {
          $this->business_type = implode(',', $this->business_type);
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
      } else {
        if (is_array($this->business_type)) {
          $this->business_type = implode(',', $this->business_type);
        }
        //对比，如果firm_nature有变更。记录下来
        $old = $this->find()->where(['id' => $this->id])->one();
        if ($old->firm_nature != $this->firm_nature) {
          $historyModel = new History;
          $object_id = $this->id;
          $field = 'firm_nature';
          $original = $old->firm_nature;
          $result = $this->firm_nature;
          $original_value = '';
          $result_value = '';
          if ($original) {
            $nature_original = SupplierNature::getNatureById($original);
            $original_value = $nature_original ? $nature_original->nature_name : '';
          }
          if ($result) {
            $nature_result = SupplierNature::getNatureById($result);
            $result_value = $nature_result ? $nature_result->nature_name : '';
          }
          if ($original_value && $result_value) {
            $desc = "更新企业性质从{{$original_value}}到{{$result_value}}";
            $historyModel::history($object_id, $field, $original, $result, $desc);
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
      return true;
    } else {
      return false;
    }

  }

  /**
   * 查询后修改
   * @return [type] [description]
   */
  public function afterFind():void
  {
    $this->business_type = $this->business_type ? explode(',', $this->business_type) : '';
  }

  /**
   * @param bool $insert
   * @param array $changedAttributes
   */
  public function afterSave($insert, $changedAttributes):void
  {
    if ($insert) { // 新增操作
      $historyModel = new History;
      $object_id = $this->id;
      $field = 'firm_nature';
      $original = '';
      $result = $this->firm_nature;
      if ($result) {
        $nature_result = SupplierNature::getNatureById($this->firm_nature);
        $result_value = $nature_result ? $nature_result->nature_name : '';
        $desc = "新增企业性质{{$result_value}}";
        $historyModel::history($object_id, $field, $original, $result, $desc);
      }
    } else { // 编辑操作
      // do other sth.
    }
  }

  /*
   *
   * 根据名称获取企业等级
   *
   * **/
  public static function getSupplierByName($name)
  {
    if (!$name) {
      return false;
    }
    $where['name'] = $name;
    $info = self::find()->where($where)->one();
    if ($info) {
      return $info;
    }
    return false;
  }

  /**
   * 根据id获取供应商
   * @param  string $id [description]
   * @return [type]     [description]
   */
  public static function getSupplierById($id = '')
  {
    if (!$id) {
      return false;
    }
    $info = self::find()->where(['id' => $id])->one();
    return $info ? $info : false;
  }

  /**
   * 获取key-value键值对
   * @return [type] [description]
   */
  public static function getSuppliers():array
  {
    $suppliers = self::find()->all();
    $supplier = ArrayHelper::map($suppliers, 'id', 'name');
    return $supplier;
  }


  public static function getCountByParams($key, $value)
  {
    if (!$value) {
      return false;
    }
    $where[$key] = $value;
    $where['status'] = 10;
    $count = self::find()->where($where)->count();
    return $count;
  }

  public static function getTotalCount()
  {
    $where['status'] = 10;
    $count = self::find()->where($where)->count();
    return $count;
  }

  public static function getCountByParamsArr($where)
  {
    if (empty($where)) {
      return false;
    }
    $where['status'] = 10;
    $count = self::find()->where($where)->count();
    return $count;

  }
  /**
   * 获取key-value键值对
   * @return [type] [description]
   */
  public static function getSuppliersByParams($where)
  {
    if (empty($where)) {
      return false;
    }
    $suppliers = self::find()->where($where)->all();
    $supplier = ArrayHelper::map($suppliers, 'id', 'name');
    return $supplier;
  }
}
