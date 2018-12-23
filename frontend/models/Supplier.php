<?php

namespace frontend\models;

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
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';
    const SCENARIO_UPLOAD = 'upload';
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
        'id' => Yii::t('suppliers','id'),
        'name' => Yii::t('suppliers', 'name'),
        'level' => Yii::t('suppliers','level'),
        'business_address' => Yii::t('suppliers','business_address'),
        'url' => Yii::t('suppliers','url'),
        'register_date' => Yii::t('suppliers','register_date'),
        'created_at' => Yii::t('suppliers','created_at'),
        'updated_at' => Yii::t('suppliers','updated_at'),
        'coop_content' => Yii::t('suppliers','coop_content'),
        'firm_nature' => Yii::t('suppliers','firm_nature'),
        'register_fund' => Yii::t('suppliers','register_fund'),
        'headcount' => Yii::t('suppliers','headcount'),
        'trade' => Yii::t('suppliers','trade'),
        'business_mobile' => Yii::t('suppliers','business_mobile'),
        'business_phone' => Yii::t('suppliers','business_phone'),
        'business_scope' =>Yii::t('suppliers','business_scope'),
        'business_type' =>Yii::t('suppliers','business_type'),
        'factory_summary' =>Yii::t('suppliers','factory_summary'),
        'factory_land_area' =>Yii::t('suppliers','factory_land_area'),
        'factory_work_area' =>Yii::t('suppliers','factory_work_area'),
        'business_customer1' =>Yii::t('suppliers','business_customer1'),
        'business_customer2' =>Yii::t('suppliers','business_customer2'),
        'business_customer3' =>Yii::t('suppliers','business_customer3'),
        'material_name1' => Yii::t('suppliers','material_name1'),
        'material_name2' => Yii::t('suppliers','material_name2'),
        'material_name3' => Yii::t('suppliers','material_name3'),
        'instrument_device1' => Yii::t('suppliers','instrument_device1'),
        'instrument_device2' => Yii::t('suppliers','instrument_device2'),
        'instrument_device3' => Yii::t('suppliers','instrument_device3'),
        'instrument_device4' => Yii::t('suppliers','instrument_device4'),
        'business_contact' => Yii::t('suppliers','business_contact'),
        'business_position' =>Yii::t('suppliers','business_position'),
        'business_email' =>Yii::t('suppliers','business_email'),
        'legal_person' => Yii::t('suppliers','legal_person'),
        'legal_position' => Yii::t('suppliers','legal_position'),
        'legal_phone' => Yii::t('suppliers','legal_phone'),
        'sales_latest' => Yii::t('suppliers','sales_latest'),
        'tax_latest' => Yii::t('suppliers','tax_latest'),
        'social_responsibility' => Yii::t('suppliers','social_responsibility'),
        'department_name' => Yii::t('suppliers','department_name'),
        'department_manager' => Yii::t('suppliers','department_manager'),
        'department_manager_phone' => Yii::t('suppliers','department_manager_phone'),
        'enterprise_code_image_id' => Yii::t('suppliers','enterprise_code'),
        'enterprise_license_image_id' => Yii::t('suppliers','enterprise_license'),
        'enterprise_certificate_image_id' => Yii::t('suppliers','enterprise_certificate'),
        'enterprise_certificate_etc_image_id' => Yii::t('suppliers','enterprise_certificate_etc'),
        'enterprise_license_relate' => Yii::t('suppliers','enterprise_license_relate'),
        'enterprise_license_relate_image_id' => Yii::t('suppliers','enterprise_license_relate_image_id'),
        'total_fund' => Yii::t('suppliers','total_fund'),
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
                'enterprise_code',
                'enterprise_license',
                'enterprise_certificate',
                'enterprise_certificate_etc', 
                'enterprise_license_relate',               
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
                'enterprise_code',
                'enterprise_license',
                'enterprise_certificate',
                'enterprise_certificate_etc',
                'enterprise_license_relate',               
            ],
            self::SCENARIO_UPLOAD => [
                'enterprise_code',
                'enterprise_license',
                'enterprise_certificate',
                'enterprise_certificate_etc', 
                'enterprise_license_relate',               
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
            ['headcount','integer','on' => 'add,edit'],
            ['register_fund','double','on' => 'add,edit'],
            [['level','enterprise_code','enterprise_license','enterprise_certificate','enterprise_certificate_etc','enterprise_license_relate'], 'safe'],
            ['business_mobile','required','message'=>'联系人电话不能为空！','on'=>'add'],
            ['business_phone','required','message'=>'联系人电话不能为空！','on'=>'add'],
            ['business_phone','match','pattern'=>'/^1[345678]\d{9}$/','message'=>'联系人手机号格式不正确！','on' => 'add,edit'],
            [['enterprise_code_image_id'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg','on' => 'add,edit,upload'],
            [['enterprise_license_image_id'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg','on' => 'add,edit,upload'],
            [['enterprise_certificate'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg','on' => 'add,edit,upload'],
            [['enterprise_certificate_etc'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg','on' => 'add,edit,upload'],
               [['enterprise_license_relate_image_id'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg','on' => 'add,edit,upload'],

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

    /**
     * 根据id获取信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getByID($id){
        if (($model = self::findOne($id)) !== null) {
            return json_encode($model->toArray());
        } else {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }    


    public function getTotalFund($id){
        $supplierFundModel = new SupplierFunds;
        if (!$id) {
            return false;
        }
        $where['sid'] = $id;
        $where['year'] = date('Y') - 1;
        $fund = $supplierFundModel::find()->where($where)->one();
        return $fund;
    }

}