<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use backend\models\Attachment;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "{{%pitch}}".
 **/
class Pitch extends ActiveRecord
{
    const SCENARIO_UPLOAD = 'upload';
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';
    public $record_id;
    public $record_url;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pitch}}';
    }

    /**
     * 行为
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('pitch', 'id'),
            'name' => Yii::t('pitch', 'name'),
            'desc' => Yii::t('pitch', 'desc'),
            'start_date' => Yii::t('pitch', 'start_date'),
            'end_date' => Yii::t('pitch', 'end_date'),
            'sids' => Yii::t('pitch', 'sids'),
            'record' => Yii::t('pitch', 'record'),
            'remark' => Yii::t('pitch', 'remark'),
            'result' => Yii::t('pitch', 'result'),
            'created_at' => Yii::t('pitch', 'created_at'),
            'updated_at' => Yii::t('pitch', 'updated_at'),
            'created_by' => Yii::t('pitch', 'created_by'),
            'updated_by' => Yii::t('pitch', 'updated_by'),
            'record_id' => Yii::t('pitch', 'record_id'),
            'document' => Yii::t('pitch', 'document'),
            'status' => Yii::t('pitch', 'status'),
            'email_flag' => Yii::t('pitch', 'email_flag'),
            'email_text' => Yii::t('pitch', 'email_text'),
        ];
    }

    /**
     * 场景
     * @return [type] [description]
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_UPLOAD => [
                'record',
            ],
            self::SCENARIO_ADD => [
                'name', 'desc', 'start_date', 'end_date', 'sids', 'record', 'remark',
                'result', 'department', 'auditor', 'document', 'status','email_flag','email_text',
            ],
            self::SCENARIO_EDIT => [
                'name', 'desc', 'start_date', 'end_date', 'sids', 'record', 'remark',
                'result', 'department', 'auditor', 'document', 'status','email_flag','email_text',
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
            [['sids','name','email_flag'],'required','on' => 'add'],
            ['email_text','required','when' => function($model){
                return $model->email_flag == 'y';
            },'whenClient' => "function(attribute,value){ return $('#email_flag').val() == 'y'; }",'on' => 'add'],
            ['email_text','validateEmailText','skipOnEmpty' => true,'when' => function($model){
                return $model->email_flag == 'y';
            },'whenClient' => "function(attribute,value){ return $('#email_flag').val() == 'y'; }"]

        ];
    }

    /**
     * Name: validateEmailText
     * User: aimer
     * Date: 2019/4/10
     * Time: 下午3:40
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function validateEmailText($attribute,$params)
    {
        if (!$this->$attribute) {
            $this->addError($attribute,'供应商邮箱不能为空!');
            return false;
        }
        $email_arr = explode(';',$this->$attribute);
        foreach ($email_arr as $item) {
            list($name,$email) = explode(':',$item);
            $supplier = Supplier::getSupplierByName($name);
            if (!$supplier) {
                $this->addError($attribute,"供应商：{$name} 不存在！");
                return false;
            } else {
                //TODO验证邮箱是否正确
                $preg_email='/^[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+)*@([a-zA-Z0-9]+[-.])+([a-z]{2,5})$/ims';
                if(preg_match($preg_email,$email)){
                    return true;
                }else{
                    $this->addError($attribute,"供应商：{$name} 邮箱不正确！");
                    return false;
                }
            }
        }
        return true;
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
    public function parseImageUrl($filePath)
    {
        if (strpos($filePath, Yii::getAlias('@uploadPath')) !== false) {
            $url = Yii::$app->params['assetDomain'] . str_replace(Yii::getAlias('@uploadPath'), '', $filePath);
            return $url;
        } else {
            return $filePath;
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) { // 新增操作
                //对sids 进行操作
                if (is_array($this->sids)) {
                    $this->sids = implode(',', $this->sids);
                }
                if (is_array($this->auditor)) {
                    $this->auditor = implode(',', $this->auditor);
                }
                if (is_array($this->record)) {
                    $this->record = implode(',',$this->record);
                }
            } else {
                //sids 进行操作
                if (is_array($this->sids)) {
                    $this->sids = implode(',', $this->sids);
                }
                if (is_array($this->auditor)) {
                    $this->auditor = implode(',', $this->auditor);
                }
                if (is_array($this->record)) {
                    $this->record = implode(',',$this->record);
                }
            }
            return true;
        } else {
            return false;
        }
    }


    public static function sendEmail($pitch_id, $email_arr = [], $subject = '')
    {
        if (!$pitch_id) {
            return false;
        }
        $model = self::getPitchById($pitch_id);
        if (empty($email_arr)) {
            return false;
        }
//        $attachModel = new Attachment();
//        $image = $attachModel->getImageByID($model->attachment);
//        $attachFile = $image->filepath;
        $messages = [];
        $name = '';
        $email = '';
        foreach ($email_arr as $item) {
            list($name,$email) = explode(':',$item);
            $supplier = Supplier::getSupplierByName($name);
            if ($supplier) {
                $messages[] = Yii::$app->mailer->compose(['html' => 'uploadAttachment-html', 'text' => 'uploadAttachment-text'], ['supplier' => $supplier, 'pitch_id' => $model->id])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                    ->setTo($email)
//                  ->attach($attachFile)
                    ->setSubject($subject . Yii::$app->name);;
            }
        }
        $count = Yii::$app->mailer->sendMultiple($messages);
        if (!$count) {
            return false;
        }
        return true;
    }

    /**
     * 根据id获取比稿
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public static function getPitchById($id = '')
    {
        if (!$id) {
            return false;
        }
        $info = self::find()->where(['id' => $id])->one();
        return $info ? $info : false;
    }

    /**
     *
     * 关联表获取数据
     *
     **/
    public function getAttachments()
    {
        return $this->hasMany(PitchAttachment::className(), ['pitch_id' => 'id']);
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
}