<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\Supplier;
use yii\helpers\FileHelper;
use backend\models\Attachment;

/**
 * Signup form
 */
class AdminAdd extends Model
{
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';
    const SCENARIO_UPLOAD = 'upload';
    public $name;
    public $enterprise_code;
    public $check_id;
    public $check_url;
    public $check;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required','on' => 'add,edit'],
            [
                'name','unique','targetClass'=>'backend\models\Supplier','message'=>'供应商名称已经存在','on' => 'add,edit'
            ],
            [['enterprise_code','check'], 'required','on' => 'add,edit'],
            ['enterprise_code','string','length'=>[18,18],'message'=>'营业执照长度为18位'],
            [['check_id'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg','on' => 'upload'],
        ];
    }

    /**
     * 
     *
     * @return 
     */
    public function add()
    {
        $this->scenario = 'add';
        if ($this->validate()) {
            $supplierModel = new Supplier();
            $supplierModel->scenario = 'admin-add';
            $supplierModel->name = $this->name;
            $supplierModel->public_flag = 'y';
            $supplierModel->department = Yii::$app->user->identity->department;
            $supplierModel->source = 'add';
            $supplierModel->enterprise_code_desc = $this->enterprise_code;
            $supplierModel->status = 'wait';
            $supplierModel->check = $this->check;
            if ($supplierModel->save()) {
                return $supplierModel;
            }
        }
        return null;
    }

    /**
     * 对应中文
     * @return [type] [description]
     */
    public function attributeLabels()
    {
        return [
            'name' => '供应商全称',
            'enterprise_code' => '营业执照',
            'check_id' => '备案查询',
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
                'enterprise_code',
                'check',
            ],
            self::SCENARIO_EDIT => [
                'name',
                'enterprise_code',
            ],
            self::SCENARIO_UPLOAD => [
                'check',
                'check_id'
            ]
        ];
    }
    /**
     * Name: upload
     * User: aimer
     * Date: 2019/7/23
     * Time: 上午10:12
     * @param $field
     * @return array|bool
     */
    public function upload($field)
    {
        $this->scenario = 'upload';
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
                $attachmentModel->filename = $this->{$field}->name;
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
    public function parseImageUrl($filePath)
    {
        if (strpos($filePath, Yii::getAlias('@uploadPath')) !== false) {
            $url = Yii::$app->params['assetDomain'] . str_replace(Yii::getAlias('@uploadPath'), '', $filePath);
            return $url;
        } else {
            return $filePath;
        }
    }

}
